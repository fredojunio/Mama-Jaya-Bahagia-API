<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class DeployDatabaseTest extends TestCase
{
    private string $directory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->directory = sys_get_temp_dir().'/mamajaya-deploy-db-'.uniqid();

        File::ensureDirectoryExists($this->directory);
    }

    protected function tearDown(): void
    {
        File::deleteDirectory($this->directory);

        parent::tearDown();
    }

    public function test_dump_writes_a_gzipped_archive_and_prunes_older_ones(): void
    {
        $this->requireMysqlTools();

        $old = $this->directory.'/2020-01-01-000000-old.sql.gz';
        $older = $this->directory.'/2019-01-01-000000-oldest.sql.gz';

        File::put($old, 'old');
        File::put($older, 'older');

        touch($old, time() - 3600);
        touch($older, time() - 7200);

        $this->artisan('deploy:db-dump', [
            '--path' => $this->directory,
            '--name' => 'latest.sql.gz',
            '--keep' => 2,
        ])->assertExitCode(0);

        $dump = $this->directory.'/latest.sql.gz';

        $this->assertFileExists($dump);
        $this->assertGreaterThan(0, filesize($dump));

        $handle = fopen($dump, 'rb');
        $this->assertSame("\x1f\x8b", fread($handle, 2));
        fclose($handle);

        $this->assertFileExists($old);
        $this->assertFileDoesNotExist($older);
    }

    public function test_restore_refuses_to_run_without_explicit_confirmation(): void
    {
        $this->artisan('deploy:db-restore', ['file' => $this->directory.'/missing.sql.gz'])
            ->expectsOutputToContain('--force')
            ->assertExitCode(1);
    }

    private function requireMysqlTools(): void
    {
        if (DB::connection()->getDriverName() !== 'mysql') {
            $this->markTestSkipped('The database dump command requires a MySQL connection.');
        }

        foreach (['mysqldump', 'mysql', 'gzip'] as $binary) {
            exec('command -v '.escapeshellarg($binary), $output, $exitCode);

            if ($exitCode !== 0) {
                $this->markTestSkipped("The {$binary} binary is not available.");
            }
        }
    }
}
