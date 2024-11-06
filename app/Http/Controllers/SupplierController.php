<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\SupplierProducts;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    protected $nav_id;

    public function __construct()
    {
        $this->nav_id = 3;
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
        $data['page_title'] = "Suppliers";
        $this->checkPermissions('view');

        if ($request->ajax()) {
            $query = Supplier::Query();
            $query = $query->latest()->get();
            return Datatables::of($query)->addIndexColumn()->make(true);
        }

        return view('supplier.index', $data);
    }

    public function create(Request $request)
    {
        $data['page_title'] = "Add New Supplier";
        $this->checkPermissions('create');

        return view('supplier.create', $data);
    }

    public function edit($id)
    {
        $data['page_title'] = "Edit Supplier";
        $this->checkPermissions('update');

        $data['supplier'] = Supplier::where("id", $id)->first();
        return view('supplier.edit', $data);
    }

    public function view($id)
    {
        $data['page_title'] = "View Supplier";
        $this->checkPermissions('view');

        $data['supplier'] = Supplier::where("id", $id)->with('products')->first();
        return view('supplier.view', $data);
    }

    public function delete($id)
    {
        $this->checkPermissions('delete');

        Supplier::where("id", $id)->delete();
        return back()->withSuccess('Supplier deleted successfully.');
    }

    public function map(Request $request)
    {
        $data['page_title'] = "Supplier Map Material";
        $this->checkPermissions('map product');

        if (isset($request->id) && !empty($request->id)) {
            $d = SupplierProducts::where('supplier_id', $request->id)->get();
            return $d;
        }

        $data['suppliers'] = Supplier::orderBy("name")->get();
        $data['products'] = Product::orderBy("name")->get();
        return view('supplier.map', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'fax_number' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:150',
            'email_2' => 'nullable|email|max:150',
            'email_3' => 'nullable|email|max:150',
            'person' => 'nullable|string|max:150',
            'person_2' => 'nullable|string|max:150',
            'person_3' => 'nullable|string|max:150',
            'band_detail' => 'nullable|string',
            'address' => 'nullable|string',
            'origin' => 'nullable|string|max:150',
            'swift_code' => 'nullable|string|max:50',
        ]);

        $supplier = new Supplier();
        $supplier->name = $request->name;
        $supplier->fax_number = $request->fax_number;
        $supplier->phone = $request->phone;
        $supplier->email = $request->email;
        $supplier->email_2 = $request->email_2;
        $supplier->email_3 = $request->email_3;
        $supplier->person = $request->person;
        $supplier->person_2 = $request->person_2;
        $supplier->person_3 = $request->person_3;
        $supplier->band_detail = $request->band_detail;
        $supplier->address = $request->address;
        $supplier->origin = $request->origin;
        $supplier->swift_code = $request->swift_code;

        if ($supplier->save()) {
            return redirect()->route('supplier')->withSuccess('Supplier added successfully.');
        }

        return back()->withError('Something went wrong.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'fax_number' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:150',
            'email_2' => 'nullable|email|max:150',
            'email_3' => 'nullable|email|max:150',
            'person' => 'nullable|string|max:150',
            'person_2' => 'nullable|string|max:150',
            'person_3' => 'nullable|string|max:150',
            'band_detail' => 'nullable|string',
            'address' => 'nullable|string',
            'origin' => 'nullable|string|max:150',
            'swift_code' => 'nullable|string|max:50',
        ]);

        $supplier = Supplier::find($request->id);
        $supplier->name = $request->name;
        $supplier->fax_number = $request->fax_number;
        $supplier->phone = $request->phone;
        $supplier->email = $request->email;
        $supplier->email_2 = $request->email_2;
        $supplier->email_3 = $request->email_3;
        $supplier->person = $request->person;
        $supplier->person_2 = $request->person_2;
        $supplier->person_3 = $request->person_3;
        $supplier->band_detail = $request->band_detail;
        $supplier->address = $request->address;
        $supplier->origin = $request->origin;
        $supplier->swift_code = $request->swift_code;

        if ($supplier->save()) {
            return redirect()->route('supplier')->withSuccess('Supplier updated successfully.');
        }

        return back()->withError('Something went wrong.');
    }

    public function map_product(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'products' => 'required|array',
            'products.*' => 'exists:products,id',
        ]);

        SupplierProducts::where('supplier_id', $request->supplier_id)->delete();

        foreach ($request->products as $key => $value) {
            $supplier_product = new SupplierProducts();
            $supplier_product->supplier_id = $request->supplier_id;
            $supplier_product->product_id = $value;
            $supplier_product->save();
        }

        return redirect()->route('supplier')->withSuccess('Products mapped successfully.');
    }

    public function supplier_product(Request $request)
    {
        $type = $request->type;
        $supID = $request->supID;
        $data = null;

        if ($supID) {
            $data = SupplierProducts::where('supplier_id', $supID)->with('product')->get();
        }

        return $data;
    }
}
