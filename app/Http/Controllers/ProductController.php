<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerProducts;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\SupplierProducts;
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
            $query = Product::query();

            if (!empty($request->input('search')['value'])) {
                $search = $request->input('search')['value'];
                $query->where(function ($q) use ($search) {
                    $q->where('id', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%")
                        ->orWhere('hs_code', 'like', "%{$search}%")
                        ->orWhere('unit', 'like', "%{$search}%")
                        ->orWhere('type', 'like', "%{$search}%");
                });
            }

            $query = $query->orderBy('id', 'desc');
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

    public function map(Request $request)
    {
        $data['page_title'] = "Map Material";
        $this->checkPermissions('map');

        if (isset($request->id) && !empty($request->id)) {
            $arr["supplier_products"] = SupplierProducts::where('product_id', $request->id)->get();
            $arr["customer_products"] = CustomerProducts::where('product_id', $request->id)->get();
            return $arr;
        }

        $data['suppliers'] = Supplier::orderBy("name")->get();
        $data['customers'] = Customer::orderBy("name")->get();
        $data['products'] = Product::orderBy("name")->get();
        return view('product.map', $data);
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
            'scode' => 'nullable|string|max:30',
            'pup' => 'nullable|string|max:30',
        ]);

        $id = 1;
        $p = Product::orderBy('id', 'desc')->first();
        if ($p) {
            $id = $p->id + 1;
        }

        $product = new Product();
        $product->id = $id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->hs_code = $request->hs_code;
        $product->unit = $request->unit;
        $product->type = $request->type;
        $product->code = $request->code;
        $product->scode = $request->scode;
        $product->pup = $request->pup;

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
            'scode' => 'nullable|string|max:30',
            'pup' => 'nullable|string|max:30',
        ]);

        $new_id = $request->new_id;
        $product = Product::find($request->id);

        if ($new_id != $request->id) {
            $chk = Product::where('id', $new_id)->count();
            if ($chk > 0) {
                return back()->withError('The ID is already in use. Please choose a different ID.');
            }

            $product->id = $new_id;
        }

        $product->name = $request->name;
        $product->description = $request->description;
        $product->hs_code = $request->hs_code;
        $product->unit = $request->unit;
        $product->type = $request->type;
        $product->code = $request->code;
        $product->scode = $request->scode;
        $product->pup = $request->pup;

        if ($product->save()) {
            return redirect()->route('product')->withSuccess('Material updated successfully.');
        }

        return back()->withError('Something went wrong.');
    }

    public function map_product(Request $request)
    {
        $request->validate([
            // 'supplier_id' => 'required|exists:suppliers,id',
            'supplier_id'   => 'nullable|array',
            'supplier_id.*' => 'exists:suppliers,id',
            'customer_id'   => 'nullable|array',
            'customer_id.*' => 'exists:customers,id',
            'products' => 'required|exists:products,id',
            // 'products'      => 'required|array',
            // 'products.*'    => 'exists:products,id',
        ]);

        $product_id = $request->products;
        $supplier_id = $request->supplier_id;
        $customer_id = $request->customer_id;

        SupplierProducts::where('product_id', $product_id)->delete();
        CustomerProducts::where('product_id', $product_id)->delete();

        if ($supplier_id) {
            foreach ($supplier_id as $key => $value) {
                $supplier_product = new SupplierProducts();
                $supplier_product->supplier_id = $value;
                $supplier_product->product_id = $product_id;
                $supplier_product->save();
            }
        }

        if ($customer_id) {
            foreach ($customer_id as $key => $value) {
                $customer_product = new CustomerProducts();
                $customer_product->customer_id = $value;
                $customer_product->product_id = $product_id;
                $customer_product->save();
            }
        }

        return back()->withSuccess('Products mapped successfully.');
    }
}
