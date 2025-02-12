@extends('layout.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <form method="post" action="{{ route('product.update') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $product->id }}">

            <div class="card">
                <div class="card-header">
                    <h4 class="fw-bold">{{ $page_title }}</h4>
                    <hr />
                </div>
                <div class="card-body">
                    <div class="row">
                        {{-- <div class="col-3">
                            <h5><b>Material ID: </b> {{ $product->id }}</h5>
                        </div> --}}

                        <div class="col-md-3 col-12">
                            <div class="mb-3">
                                <label class="form-label">Material ID*</label>
                                <input name="new_id" type="number" class="form-control"
                                    value="{{ old('new_id', $product->id) }}" placeholder="ID*"
                                    @if (auth()->user()->role_id != 1) readonly @endif />
                            </div>
                        </div>

                        <div class="col-md-12 col-12">
                            <div class="mb-3">
                                <label class="form-label">Name*</label>
                                <input name="name" type="text" class="form-control"
                                    value="{{ old('name', $product->name) }}" placeholder="Name*" />
                            </div>
                        </div>

                        <div class="col-md-8 col-12">
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" placeholder="Description">{{ old('description', $product->description) }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">HS Code</label>
                                <input name="hs_code" type="text" class="form-control"
                                    value="{{ old('hs_code', $product->hs_code) }}" placeholder="HS Code" />
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Unit</label>
                                <select name="unit" class="form-select">
                                    @foreach (units() as $key => $value)
                                        <option @if (old('unit', $product->unit) == $key) selected @endif
                                            value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Type</label>
                                <select name="type" class="form-select">
                                    <option @if (old('type', $product->type) == 'Packaging') selected @endif value="Packaging">Packaging
                                    </option>
                                    <option @if (old('type', $product->type) == 'Raw Material') selected @endif value="Raw Material">Raw
                                        Material</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Item Code</label>
                                <input name="code" type="text" class="form-control"
                                    value="{{ old('code', $product->code) }}" placeholder="Item Code" />
                            </div>
                        </div>

                        <div class="col-md-2 col-12">
                            <div class="mb-3">
                                <label class="form-label">Scodes</label>
                                <select name="scode" class="form-select">
                                    <option value="" selected></option>
                                    @foreach (scodes() as $key => $value)
                                        <option @if (old('scode', $product->scode) == $key) selected @endif
                                            value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2 col-12">
                            <div class="mb-3">
                                <label class="form-label">Pup</label>
                                <select name="pup" class="form-select">
                                    <option value="" selected></option>
                                    @foreach (pup() as $key => $value)
                                        <option @if (old('pup', $product->pup) == $key) selected @endif
                                            value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
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
@endsection
