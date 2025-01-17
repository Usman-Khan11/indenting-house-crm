<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Inquiry;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\InquiryItem;
use App\Models\SupplierProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class InquiryController extends Controller
{
    protected $nav_id;

    public function __construct()
    {
        $this->nav_id = 4;
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
        $data['page_title'] = "Inquries";
        $this->checkPermissions('view');

        if ($request->ajax()) {
            if (isset($request->type) && $request->type == 'get_suppliers') {
                return SupplierProducts::whereIn('product_id', $request->product_ids)
                    ->with('supplier', 'product')
                    ->get();
            }
            $query = Inquiry::Query();
            $query = $query->with('customer', 'added_by', 'offer.po.indent');
            $query = $query->orderBy('inq_no', 'desc')->get();
            return DataTables::of($query)->addIndexColumn()->make(true);
        }

        return view('inquiry.index', $data);
    }

    public function create()
    {
        $data['page_title'] = "Add New Inquiry";
        $this->checkPermissions('create');

        $data['customers'] = Customer::orderBy('name', 'asc')->get();
        $data['suppliers'] = Supplier::orderBy('name', 'asc')->get();
        $data['products'] = Product::orderBy('name', 'asc')->get();

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
        $this->checkPermissions('update');

        $data['customers'] = Customer::orderBy('name', 'asc')->get();
        $data['suppliers'] = Supplier::orderBy('name', 'asc')->get();
        $data['products'] = Product::orderBy('name', 'asc')->get();
        $data['inquiry'] = Inquiry::where("id", $id)->with('items')->first();
        return $data['inquiry']->checkInquiry();
        return view('inquiry.edit', $data);
    }

    public function view($id)
    {
        $data['page_title'] = "View Inquiry";
        $this->checkPermissions('view');

        $data['inquiry'] = Inquiry::where("id", $id)->with('items')->first();
        return view('inquiry.view', $data);
    }

    public function delete($id)
    {
        $this->checkPermissions('delete');

        Inquiry::where("id", $id)->delete();
        InquiryItem::where("inquiry_id", $id)->delete();
        return back()->withSuccess('Inquiry deleted successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'inq_no' => 'required|string|max:200|unique:inquiries',
            'customer_id' => 'required|integer|exists:customers,id',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'date' => 'required|string|max:15',
            'validity' => 'nullable|string|max:20',
            'currency' => 'nullable|string|max:20',
            'remark' => 'nullable|string',
            'remark_2' => 'nullable|string',
            'signature' => 'nullable|string|max:100'
        ]);

        $inquiry = new Inquiry();
        $inquiry->inq_no = $request->inq_no;
        $inquiry->customer_id = $request->customer_id;
        $inquiry->supplier_id = $request->supplier_id;
        $inquiry->currency = $request->currency;
        $inquiry->validity = $request->validity;
        $inquiry->date = $request->date;
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
                $inquiry_product->item_desc = $request->product_description[$key];
                $inquiry_product->qty = $request->product_qty[$key] ?? 0;
                $inquiry_product->unit = $request->product_unit[$key];
                $inquiry_product->rate = $request->product_rate[$key] ?? 0;
                $inquiry_product->total = $request->product_total[$key] ?? 0;
                $inquiry_product->shipping_type = $request->product_shipping_type[$key];
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
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'validity' => 'nullable|string|max:20',
            'date' => 'required|string|max:15',
            'currency' => 'nullable|string|max:20',
            'remark' => 'nullable|string',
            'remark_2' => 'nullable|string',
            'signature' => 'nullable|string|max:100'
        ]);

        $inquiry = Inquiry::find($request->id);
        $inquiry->inq_no = $request->inq_no;
        $inquiry->customer_id = $request->customer_id;
        $inquiry->supplier_id = $request->supplier_id;
        $inquiry->currency = $request->currency;
        $inquiry->validity = $request->validity;
        $inquiry->date = $request->date;
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
                $inquiry_product->item_desc = $request->product_description[$key];
                $inquiry_product->qty = $request->product_qty[$key] ?? 0;
                $inquiry_product->unit = $request->product_unit[$key];
                $inquiry_product->rate = $request->product_rate[$key] ?? 0;
                $inquiry_product->total = $request->product_total[$key] ?? 0;
                $inquiry_product->shipping_type = $request->product_shipping_type[$key];
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
