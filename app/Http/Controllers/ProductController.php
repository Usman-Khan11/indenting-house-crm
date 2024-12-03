<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    protected $nav_id;

    public function __construct()
    {
        $this->nav_id = 1;
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
        $data['page_title'] = "Materials";
        $this->checkPermissions('view');

        if ($request->ajax()) {
            $query = Product::Query();
            $query = $query->orderBy('id', 'desc')->get();
            return DataTables::of($query)->addIndexColumn()->make(true);
        }

        return view('product.index', $data);
    }

    public function create(Request $request)
    {
        $data['page_title'] = "Add New Material";
        $this->checkPermissions('create');

        return view('product.create', $data);
    }

    public function get(Request $request)
    {
        $id = $request->id;
        $data = Product::where("id", $id)->first();
        if ($data) {
            return $data;
        }
    }

    public function edit($id)
    {
        $data['page_title'] = "Edit Material";
        $this->checkPermissions('update');

        $data['product'] = Product::where("id", $id)->first();
        return view('product.edit', $data);
    }

    public function delete($id)
    {
        $this->checkPermissions('delete');

        Product::where("id", $id)->delete();
        return back()->withSuccess('Material deleted successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'hs_code' => 'nullable|string|max:100',
            'unit' => 'nullable|string|max:100',
            'type' => 'nullable|string|max:30',
            'code' => 'nullable|string|max:255',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->hs_code = $request->hs_code;
        $product->unit = $request->unit;
        $product->type = $request->type;
        $product->code = $request->code;

        if ($product->save()) {
            return redirect()->route('product')->withSuccess('Material added successfully.');
        }

        return back()->withError('Something went wrong.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'hs_code' => 'nullable|string|max:100',
            'unit' => 'nullable|string|max:100',
            'type' => 'nullable|string|max:30',
            'code' => 'nullable|string|max:255',
        ]);

        $product = Product::find($request->id);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->hs_code = $request->hs_code;
        $product->unit = $request->unit;
        $product->type = $request->type;
        $product->code = $request->code;

        if ($product->save()) {
            return redirect()->route('product')->withSuccess('Material updated successfully.');
        }

        return back()->withError('Something went wrong.');
    }
}
