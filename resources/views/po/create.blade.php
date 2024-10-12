@extends('layout.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <form method="post" action="{{ route('po.store') }}" enctype="multipart/form-data">
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
                            <label class="form-label">PO #</label>
                            <input type="text" name="po_no" value="PO-{{ $po_no }}" class="form-control" readonly />
                        </div>
                    </div>

                    <div class="col-md-2 col-12">
                        <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" required name="date" value="{{ old('date', date('Y-m-d')) }}" class="form-control" placeholder="Date" />
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Offers</label>
                            <select class="select2 form-select" name="offer_id" required onchange="getOfferData(this)">
                                <option selected disabled value="">Select Offer</option>
                                @foreach($offers as $offer)
                                <option @if(old('offer_id')==$offer->id) selected @endif value="{{ $offer->id }}">{{ $offer->offer_no }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Customers</label>
                            <select class="select2 form-select customer_id" name="customer_id" required>
                                <option selected disabled value="">Select Customer</option>
                                @foreach($customers as $customer)
                                <option @if(old('customer_id')==$customer->id) selected @endif value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Suppliers</label>
                            <select class="select2 form-select" name="supplier_id" required>
                                <option selected disabled value="">Select Supplier</option>
                                @foreach($suppliers as $supplier)
                                <option @if(old('supplier_id')==$supplier->id) selected @endif value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2 col-12">
                        <div class="mb-3">
                            <label class="form-label">Shipping Type</label>
                            <select name="shipping_type" class="form-select shipping_type">
                                @foreach(shippingType() as $key => $value)
                                <option @if(old('shipping_type')==$key) selected @endif value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Remarks</label>
                            <textarea name="remark" class="form-control remark" placeholder="Remarks">{{ old('remark') }}</textarea>
                        </div>
                    </div>

                    <!-- Product Repeater -->
                    <div class="col-12 mb-4 card-datatable table-responsive">
                        <h4>
                            Items: &nbsp;
                            <button onclick="addProductRow(this)" type="button" class="btn btn-info btn-sm"><i class="fa fa-plus"></i></button>
                        </h4>
                        <table class="datatables-basic table table-bordered" id="product_table" style="width:120%;">
                            <thead>
                                <tr>
                                    <th>...</th>
                                    <th>Item</th>
                                    <th>Qty</th>
                                    <th>Unit</th>
                                    <th>Rate</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $p = (!empty(old('product'))) ? old('product') : [];
                                @endphp
                                @forelse($p as $k => $v)
                                <tr>
                                    <td>
                                        <button onclick="delProductRow(this)" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                    </td>
                                    <td>
                                        <select name="product[]" class="form-select product" required>
                                            <option selected disabled value="">Select Item</option>
                                            @foreach($products as $product)
                                            <option @if($v==$product->id) selected @endif value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" onkeyup="calculation(this)" value="{{ old('product_qty')[$k] }}" name="product_qty[]" class="form-control product_qty" step="any" required>
                                    </td>
                                    <td>
                                        <input type="text" value="{{ old('product_unit')[$k] }}" name="product_unit[]" class="form-control product_unit">
                                    </td>
                                    <td>
                                        <input type="number" onkeyup="calculation(this)" value="{{ old('product_rate')[$k] }}" name="product_rate[]" class="form-control product_rate" step="any" required>
                                    </td>
                                    <td>
                                        <input type="number" value="{{ old('product_total')[$k] }}" name="product_total[]" class="form-control product_total" step="any" readonly>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td>
                                        <button onclick="delProductRow(this)" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                    </td>
                                    <td>
                                        <select name="product[]" class="form-select product" required>
                                            <option selected disabled value="">Select Item</option>
                                            @foreach($products as $product)
                                            <option data-price="{{ $product->unit_price }}" value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" onkeyup="calculation(this)" name="product_qty[]" class="form-control product_qty" step="any" required>
                                    </td>
                                    <td>
                                        <input type="text" name="product_unit[]" class="form-control product_unit">
                                    </td>
                                    <td>
                                        <input type="number" onkeyup="calculation(this)" name="product_rate[]" class="form-control product_rate" step="any" required>
                                    </td>
                                    <td>
                                        <input type="number" name="product_total[]" class="form-control product_total" step="any" readonly>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
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