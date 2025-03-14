<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Offer;
use App\Models\OfferItem;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class PurchaseOrderController extends Controller
{
    protected $nav_id;

    public function __construct()
    {
        $this->nav_id = 6;
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
        $data['page_title'] = "Purchase Orders";
        $this->checkPermissions('view');

        if ($request->ajax()) {

            if (isset($request->type) && $request->type == "getOfferData") {
                $offerId = $request->offerId;
                $data = Offer::where('id', $offerId)->with('items')->first();
                return $data;
            }

            $query = PurchaseOrder::Query();
            $query = $query->with('offer', 'customer', 'supplier', 'added_by', 'indent');
            $query = $query->get();
            return DataTables::of($query)->addIndexColumn()->make(true);
        }

        return view('po.index', $data);
    }

    public function create()
    {
        $data['page_title'] = "Add New Purchase Order";
        $this->checkPermissions('create');

        $data['customers'] = Customer::orderBy('name', 'asc')->get();
        $data['suppliers'] = Supplier::orderBy('name', 'asc')->get();
        $data['products'] = Product::orderBy('name', 'asc')->get();
        $data['offers'] = Offer::leftJoin('purchase_orders', 'offers.id', '=', 'purchase_orders.offer_id')->whereNull('purchase_orders.offer_id')->select('offers.*')->latest()->get();

        $data["po_no"] = 1000;
        $q = PurchaseOrder::latest()->first();
        if ($q) {
            $str = $q->po_no;
            $str = explode("-", $str);
            $str = $str[1] + 1;
            $data["po_no"] = $str;
        }

        return view('po.create', $data);
    }

    public function edit($id)
    {
        $data['page_title'] = "Edit Purchase Order";
        $this->checkPermissions('update');

        $data['customers'] = Customer::orderBy('name', 'asc')->get();
        $data['suppliers'] = Supplier::orderBy('name', 'asc')->get();
        $data['products'] = Product::orderBy('name', 'asc')->get();
        $data['offers'] = Offer::latest()->get();
        $data['po'] = PurchaseOrder::where("id", $id)->with('items', 'customer', 'supplier')->first();
        return view('po.edit', $data);
    }

    public function view($id)
    {
        $data['page_title'] = "View Purchase Order";
        $this->checkPermissions('view');

        $data['po'] = PurchaseOrder::where("id", $id)->with('items')->first();
        return view('po.view', $data);
    }

    public function delete($id)
    {
        $this->checkPermissions('delete');

        PurchaseOrder::where("id", $id)->delete();
        PurchaseOrderItem::where("po_id", $id)->delete();
        return back()->withSuccess('Purchase Order deleted successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'po_no' => 'required|string|max:200|unique:purchase_orders',
            'offer_id' => 'required|integer|exists:offers,id',
            'customer_id' => 'required|integer|exists:customers,id',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'date' => 'required|string|max:15',
            'currency' => 'nullable|string|max:20',
            'remark' => 'nullable|string',
            'sales_person' => 'nullable|string|max:80',
            'sourcing_person' => 'nullable|string|max:80'
        ]);

        $po = new PurchaseOrder();
        $po->po_no = $request->po_no;
        $po->offer_id = $request->offer_id;
        $po->customer_id = $request->customer_id;
        $po->supplier_id = $request->supplier_id;
        $po->date = $request->date;
        $po->currency = $request->currency;
        $po->remark = $request->remark;
        $po->added_by = auth()->user()->id;
        $po->sales_person = $request->sales_person;
        $po->sourcing_person = $request->sourcing_person;

        $product = (!empty($request->product)) ? $request->product : [];

        if ($po->save()) {
            foreach ($product as $key => $value) {
                $po_product = new PurchaseOrderItem();
                $po_product->po_id = $po->id;
                $po_product->item_id = $request->product[$key];
                $po_product->item_desc = $request->product_description[$key];
                $po_product->qty = $request->product_qty[$key] ?? 0;
                $po_product->unit = $request->product_unit[$key];
                $po_product->rate = $request->product_rate[$key] ?? 0;
                $po_product->total = $request->product_total[$key] ?? 0;
                $po_product->shipping_type = $request->product_shipping_type[$key];
                $po_product->save();
            }

            return redirect()->route('po')->withSuccess('Purchase Order added successfully.');
        }

        return back()->withError('Something went wrong.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'po_no' => [
                'required',
                'string',
                'max:200',
                Rule::unique('purchase_orders')->ignore($request->id),
            ],
            'offer_id' => 'required|integer|exists:offers,id',
            'customer_id' => 'required|integer|exists:customers,id',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'date' => 'required|string|max:15',
            'currency' => 'nullable|string|max:20',
            'remark' => 'nullable|string',
            'sales_person' => 'nullable|string|max:80',
            'sourcing_person' => 'nullable|string|max:80'
        ]);

        $po = PurchaseOrder::find($request->id);
        $po->po_no = $request->po_no;
        $po->offer_id = $request->offer_id;
        $po->customer_id = $request->customer_id;
        $po->supplier_id = $request->supplier_id;
        $po->date = $request->date;
        $po->currency = $request->currency;
        $po->remark = $request->remark;
        $po->sales_person = $request->sales_person;
        $po->sourcing_person = $request->sourcing_person;

        $product = (!empty($request->product)) ? $request->product : [];

        if ($po->save()) {
            PurchaseOrderItem::where('po_id', $po->id)->delete();
            foreach ($product as $key => $value) {
                $po_product = new PurchaseOrderItem();
                $po_product->po_id = $po->id;
                $po_product->item_id = $request->product[$key];
                $po_product->item_desc = $request->product_description[$key];
                $po_product->qty = $request->product_qty[$key] ?? 0;
                $po_product->unit = $request->product_unit[$key];
                $po_product->rate = $request->product_rate[$key] ?? 0;
                $po_product->total = $request->product_total[$key] ?? 0;
                $po_product->shipping_type = $request->product_shipping_type[$key];
                $po_product->save();
            }

            return redirect()->route('po')->withSuccess('Purchase Order updated successfully.');
        }

        return back()->withError('Something went wrong.');
    }
}
