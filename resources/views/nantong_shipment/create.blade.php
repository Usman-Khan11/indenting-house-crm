@extends('layout.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <form method="post" action="{{ route('nantong_shipment.store') }}" enctype="multipart/form-data">
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
                                <input type="text" name="shipment_no" value="{{ $shipment_no }}" class="form-control"
                                    readonly />
                            </div>
                        </div>

                        <div class="col-md-2 col-12">
                            <div class="mb-3">
                                <label class="form-label">Date</label>
                                <input type="date" required name="date" value="{{ old('date', date('Y-m-d')) }}"
                                    class="form-control" placeholder="Date" />
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Proforma Invoices</label>
                                <select class="select2 form-select" name="pi_id" required
                                    onchange="getProformaInvoiceData(this)">
                                    <option selected disabled value="">Select Proforma Invoice</option>
                                    @foreach ($proforma_invoices as $proforma_invoice)
                                        <option @if (old('pi_id') == $proforma_invoice->id) selected @endif
                                            value="{{ $proforma_invoice->id }}">{{ $proforma_invoice->pi_no }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2 col-12">
                            <div class="mb-3">
                                <label class="form-label">LC/BC/TT No</label>
                                <input type="text" name="lc_bt_tt_no" value="{{ old('lc_bt_tt_no') }}"
                                    class="form-control lc_bt_tt_no" placeholder="LC/BC/TT No" />
                            </div>
                        </div>

                        <div class="col-md-2 col-12">
                            <div class="mb-3">
                                <label class="form-label">Currency</label>
                                <select class="select2 form-select currency" name="currency">
                                    @foreach (currency() as $key => $value)
                                        <option @if (old('currency') == $key) selected @endif
                                            value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2 col-12">
                            <div class="mb-3">
                                <label class="form-label">LC Issue Date</label>
                                <input type="date" name="lc_issue_date" value="{{ old('lc_issue_date') }}"
                                    class="form-control" placeholder="LC Issue Date" />
                            </div>
                        </div>

                        <div class="col-md-2 col-12">
                            <div class="mb-3">
                                <label class="form-label">LC Exp Date</label>
                                <input type="date" name="lc_exp_date" value="{{ old('lc_exp_date') }}"
                                    class="form-control" placeholder="LC Exp Date" />
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Customers</label>
                                <select class="select2 form-select customer_id" name="customer_id" required>
                                    <option selected disabled value="">Select Customer</option>
                                    @foreach ($customers as $customer)
                                        <option @if (old('customer_id') == $customer->id) selected @endif
                                            value="{{ $customer->id }}">{{ $customer->id }} -- {{ $customer->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Suppliers</label>
                                <select class="select2 form-select supplier_id" name="supplier_id" required>
                                    <option selected disabled value="">Select Supplier</option>
                                    @foreach ($suppliers as $supplier)
                                        <option @if (old('supplier_id') == $supplier->id) selected @endif
                                            value="{{ $supplier->id }}">{{ $supplier->id }} -- {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 shipment_lot_row">
                            <div class="mb-2">
                                <button onclick="addShipmentLotRow(this)" type="button"
                                    class="btn btn-info btn-sm p-1 px-2"><i class="fa fa-plus"></i></button>
                                <button onclick="delShipmentLotRow(this)" type="button"
                                    class="btn btn-danger btn-sm p-1 px-2"><i class="fa fa-trash-alt"></i></button>
                            </div>

                            @php
                                $p = old('lot_no', []);
                            @endphp

                            @forelse ($p as $k => $v)
                                @include('nantong_shipment.shipment_lot_row', [
                                    'lot_no' => $v,
                                    'inv_no' => old('inv_no')[$k] ?? '',
                                    'inv_date' => old('inv_date')[$k] ?? '',
                                    'bl_no' => old('bl_no')[$k] ?? '',
                                    'bl_date' => old('bl_date')[$k] ?? '',
                                    'payment_remark' => old('payment_remark')[$k] ?? '',
                                    'payment_remark_2' => old('payment_remark_2')[$k] ?? '',
                                ])
                            @empty
                                @include('nantong_shipment.shipment_lot_row', [
                                    'lot_no' => '',
                                    'inv_no' => '',
                                    'inv_date' => '',
                                    'bl_no' => '',
                                    'bl_date' => '',
                                    'payment_remark' => '',
                                    'payment_remark_2' => '',
                                ])
                            @endforelse
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
                                    @include('nantong_shipment.product_row', [
                                        'sno' => $k + 1,
                                        'product_id' => $v,
                                        'product_description' => old('product_description')[$k] ?? '',
                                        'product_qty' => old('product_qty')[$k] ?? '',
                                        'product_unit' => old('product_unit')[$k] ?? '',
                                        'product_rate' => old('product_rate')[$k] ?? '',
                                        'product_total' => old('product_total')[$k] ?? '',
                                        'product_size_id' => old('product_size_id')[$k] ?? '',
                                        'products' => $products,
                                        'sizes' => $sizes,
                                    ])
                                @empty
                                    @include('nantong_shipment.product_row', [
                                        'sno' => 1,
                                        'product_id' => '',
                                        'product_description' => '',
                                        'product_qty' => '',
                                        'product_unit' => '',
                                        'product_rate' => '',
                                        'product_total' => '',
                                        'product_size_id' => '',
                                        'products' => $products,
                                        'sizes' => $sizes,
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
