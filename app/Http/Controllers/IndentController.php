<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Indent;
use App\Models\IndentItems;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class IndentController extends Controller
{
    public function index(Request $request)
    {
        $data['page_title'] = "Indents";

        if ($request->ajax()) {
            if (isset($request->type) && $request->type == "getPurchaseOrderData") {
                $poId = $request->poId;
                $data = PurchaseOrder::where('id', $poId)->with('items')->first();
                return $data;
            }

            $query = Indent::Query();
            $query = $query->with('po', 'customer', 'supplier', 'added_by');
            $query = $query->latest()->get();
            return DataTables::of($query)->addIndexColumn()->make(true);
        }

        return view('indent.index', $data);
    }

    public function create()
    {
        $data['page_title'] = "Add New Indent";
        $data['customers'] = Customer::latest()->get();
        $data['suppliers'] = Supplier::latest()->get();
        $data['products'] = Product::latest()->get();
        $data['purchase_orders'] = PurchaseOrder::latest()->get();

        $data["indent_no"] = 1000;
        $q = Indent::latest()->first();
        if ($q) {
            $str = $q->indent_no;
            $str = explode("-", $str);
            $str = $str[1] + 1;
            $data["indent_no"] = $str;
        }

        return view('indent.create', $data);
    }

    public function edit($id)
    {
        $data['page_title'] = "Edit Indent";
        $data['customers'] = Customer::latest()->get();
        $data['suppliers'] = Supplier::latest()->get();
        $data['products'] = Product::latest()->get();
        $data['purchase_orders'] = PurchaseOrder::latest()->get();
        $data['indent'] = Indent::where("id", $id)->with('items')->first();
        return view('indent.edit', $data);
    }

    public function view($id)
    {
        $data['page_title'] = "View Indent";
        $data['indent'] = Indent::where("id", $id)->with('items')->first();
        return view('indent.view', $data);
    }

    public function delete($id)
    {
        Indent::where("id", $id)->delete();
        IndentItems::where("indent_id", $id)->delete();
        return back()->withSuccess('Indent deleted successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'indent_no' => 'required|string|max:20|unique:indents',
            'po_id' => 'required|integer|exists:purchase_orders,id',
            'customer_id' => 'required|integer|exists:customers,id',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'date' => 'required|string|max:15',
            'port_destination' => 'nullable|string',
            'port_shipment' => 'nullable|string',
            'partial_ship' => 'nullable|string|max:200',
            'trans_shipment' => 'nullable|string|max:200',
            'packing' => 'nullable|string|max:200',
            'shipment' => 'nullable|string|max:200',
            'shipping_type' => 'nullable|string|max:200',
            'payment' => 'nullable|string|max:200',
            'latest_date_of_shipment' => 'nullable|string|max:15',
            'date_of_negotiation' => 'nullable|string|max:15',
            'validity' => 'nullable|string|max:15',
            'origin' => 'nullable|string|max:200',
            'bank_detail' => 'nullable|string',
            'remark' => 'nullable|string',
            'remark_2' => 'nullable|string',
            'shipping_marks' => 'nullable|string'
        ]);

        $indent = new Indent();
        $indent->indent_no = $request->indent_no;
        $indent->po_id = $request->po_id;
        $indent->customer_id = $request->customer_id;
        $indent->supplier_id = $request->supplier_id;
        $indent->date = $request->date;
        $indent->port_destination = $request->port_destination;
        $indent->port_shipment = $request->port_shipment;
        $indent->partial_ship = $request->partial_ship;
        $indent->trans_shipment = $request->trans_shipment;
        $indent->packing = $request->packing;
        $indent->shipment = $request->shipment;
        $indent->shipping_type = $request->shipping_type;
        $indent->payment = $request->payment;
        $indent->latest_date_of_shipment = $request->latest_date_of_shipment;
        $indent->date_of_negotiation = $request->date_of_negotiation;
        $indent->validity = $request->validity;
        $indent->origin = $request->origin;
        $indent->bank_detail = $request->bank_detail;
        $indent->remark = $request->remark;
        $indent->remark_2 = $request->remark_2;
        $indent->shipping_marks = $request->shipping_marks;
        $indent->revised = (!empty($request->revised)) ? 1 : 0;
        $indent->added_by = auth()->user()->id;

        $product = (!empty($request->product)) ? $request->product : [];

        if ($indent->save()) {
            foreach ($product as $key => $value) {
                $indent_product = new IndentItems();
                $indent_product->indent_id = $indent->id;
                $indent_product->item_id = $request->product[$key];
                $indent_product->qty = $request->product_qty[$key] ?? 0;
                $indent_product->unit = $request->product_unit[$key];
                $indent_product->rate = $request->product_rate[$key] ?? 0;
                $indent_product->total = $request->product_total[$key] ?? 0;
                $indent_product->shipment_mode = $request->product_shipment[$key];
                $indent_product->payment_term = $request->product_payment_term[$key];
                $indent_product->po_id = $request->product_po_id[$key];
                $indent_product->po_date = $request->product_po_date[$key];
                $indent_product->lot_detail = $request->product_lot_detail[$key];
                $indent_product->other_desc = $request->product_other_desc[$key];
                $indent_product->save();
            }

            return redirect()->route('indent')->withSuccess('Indent added successfully.');
        }

        return back()->withError('Something went wrong.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'indent_no' => [
                'required',
                'string',
                'max:200',
                Rule::unique('indents')->ignore($request->id),
            ],
            'po_id' => 'required|integer|exists:purchase_orders,id',
            'customer_id' => 'required|integer|exists:customers,id',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'date' => 'required|string|max:15',
            'port_destination' => 'nullable|string',
            'port_shipment' => 'nullable|string',
            'partial_ship' => 'nullable|string|max:200',
            'trans_shipment' => 'nullable|string|max:200',
            'packing' => 'nullable|string|max:200',
            'shipment' => 'nullable|string|max:200',
            'shipping_type' => 'nullable|string|max:200',
            'payment' => 'nullable|string|max:200',
            'latest_date_of_shipment' => 'nullable|string|max:15',
            'date_of_negotiation' => 'nullable|string|max:15',
            'validity' => 'nullable|string|max:15',
            'origin' => 'nullable|string|max:200',
            'bank_detail' => 'nullable|string',
            'remark' => 'nullable|string',
            'remark_2' => 'nullable|string',
            'shipping_marks' => 'nullable|string'
        ]);

        $indent = Indent::find($request->id);
        $indent->po_id = $request->po_id;
        $indent->customer_id = $request->customer_id;
        $indent->supplier_id = $request->supplier_id;
        $indent->date = $request->date;
        $indent->port_destination = $request->port_destination;
        $indent->port_shipment = $request->port_shipment;
        $indent->partial_ship = $request->partial_ship;
        $indent->trans_shipment = $request->trans_shipment;
        $indent->packing = $request->packing;
        $indent->shipment = $request->shipment;
        $indent->shipping_type = $request->shipping_type;
        $indent->payment = $request->payment;
        $indent->latest_date_of_shipment = $request->latest_date_of_shipment;
        $indent->date_of_negotiation = $request->date_of_negotiation;
        $indent->validity = $request->validity;
        $indent->origin = $request->origin;
        $indent->bank_detail = $request->bank_detail;
        $indent->remark = $request->remark;
        $indent->remark_2 = $request->remark_2;
        $indent->shipping_marks = $request->shipping_marks;
        $indent->revised = (!empty($request->revised)) ? 1 : 0;

        $product = (!empty($request->product)) ? $request->product : [];

        if ($indent->save()) {
            IndentItems::where('indent_id', $indent->id)->delete();
            foreach ($product as $key => $value) {
                $indent_product = new IndentItems();
                $indent_product->indent_id = $indent->id;
                $indent_product->item_id = $request->product[$key];
                $indent_product->qty = $request->product_qty[$key] ?? 0;
                $indent_product->unit = $request->product_unit[$key];
                $indent_product->rate = $request->product_rate[$key] ?? 0;
                $indent_product->total = $request->product_total[$key] ?? 0;
                $indent_product->shipment_mode = $request->product_shipment[$key];
                $indent_product->payment_term = $request->product_payment_term[$key];
                $indent_product->po_id = $request->product_po_id[$key];
                $indent_product->po_date = $request->product_po_date[$key];
                $indent_product->lot_detail = $request->product_lot_detail[$key];
                $indent_product->other_desc = $request->product_other_desc[$key];
                $indent_product->save();
            }

            return redirect()->route('indent')->withSuccess('Indent updated successfully.');
        }

        return back()->withError('Something went wrong.');
    }
}