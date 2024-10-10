<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class WarrantyNoteController extends Controller
{
    protected $type;

    public function __construct()
    {
        $this->type = 4;
    }

    public function index(Request $request)
    {
        $data['page_title'] = "Warranty Notes";

        if ($request->ajax()) {
            $query = Note::Query();
            $query = $query->where('type', $this->type);
            $query = $query->latest()->get();
            return DataTables::of($query)->addIndexColumn()->make(true);
        }

        return view('warranty_note.index', $data);
    }

    public function create(Request $request)
    {
        $data['page_title'] = "Add New Warranty Note";
        return view('warranty_note.create', $data);
    }

    public function edit($id)
    {
        $data['page_title'] = "Edit Warranty Note";
        $data['note'] = Note::where("id", $id)->first();
        return view('warranty_note.edit', $data);
    }

    public function delete($id)
    {
        Note::where("id", $id)->delete();
        return back()->withSuccess('Warranty Note deleted successfully.');
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
            return redirect()->route('warranty_note')->withSuccess('Warranty Note added successfully.');
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
            return redirect()->route('warranty_note')->withSuccess('Warranty Note updated successfully.');
        }

        return back()->withError('Something went wrong.');
    }
}
