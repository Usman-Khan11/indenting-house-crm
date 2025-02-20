@extends('layout.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <form method="post" action="{{ route('supplier.map_product') }}" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-header">
                <h4 class="fw-bold">{{ $page_title }}</h4>
                <hr />
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="mb-3">
                            <label class="form-label">Suppliers*</label>
                            <select name="supplier_id" class="form-select select2 supplier_id">
                                <option value="" selected disabled>Select Supplier</option>
                                @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12 col-12">
                        <div class="mb-3">
                            <label class="form-label">Products*</label>
                            <select name="products[]" class="form-select select2 products" multiple>
                                @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
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

@push('script')
    <script>
        $(".supplier_id").change(function(){
            let id = $(this).val();
            $(".loader").show();

            if(id) {
                $.get("{{ route('supplier.map') }}", {
                    _token: '{{ csrf_token() }}',
                    id,
                }, function (res) {
                    $(".products").find("option:selected").attr("selected", false).trigger('change');
                    if(res){
                        $(res).each(function(i, v){
                            $(".products").find(`option[value=${v.product_id}]`).attr("selected", true).trigger('change');
                        })
                    }
                    $(".loader").hide();
                })
            } else {
                $(".loader").hide();
            }
        })
    </script>
@endpush