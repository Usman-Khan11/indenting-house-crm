<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Inquiry;
use App\Models\Supplier;
use App\Models\OfferItem;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class OfferController extends Controller
{
    public function index(Request $request)
    {
        $data['page_title'] = "Offers";

        if ($request->ajax()) {

            if (isset($request->type) && $request->type == "getInquiryData") {
                $inqId = $request->inqId;
                $data = Inquiry::where('id', $inqId)->with('items')->first();
                return $data;
            }

            $query = Offer::Query();
            $query = $query->with('inquiry', 'customer', 'added_by');
            $query = $query->latest()->get();
            return DataTables::of($query)->addIndexColumn()->make(true);
        }

        return view('offer.index', $data);
    }

    public function create()
    {
        $data['page_title'] = "Add New Offer";
        $data['customers'] = Customer::latest()->get();
        $data['suppliers'] = Supplier::latest()->get();
        $data['products'] = Product::latest()->get();
        $data['inquiries'] = Inquiry::latest()->get();

        $data["offer_no"] = 1000;
        $q = Offer::latest()->first();
        if ($q) {
            $str = $q->offer_no;
            $str = explode("-", $str);
            $str = $str[1] + 1;
            $data["offer_no"] = $str;
        }

        return view('offer.create', $data);
    }

    public function edit($id)
    {
        $data['page_title'] = "Edit Offer";
        $data['customers'] = Customer::latest()->get();
        $data['suppliers'] = Supplier::latest()->get();
        $data['products'] = Product::latest()->get();
        $data['inquiries'] = Inquiry::latest()->get();
        $data['offer'] = Offer::where("id", $id)->with('items')->first();
        return view('offer.edit', $data);
    }

    public function view($id)
    {
        $data['page_title'] = "View Offer";
        $data['offer'] = Offer::where("id", $id)->with('items')->first();
        return view('offer.view', $data);
    }

    public function delete($id)
    {
        Offer::where("id", $id)->delete();
        OfferItem::where("offer_id", $id)->delete();
        return back()->withSuccess('Offer deleted successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'offer_no' => 'required|string|max:200|unique:offers',
            'inquiry_id' => 'required|integer|exists:inquiries,id',
            'customer_id' => 'required|integer|exists:customers,id',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'date' => 'required|string|max:20',
            'validity' => 'nullable|string|max:20',
            'currency' => 'nullable|string|max:20',
            'remark' => 'nullable|string',
            'remark_2' => 'nullable|string',
            'status_remark' => 'nullable|string',
            'signature' => 'nullable|string|max:150'
        ]);

        $offer = new Offer();
        $offer->offer_no = $request->offer_no;
        $offer->inquiry_id = $request->inquiry_id;
        $offer->customer_id = $request->customer_id;
        $offer->supplier_id = $request->supplier_id;
        $offer->currency = $request->currency;
        // $offer->shipping_type = $request->shipping_type;
        $offer->date = $request->date;
        $offer->validity = $request->validity;
        $offer->remark = $request->remark;
        $offer->remark_2 = $request->remark_2;
        $offer->status_remark = $request->status_remark;
        $offer->signature = $request->signature;
        $offer->added_by = auth()->user()->id;

        $product = (!empty($request->product)) ? $request->product : [];

        if ($offer->save()) {
            foreach ($product as $key => $value) {
                $offer_product = new OfferItem();
                $offer_product->offer_id = $offer->id;
                $offer_product->item_id = $request->product[$key];
                $offer_product->qty = $request->product_qty[$key] ?? 0;
                $offer_product->unit = $request->product_unit[$key];
                $offer_product->rate = $request->product_rate[$key] ?? 0;
                $offer_product->total = $request->product_total[$key] ?? 0;
                $offer_product->shipping_type = $request->product_shipping_type[$key];
                $offer_product->shipment_mode = $request->product_shipment[$key];
                $offer_product->payment_term = $request->product_payment_term[$key];
                $offer_product->delivery = $request->product_delivery[$key];
                $offer_product->supplier_id = $request->product_supplier[$key];
                $offer_product->save();
            }

            return redirect()->route('offer')->withSuccess('Offer added successfully.');
        }

        return back()->withError('Something went wrong.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'offer_no' => [
                'required',
                'string',
                'max:200',
                Rule::unique('offers')->ignore($request->id),
            ],
            'inquiry_id' => 'required|integer|exists:inquiries,id',
            'customer_id' => 'required|integer|exists:customers,id',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'date' => 'required|string|max:20',
            'validity' => 'nullable|string|max:20',
            'currency' => 'nullable|string|max:20',
            'remark' => 'nullable|string',
            'remark_2' => 'nullable|string',
            'status_remark' => 'nullable|string',
            'signature' => 'nullable|string|max:150'
        ]);

        $offer = Offer::find($request->id);
        $offer->offer_no = $request->offer_no;
        $offer->inquiry_id = $request->inquiry_id;
        $offer->customer_id = $request->customer_id;
        $offer->supplier_id = $request->supplier_id;
        $offer->currency = $request->currency;
        // $offer->shipping_type = $request->shipping_type;
        $offer->date = $request->date;
        $offer->validity = $request->validity;
        $offer->remark = $request->remark;
        $offer->remark_2 = $request->remark_2;
        $offer->status_remark = $request->status_remark;
        $offer->signature = $request->signature;

        $product = (!empty($request->product)) ? $request->product : [];

        if ($offer->save()) {
            OfferItem::where('offer_id', $offer->id)->delete();
            foreach ($product as $key => $value) {
                $offer_product = new OfferItem();
                $offer_product->offer_id = $offer->id;
                $offer_product->item_id = $request->product[$key];
                $offer_product->qty = $request->product_qty[$key] ?? 0;
                $offer_product->unit = $request->product_unit[$key];
                $offer_product->rate = $request->product_rate[$key] ?? 0;
                $offer_product->total = $request->product_total[$key] ?? 0;
                $offer_product->shipping_type = $request->product_shipping_type[$key];
                $offer_product->shipment_mode = $request->product_shipment[$key];
                $offer_product->payment_term = $request->product_payment_term[$key];
                $offer_product->delivery = $request->product_delivery[$key];
                $offer_product->supplier_id = $request->product_supplier[$key];
                $offer_product->save();
            }

            return redirect()->route('offer')->withSuccess('Offer updated successfully.');
        }

        return back()->withError('Something went wrong.');
    }
}
