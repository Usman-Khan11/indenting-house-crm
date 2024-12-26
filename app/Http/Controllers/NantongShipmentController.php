<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\ProformaInvoice;
use App\Models\Shipment;
use App\Models\ShipmentItems;
use App\Models\Size;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class NantongShipmentController extends Controller
{
    protected $nav_id;

    public function __construct()
    {
        $this->nav_id = 13;
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
        $data['page_title'] = "Nantong Shipments";
        $this->checkPermissions('view');

        if ($request->ajax()) {
            if (isset($request->type) && $request->type == "getProformaInvoiceData") {
                $piId = $request->piId;
                $data = ProformaInvoice::where('id', $piId)->with('items')->first();
                return $data;
            }

            $query = Shipment::Query();
            $query = $query->where('indent_id', 0);
            $query = $query->with('pi', 'customer', 'supplier', 'added_by');
            $query = $query->orderBy('date', 'desc')->get();
            return DataTables::of($query)->addIndexColumn()->make(true);
        }

        return view('nantong_shipment.index', $data);
    }

    public function create()
    {
        $data['page_title'] = "Add New Nantong Shipment";
        $this->checkPermissions('create');

        $data['customers'] = Customer::orderBy('name', 'asc')->get();
        $data['suppliers'] = Supplier::orderBy('name', 'asc')->get();
        $data['products'] = Product::orderBy('name', 'asc')->get();
        $data['sizes'] = Size::orderBy('name', 'asc')->get();
        $data['proforma_invoices'] = ProformaInvoice::leftJoin('shipments', 'proforma_invoices.id', '=', 'shipments.pi_id')->whereNull('shipments.pi_id')->select('proforma_invoices.*')->latest()->get();

        $data["shipment_no"] = 1000;
        $q = Shipment::latest()->first();
        if ($q) {
            $str = $q->shipment_no;
            $str = $str + 1;
            $data["shipment_no"] = $str;
        }

        return view('nantong_shipment.create', $data);
    }

    public function edit($id)
    {
        $data['page_title'] = "Edit Nantong Shipment";
        $this->checkPermissions('update');

        $data['customers'] = Customer::orderBy('name', 'asc')->get();
        $data['suppliers'] = Supplier::orderBy('name', 'asc')->get();
        $data['products'] = Product::orderBy('name', 'asc')->get();
        $data['proforma_invoices'] = ProformaInvoice::latest()->get();
        $data['shipment'] = Shipment::where("id", $id)->with('items')->first();
        return view('nantong_shipment.edit', $data);
    }

    public function view($id)
    {
        $data['page_title'] = "View Nantong Shipment";
        $this->checkPermissions('view');

        $data['shipment'] = Shipment::where("id", $id)->with('items')->first();
        return view('nantong_shipment.view', $data);
    }

    public function delete($id)
    {
        $this->checkPermissions('delete');

        Shipment::where("id", $id)->delete();
        ShipmentItems::where("shipment_id", $id)->delete();
        return back()->withSuccess('Shipment deleted successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipment_no' => 'required|string|max:20|unique:shipments',
            'date' => 'required|date',
            'currency' => 'nullable|string|max:30',
            'pi_id' => 'required|integer|exists:proforma_invoices,id',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'customer_id' => 'required|integer|exists:customers,id',
            'lc_bt_tt_no' => 'nullable|string|max:100',
            'lc_issue_date' => 'nullable|date',
            'lc_exp_date' => 'nullable|date',
            'final_remark' => 'nullable|string',
        ]);

        $shipment = new Shipment();
        $shipment->shipment_no = $request->shipment_no;
        $shipment->pi_id = $request->pi_id;
        $shipment->customer_id = $request->customer_id;
        $shipment->supplier_id = $request->supplier_id;
        $shipment->date = $request->date;
        $shipment->currency = $request->currency;
        $shipment->lc_bt_tt_no = $request->lc_bt_tt_no;
        $shipment->lc_issue_date = $request->lc_issue_date;
        $shipment->lc_exp_date = $request->lc_exp_date;
        $shipment->final_remark = $request->final_remark;
        $shipment->added_by = auth()->user()->id;

        $product = (!empty($request->product)) ? $request->product : [];
        $lot_no = (!empty($request->lot_no)) ? $request->lot_no : [];
        $arr = [];

        foreach ($lot_no as $key => $value) {
            $arr[$value . '_' . $key] = [
                "lot_no" => $value,
                "inv_no" => $request->inv_no[$key],
                "inv_date" => $request->inv_date[$key],
                "bl_no" => $request->bl_no[$key],
                "bl_date" => $request->bl_date[$key],
                "payment_remark" => $request->payment_remark[$key],
                "payment_remark_2" => $request->payment_remark_2[$key],
            ];
        }

        $shipment->lot_no = $arr;

        if ($shipment->save()) {
            foreach ($product as $key => $value) {
                $shipment_product = new ShipmentItems();
                $shipment_product->shipment_id = $shipment->id;
                $shipment_product->item_id = $request->product[$key];
                $shipment_product->qty = $request->product_qty[$key] ?? 0;
                $shipment_product->unit = $request->product_unit[$key];
                $shipment_product->rate = $request->product_rate[$key] ?? 0;
                $shipment_product->total = $request->product_total[$key] ?? 0;
                $shipment_product->size_id = $request->product_size_id[$key] ?? 0;
                $shipment_product->save();
            }

            return redirect()->route('nantong_shipment')->withSuccess('Shipment added successfully.');
        }

        return back()->withError('Something went wrong.');
    }
}
