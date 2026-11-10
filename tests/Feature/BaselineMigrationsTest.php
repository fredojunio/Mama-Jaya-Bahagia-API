<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class BaselineMigrationsTest extends TestCase
{
    private string $baselinePath;

    private string $driftPath;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
        ]);

        Schema::create('migrations', function ($table) {
            $table->increments('id');
            $table->string('migration');
            $table->integer('batch');
        });

        Schema::create('users', function ($table) {
            $table->increments('id');
        });

        $this->baselinePath = base_path('tests/fixtures/migrations/baseline');
        $this->driftPath = base_path('tests/fixtures/migrations/drift');
    }

    public function test_dry_run_lists_missing_migrations_without_recording_them(): void
    {
        $this->artisan('deploy:baseline-migrations', ['--path' => $this->baselinePath])
            ->expectsOutputToContain('create_users_table')
            ->expectsOutputToContain('add_flag_to_users_table')
            ->assertExitCode(0);

        $this->assertSame(0, DB::table('migrations')->count());
    }

    public function test_apply_records_migrations_that_match_the_live_schema(): void
    {
        $this->artisan('deploy:baseline-migrations', [
            '--path' => $this->baselinePath,
            '--apply' => true,
        ])->assertExitCode(0);

        $this->assertSame(
            ['2023_01_01_000000_create_users_table', '2023_01_01_000002_add_flag_to_users_table'],
            DB::table('migrations')->orderBy('id')->pluck('migration')->all()
        );

        $this->assertSame(1, (int) DB::table('migrations')->max('batch'));
    }

    public function test_missing_table_blocks_dry_run_and_apply(): void
    {
        $this->artisan('deploy:baseline-migrations', ['--path' => $this->driftPath])
            ->expectsOutputToContain('create_ghost_table')
            ->assertExitCode(1);

        $this->artisan('deploy:baseline-migrations', [
            '--path' => $this->driftPath,
            '--apply' => true,
        ])->assertExitCode(1);

        $this->assertSame(0, DB::table('migrations')->count());
    }

    public function test_already_recorded_migrations_are_ignored(): void
    {
        DB::table('migrations')->insert([
            ['migration' => '2023_01_01_000000_create_users_table', 'batch' => 1],
            ['migration' => '2023_01_01_000002_add_flag_to_users_table', 'batch' => 1],
        ]);

        $this->artisan('deploy:baseline-migrations', [
            '--path' => $this->baselinePath,
            '--apply' => true,
        ])
            ->expectsOutputToContain('Nothing to baseline')
            ->assertExitCode(0);

        $this->assertSame(2, DB::table('migrations')->count());
    }
}
