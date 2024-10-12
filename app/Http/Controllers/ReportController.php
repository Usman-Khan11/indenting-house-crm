<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    public function supplier(Request $request)
    {
        $data['page_title'] = "Supplier Report";

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

        if ($request->ajax()) {
            $query = Product::Query();
            $query = $query->latest()->get();
            return DataTables::of($query)->addIndexColumn()->make(true);
        }

        return view('reports.product', $data);
    }
}
