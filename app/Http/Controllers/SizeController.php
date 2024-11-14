<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SizeController extends Controller
{
    protected $nav_id;

    public function __construct()
    {
        $this->nav_id = 10;
    }

    protected function checkPermissions($action)
    {
        $permission = Get_Permission($this->nav_id, auth()->user()->role_id);

        if (!in_array($action, $permission)) {
            abort(403, 'Access denied.');
        }
    }

    public function index(Request $request)
    {
        $data['page_title'] = "Sizes";
        $this->checkPermissions('view');

        if ($request->ajax()) {
            $query = Size::Query();
            $query = $query->orderBy('id', 'desc')->get();
            return DataTables::of($query)->addIndexColumn()->make(true);
        }

        return view('size.index', $data);
    }

    public function create(Request $request)
    {
        $data['page_title'] = "Add New Size";
        $this->checkPermissions('create');

        return view('size.create', $data);
    }

    public function edit($id)
    {
        $data['page_title'] = "Edit Size";
        $this->checkPermissions('update');

        $data['size'] = Size::where("id", $id)->first();
        return view('size.edit', $data);
    }

    public function delete($id)
    {
        $this->checkPermissions('delete');

        Size::where("id", $id)->delete();
        return back()->withSuccess('Size deleted successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $size = new Size();
        $size->name = $request->name;

        if ($size->save()) {
            return redirect()->route('size')->withSuccess('Size added successfully.');
        }

        return back()->withError('Something went wrong.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $size = Size::find($request->id);
        $size->name = $request->name;

        if ($size->save()) {
            return redirect()->route('size')->withSuccess('Size updated successfully.');
        }

        return back()->withError('Something went wrong.');
    }
}
