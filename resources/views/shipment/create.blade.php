@extends('layout.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <form method="post" action="{{ route('shipment.store') }}" enctype="multipart/form-data">
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
                            <label class="form-label">Shipment #</label>
                            <input type="text" name="shipment_no" value="SHIP-{{ $shipment_no }}" class="form-control" readonly />
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
                            <label class="form-label">Indents</label>
                            <select class="select2 form-select" name="indent_id" required onchange="getIndentData(this)">
                                <option selected disabled value="">Select Indent</option>
                                @foreach($indents as $indent)
                                <option @if(old('indent_id')==$indent->id) selected @endif value="{{ $indent->id }}">{{ $indent->indent_no }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2 col-12">
                        <div class="mb-3">
                            <label class="form-label">LC/BC/TT No</label>
                            <input type="text" name="lc_bt_tt_no" value="{{ old('lc_bt_tt_no') }}" class="form-control" placeholder="LC/BC/TT No" />
                        </div>
                    </div>

                    <div class="col-md-2 col-12">
                        <div class="mb-3">
                            <label class="form-label">Currency</label>
                            <select class="select2 form-select currency" name="currency">
                                @foreach(currency() as $key => $value)
                                <option @if(old('currency')==$key ) selected @endif value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2 col-12">
                        <div class="mb-3">
                            <label class="form-label">LC Issue Date</label>
                            <input type="date" name="lc_issue_date" value="{{ old('lc_issue_date') }}" class="form-control" placeholder="LC Issue Date" />
                        </div>
                    </div>

                    <div class="col-md-2 col-12">
                        <div class="mb-3">
                            <label class="form-label">LC Exp Date</label>
                            <input type="date" name="lc_exp_date" value="{{ old('lc_exp_date') }}" class="form-control" placeholder="LC Exp Date" />
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Shipment Lot No</label>
                            <select name="lot_no" class="form-select">
                                @foreach (shipmentLotDetails() as $key => $value)
                                    <option @if($key == old('lot_no')) selected @endif value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2 col-12">
                        <div class="mb-3">
                            <label class="form-label">Invoice No</label>
                            <input type="text" name="inv_no" value="{{ old('inv_no') }}" class="form-control" placeholder="Invoice No" />
                        </div>
                    </div>

                    <div class="col-md-2 col-12">
                        <div class="mb-3">
                            <label class="form-label">Invoice Date</label>
                            <input type="date" name="inv_date" value="{{ old('inv_date') }}" class="form-control" placeholder="Invoice Date" />
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
                            <select class="select2 form-select supplier_id" name="supplier_id" required>
                                <option selected disabled value="">Select Supplier</option>
                                @foreach($suppliers as $supplier)
                                <option @if(old('supplier_id')==$supplier->id) selected @endif value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2 col-12">
                        <div class="mb-3">
                            <label class="form-label">BL No</label>
                            <input type="text" name="bl_no" value="{{ old('bl_no') }}" class="form-control" placeholder="BL No" />
                        </div>
                    </div>

                    <div class="col-md-2 col-12">
                        <div class="mb-3">
                            <label class="form-label">BL Date</label>
                            <input type="date" name="bl_date" value="{{ old('bl_date') }}" class="form-control" placeholder="BL Date" />
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Payment Remarks</label>
                            <select name="payment_remark" class="form-select">
                                @foreach (paymentRemarks() as $key => $value)
                                    <option @if($key == old('payment_remark')) selected @endif value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Final Remarks</label>
                            <textarea name="final_remark" class="form-control remark" placeholder="Final Remarks">{{ old('final_remark') }}</textarea>
                        </div>
                    </div>

                    <!-- Product Repeater -->
                    <div class="col-12">
                        <h4>
                            Items: &nbsp;
                            {{-- <button onclick="addProductRow(this)" type="button" class="btn btn-info btn-sm"><i class="fa fa-plus"></i></button> --}}
                        </h4>
                        <div id="product_table">
                            @php
                            $p = old('product', []);
                            @endphp

                            @forelse ($p as $k => $v)
                            @include('shipment.product_row', [
                            'product_id' => $v,
                            'product_qty' => old('product_qty')[$k] ?? '',
                            'product_unit' => old('product_unit')[$k] ?? '',
                            'product_rate' => old('product_rate')[$k] ?? '',
                            'product_total' => old('product_total')[$k] ?? '',
                            'products' => $products
                            ])
                            @empty
                            @include('shipment.product_row', [
                            'product_id' => '',
                            'product_qty' => '',
                            'product_unit' => '',
                            'product_rate' => '',
                            'product_total' => '',
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