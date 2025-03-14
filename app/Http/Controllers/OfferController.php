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
    protected $nav_id;

    public function __construct()
    {
        $this->nav_id = 5;
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
        $data['page_title'] = "Offers";
        $this->checkPermissions('view');

        if ($request->ajax()) {

            if (isset($request->type) && $request->type == "getInquiryData") {
                $inqId = $request->inqId;
                $data = Inquiry::where('id', $inqId)->with('items')->first();
                return $data;
            }

            $query = Offer::Query();
            $query = $query->with('inquiry', 'customer', 'added_by', 'po.indent');
            $query = $query->get();
            return DataTables::of($query)->addIndexColumn()->make(true);
        }

        return view('offer.index', $data);
    }

    public function create()
    {
        $data['page_title'] = "Add New Offer";
        $this->checkPermissions('create');

        $data['customers'] = Customer::orderBy('name', 'asc')->get();
        $data['suppliers'] = Supplier::orderBy('name', 'asc')->get();
        $data['products'] = Product::orderBy('name', 'asc')->get();
        $data['inquiries'] =  Inquiry::leftJoin('offers', 'inquiries.id', '=', 'offers.inquiry_id')->whereNull('offers.inquiry_id')->select('inquiries.*')->latest()->get();

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
        $this->checkPermissions('update');

        $data['customers'] = Customer::orderBy('name', 'asc')->get();
        $data['suppliers'] = Supplier::orderBy('name', 'asc')->get();
        $data['products'] = Product::orderBy('name', 'asc')->get();
        $data['inquiries'] = Inquiry::latest()->get();
        $data['offer'] = Offer::where("id", $id)->with('items', 'customer', 'supplier')->first();
        return view('offer.edit', $data);
    }

    public function view($id)
    {
        $data['page_title'] = "View Offer";
        $this->checkPermissions('view');

        $data['offer'] = Offer::where("id", $id)->with('items')->first();
        return view('offer.view', $data);
    }

    public function delete($id)
    {
        $this->checkPermissions('delete');

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
            'signature' => 'nullable|string|max:150',
            'sales_person' => 'nullable|string|max:80',
            'sourcing_person' => 'nullable|string|max:80'
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
        $offer->sales_person = $request->sales_person;
        $offer->sourcing_person = $request->sourcing_person;

        $product = (!empty($request->product)) ? $request->product : [];

        if ($offer->save()) {
            foreach ($product as $key => $value) {
                $offer_product = new OfferItem();
                $offer_product->offer_id = $offer->id;
                $offer_product->item_id = $request->product[$key];
                $offer_product->item_desc = $request->product_description[$key];
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
            'signature' => 'nullable|string|max:150',
            'sales_person' => 'nullable|string|max:80',
            'sourcing_person' => 'nullable|string|max:80'
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
        $offer->sales_person = $request->sales_person;
        $offer->sourcing_person = $request->sourcing_person;

        $product = (!empty($request->product)) ? $request->product : [];

        if ($offer->save()) {
            OfferItem::where('offer_id', $offer->id)->delete();
            foreach ($product as $key => $value) {
                $offer_product = new OfferItem();
                $offer_product->offer_id = $offer->id;
                $offer_product->item_id = $request->product[$key];
                $offer_product->item_desc = $request->product_description[$key];
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
