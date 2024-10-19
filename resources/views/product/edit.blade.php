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
                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label class="form-label">Name*</label>
                            <input name="name" type="text" class="form-control" value="{{ old('name', $product->name) }}" placeholder="Name*" />
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" placeholder="Description">{{ old('description', $product->description) }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">HS Code</label>
                            <input name="hs_code" type="text" class="form-control" value="{{ old('hs_code', $product->hs_code) }}" placeholder="HS Code" />
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Unit</label>
                            <input name="unit" type="text" class="form-control" value="{{ old('unit', $product->unit) }}" placeholder="Unit" />
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Type</label>
                            <select name="type" class="form-select">
                                <option @if(old('type',$product->type)=='Packaging' ) selected @endif value="Packaging">Packaging</option>
                                <option @if(old('type',$product->type)=='Raw Material' ) selected @endif value="Raw Material">Raw Material</option>
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