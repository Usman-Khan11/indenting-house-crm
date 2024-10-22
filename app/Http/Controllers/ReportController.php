<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerProducts;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\SupplierProducts;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    protected $nav_id;

    public function __construct()
    {
        $this->nav_id = 8;
    }

    protected function checkPermissions($action)
    {
        $permission = Get_Permission($this->nav_id, auth()->user()->role_id);

        if (!in_array($action, $permission)) {
            abort(403, 'Access denied.');
        }
    }

    public function supplier(Request $request)
    {
        $data['page_title'] = "Supplier Report";
        $this->checkPermissions('supplier list');

        if ($request->ajax()) {
            $query = Supplier::Query();
            $query = $query->latest()->get();
            return DataTables::of($query)->addIndexColumn()->make(true);
        }

        return view('reports.supplier', $data);
    }

    public function customer(Request $request)
    {
        $data['page_title'] = "Customer Report";
        $this->checkPermissions('customer list');

        if ($request->ajax()) {
            $query = Customer::Query();
            $query = $query->latest()->get();
            return DataTables::of($query)->addIndexColumn()->make(true);
        }

        return view('reports.customer', $data);
    }

    public function product(Request $request)
    {
        $data['page_title'] = "Materials Report";
        $this->checkPermissions('material list');

        if ($request->ajax()) {
            $query = Product::Query();
            $query = $query->latest()->get();
            return DataTables::of($query)->addIndexColumn()->make(true);
        }

        return view('reports.product', $data);
    }

    public function supplier_product(Request $request)
    {
        $data['page_title'] = "Item Wise Supplier Report";
        $this->checkPermissions('item wise supplier');

        $data['products'] = Product::orderBy('name')->get();

        if ($request->ajax()) {
            $query = SupplierProducts::Query();

            if ($request->product_id != "all") {
                $query = $query->where('product_id', $request->product_id);
            }

            $query = $query->with('supplier', 'product');
            $query = $query->latest()->get();
            return DataTables::of($query)->addIndexColumn()->make(true);
        }

        return view('reports.supplier_product', $data);
    }

    public function customer_product(Request $request)
    {
        $data['page_title'] = "Item Wise Customer Report";
        $this->checkPermissions('item wise customer');

        $data['products'] = Product::orderBy('name')->get();

        if ($request->ajax()) {
            $query = CustomerProducts::Query();

            if ($request->product_id != "all") {
                $query = $query->where('product_id', $request->product_id);
            }

            $query = $query->with('customer', 'product');
            $query = $query->latest()->get();
            return DataTables::of($query)->addIndexColumn()->make(true);
        }

        return view('reports.customer_product', $data);
    }
}
