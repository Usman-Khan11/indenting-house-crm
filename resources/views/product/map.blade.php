@extends('layout.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <form method="post" action="{{ route('product.map_product') }}" enctype="multipart/form-data">
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
                                <label class="form-label">Products*</label>
                                <select name="products" class="form-select select2 products">
                                    <option value=""></option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">
                                            {{ $product->id }} - {{ $product->name }}
                                            @if (!empty($product->code))
                                                ({{ $product->code }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12 col-12">
                            <div class="mb-3">
                                <label class="form-label">Suppliers*</label>
                                <select name="supplier_id[]" class="form-select select2 supplier_id" multiple>
                                    {{-- <option value="" selected disabled>Select Supplier</option> --}}
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->id }} - {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12 col-12">
                            <div class="mb-3">
                                <label class="form-label">Customers*</label>
                                <select name="customer_id[]" class="form-select select2 customer_id" multiple>
                                    {{-- <option value="" selected disabled>Select Customer</option> --}}
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->id }} - {{ $customer->name }}
                                        </option>
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
        $(".products").change(function() {
            let id = $(this).val();
            $(".loader").show();

            if (id) {
                $.get("{{ route('product.map') }}", {
                    _token: '{{ csrf_token() }}',
                    id,
                }, function(res) {
                    $(".supplier_id, .customer_id").find("option").prop("selected", false);

                    if (res.supplier_products.length) {
                        res.supplier_products.forEach(v => {
                            $(`.supplier_id option[value=${v.supplier_id}]`).prop("selected", true);
                        });
                    }

                    if (res.customer_products.length) {
                        res.customer_products.forEach(v => {
                            $(`.customer_id option[value=${v.customer_id}]`).prop("selected", true);
                        });
                    }

                    $(".supplier_id, .customer_id").trigger('change');
                    $(".loader").hide();
                });
            } else {
                $(".loader").hide();
            }
        });
    </script>
@endpush
