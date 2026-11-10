<?php

namespace App\Console\Commands;

use App\Support\MysqlDump;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Throwable;

class DeployDbDump extends Command
{
    protected $signature = 'deploy:db-dump
        {--path= : Destination directory}
        {--name= : Dump file name}
        {--keep=10 : Number of dumps to retain in the destination directory}';

    protected $description = 'Write a gzipped MySQL dump to the deploy backup directory';

    public function handle(): int
    {
        $directory = rtrim((string) ($this->option('path') ?: storage_path('deploy-backups/db')), '/');
        $name = (string) ($this->option('name') ?: now()->format('Ymd-His').'.sql.gz');
        $target = $directory.'/'.basename($name);

        File::ensureDirectoryExists($directory, 0700);

        try {
            (new MysqlDump(DB::connection()))->dump($target);
        } catch (Throwable $exception) {
            $this->error($exception->getMessage());

            return self::FAILURE;
        }

        chmod($target, 0600);
        $this->prune($directory, max(1, (int) $this->option('keep')));

        $this->info("Database dump written to {$target}");

        return self::SUCCESS;
    }

    private function prune(string $directory, int $keep): void
    {
        $dumps = collect(File::files($directory))
            ->filter(fn ($file) => str_ends_with($file->getFilename(), '.sql.gz'))
            ->sortByDesc(fn ($file) => $file->getMTime())
            ->values();

        $dumps->slice($keep)->each(fn ($file) => File::delete($file->getPathname()));
    }
}
