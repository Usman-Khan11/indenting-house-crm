<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    protected $nav_id;

    public function __construct()
    {
        $this->nav_id = 6;
    }

    public function dashboard()
    {
        $data['page_title'] = "Dashboard";
        return view('dashboard', $data);
    }

    public function users(Request $request)
    {
        $data['page_title'] = "Users";

        if ($request->ajax()) {
            $query = User::Query();
            // $query = $query->where('id', '!=', 1);
            $query = $query->with('role');
            $query = $query->latest()->get();
            return DataTables::of($query)->addIndexColumn()->make(true);
        }

        return view('user.index', $data);
    }

    public function create()
    {
        $data['page_title'] = "Add New User";
        $data['roles'] = Role::all();
        return view('user.create', $data);
    }

    public function edit($id)
    {
        $data['page_title'] = "Edit User";
        $data['roles'] = Role::all();
        $data['user'] = User::where("id", $id)->first();
        return view('user.edit', $data);
    }

    public function delete($id)
    {
        User::where("id", $id)->delete();
        return back()->withSuccess('User deleted successfully.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'username' => 'required|string|max:200|unique:users',
            'password' => 'required|string|max:255',
            'role_id' => 'required|integer',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->phone = $request->phone;
        $user->designation = $request->designation;
        $user->address = $request->address;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->imap_setting = [
            'host'     => $request->imap_host,
            'username' => $request->imap_username,
            'password' => $request->imap_password,
        ];

        if ($user->save()) {
            return redirect()->route('user')->withSuccess('User added successfully.');
        }

        return back()->withError('Something went wrong.');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'username' => 'required|string|max:200|unique:users,username,' . $request->id,
            'password' => 'sometimes|nullable|string|max:255',
            'role_id' => 'required|integer',
        ]);

        $user = User::where("id", $request->id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->phone = $request->phone;
        $user->designation = $request->designation;
        $user->address = $request->address;
        $user->username = $request->username;
        $user->imap_setting = [
            'host'     => $request->imap_host,
            'username' => $request->imap_username,
            'password' => $request->imap_password,
        ];

        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        if ($user->save()) {
            return redirect()->route('user')->withSuccess('User updated successfully.');
        }

        return back()->withError('Something went wrong.');
    }

    public function permissions($id)
    {
        $data['page_title'] = "Permissions";
        $data["role"] = Role::where('id', $id)->first();
        return view('user.permissions', $data);
    }

    public function add_permissions(Request $request)
    {
        DB::table('permissions')->where('user_id', $request->user_id)->delete();

        for ($i = 0; $i < count($request->perm); $i++) {
            $view = isset($request->perm) ? 1 : 0;
            if ($view == 1) {
                $arr = explode('-', $request->perm[$i]);
                $navId = $arr[0];
                $keyId = $arr[1];

                DB::table('permissions')->insert([
                    'user_id' => $request->user_id,
                    'nav_id' => $navId,
                    'nav_key_id' => $keyId,
                ]);
            }
        }

        return redirect()->route('role')->withSuccess('Permission assign successfully.');
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
