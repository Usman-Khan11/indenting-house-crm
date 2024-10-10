<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DeliveryNoteController extends Controller
{
    protected $type;

    public function __construct()
    {
        $this->type = 2;
    }

    public function index(Request $request)
    {
        $data['page_title'] = "Delivery Notes";

        if ($request->ajax()) {
            $query = Note::Query();
            $query = $query->where('type', $this->type);
            $query = $query->latest()->get();
            return DataTables::of($query)->addIndexColumn()->make(true);
        }

        return view('delivery_note.index', $data);
    }

    public function create(Request $request)
    {
        $data['page_title'] = "Add New Delivery Note";
        return view('delivery_note.create', $data);
    }

    public function edit($id)
    {
        $data['page_title'] = "Edit Delivery Note";
        $data['note'] = Note::where("id", $id)->first();
        return view('delivery_note.edit', $data);
    }

    public function delete($id)
    {
        Note::where("id", $id)->delete();
        return back()->withSuccess('Delivery Note deleted successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required|string'
        ]);

        $note = new Note();
        $note->text = $request->text;
        $note->type = $this->type;
        $note->for_type = $request->for_type;

        if ($note->save()) {
            return redirect()->route('delivery_note')->withSuccess('Delivery Note added successfully.');
        }

        return back()->withError('Something went wrong.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'text' => 'required|string'
        ]);

        $note = Note::find($request->id);
        $note->text = $request->text;
        $note->type = $this->type;
        $note->for_type = $request->for_type;

        if ($note->save()) {
            return redirect()->route('delivery_note')->withSuccess('Delivery Note updated successfully.');
        }

        return back()->withError('Something went wrong.');
    }
}
