<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Service;
use App\Models\Customer;
use App\Models\Quotation;
use App\Models\QuotationProduct;
use App\Models\QuotationService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class QuotationController extends Controller
{
    public function index(Request $request)
    {
        $data['page_title'] = "Quotations";

        if ($request->ajax()) {
            $query = Quotation::Query();
            $query = $query->latest()->get();
            return DataTables::of($query)->addIndexColumn()->make(true);
        }

        return view('quotation.index', $data);
    }

    public function create()
    {
        $data['page_title'] = "Add New Quotation";
        $data['customers'] = Customer::latest()->get();
        $data['products'] = Product::latest()->get();
        $data['services'] = Service::latest()->get();

        $data["quotation_num"] = 1000;
        $q = Quotation::latest()->first();
        if ($q) {
            $str = $q->num;
            $str = explode("-", $str);
            $str = $str[1] + 1;
            $data["quotation_num"] = $str;
        }

        return view('quotation.create', $data);
    }

    public function edit($id)
    {
        $data['page_title'] = "Edit Quotation";
        $data['customers'] = Customer::latest()->get();
        $data['products'] = Product::latest()->get();
        $data['services'] = Service::latest()->get();
        $data['quotation'] = Quotation::where("id", $id)->first();
        return view('quotation.edit', $data);
    }

    public function delete($id)
    {
        Quotation::where("id", $id)->delete();
        QuotationProduct::where("quotation_id", $id)->delete();
        QuotationService::where("quotation_id", $id)->delete();
        return back()->withSuccess('Quotation deleted successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'num' => 'required|string|max:200|unique:quotations',
            'customer_id' => 'required|integer|exists:customers,id',
            'validity' => 'nullable|string|max:150',
            'subject' => 'nullable|string|max:150',
            'gst' => 'nullable|string|max:20',
            'date' => 'required',
            'sst' => 'nullable|string|max:20',
            'discount' => 'nullable|string|max:20',
            's_discount' => 'nullable|string|max:20',
            'note' => 'nullable|string',
            'delivery' => 'nullable|string',
            'payment' => 'nullable|string',
            'warranty' => 'nullable|string|max:150',
            'show_txt' => 'nullable|array',
        ]);

        $quotation = new Quotation();
        $quotation->num = $request->num;
        $quotation->customer_id = $request->customer_id;
        $quotation->validity = $request->validity;
        $quotation->subject = $request->subject;
        $quotation->date = $request->date;
        $quotation->discount = $request->discount;
        $quotation->s_discount = $request->s_discount;
        $quotation->note = $request->note;
        $quotation->delivery = $request->delivery;
        $quotation->payment = $request->payment;
        $quotation->warranty = $request->warranty;
        $quotation->show_txt = $request->show_txt;
        $quotation->added_by = auth()->user()->id;
        $quotation->tax = $request->tax;
        if ($quotation->tax == 1) {
            $quotation->gst = $request->gst;
            $quotation->sst = $request->sst;
        }

        $product = (!empty($request->product)) ? $request->product : [];
        $service = (!empty($request->service)) ? $request->service : [];

        if ($quotation->save()) {
            foreach ($product as $key => $value) {
                $quotation_product = new QuotationProduct();
                $quotation_product->quotation_id = $quotation->id;
                $quotation_product->product_id = $request->product[$key];
                $quotation_product->qty = $request->product_qty[$key] ?? 0;
                $quotation_product->price = $request->product_rate[$key] ?? 0;
                $quotation_product->unit = $request->product_unit[$key];
                $quotation_product->order = $request->product_order[$key] ?? 0;
                $quotation_product->save();
            }

            foreach ($service as $key => $value) {
                $quotation_service = new QuotationService();
                $quotation_service->quotation_id = $quotation->id;
                $quotation_service->service_id = $request->service[$key];
                $quotation_service->qty = $request->service_qty[$key] ?? 0;
                $quotation_service->price = $request->service_rate[$key] ?? 0;
                $quotation_service->unit = $request->service_unit[$key];
                $quotation_service->order = $request->service_order[$key] ?? 0;
                $quotation_service->save();
            }

            return redirect()->route('quotation')->withSuccess('Quotation added successfully.');
        }

        return back()->withError('Something went wrong.');
    }
}
