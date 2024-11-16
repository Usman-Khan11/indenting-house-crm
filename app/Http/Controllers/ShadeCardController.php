<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Card;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Size;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class ShadeCardController extends Controller
{
    protected $nav_id;

    public function __construct()
    {
        $this->nav_id = 11;
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
        $data['page_title'] = "Shade Card & Artwork";
        $this->checkPermissions('view');

        if ($request->ajax()) {
            $query = Card::Query();
            $query = $query->with('artwork', 'customer', 'supplier', 'item', 'size')->orderBy('card_no', 'desc')->get();
            return DataTables::of($query)->addIndexColumn()->make(true);
        }

        return view('shade_card.index', $data);
    }

    public function create(Request $request)
    {
        $data['page_title'] = "Add New Shade Card & Artwork";
        $this->checkPermissions('create');

        $data['customers'] = Customer::orderBy('name', 'asc')->get();
        $data['suppliers'] = Supplier::orderBy('name', 'asc')->get();
        $data['products'] = Product::orderBy('name', 'asc')->get();
        $data['sizes'] = Size::orderBy('name', 'asc')->get();

        return view('shade_card.create', $data);
    }

    public function edit($id)
    {
        $data['page_title'] = "Edit Shade Card & Artwork";
        $this->checkPermissions('update');

        $data['customers'] = Customer::orderBy('name', 'asc')->get();
        $data['suppliers'] = Supplier::orderBy('name', 'asc')->get();
        $data['products'] = Product::orderBy('name', 'asc')->get();
        $data['sizes'] = Size::orderBy('name', 'asc')->get();
        $data['card'] = Card::where("id", $id)->first();
        $data['artwork'] = Artwork::where("card_id", $id)->first();

        return view('shade_card.edit', $data);
    }

    public function view($id)
    {
        $data['page_title'] = "View Shade Card & Artwork";
        $this->checkPermissions('view');

        $data['card'] = Card::where("id", $id)->first();
        $data['artwork'] = Artwork::where("card_id", $id)->first();

        return view('shade_card.view', $data);
    }

    public function delete($id)
    {
        $this->checkPermissions('delete');

        $card = Card::where("id", $id)->first();
        $artwork = Artwork::where("card_id", $id)->first();

        if ($card) {
            deleteImage($card->image);
            $card->delete();
        }

        if ($artwork) {
            deleteImage($artwork->image);
            $artwork->delete();
        }

        return back()->withSuccess('Shade Card deleted successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'card_no' => 'required|string|max:20|unique:cards',
            'date' => 'required|string|max:20',
            'customer_id' => 'required|integer|exists:customers,id',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'item_id' => 'required|integer|exists:products,id',
            'size_id' => 'required|integer|exists:sizes,id',
            'front_color' => 'nullable|string|max:50',
            'front_code' => 'nullable|string|max:50',
            'back_color' => 'nullable|string|max:50',
            'back_code' => 'nullable|string|max:50',
            'ingredient' => 'nullable|string|max:100',
            'ref_code' => 'nullable|string|max:150',
            'card_status' => 'required',
            'card_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1048',

            'artwork_no' => 'required|string|max:20|unique:artworks',
            'front_print' => 'nullable|string|max:50',
            'front_print_color' => 'nullable|string|max:50',
            'back_print' => 'nullable|string|max:50',
            'back_print_color' => 'nullable|string|max:50',
            'remarks' => 'nullable|string',
            'artwork_status' => 'required',
            'print_style' => 'required',
            'artwork_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1048',
        ]);

        $card = new Card();
        $card->card_no = $request->card_no;
        $card->date = $request->date;
        $card->customer_id = $request->customer_id;
        $card->supplier_id = $request->supplier_id;
        $card->item_id = $request->item_id;
        $card->size_id = $request->size_id;
        $card->front_color = $request->front_color;
        $card->front_code = $request->front_code;
        $card->back_color = $request->back_color;
        $card->back_code = $request->back_code;
        $card->ingredient = $request->ingredient;
        $card->ref_code = $request->ref_code;
        $card->status = $request->card_status;

        if ($request->hasFile('card_image')) {
            $file = $request->file('card_image');
            $card->image = uploadImage($file, 'assets/img/cards/');
        }

        if ($card->save()) {
            $artwork = new Artwork();

            if ($request->hasFile('artwork_image')) {
                $file = $request->file('artwork_image');
                $artwork->image = uploadImage($file, 'assets/img/artworks/');
            }

            $artwork->card_id = $card->id;
            $artwork->artwork_no = $request->artwork_no;
            $artwork->front_print = $request->front_print;
            $artwork->front_print_color = $request->front_print_color;
            $artwork->back_print = $request->back_print;
            $artwork->back_print_color = $request->back_print_color;
            $artwork->remarks = $request->remarks;
            $artwork->status = $request->artwork_status;
            $artwork->print_style = $request->print_style;
            $artwork->save();

            return redirect()->route('shade_card')->withSuccess('Shade Card added successfully.');
        }

        return back()->withError('Something went wrong.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'card_no' => [
                'required',
                'string',
                'max:20',
                Rule::unique('cards')->ignore($request->card_id),
            ],
            'date' => 'required|string|max:20',
            'customer_id' => 'required|integer|exists:customers,id',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'item_id' => 'required|integer|exists:products,id',
            'size_id' => 'required|integer|exists:sizes,id',
            'front_color' => 'nullable|string|max:50',
            'front_code' => 'nullable|string|max:50',
            'back_color' => 'nullable|string|max:50',
            'back_code' => 'nullable|string|max:50',
            'ingredient' => 'nullable|string|max:100',
            'ref_code' => 'nullable|string|max:150',
            'card_status' => 'required',
            'card_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1048',

            'artwork_no' => [
                'required',
                'string',
                'max:20',
                Rule::unique('artworks')->ignore($request->artwork_id),
            ],
            'front_print' => 'nullable|string|max:50',
            'front_print_color' => 'nullable|string|max:50',
            'back_print' => 'nullable|string|max:50',
            'back_print_color' => 'nullable|string|max:50',
            'remarks' => 'nullable|string',
            'artwork_status' => 'required',
            'print_style' => 'required',
            'artwork_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1048',
        ]);

        $card = Card::find($request->card_id);
        $card->card_no = $request->card_no;
        $card->date = $request->date;
        $card->customer_id = $request->customer_id;
        $card->supplier_id = $request->supplier_id;
        $card->item_id = $request->item_id;
        $card->size_id = $request->size_id;
        $card->front_color = $request->front_color;
        $card->front_code = $request->front_code;
        $card->back_color = $request->back_color;
        $card->back_code = $request->back_code;
        $card->ingredient = $request->ingredient;
        $card->ref_code = $request->ref_code;
        $card->status = $request->card_status;

        if ($request->hasFile('card_image')) {
            $file = $request->file('card_image');
            $card->image = uploadImage($file, 'assets/img/cards/', $card->image);
        }

        if ($card->save()) {
            $artwork = Artwork::where('card_id', $card->id)->first();

            if ($request->hasFile('artwork_image')) {
                $file = $request->file('artwork_image');
                $artwork->image = uploadImage($file, 'assets/img/artworks/', $artwork->image);
            }

            $artwork->artwork_no = $request->artwork_no;
            $artwork->front_print = $request->front_print;
            $artwork->front_print_color = $request->front_print_color;
            $artwork->back_print = $request->back_print;
            $artwork->back_print_color = $request->back_print_color;
            $artwork->remarks = $request->remarks;
            $artwork->status = $request->artwork_status;
            $artwork->print_style = $request->print_style;
            $artwork->save();

            return redirect()->route('shade_card')->withSuccess('Shade Card updated successfully.');
        }

        return back()->withError('Something went wrong.');
    }
}
