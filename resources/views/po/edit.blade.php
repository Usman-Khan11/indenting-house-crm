@extends('layout.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <form method="post" action="{{ route('po.update') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $po->id }}">

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
                            <input type="text" name="po_no" value="{{ $po->po_no }}" class="form-control" readonly />
                        </div>
                    </div>

                    <div class="col-md-2 col-12">
                        <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" required name="date" value="{{ old('date', $po->date) }}" class="form-control" placeholder="Date" />
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Offers</label>
                            <select class="select2 form-select" name="offer_id" required onchange="getOfferData(this)">
                                <option selected disabled value="">Select Offer</option>
                                @foreach($offers as $offer)
                                <option @if(old('offer_id', $po->offer_id) == $offer->id) selected @endif value="{{ $offer->id }}">{{ $offer->offer_no }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Customer</label>
                            <select class="select2 form-select customer_id" name="customer_id" required disabled>
                                <option selected disabled value="">Select Customer</option>
                                @foreach($customers as $customer)
                                <option @if(old('customer_id', $po->customer_id) == $customer->id) selected @endif value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Suppliers</label>
                            <select class="select2 form-select supplier_id" name="supplier_id" required disabled>
                                <option selected disabled value="">Select Supplier</option>
                                @foreach($suppliers as $supplier)
                                <option @if(old('supplier_id', $po->supplier_id) == $supplier->id) selected @endif value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2 col-12">
                        <div class="mb-3">
                            <label class="form-label">Currency</label>
                            <select class="select2 form-select currency" name="currency">
                                @foreach(currency() as $key => $value)
                                <option @if(old('currency', $po->currency)==$key ) selected @endif value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Remarks</label>
                            <textarea name="remark" class="form-control remark" placeholder="Remarks">{{ old('remark', $po->remark) }}</textarea>
                        </div>
                    </div>

                    <!-- Product Repeater -->
                    <div class="col-12 mb-4 card-datatable table-responsive">
                        <h4>
                            Items: &nbsp;
                            <button onclick="addProductRow(this)" type="button" class="btn btn-info btn-sm"><i class="fa fa-plus"></i></button>
                        </h4>
                        <table class="datatables-basic table table-bordered" id="product_table" style="width:100%;">
                            <thead>
                                <tr>
                                    <th width="3%">...</th>
                                    <th width="30%">Item</th>
                                    <th width="8%">Qty</th>
                                    <th width="8%">Unit</th>
                                    <th width="10%">Rate</th>
                                    <th width="10%">Shipping Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $p = (!empty($po->items)) ? $po->items : [];
                                @endphp
                                @forelse($p as $k => $v)
                                <tr>
                                    <td width="3%">
                                        <button onclick="delProductRow(this)" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                    </td>
                                    <td width="30%">
                                        <select name="product[]" class="form-select product" required onchange="productData(this)">
                                            <option selected disabled value="">Select Item</option>
                                            @foreach($products as $product)
                                            <option @if($v->item_id==$product->id) selected @endif value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td width="8%">
                                        <input type="number" onkeyup="calculation(this)" value="{{ $v->qty }}" name="product_qty[]" class="form-control product_qty" step="any" required>
                                    </td>
                                    <td width="8%">
                                        <input type="text" value="{{ $v->unit }}" name="product_unit[]" class="form-control product_unit">
                                    </td>
                                    <td width="10%">
                                        <input type="number" onkeyup="calculation(this)" value="{{ $v->rate }}" name="product_rate[]" class="form-control product_rate" step="any" required>
                                    </td>
                                    <td class="d-none">
                                        <input type="number" value="{{ $v->total }}" name="product_total[]" class="form-control product_total" step="any" readonly>
                                    </td>
                                    <td width="10%">
                                        <select name="product_shipping_type[]" class="form-select product_shipping_type">
                                            <option value="" selected>Select Shipping Type</option>
                                            @foreach(shippingType() as $key => $value)
                                            <option @if($v->shipping_type == $key) selected @endif value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td width="3%">
                                        <button onclick="delProductRow(this)" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                    </td>
                                    <td width="30%">
                                        <select name="product[]" class="form-select product" required onchange="productData(this)">
                                            <option selected disabled value="">Select Item</option>
                                            @foreach($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td width="8%">
                                        <input type="number" onkeyup="calculation(this)" name="product_qty[]" class="form-control product_qty" step="any" required>
                                    </td>
                                    <td width="8%">
                                        <input type="text" name="product_unit[]" class="form-control product_unit">
                                    </td>
                                    <td width="10%">
                                        <input type="number" onkeyup="calculation(this)" name="product_rate[]" class="form-control product_rate" step="any" required>
                                    </td>
                                    <td class="d-none">
                                        <input type="number" name="product_total[]" class="form-control product_total" step="any" readonly>
                                    </td>
                                    <td width="10%">
                                        <select name="product_shipping_type[]" class="form-select product_shipping_type">
                                            <option value="" selected>Select Shipping Type</option>
                                            @foreach(shippingType() as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
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