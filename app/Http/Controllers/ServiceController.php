<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $data['page_title'] = "Services";

        if ($request->ajax()) {
            $query = Service::Query();
            $query = $query->latest()->get();
            return DataTables::of($query)->addIndexColumn()->make(true);
        }

        return view('service.index', $data);
    }

    public function create(Request $request)
    {
        $data['page_title'] = "Add New Service";
        return view('service.create', $data);
    }

    public function edit($id)
    {
        $data['page_title'] = "Edit Service";
        $data['service'] = Service::where("id", $id)->first();
        return view('service.edit', $data);
    }

    public function delete($id)
    {
        Service::where("id", $id)->delete();
        return back()->withSuccess('Service deleted successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'nullable|numeric|min:0'
        ]);

        $service = new Service();
        $service->name = $request->name;
        $service->amount = $request->amount;

        if ($service->save()) {
            return redirect()->route('service')->withSuccess('Service added successfully.');
        }

        return back()->withError('Something went wrong.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'nullable|numeric|min:0'
        ]);

        $service = Service::find($request->id);
        $service->name = $request->name;
        $service->amount = $request->amount;

        if ($service->save()) {
            return redirect()->route('service')->withSuccess('Service updated successfully.');
        }

        return back()->withError('Something went wrong.');
    }
}
