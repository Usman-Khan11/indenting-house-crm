<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function dashboard()
    {
        $data['page_title'] = "Dashboard";
        return view('dashboard', $data);
    }

    public function db_backup()
    {
        $dbHost = env('DB_HOST');
        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');
        $backupPath = storage_path('app/backups');
        $fileName = 'backup-' . date('Y-m-d_H-i-s') . '.sql';

        if (!file_exists($backupPath)) {
            mkdir($backupPath, 0777, true);
        }

        $command = "mysqldump --host=$dbHost --user=$dbUser --password=$dbPass $dbName > $backupPath/$fileName";

        // Capture output and result code
        $output = [];
        $resultCode = 0;
        exec($command, $output, $resultCode);

        if ($resultCode === 0) {
            return response()->json(['success' => 'Database backup created successfully!']);
        } else {
            return response()->json([
                'error' => 'Database backup failed!',
                'output' => $output,
                'result_code' => $resultCode
            ], 500);
        }
    }
}
