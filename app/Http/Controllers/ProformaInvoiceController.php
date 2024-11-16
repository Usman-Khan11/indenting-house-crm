<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProformaInvoice;
use App\Models\ProformaInvoiceItems;
use App\Models\Size;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class ProformaInvoiceController extends Controller
{
    protected $nav_id;

    public function __construct()
    {
        $this->nav_id = 12;
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
        $data['page_title'] = "Proforma Invoices";
        $this->checkPermissions('view');

        if ($request->ajax()) {
            if (isset($request->type) && $request->type == "getSupplierBankDetail") {
                $data = Supplier::find($request->supId);
                return $data->band_detail;
            }

            $query = ProformaInvoice::Query();
            $query = $query->with('customer', 'supplier', 'added_by');
            $query = $query->orderBy('pi_no', 'desc')->get();
            return DataTables::of($query)->addIndexColumn()->make(true);
        }

        return view('proforma_invoice.index', $data);
    }

    public function create()
    {
        $data['page_title'] = "Add New Proforma Invoice";
        $this->checkPermissions('create');

        $data['customers'] = Customer::orderBy('name', 'asc')->get();
        $data['suppliers'] = Supplier::orderBy('name', 'asc')->get();
        $data['products'] = Product::orderBy('name', 'asc')->get();
        $data['sizes'] = Size::orderBy('name', 'asc')->get();
        $data['artworks'] = Artwork::orderBy('artwork_no', 'desc')->get();

        $data["pi_no"] = 'NHP-001000';
        $q = ProformaInvoice::orderBy('pi_no', 'desc')->first();
        if ($q) {
            $str = $q->pi_no;
            $str_parts = explode("-", $str);
            $incremented_number = str_pad($str_parts[1] + 1, strlen($str_parts[1]), "0", STR_PAD_LEFT);
            $data["pi_no"] = $str_parts[0] . "-" . $incremented_number;
        }

        return view('proforma_invoice.create', $data);
    }

    public function edit($id)
    {
        $data['page_title'] = "Edit Proforma Invoice";
        $this->checkPermissions('update');

        $data['customers'] = Customer::orderBy('name', 'asc')->get();
        $data['suppliers'] = Supplier::orderBy('name', 'asc')->get();
        $data['products'] = Product::orderBy('name', 'asc')->get();
        $data['sizes'] = Size::orderBy('name', 'asc')->get();
        $data['artworks'] = Artwork::orderBy('artwork_no', 'desc')->get();
        $data['proforma_invoice'] = ProformaInvoice::where("id", $id)->with('items')->first();
        return view('proforma_invoice.edit', $data);
    }

    public function view($id)
    {
        $data['page_title'] = "View Proforma Invoice";
        $this->checkPermissions('view');

        $data['proforma_invoice'] = ProformaInvoice::where("id", $id)->with('items')->first();
        return view('proforma_invoice.view', $data);
    }

    public function delete($id)
    {
        $this->checkPermissions('delete');

        ProformaInvoice::where("id", $id)->delete();
        ProformaInvoiceItems::where("proforma_invoice_id", $id)->delete();
        return back()->withSuccess('Proforma Invoice deleted successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pi_no' => 'required|string|max:20|unique:proforma_invoices',
            'date' => 'required|string|max:15',
            'validity' => 'nullable|string|max:15',
            'customer_id' => 'required|integer|exists:customers,id',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'port_of_ship' => 'nullable|string|max:100',
            'port_destination' => 'nullable|string|max:100',
            'partial_ship' => 'nullable|string|max:100',
            'trans_shipment' => 'nullable|string|max:100',
            'packing' => 'nullable|string|max:100',
            'shipment' => 'nullable|string|max:100',
            'shipping_type' => 'nullable|string|max:100',
            'payment' => 'nullable|string|max:100',
            'last_date_of_shipment' => 'nullable|string|max:15',
            'date_of_negotiation' => 'nullable|string|max:15',
            'origin' => 'nullable|string|max:100',
            'currency' => 'nullable|string|max:20',
            'bank_detail' => 'nullable|string',
            'remark' => 'nullable|string',
            'remark_2' => 'nullable|string',
            'shipping_marks' => 'nullable|string'
        ]);

        $pi = new ProformaInvoice();
        $pi->pi_no = $request->pi_no;
        $pi->date = $request->date;
        $pi->validity = $request->validity;
        $pi->customer_id = $request->customer_id;
        $pi->supplier_id = $request->supplier_id;
        $pi->port_of_ship = $request->port_of_ship;
        $pi->port_destination = $request->port_destination;
        $pi->partial_ship = $request->partial_ship;
        $pi->trans_shipment = $request->trans_shipment;
        $pi->packing = $request->packing;
        $pi->shipment = $request->shipment;
        $pi->shipping_type = $request->shipping_type;
        $pi->payment = $request->payment;
        $pi->last_date_of_shipment = $request->last_date_of_shipment;
        $pi->date_of_negotiation = $request->date_of_negotiation;
        $pi->origin = $request->origin;
        $pi->currency = $request->currency;
        $pi->bank_detail = $request->bank_detail;
        $pi->remark = $request->remark;
        $pi->remark_2 = $request->remark_2;
        $pi->shipping_marks = $request->shipping_marks;
        $pi->revised = (!empty($request->revised)) ? 1 : 0;
        $pi->added_by = auth()->user()->id;

        $product = (!empty($request->product)) ? $request->product : [];

        if ($pi->save()) {
            foreach ($product as $key => $value) {
                $pi_product = new ProformaInvoiceItems();
                $pi_product->proforma_invoice_id = $pi->id;
                $pi_product->item_id = $request->product[$key];
                $pi_product->qty = $request->product_qty[$key] ?? 0;
                $pi_product->unit = $request->product_unit[$key];
                $pi_product->rate = $request->product_rate[$key] ?? 0;
                $pi_product->total = $request->product_total[$key] ?? 0;
                $pi_product->size_id = $request->product_size_id[$key] ?? 0;
                $pi_product->artwork_id = $request->product_artwork_id[$key] ?? 0;
                $pi_product->save();
            }

            return redirect()->route('proforma_invoice')->withSuccess('Proforma Invoice added successfully.');
        }

        return back()->withError('Something went wrong.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'pi_no' => [
                'required',
                'string',
                'max:20',
                Rule::unique('proforma_invoices')->ignore($request->id),
            ],
            'date' => 'required|string|max:15',
            'validity' => 'nullable|string|max:15',
            'customer_id' => 'required|integer|exists:customers,id',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'port_of_ship' => 'nullable|string|max:100',
            'port_destination' => 'nullable|string|max:100',
            'partial_ship' => 'nullable|string|max:100',
            'trans_shipment' => 'nullable|string|max:100',
            'packing' => 'nullable|string|max:100',
            'shipment' => 'nullable|string|max:100',
            'shipping_type' => 'nullable|string|max:100',
            'payment' => 'nullable|string|max:100',
            'last_date_of_shipment' => 'nullable|string|max:15',
            'date_of_negotiation' => 'nullable|string|max:15',
            'origin' => 'nullable|string|max:100',
            'currency' => 'nullable|string|max:20',
            'bank_detail' => 'nullable|string',
            'remark' => 'nullable|string',
            'remark_2' => 'nullable|string',
            'shipping_marks' => 'nullable|string'
        ]);

        $pi = ProformaInvoice::find($request->id);
        $pi->pi_no = $request->pi_no;
        $pi->date = $request->date;
        $pi->validity = $request->validity;
        $pi->customer_id = $request->customer_id;
        $pi->supplier_id = $request->supplier_id;
        $pi->port_of_ship = $request->port_of_ship;
        $pi->port_destination = $request->port_destination;
        $pi->partial_ship = $request->partial_ship;
        $pi->trans_shipment = $request->trans_shipment;
        $pi->packing = $request->packing;
        $pi->shipment = $request->shipment;
        $pi->shipping_type = $request->shipping_type;
        $pi->payment = $request->payment;
        $pi->last_date_of_shipment = $request->last_date_of_shipment;
        $pi->date_of_negotiation = $request->date_of_negotiation;
        $pi->origin = $request->origin;
        $pi->currency = $request->currency;
        $pi->bank_detail = $request->bank_detail;
        $pi->remark = $request->remark;
        $pi->remark_2 = $request->remark_2;
        $pi->shipping_marks = $request->shipping_marks;
        $pi->revised = (!empty($request->revised)) ? 1 : 0;

        $product = (!empty($request->product)) ? $request->product : [];

        if ($pi->save()) {
            ProformaInvoiceItems::where('proforma_invoice_id', $pi->id)->delete();
            foreach ($product as $key => $value) {
                $pi_product = new ProformaInvoiceItems();
                $pi_product->proforma_invoice_id = $pi->id;
                $pi_product->item_id = $request->product[$key];
                $pi_product->qty = $request->product_qty[$key] ?? 0;
                $pi_product->unit = $request->product_unit[$key];
                $pi_product->rate = $request->product_rate[$key] ?? 0;
                $pi_product->total = $request->product_total[$key] ?? 0;
                $pi_product->size_id = $request->product_size_id[$key] ?? 0;
                $pi_product->artwork_id = $request->product_artwork_id[$key] ?? 0;
                $pi_product->save();
            }

            return redirect()->route('proforma_invoice')->withSuccess('Proforma Invoice updated successfully.');
        }

        return back()->withError('Something went wrong.');
    }
}
