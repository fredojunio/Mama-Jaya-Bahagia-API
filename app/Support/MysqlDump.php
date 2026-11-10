<?php

namespace App\Support;

use Illuminate\Database\Connection;
use RuntimeException;
use Symfony\Component\Process\Process;
use Throwable;

class MysqlDump
{
    public function __construct(
        private Connection $connection,
        private string $mysqldump = 'mysqldump',
        private string $mysql = 'mysql',
    ) {
    }

    public function dump(string $target): void
    {
        $this->assertMysql();

        $defaults = $this->writeDefaultsFile();

        try {
            $flags = ['--single-transaction', '--quick', '--routines', '--triggers'];

            foreach (['--no-tablespaces', '--set-gtid-purged=OFF', '--column-statistics=0'] as $optional) {
                if ($this->supports($optional)) {
                    $flags[] = $optional;
                }
            }

            $process = new Process([
                'bash', '-o', 'pipefail', '-c',
                '"$1" --defaults-extra-file="$2" "${@:5}" "$3" | gzip -c > "$4"',
                '--',
                $this->mysqldump,
                $defaults,
                $this->database(),
                $target,
                ...$flags,
            ]);

            $this->run($process, 'mysqldump');
        } finally {
            @unlink($defaults);
        }
    }

    public function restore(string $source): void
    {
        $this->assertMysql();

        $defaults = $this->writeDefaultsFile();

        try {
            $process = new Process([
                'bash', '-o', 'pipefail', '-c',
                'if gzip -t "$1" 2>/dev/null; then gzip -dc "$1"; else cat "$1"; fi | "$2" --defaults-extra-file="$3" "$4"',
                '--',
                $source,
                $this->mysql,
                $defaults,
                $this->database(),
            ]);

            $this->run($process, 'mysql');
        } finally {
            @unlink($defaults);
        }
    }

    private function run(Process $process, string $binary): void
    {
        $process->setTimeout(null);
        $process->run();

        if (! $process->isSuccessful()) {
            throw new RuntimeException("{$binary} failed: ".trim($process->getErrorOutput()));
        }
    }

    private function assertMysql(): void
    {
        if ($this->connection->getDriverName() !== 'mysql') {
            throw new RuntimeException('Only MySQL connections can be dumped or restored.');
        }

        if ($this->database() === '') {
            throw new RuntimeException('The database name is not configured.');
        }
    }

    private function database(): string
    {
        return (string) $this->connection->getDatabaseName();
    }

    private function writeDefaultsFile(): string
    {
        $config = $this->connection->getConfig();

        $lines = [
            '[client]',
            'host='.$this->quote((string) ($config['host'] ?? '127.0.0.1')),
            'port='.$this->quote((string) ($config['port'] ?? '3306')),
            'user='.$this->quote((string) ($config['username'] ?? '')),
            'password='.$this->quote((string) ($config['password'] ?? '')),
        ];

        $path = tempnam(sys_get_temp_dir(), 'mamajaya-db-');

        if ($path === false) {
            throw new RuntimeException('Could not create a temporary credentials file.');
        }

        chmod($path, 0600);
        file_put_contents($path, implode("\n", $lines)."\n");

        return $path;
    }

    private function quote(string $value): string
    {
        return '"'.str_replace(['\\', '"'], ['\\\\', '\\"'], $value).'"';
    }

    private function supports(string $flag): bool
    {
        $name = strtok($flag, '=');

        try {
            $process = new Process([$this->mysqldump, '--help']);
            $process->setTimeout(30);
            $process->run();

            return $process->isSuccessful() && str_contains($process->getOutput(), (string) $name);
        } catch (Throwable) {
            return false;
        }
    }
}
