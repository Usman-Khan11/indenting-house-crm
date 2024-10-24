<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerProducts;
use App\Models\Indent;
use App\Models\Inquiry;
use App\Models\InquiryItem;
use App\Models\Offer;
use App\Models\Product;
use App\Models\PurchaseOrder;
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

    public function inquiry(Request $request)
    {
        $data['page_title'] = "Inquiry Report";
        $this->checkPermissions('inquiry');

        if ($request->ajax()) {
            $query = Inquiry::join('inquiry_items', 'inquiries.id', '=', 'inquiry_items.inquiry_id')
                ->join('customers', 'inquiries.customer_id', '=', 'customers.id')
                ->join('suppliers', 'inquiries.supplier_id', '=', 'suppliers.id')
                ->join('products', 'inquiry_items.item_id', '=', 'products.id')
                ->select(
                    'inquiries.inq_no',
                    'inquiries.customer_id',
                    'inquiries.supplier_id',
                    'inquiry_items.*',
                    'customers.name as customer_name',
                    'suppliers.name as supplier_name',
                    'products.name as product_name',
                    'products.description as product_description',
                );

            if (!empty($request->from) && !empty($request->to)) {
                $query->whereBetween('inquiry_items.created_at', [
                    $request->from . ' 00:00:00',
                    $request->to . ' 23:59:59'
                ]);
            }

            if (!empty($request->customer_id)) {
                $query->where('inquiries.customer_id', $request->customer_id);
            }

            if (!empty($request->supplier_id)) {
                $query->where('inquiries.supplier_id', $request->supplier_id);
            }

            if (!empty($request->product_id)) {
                $query->where('inquiry_items.item_id', $request->product_id);
            }

            $query = $query->get();
            return DataTables::of($query)->addIndexColumn()->make(true);
        }

        $data['customers'] = Customer::orderBy('name', 'asc')->get();
        $data['suppliers'] = Supplier::orderBy('name', 'asc')->get();
        $data['products'] = Product::orderBy('name', 'asc')->get();

        return view('reports.inquiry', $data);
    }

    public function offer(Request $request)
    {
        $data['page_title'] = "Offer Report";
        $this->checkPermissions('offer');

        if ($request->ajax()) {
            $query = Offer::join('offer_items', 'offers.id', '=', 'offer_items.offer_id')
                ->join('customers', 'offers.customer_id', '=', 'customers.id')
                ->join('suppliers', 'offers.supplier_id', '=', 'suppliers.id')
                ->join('products', 'offer_items.item_id', '=', 'products.id')
                ->select(
                    'offers.offer_no',
                    'offers.customer_id',
                    'offers.supplier_id',
                    'offer_items.*',
                    'customers.name as customer_name',
                    'suppliers.name as supplier_name',
                    'products.name as product_name',
                    'products.description as product_description',
                );

            if (!empty($request->from) && !empty($request->to)) {
                $query->whereBetween('offer_items.created_at', [
                    $request->from . ' 00:00:00',
                    $request->to . ' 23:59:59'
                ]);
            }

            if (!empty($request->customer_id)) {
                $query->where('offers.customer_id', $request->customer_id);
            }

            if (!empty($request->supplier_id)) {
                $query->where('offers.supplier_id', $request->supplier_id);
            }

            if (!empty($request->product_id)) {
                $query->where('offer_items.item_id', $request->product_id);
            }

            $query = $query->get();
            return DataTables::of($query)->addIndexColumn()->make(true);
        }

        $data['customers'] = Customer::orderBy('name', 'asc')->get();
        $data['suppliers'] = Supplier::orderBy('name', 'asc')->get();
        $data['products'] = Product::orderBy('name', 'asc')->get();

        return view('reports.offer', $data);
    }

    public function po(Request $request)
    {
        $data['page_title'] = "Purchase Order Report";
        $this->checkPermissions('po');

        if ($request->ajax()) {
            $query = PurchaseOrder::join('purchase_order_items', 'purchase_orders.id', '=', 'purchase_order_items.po_id')
                ->join('customers', 'purchase_orders.customer_id', '=', 'customers.id')
                ->join('suppliers', 'purchase_orders.supplier_id', '=', 'suppliers.id')
                ->join('products', 'purchase_order_items.item_id', '=', 'products.id')
                ->select(
                    'purchase_orders.po_no',
                    'purchase_orders.customer_id',
                    'purchase_orders.supplier_id',
                    'purchase_order_items.*',
                    'customers.name as customer_name',
                    'suppliers.name as supplier_name',
                    'products.name as product_name',
                    'products.description as product_description',
                );

            if (!empty($request->from) && !empty($request->to)) {
                $query->whereBetween('purchase_order_items.created_at', [
                    $request->from . ' 00:00:00',
                    $request->to . ' 23:59:59'
                ]);
            }

            if (!empty($request->customer_id)) {
                $query->where('purchase_orders.customer_id', $request->customer_id);
            }

            if (!empty($request->supplier_id)) {
                $query->where('purchase_orders.supplier_id', $request->supplier_id);
            }

            if (!empty($request->product_id)) {
                $query->where('purchase_order_items.item_id', $request->product_id);
            }

            $query = $query->get();
            return DataTables::of($query)->addIndexColumn()->make(true);
        }

        $data['customers'] = Customer::orderBy('name', 'asc')->get();
        $data['suppliers'] = Supplier::orderBy('name', 'asc')->get();
        $data['products'] = Product::orderBy('name', 'asc')->get();

        return view('reports.po', $data);
    }

    public function indent(Request $request)
    {
        $data['page_title'] = "Indent Report";
        $this->checkPermissions('indent');

        if ($request->ajax()) {
            $query = Indent::join('indent_items', 'indents.id', '=', 'indent_items.indent_id')
                ->join('customers', 'indents.customer_id', '=', 'customers.id')
                ->join('suppliers', 'indents.supplier_id', '=', 'suppliers.id')
                ->join('products', 'indent_items.item_id', '=', 'products.id')
                ->select(
                    'indents.indent_no',
                    'indents.customer_id',
                    'indents.supplier_id',
                    'indent_items.*',
                    'customers.name as customer_name',
                    'suppliers.name as supplier_name',
                    'products.name as product_name',
                    'products.description as product_description',
                );

            if (!empty($request->from) && !empty($request->to)) {
                $query->whereBetween('indent_items.created_at', [
                    $request->from . ' 00:00:00',
                    $request->to . ' 23:59:59'
                ]);
            }

            if (!empty($request->customer_id)) {
                $query->where('indents.customer_id', $request->customer_id);
            }

            if (!empty($request->supplier_id)) {
                $query->where('indents.supplier_id', $request->supplier_id);
            }

            if (!empty($request->product_id)) {
                $query->where('indent_items.item_id', $request->product_id);
            }

            $query = $query->get();
            return DataTables::of($query)->addIndexColumn()->make(true);
        }

        $data['customers'] = Customer::orderBy('name', 'asc')->get();
        $data['suppliers'] = Supplier::orderBy('name', 'asc')->get();
        $data['products'] = Product::orderBy('name', 'asc')->get();

        return view('reports.indent', $data);
    }
}
