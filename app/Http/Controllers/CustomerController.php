<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\CustomerProducts;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $data['page_title'] = "Customers";

        if ($request->ajax()) {
            $query = Customer::Query();
            $query = $query->latest()->get();
            return Datatables::of($query)->addIndexColumn()->make(true);
        }

        return view('customer.index', $data);
    }

    public function create(Request $request)
    {
        $data['page_title'] = "Add New Customer";
        return view('customer.create', $data);
    }

    public function edit($id)
    {
        $data['page_title'] = "Edit Customer";
        $data['customer'] = Customer::where("id", $id)->first();
        return view('customer.edit', $data);
    }

    public function view($id)
    {
        $data['page_title'] = "View Customer";
        $data['customer'] = Customer::where("id", $id)->with('products')->first();
        return view('customer.view', $data);
    }

    public function delete($id)
    {
        Customer::where("id", $id)->delete();
        return back()->withSuccess('Customer deleted successfully.');
    }

    public function map()
    {
        $data['page_title'] = "Customer Map Material";
        $data['customers'] = Customer::orderBy("name")->get();
        $data['products'] = Product::orderBy("name")->get();
        return view('customer.map', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:150',
            'fax_number' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:150',
            'email_2' => 'nullable|email|max:150',
            'email_3' => 'nullable|email|max:150',
            'person' => 'nullable|string|max:150',
            'person_2' => 'nullable|string|max:150',
            'person_3' => 'nullable|string|max:150',
            'address_office' => 'nullable|string',
            'address_factory' => 'nullable|string',
            'cell_1' => 'nullable|string|max:80',
            'cell_2' => 'nullable|string|max:80',
            'cell_3' => 'nullable|string|max:80',
            'phone_1' => 'nullable|string|max:80',
            'phone_2' => 'nullable|string|max:80',
        ]);

        $customer = new Customer();
        $customer->name = $request->name;
        $customer->location = $request->location;
        $customer->fax_number = $request->fax_number;
        $customer->email = $request->email;
        $customer->email_2 = $request->email_2;
        $customer->email_3 = $request->email_3;
        $customer->person = $request->person;
        $customer->person_2 = $request->person_2;
        $customer->person_3 = $request->person_3;
        $customer->address_office = $request->address_office;
        $customer->address_factory = $request->address_factory;
        $customer->cell_1 = $request->cell_1;
        $customer->cell_2 = $request->cell_2;
        $customer->cell_3 = $request->cell_3;
        $customer->phone_1 = $request->phone_1;
        $customer->phone_2 = $request->phone_2;

        if ($customer->save()) {
            return redirect()->route('customer')->withSuccess('Customer added successfully.');
        }

        return back()->withError('Something went wrong.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:150',
            'fax_number' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:150',
            'email_2' => 'nullable|email|max:150',
            'email_3' => 'nullable|email|max:150',
            'person' => 'nullable|string|max:150',
            'person_2' => 'nullable|string|max:150',
            'person_3' => 'nullable|string|max:150',
            'address_office' => 'nullable|string',
            'address_factory' => 'nullable|string',
            'cell_1' => 'nullable|string|max:80',
            'cell_2' => 'nullable|string|max:80',
            'cell_3' => 'nullable|string|max:80',
            'phone_1' => 'nullable|string|max:80',
            'phone_2' => 'nullable|string|max:80',
        ]);

        $customer = Customer::find($request->id);
        $customer->name = $request->name;
        $customer->location = $request->location;
        $customer->fax_number = $request->fax_number;
        $customer->email = $request->email;
        $customer->email_2 = $request->email_2;
        $customer->email_3 = $request->email_3;
        $customer->person = $request->person;
        $customer->person_2 = $request->person_2;
        $customer->person_3 = $request->person_3;
        $customer->address_office = $request->address_office;
        $customer->address_factory = $request->address_factory;
        $customer->cell_1 = $request->cell_1;
        $customer->cell_2 = $request->cell_2;
        $customer->cell_3 = $request->cell_3;
        $customer->phone_1 = $request->phone_1;
        $customer->phone_2 = $request->phone_2;

        if ($customer->save()) {
            return redirect()->route('customer')->withSuccess('Customer updated successfully.');
        }

        return back()->withError('Something went wrong.');
    }

    public function map_product(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'products' => 'required|array',
            'products.*' => 'exists:products,id',
        ]);

        CustomerProducts::where('customer_id', $request->customer_id)->delete();

        foreach ($request->products as $key => $value) {
            $customer_product = new CustomerProducts();
            $customer_product->customer_id = $request->customer_id;
            $customer_product->product_id = $value;
            $customer_product->save();
        }

        return redirect()->route('customer')->withSuccess('Products mapped successfully.');
    }
}
