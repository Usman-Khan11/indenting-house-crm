@extends('layout.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <form method="post" action="{{ route('inquiry.update') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $inquiry->id }}">

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
                            <input type="text" name="inq_no" value="{{ $inquiry->inq_no }}" class="form-control" readonly />
                        </div>
                    </div>

                    <div class="col-md-3 col-12">
                        <div class="mb-3">
                            <label class="form-label">Validity</label>
                            <input type="date" name="validity" value="{{ old('validity', $inquiry->validity) }}" class="form-control" placeholder="Validity" />
                        </div>
                    </div>

                    <div class="col-md-3 col-12">
                        <div class="mb-3">
                            <label class="form-label">Currency</label>
                            <select class="select2 form-select" name="currency">
                                @foreach(currency() as $key => $value)
                                <option @if(old('currency', $inquiry->currency)==$key ) selected @endif value="{{ $key }}">{{ $value }}</option>
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
                                <option @if(old('customer_id', $inquiry->customer_id) == $customer->id) selected @endif value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Remarks</label>
                            <textarea name="remark" class="form-control" placeholder="Remarks">{{ old('remark', $inquiry->remark) }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Remarks 2</label>
                            <textarea name="remark_2" class="form-control" placeholder="Remarks 2">{{ old('remark_2', $inquiry->remark_2) }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Signature</label>
                            <input type="text" name="signature" value="{{ old('signature', $inquiry->signature) }}" class="form-control" placeholder="Signature" />
                        </div>
                    </div>

                    <!-- Product Repeater -->
                    <div class="col-12 mb-4 card-datatable table-responsive">
                        <h4>
                            Items: &nbsp;
                            <button onclick="addProductRow(this)" type="button" class="btn btn-info btn-sm"><i class="fa fa-plus"></i></button>
                        </h4>
                        <table class="datatables-basic table table-bordered" id="product_table" style="width:170%;">
                            <thead>
                                <tr>
                                    <th>...</th>
                                    <th>Item</th>
                                    <th>Qty</th>
                                    <th>Unit</th>
                                    <th>Rate</th>
                                    <th>Total</th>
                                    <th>Shipment Mode</th>
                                    <th>Payment Term</th>
                                    <th>Delivery</th>
                                    <th>Supplier/Mfg</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $p = (!empty($inquiry->items)) ? $inquiry->items : [];
                                @endphp
                                @forelse($p as $k => $v)
                                <tr>
                                    <td>
                                        <button onclick="delProductRow(this)" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                    </td>
                                    <td>
                                        <select name="product[]" class="form-select" required>
                                            <option selected disabled value="">Select Item</option>
                                            @foreach($products as $product)
                                            <option @if($v->item_id==$product->id) selected @endif value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" onkeyup="calculation(this)" value="{{ $v->qty }}" name="product_qty[]" class="form-control product_qty" step="any" required>
                                    </td>
                                    <td>
                                        <input type="text" value="{{ $v->unit }}" name="product_unit[]" class="form-control product_unit">
                                    </td>
                                    <td>
                                        <input type="number" onkeyup="calculation(this)" value="{{ $v->rate }}" name="product_rate[]" class="form-control product_rate" step="any" required>
                                    </td>
                                    <td>
                                        <input type="number" value="{{ $v->total }}" name="product_total[]" class="form-control product_total" step="any" readonly>
                                    </td>
                                    <td>
                                        <select name="product_shipment[]" class="form-select product_shipment">
                                            <option selected value="">Select Shipment Mode</option>
                                            @foreach(shippingMode() as $key => $value)
                                            <option @if($v->shipment_mode == $key) selected @endif value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select name="product_payment_term[]" class="form-select product_payment_term">
                                            <option selected value="">Select Payment Term</option>
                                            @foreach(paymentTerms() as $key => $value)
                                            <option @if($v->payment_term == $key) selected @endif value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" value="{{ $v->delivery }}" name="product_delivery[]" class="form-control product_delivery">
                                    </td>
                                    <td>
                                        <select name="product_supplier[]" class="form-select" required>
                                            <option selected disabled value="">Select Supplier</option>
                                            @foreach($suppliers as $supplier)
                                            <option @if($v->supplier_id==$supplier->id) selected @endif value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td>
                                        <button onclick="delProductRow(this)" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                    </td>
                                    <td>
                                        <select name="product[]" class="form-select" required>
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
                                    <td>
                                        <select name="product_shipment[]" class="form-select product_shipment">
                                            <option selected value="">Select Shipment Mode</option>
                                            @foreach(shippingMode() as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select name="product_payment_term[]" class="form-select product_payment_term">
                                            <option selected value="">Select Payment Term</option>
                                            @foreach(paymentTerms() as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="product_delivery[]" class="form-control product_delivery">
                                    </td>
                                    <td>
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

                    <div class="col-md-6 col-12">
                        <div class="form-check mb-3">
                            <input class="form-check-input" @if($inquiry->is_close) checked @endif type="checkbox" value="1" id="is_close" name="is_close">
                            <label class="form-check-label" for="is_close">
                                Inquiry Close
                            </label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Reason of Close</label>
                            <textarea name="reason_of_close" class="form-control" placeholder="Reason of Close">{{ old('reason_of_close', $inquiry->reason_of_close) }}</textarea>
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