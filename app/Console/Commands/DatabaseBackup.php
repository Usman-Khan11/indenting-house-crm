<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a database backup';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host = env('DB_HOST');
        $backupPath = storage_path('backups');

        if (!file_exists($backupPath)) {
            mkdir($backupPath, 0755, true);
        }

        $filename = "backup_" . date('Y-m-d_H-i-s') . ".sql";
        $command = sprintf(
            'mysqldump -h %s -u %s -p%s %s > %s/%s',
            escapeshellarg($host),
            escapeshellarg($username),
            escapeshellarg($password),
            escapeshellarg($database),
            escapeshellarg($backupPath),
            escapeshellarg($filename)
        );

        exec($command, $output, $result);

        $this->info("Backup created: $filename");
    }
}
