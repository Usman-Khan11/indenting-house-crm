<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Indent;
use App\Models\Product;
use App\Models\Shipment;
use App\Models\ShipmentItems;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class ShipmentController extends Controller
{
    protected $nav_id;

    public function __construct()
    {
        $this->nav_id = 9;
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
        $data['page_title'] = "Shipments";
        $this->checkPermissions('view');

        if ($request->ajax()) {
            if (isset($request->type) && $request->type == "getIndentData") {
                $indentId = $request->indentId;
                $data = Indent::where('id', $indentId)->with('items')->first();
                return $data;
            }

            // $query = Shipment::join('customers', 'shipments.customer_id', '=', 'customers.id')
            //     ->join('suppliers', 'shipments.supplier_id', '=', 'suppliers.id')
            //     ->join('indents', 'shipments.indent_id', '=', 'indents.id')
            //     ->join('users', 'shipments.added_by', '=', 'users.id')
            //     ->select(
            //         'shipments.id',
            //         'shipments.shipment_no',
            //         'shipments.date as shipment_date',
            //         'shipments.customer_id',
            //         'shipments.supplier_id',
            //         'shipments.currency',
            //         'customers.name as customer_name',
            //         'suppliers.name as supplier_name',
            //         'indents.indent_no',
            //         'indents.date as indent_date',
            //         'users.name as user_name',
            //     );

            // if (!empty($request->input('search')['value'])) {
            //     $search = $request->input('search')['value'];
            //     $query->where(function ($q) use ($search) {
            //         $q->where('shipments.id', "{$search}")
            //             ->orWhere('shipments.shipment_no', "{$search}")
            //             ->orWhere('shipments.currency', "{$search}")
            //             ->orWhere('indents.indent_no', 'like', "%{$search}%")
            //             ->orWhere('customers.name', 'like', "%{$search}%")
            //             ->orWhere('suppliers.name', 'like', "%{$search}%")
            //             ->orWhere('users.name', 'like', "%{$search}%");
            //     });
            // }

            $query = Shipment::Query();
            $query = $query->where('shipments.pi_id', 0);
            $query = $query->with('indent', 'customer', 'supplier', 'added_by');
            $query = $query->get();
            return DataTables::of($query)->addIndexColumn()->make(true);
        }

        return view('shipment.index', $data);
    }

    public function create()
    {
        $data['page_title'] = "Add New Shipment";
        $this->checkPermissions('create');

        $data['customers'] = Customer::orderBy('name', 'asc')->get();
        $data['suppliers'] = Supplier::orderBy('name', 'asc')->get();
        $data['products'] = Product::orderBy('name', 'asc')->get();
        $data['indents'] = Indent::leftJoin('shipments', 'indents.id', '=', 'shipments.indent_id')->whereNull('shipments.indent_id')->select('indents.*')->latest()->get();

        $data["shipment_no"] = 1000;
        $q = Shipment::latest()->first();
        if ($q) {
            $str = $q->shipment_no;
            $str = $str + 1;
            $data["shipment_no"] = $str;
        }

        return view('shipment.create', $data);
    }

    public function edit($id)
    {
        $data['page_title'] = "Edit Shipment";
        $this->checkPermissions('update');

        $data['customers'] = Customer::orderBy('name', 'asc')->get();
        $data['suppliers'] = Supplier::orderBy('name', 'asc')->get();
        $data['products'] = Product::orderBy('name', 'asc')->get();
        $data['indents'] = Indent::latest()->get();
        $data['shipment'] = Shipment::where("id", $id)->with('items')->first();
        return view('shipment.edit', $data);
    }

    public function view($id)
    {
        $data['page_title'] = "View Shipment";
        $this->checkPermissions('view');

        $data['shipment'] = Shipment::where("id", $id)->with('items')->first();
        return view('shipment.view', $data);
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
            'indent_id' => 'required|integer|exists:indents,id',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'customer_id' => 'required|integer|exists:customers,id',
            'lc_bt_tt_no' => 'nullable|string|max:100',
            'lc_issue_date' => 'nullable|date',
            'lc_exp_date' => 'nullable|date',
            // 'lot_no' => 'required|string|max:100',
            // 'inv_no' => 'required|string|max:40',
            // 'inv_date' => 'required|date',
            // 'bl_no' => 'required|string|max:40',
            // 'bl_date' => 'required|date',
            // 'payment_remark' => 'nullable|string',
            'final_remark' => 'nullable|string',
        ]);

        $shipment = new Shipment();
        $shipment->shipment_no = $request->shipment_no;
        $shipment->indent_id = $request->indent_id;
        $shipment->customer_id = $request->customer_id;
        $shipment->supplier_id = $request->supplier_id;
        $shipment->date = $request->date;
        $shipment->currency = $request->currency;
        $shipment->lc_bt_tt_no = $request->lc_bt_tt_no;
        $shipment->lc_issue_date = $request->lc_issue_date;
        $shipment->lc_exp_date = $request->lc_exp_date;
        // $shipment->lot_no = $request->lot_no;
        // $shipment->inv_no = $request->inv_no;
        // $shipment->inv_date = $request->inv_date;
        // $shipment->bl_no = $request->bl_no;
        // $shipment->bl_date = $request->bl_date;
        // $shipment->payment_remark = $request->payment_remark;
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
                $shipment_product->save();
            }

            return redirect()->route('shipment')->withSuccess('Shipment added successfully.');
        }

        return back()->withError('Something went wrong.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'shipment_no' => [
                'required',
                'string',
                'max:20',
                Rule::unique('shipments')->ignore($request->id),
            ],
            'date' => 'required|date',
            'currency' => 'nullable|string|max:30',
            'indent_id' => 'required|integer|exists:indents,id',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'customer_id' => 'required|integer|exists:customers,id',
            'lc_bt_tt_no' => 'nullable|string|max:100',
            'lc_issue_date' => 'nullable|date',
            'lc_exp_date' => 'nullable|date',
            // 'lot_no' => 'required|string|max:100',
            // 'inv_no' => 'required|string|max:40',
            // 'inv_date' => 'required|date',
            // 'bl_no' => 'required|string|max:40',
            // 'bl_date' => 'required|date',
            // 'payment_remark' => 'nullable|string',
            'final_remark' => 'nullable|string',
        ]);

        $shipment = Shipment::find($request->id);
        $shipment->shipment_no = $request->shipment_no;
        $shipment->indent_id = $request->indent_id;
        $shipment->customer_id = $request->customer_id;
        $shipment->supplier_id = $request->supplier_id;
        $shipment->date = $request->date;
        $shipment->currency = $request->currency;
        $shipment->lc_bt_tt_no = $request->lc_bt_tt_no;
        $shipment->lc_issue_date = $request->lc_issue_date;
        $shipment->lc_exp_date = $request->lc_exp_date;
        // $shipment->lot_no = $request->lot_no;
        // $shipment->inv_no = $request->inv_no;
        // $shipment->inv_date = $request->inv_date;
        // $shipment->bl_no = $request->bl_no;
        // $shipment->bl_date = $request->bl_date;
        // $shipment->payment_remark = $request->payment_remark;
        $shipment->final_remark = $request->final_remark;

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
                "payment_remark_2" => $request->payment_remark_2[$key]
            ];
        }

        $shipment->lot_no = $arr;

        if ($shipment->save()) {
            ShipmentItems::where('shipment_id', $shipment->id)->delete();
            foreach ($product as $key => $value) {
                $shipment_product = new ShipmentItems();
                $shipment_product->shipment_id = $shipment->id;
                $shipment_product->item_id = $request->product[$key];
                $shipment_product->qty = $request->product_qty[$key] ?? 0;
                $shipment_product->unit = $request->product_unit[$key];
                $shipment_product->rate = $request->product_rate[$key] ?? 0;
                $shipment_product->total = $request->product_total[$key] ?? 0;
                $shipment_product->save();
            }

            return redirect()->route('shipment')->withSuccess('Shipment updated successfully.');
        }

        return back()->withError('Something went wrong.');
    }
}
