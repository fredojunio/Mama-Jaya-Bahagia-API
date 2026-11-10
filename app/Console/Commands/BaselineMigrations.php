<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class BaselineMigrations extends Command
{
    protected $signature = 'deploy:baseline-migrations
        {--path= : Directory containing migration files}
        {--apply : Record the migrations as applied (default is a dry run)}';

    protected $description = 'Record migrations that already ran outside Laravel without executing any schema change';

    public function handle(): int
    {
        $path = $this->option('path') ?: database_path('migrations');

        if (! File::isDirectory($path)) {
            $this->error("Migration directory not found: {$path}");

            return self::FAILURE;
        }

        $table = config('database.migrations', 'migrations');

        if (! Schema::hasTable($table)) {
            $this->error('The migrations table does not exist. This database has never been migrated; do not baseline it.');

            return self::FAILURE;
        }

        $files = collect(File::files($path))
            ->map(fn ($file) => $file->getBasename('.php'))
            ->sort()
            ->values();

        $recorded = DB::table($table)->pluck('migration')->all();

        $missing = $files
            ->reject(fn ($name) => in_array($name, $recorded, true))
            ->values();

        if ($missing->isEmpty()) {
            $this->line('Nothing to baseline — every migration file is already recorded.');

            return self::SUCCESS;
        }

        $baselineable = [];
        $blocked = [];

        foreach ($missing as $name) {
            $createdTable = $this->tableCreatedByMigration($name);

            if ($createdTable !== null && ! Schema::hasTable($createdTable)) {
                $blocked[$name] = $createdTable;

                continue;
            }

            $baselineable[] = $name;
        }

        foreach ($baselineable as $name) {
            $this->line("  would mark applied: {$name}");
        }

        foreach ($blocked as $name => $createdTable) {
            $this->line("  still pending: {$name} (table [{$createdTable}] does not exist)");
        }

        if ($blocked !== []) {
            $this->error('Refusing to baseline: '.count($blocked).' migration(s) would create tables that are missing. These must run with php artisan migrate.');

            return self::FAILURE;
        }

        if (! $this->option('apply')) {
            $this->line('Dry run: '.count($baselineable).' migration(s) would be recorded. Re-run with --apply to write.');

            return self::SUCCESS;
        }

        $batch = (int) (DB::table($table)->max('batch') ?? 0) + 1;

        DB::table($table)->insert(array_map(
            fn ($name) => ['migration' => $name, 'batch' => $batch],
            $baselineable
        ));

        $this->info(count($baselineable)." migration(s) recorded in batch {$batch}.");
        $this->line('Now run `php artisan migrate --pretend` and confirm nothing destructive remains.');

        return self::SUCCESS;
    }

    private function tableCreatedByMigration(string $migration): ?string
    {
        if (preg_match('/(?:^|_)create_(.+)_table$/', $migration, $matches) === 1) {
            return $matches[1];
        }

        return null;
    }
}
