@extends('layout.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <form method="post" action="{{ route('inquiry.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-header">
                <h4 class="fw-bold">{{ $page_title }}</h4>
                <hr />
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2 col-12">
                        <div class="mb-3">
                            <label class="form-label">Inquiry #</label>
                            <input type="text" name="inq_no" value="INQ-{{ $inq_no }}" class="form-control" readonly />
                        </div>
                    </div>

                    <div class="col-md-3 col-12">
                        <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" class="form-control" placeholder="Date" />
                        </div>
                    </div>

                    <div class="col-md-3 col-12">
                        <div class="mb-3">
                            <label class="form-label">Validity</label>
                            <input type="date" name="validity" value="{{ old('validity') }}" class="form-control" placeholder="Validity" />
                        </div>
                    </div>

                    <div class="col-md-3 col-12">
                        <div class="mb-3">
                            <label class="form-label">Currency</label>
                            <select class="select2 form-select" name="currency">
                                @foreach(currency() as $key => $value)
                                <option @if(old('currency')==$key ) selected @endif value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Customer</label>
                            <select class="select2 form-select" name="customer_id" required>
                                <option selected disabled value="">Select Customer</option>
                                @foreach($customers as $customer)
                                <option @if(old('customer_id')==$customer->id) selected @endif value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Supplier</label>
                            <select class="select2 form-select" name="supplier_id" required onchange="getSupplierProducts(this)">
                                <option selected disabled value="">Select Supplier</option>
                                @foreach($suppliers as $supplier)
                                <option @if(old('supplier_id')==$supplier->id) selected @endif value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Remarks</label>
                            <textarea name="remark" class="form-control" placeholder="Remarks">{{ old('remark', 'Kindly quote your best posible C3 By Air/Sea Karachi L/C at Sight prices for the following item') }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Remarks 2</label>
                            <textarea name="remark_2" class="form-control" placeholder="Remarks 2">{{ old('remark_2') }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Signature</label>
                            <input type="text" name="signature" value="{{ old('signature') }}" class="form-control" placeholder="Signature" />
                        </div>
                    </div>

                    <!-- Product Repeater -->
                    <div class="col-12">
                        <h4>
                            Items: &nbsp;
                            <button onclick="addProductRow(this)" type="button" class="btn btn-info btn-sm"><i class="fa fa-plus"></i></button>
                        </h4>
                        <div id="product_table">
                            @php
                            $p = old('product', []);
                            @endphp

                            @forelse ($p as $k => $v)
                            @include('inquiry.product_row', [
                            'product_id' => $v,
                            'product_qty' => old('product_qty')[$k] ?? '',
                            'product_unit' => old('product_unit')[$k] ?? '',
                            'product_rate' => old('product_rate')[$k] ?? '',
                            'product_total' => old('product_total')[$k] ?? '',
                            'product_shipping_type' => old('product_shipping_type')[$k] ?? '',
                            'product_shipment' => old('product_shipment')[$k] ?? '',
                            'product_payment_term' => old('product_payment_term')[$k] ?? '',
                            'product_delivery' => old('product_delivery')[$k] ?? '',
                            'product_supplier' => old('product_supplier')[$k] ?? '',
                            'suppliers' => $suppliers,
                            'products' => $products
                            ])
                            @empty
                            @include('inquiry.product_row', [
                            'product_id' => '',
                            'product_qty' => '',
                            'product_unit' => '',
                            'product_rate' => '',
                            'product_total' => '',
                            'product_shipping_type' => '',
                            'product_shipment' => '',
                            'product_payment_term' => '',
                            'product_delivery' => '',
                            'product_supplier' => '',
                            'suppliers' => $suppliers,
                            'products' => $products
                            ])
                            @endforelse
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