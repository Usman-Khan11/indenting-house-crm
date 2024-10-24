@extends('layout.app')

@push('style')
<style>
    .note,
    .delivery,
    .payment,
    .warranty {
        display: none;
    }
</style>
@endpush

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
                            <select class="select2 form-select" name="supplier_id" required>
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
                    <div class="col-12 mb-4 card-datatable table-responsive">
                        <h4>
                            Items: &nbsp;
                            <button onclick="addProductRow(this)" type="button" class="btn btn-info btn-sm"><i class="fa fa-plus"></i></button>
                        </h4>
                        <table class="datatables-basic table table-bordered" id="product_table" style="width:150%;">
                            <thead>
                                <tr>
                                    <th width="3%">...</th>
                                    <th width="30%">Item</th>
                                    <th width="8%">Qty</th>
                                    <th width="8%">Unit</th>
                                    <th width="10%">Rate</th>
                                    <th width="10%">Shipping Type</th>
                                    <th width="10%">Shipment Mode</th>
                                    <th width="10%">Payment Term</th>
                                    <th width="10%">Delivery</th>
                                    <th width="20%">Supplier/Mfg</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $p = (!empty(old('product'))) ? old('product') : [];
                                @endphp
                                @forelse($p as $k => $v)
                                <tr>
                                    <td width="3%">
                                        <button onclick="delProductRow(this)" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                    </td>
                                    <td width="30%">
                                        <select name="product[]" class="form-select" required onchange="productData(this)">
                                            <option selected disabled value="">Select Item</option>
                                            @foreach($products as $product)
                                            <option @if($v==$product->id) selected @endif value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td width="8%">
                                        <input type="number" onkeyup="calculation(this)" value="{{ old('product_qty')[$k] }}" name="product_qty[]" class="form-control product_qty" step="any" required>
                                    </td>
                                    <td width="8%">
                                        <input type="text" value="{{ old('product_unit')[$k] }}" name="product_unit[]" class="form-control product_unit">
                                    </td>
                                    <td width="10%">
                                        <input type="number" onkeyup="calculation(this)" value="{{ old('product_rate')[$k] }}" name="product_rate[]" class="form-control product_rate" step="any" required>
                                    </td>
                                    <td class="d-none">
                                        <input type="number" value="{{ old('product_total')[$k] }}" name="product_total[]" class="form-control product_total" step="any" readonly>
                                    </td>
                                    <td width="10%">
                                        <select name="product_shipping_type[]" class="form-select product_shipping_type">
                                            <option selected value="">Select Shipping Type</option>
                                            @foreach(shippingType() as $key => $value)
                                            <option @if(old('product_shipping_type')[$k]==$key) selected @endif value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td width="10%">
                                        <select name="product_shipment[]" class="form-select product_shipment">
                                            <option selected value="">Select Shipment Mode</option>
                                            @foreach(shippingMode() as $key => $value)
                                            <option @if(old('product_shipment')[$k]==$key) selected @endif value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td width="10%">
                                        <select name="product_payment_term[]" class="form-select product_payment_term">
                                            <option selected value="">Select Payment Term</option>
                                            @foreach(paymentTerms() as $key => $value)
                                            <option @if(old('product_payment_term')[$k]==$key) selected @endif value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td width="10%">
                                        <input type="text" value="{{ old('product_delivery')[$k] }}" name="product_delivery[]" class="form-control product_delivery">
                                    </td>
                                    <td width="20%">
                                        <select name="product_supplier[]" class="form-select" required>
                                            <option selected disabled value="">Select Supplier</option>
                                            @foreach($suppliers as $supplier)
                                            <option @if(old('product_supplier')[$k]==$supplier->id) selected @endif value="{{ $supplier->id }}">{{ $supplier->name }}</option>
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
                                        <select name="product[]" class="form-select" required onchange="productData(this)">
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
                                            <option selected value="">Select Shipping Type</option>
                                            @foreach(shippingType() as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td width="10%">
                                        <select name="product_shipment[]" class="form-select product_shipment">
                                            <option selected value="">Select Shipment Mode</option>
                                            @foreach(shippingMode() as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td width="10%">
                                        <select name="product_payment_term[]" class="form-select product_payment_term">
                                            <option selected value="">Select Payment Term</option>
                                            @foreach(paymentTerms() as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td width="10%">
                                        <input type="text" name="product_delivery[]" class="form-control product_delivery">
                                    </td>
                                    <td width="20%">
                                        <select name="product_supplier[]" class="form-select" required>
                                            <option selected disabled value="">Select Supplier</option>
                                            @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
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