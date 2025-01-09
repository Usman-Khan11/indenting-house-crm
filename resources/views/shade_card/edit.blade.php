@extends('layout.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <form method="post" action="{{ route('shade_card.update') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="card_id" value="{{ $card->id }}">
            <input type="hidden" name="artwork_id" value="{{ $artwork->id }}">

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="fw-bold mb-0">{{ $page_title }}</h4>
                        </div>
                        <div class="col-md-6 text-end">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#search_modal">Search</button>
                        </div>
                    </div>
                    <hr />
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 border-bottom mb-3">
                            <h5 class="mb-1 fw-bold">Artwork Status:</h5>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Artwork No</label>
                                <input name="artwork_no" type="text"
                                    value="{{ old('artwork_no', $artwork->artwork_no) }}" class="form-control"
                                    placeholder="Artwork No" @if (auth()->user()->role_id != 1) readonly @endif />
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="artwork_status" class="form-select">
                                    <option @if (old('artwork_status', $artwork->status) == '1') selected @endif value="1">Approved
                                    </option>
                                    <option @if (old('artwork_status', $artwork->status) == '2') selected @endif value="2">Pending at
                                        Supplier</option>
                                    <option @if (old('artwork_status', $artwork->status) == '3') selected @endif value="3">Pending at
                                        Customer</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Print Style</label>
                                <select name="print_style" class="form-select">
                                    <option @if (old('print_style', $artwork->print_style) == '1') selected @endif value="1">Axial Not
                                        Rectified</option>
                                    <option @if (old('print_style', $artwork->print_style) == '2') selected @endif value="2">Radial Not
                                        Rectified</option>
                                    <option @if (old('print_style', $artwork->print_style) == '3') selected @endif value="3">Not Known
                                    </option>
                                    <option @if (old('print_style', $artwork->print_style) == '4') selected @endif value="4">Axial
                                        Rectified</option>
                                    <option @if (old('print_style', $artwork->print_style) == '5') selected @endif value="5">Radial
                                        Rectified</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 col-12">
                            <div class="mb-3">
                                <label class="form-label">Front Print</label>
                                <input name="front_print" type="text" class="form-control"
                                    value="{{ old('front_print', $artwork->front_print) }}" placeholder="Front Print" />
                            </div>
                        </div>

                        <div class="col-md-3 col-12">
                            <div class="mb-3">
                                <label class="form-label">Front Print Color</label>
                                <input name="front_print_color" type="text" class="form-control"
                                    value="{{ old('front_print_color', $artwork->front_print_color) }}"
                                    placeholder="Front Print Color" />
                            </div>
                        </div>

                        <div class="col-md-3 col-12">
                            <div class="mb-3">
                                <label class="form-label">Back Print</label>
                                <input name="back_print" type="text" class="form-control"
                                    value="{{ old('back_print', $artwork->back_print) }}" placeholder="Back Print" />
                            </div>
                        </div>

                        <div class="col-md-3 col-12">
                            <div class="mb-3">
                                <label class="form-label">Back Print Color</label>
                                <input name="back_print_color" type="text" class="form-control"
                                    value="{{ old('back_print_color', $artwork->back_print_color) }}"
                                    placeholder="Back Print Color" />
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label">Remarks</label>
                                <textarea name="remarks" rows="5" class="form-control" placeholder="Remarks">{{ old('remarks', $artwork->remarks) }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-3 col-12">
                            <div class="mb-3">
                                <label class="form-label">Image</label>
                                <input name="artwork_image" type="file" class="form-control" placeholder="Image" />
                            </div>
                        </div>

                        <div class="col-12 border-bottom my-3">
                            <h5 class="mb-1 fw-bold">Card Status:</h5>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Customers</label>
                                <select class="select2 form-select customer_id" name="customer_id" required>
                                    <option selected disabled value="">Select Customer</option>
                                    @foreach ($customers as $customer)
                                        <option @if (old('customer_id', $card->customer_id) == $customer->id) selected @endif
                                            value="{{ $customer->id }}">{{ $customer->id }} -- {{ $customer->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Suppliers</label>
                                <select class="select2 form-select supplier_id" name="supplier_id" required>
                                    <option selected disabled value="">Select Supplier</option>
                                    @foreach ($suppliers as $supplier)
                                        <option @if (old('supplier_id', $card->supplier_id) == $supplier->id) selected @endif
                                            value="{{ $supplier->id }}">{{ $supplier->id }} -- {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Products</label>
                                <select class="select2 form-select item_id" name="item_id" required>
                                    <option selected disabled value="">Select Product</option>
                                    @foreach ($products as $product)
                                        @if (old('item_id', $card->item_id))
                                            <option selected value="{{ $product->id }}">{{ $product->id }} --
                                                {{ $product->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 col-12">
                            <div class="mb-3">
                                <label class="form-label">Sizes</label>
                                <select class="select2 form-select size_id" name="size_id" required>
                                    <option selected disabled value="">Select Size</option>
                                    @foreach ($sizes as $size)
                                        <option @if (old('size_id', $card->size_id) == $size->id) selected @endif
                                            value="{{ $size->id }}">{{ $size->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 col-12">
                            <div class="mb-3">
                                <label class="form-label">Card No</label>
                                <input name="card_no" type="text" value="{{ old('card_no', $card->card_no) }}"
                                    class="form-control" placeholder="Card No"
                                    @if (auth()->user()->role_id != 1) readonly @endif />
                            </div>
                        </div>

                        <div class="col-md-2 col-12">
                            <div class="mb-3">
                                <label class="form-label">Date</label>
                                <input type="date" required name="date" value="{{ old('date', $card->date) }}"
                                    class="form-control date" placeholder="Date" />
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Ingredient</label>
                                <input name="ingredient" type="text" class="form-control"
                                    value="{{ old('ingredient', $card->ingredient) }}" placeholder="Ingredient" />
                            </div>
                        </div>

                        <div class="col-md-3 col-12">
                            <div class="mb-3">
                                <label class="form-label">Front Color</label>
                                <input name="front_color" type="text" class="form-control"
                                    value="{{ old('front_color', $card->front_color) }}" placeholder="Front Color" />
                            </div>
                        </div>

                        <div class="col-md-3 col-12">
                            <div class="mb-3">
                                <label class="form-label">Front Code</label>
                                <input name="front_code" type="text" class="form-control"
                                    value="{{ old('front_code', $card->front_code) }}" placeholder="Front Code" />
                            </div>
                        </div>

                        <div class="col-md-3 col-12">
                            <div class="mb-3">
                                <label class="form-label">Back Color</label>
                                <input name="back_color" type="text" class="form-control"
                                    value="{{ old('back_color', $card->back_color) }}" placeholder="Back Color" />
                            </div>
                        </div>

                        <div class="col-md-3 col-12">
                            <div class="mb-3">
                                <label class="form-label">Back Code</label>
                                <input name="back_code" type="text" class="form-control"
                                    value="{{ old('back_code', $card->back_code) }}" placeholder="Back Code" />
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="card_status" class="form-select">
                                    <option @if (old('card_status', $card->status) == '1') selected @endif value="1">Approved
                                    </option>
                                    <option @if (old('card_status', $card->status) == '2') selected @endif value="2">Pending at
                                        Supplier</option>
                                    <option @if (old('card_status', $card->status) == '3') selected @endif value="3">Pending at
                                        Customer</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Ref Code</label>
                                <input name="ref_code" type="text" class="form-control"
                                    value="{{ old('ref_code', $card->ref_code) }}" placeholder="Ref Code" />
                            </div>
                        </div>

                        <div class="col-md-3 col-12">
                            <div class="mb-3">
                                <label class="form-label">Image</label>
                                <input name="card_image" type="file" class="form-control" placeholder="Image" />
                            </div>
                        </div>

                        <div class="col-md-12 col-12 mt-3">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Search Modal -->
    @include('shade_card.partials.search_modal')
@endsection
