<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Inquiry;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\InquiryItem;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $data['page_title'] = "Inquries";

        if ($request->ajax()) {
            $query = Inquiry::Query();
            $query = $query->with('customer', 'added_by');
            $query = $query->latest()->get();
            return DataTables::of($query)->addIndexColumn()->make(true);
        }

        return view('inquiry.index', $data);
    }

    public function create()
    {
        $data['page_title'] = "Add New Inquiry";
        $data['customers'] = Customer::latest()->get();
        $data['suppliers'] = Supplier::latest()->get();
        $data['products'] = Product::latest()->get();

        $data["inq_no"] = 1000;
        $q = Inquiry::latest()->first();
        if ($q) {
            $str = $q->inq_no;
            $str = explode("-", $str);
            $str = $str[1] + 1;
            $data["inq_no"] = $str;
        }

        return view('inquiry.create', $data);
    }

    public function edit($id)
    {
        $data['page_title'] = "Edit Inquiry";
        $data['customers'] = Customer::latest()->get();
        $data['suppliers'] = Supplier::latest()->get();
        $data['products'] = Product::latest()->get();
        $data['inquiry'] = Inquiry::where("id", $id)->with('items')->first();
        return view('inquiry.edit', $data);
    }

    public function view($id)
    {
        $data['page_title'] = "View Inquiry";
        $data['inquiry'] = Inquiry::where("id", $id)->with('items')->first();
        return view('inquiry.view', $data);
    }

    public function delete($id)
    {
        Inquiry::where("id", $id)->delete();
        InquiryItem::where("inquiry_id", $id)->delete();
        return back()->withSuccess('Inquiry deleted successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'inq_no' => 'required|string|max:200|unique:inquiries',
            'customer_id' => 'required|integer|exists:customers,id',
            'validity' => 'nullable|string|max:20',
            'currency' => 'nullable|string|max:20',
            'remark' => 'nullable|string',
            'remark_2' => 'nullable|string',
            'signature' => 'nullable|string|max:100'
        ]);

        $inquiry = new Inquiry();
        $inquiry->inq_no = $request->inq_no;
        $inquiry->customer_id = $request->customer_id;
        $inquiry->currency = $request->currency;
        $inquiry->validity = $request->validity;
        $inquiry->remark = $request->remark;
        $inquiry->remark_2 = $request->remark_2;
        $inquiry->signature = $request->signature;
        $inquiry->added_by = auth()->user()->id;

        $product = (!empty($request->product)) ? $request->product : [];

        if ($inquiry->save()) {
            foreach ($product as $key => $value) {
                $inquiry_product = new InquiryItem();
                $inquiry_product->inquiry_id = $inquiry->id;
                $inquiry_product->item_id = $request->product[$key];
                $inquiry_product->qty = $request->product_qty[$key] ?? 0;
                $inquiry_product->unit = $request->product_unit[$key];
                $inquiry_product->rate = $request->product_rate[$key] ?? 0;
                $inquiry_product->total = $request->product_total[$key] ?? 0;
                $inquiry_product->shipment_mode = $request->product_shipment[$key];
                $inquiry_product->payment_term = $request->product_payment_term[$key];
                $inquiry_product->delivery = $request->product_delivery[$key];
                $inquiry_product->supplier_id = $request->product_supplier[$key];
                $inquiry_product->save();
            }

            return redirect()->route('inquiry')->withSuccess('Inquiry added successfully.');
        }

        return back()->withError('Something went wrong.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'inq_no' => [
                'required',
                'string',
                'max:200',
                Rule::unique('inquiries')->ignore($request->id),
            ],
            'customer_id' => 'required|integer|exists:customers,id',
            'validity' => 'nullable|string|max:20',
            'currency' => 'nullable|string|max:20',
            'remark' => 'nullable|string',
            'remark_2' => 'nullable|string',
            'signature' => 'nullable|string|max:100'
        ]);

        $inquiry = Inquiry::find($request->id);
        $inquiry->inq_no = $request->inq_no;
        $inquiry->customer_id = $request->customer_id;
        $inquiry->currency = $request->currency;
        $inquiry->validity = $request->validity;
        $inquiry->remark = $request->remark;
        $inquiry->remark_2 = $request->remark_2;
        $inquiry->signature = $request->signature;
        $inquiry->reason_of_close = $request->reason_of_close;
        if ($inquiry->is_close == 0 && $request->is_close == 1) {
            $inquiry->closed_at = date("Y-m-d h:i:s");
        }
        $inquiry->is_close = (!empty($request->is_close)) ? 1 : 0;

        $product = (!empty($request->product)) ? $request->product : [];

        if ($inquiry->save()) {
            InquiryItem::where('inquiry_id', $inquiry->id)->delete();
            foreach ($product as $key => $value) {
                $inquiry_product = new InquiryItem();
                $inquiry_product->inquiry_id = $inquiry->id;
                $inquiry_product->item_id = $request->product[$key];
                $inquiry_product->qty = $request->product_qty[$key] ?? 0;
                $inquiry_product->unit = $request->product_unit[$key];
                $inquiry_product->rate = $request->product_rate[$key] ?? 0;
                $inquiry_product->total = $request->product_total[$key] ?? 0;
                $inquiry_product->shipment_mode = $request->product_shipment[$key];
                $inquiry_product->payment_term = $request->product_payment_term[$key];
                $inquiry_product->delivery = $request->product_delivery[$key];
                $inquiry_product->supplier_id = $request->product_supplier[$key];
                $inquiry_product->save();
            }

            return redirect()->route('inquiry')->withSuccess('Inquiry updated successfully.');
        }

        return back()->withError('Something went wrong.');
    }
}
