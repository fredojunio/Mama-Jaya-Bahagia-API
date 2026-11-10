<?php

namespace App\Console\Commands;

use App\Support\MysqlDump;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Throwable;

class DeployDbRestore extends Command
{
    protected $signature = 'deploy:db-restore
        {file : Path to a .sql or .sql.gz dump}
        {--force : Confirm that the current database will be overwritten}';

    protected $description = 'Restore a MySQL dump over the configured database (destructive)';

    public function handle(): int
    {
        if (! $this->option('force')) {
            $this->error('Refusing to overwrite the database. Re-run with --force to restore.');

            return self::FAILURE;
        }

        $file = (string) $this->argument('file');

        if (! is_file($file) || ! is_readable($file)) {
            $this->error("Dump not found or not readable: {$file}");

            return self::FAILURE;
        }

        $database = DB::connection()->getDatabaseName();

        $this->warn("Restoring {$file} into [{$database}].");

        try {
            (new MysqlDump(DB::connection()))->restore($file);
        } catch (Throwable $exception) {
            $this->error($exception->getMessage());

            return self::FAILURE;
        }

        $this->info('Database restore finished.');

        return self::SUCCESS;
    }
}
