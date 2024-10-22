<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $data['page_title'] = "Roles";

        if ($request->ajax()) {
            $query = Role::Query();
            $query = $query->orderby('id', 'asc')->get();
            return DataTables::of($query)->addIndexColumn()->make(true);
        }

        return view('role.index', $data);
    }

    public function create()
    {
        $data['page_title'] = "Add New Role";
        return view('role.create', $data);
    }


    public function delete($id)
    {
        Role::where('id', $id)->delete();
        return back()->withSuccess('Role deleted successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $role = new Role();
        $role->name = $request->name;
        $role->save();

        return redirect()->route('role')->withSuccess('Role added successfully.');
    }

    public function edit($id)
    {
        $data['page_title'] = "Edit Role";
        $data['role'] = Role::find($id);
        return view('role.edit', $data);
    }


    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $role = Role::find($request->id);
        $role->name = $request->name;
        $role->save();

        return redirect()->route('role')->withSuccess('Role updated successfully.');
    }
}
