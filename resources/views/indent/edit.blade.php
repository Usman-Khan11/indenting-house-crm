@extends('layout.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <form method="post" action="{{ route('indent.update') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $indent->id }}">

            <div class="card">
                <div class="card-header">
                    <h4 class="fw-bold">{{ $page_title }}</h4>
                    <hr />
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 col-12">
                            <div class="mb-3">
                                <label class="form-label">INDENT #</label>
                                <input type="text" name="indent_no" value="{{ $indent->indent_no }}" class="form-control"
                                    @if (auth()->user()->id != 1) readonly @endif />
                            </div>
                        </div>

                        <div class="col-md-2 col-12">
                            <div class="mb-3">
                                <label class="form-label">Date</label>
                                <input type="date" required name="date" value="{{ old('date', $indent->date) }}"
                                    class="form-control" placeholder="Date" onchange="indentDates(this)" />
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Purchase Orders</label>
                                <select class="select2 form-select" name="po_id" required
                                    onchange="getPurchaseOrderData(this)">
                                    <option selected disabled value="">Select Purchase Order</option>
                                    @foreach ($purchase_orders as $purchase_order)
                                        <option @if (old('po_id', $indent->po_id) == $purchase_order->id) selected @endif
                                            value="{{ $purchase_order->id }}">{{ $purchase_order->po_no }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Customer</label>
                                <select class="select2 form-select" name="customer_id" required disabled>
                                    <option selected disabled value="">Select Customer</option>
                                    @foreach ($customers as $customer)
                                        <option @if (old('customer_id', $indent->customer_id) == $customer->id) selected @endif
                                            data-sales_person="{{ $customer->sales_person }}" value="{{ $customer->id }}">
                                            {{ $customer->id }} -- {{ $customer->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Suppliers</label>
                                <select class="select2 form-select" name="supplier_id" required disabled
                                    onchange="getBankDetail(this)">
                                    <option selected disabled value="">Select Supplier</option>
                                    @foreach ($suppliers as $supplier)
                                        <option @if (old('supplier_id', $indent->supplier_id) == $supplier->id) selected @endif
                                            data-sourcing_person="{{ $supplier->sourcing_person }}"
                                            value="{{ $supplier->id }}">{{ $supplier->id }} -- {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @php
                            $sales_persons = $indent->customer
                                ? explode('|', $indent->customer->sales_person ?? '')
                                : [];
                            $sourcing_persons = $indent->supplier
                                ? explode('|', $indent->supplier->sourcing_person ?? '')
                                : [];
                        @endphp
                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Sales Person</label>
                                <select class="select2 form-select sales_person" name="sales_person">
                                    @foreach ($sales_persons as $sales_person)
                                        @php
                                            $sales_person = trim($sales_person);
                                        @endphp
                                        <option @if ($sales_person == $indent->sales_person) selected @endif
                                            value="{{ $sales_person }}">
                                            {{ $sales_person }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Sourcing Person</label>
                                <select class="select2 form-select sourcing_person" name="sourcing_person">
                                    @foreach ($sourcing_persons as $sourcing_person)
                                        @php
                                            $sourcing_person = trim($sourcing_person);
                                        @endphp
                                        <option @if ($sourcing_person == $indent->sourcing_person) selected @endif
                                            value="{{ $sourcing_person }}">
                                            {{ $sourcing_person }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Port of Shipment</label>
                                <select name="port_shipment" class="form-select port_shipment select2">
                                    <option value="" selected>Select Shipment</option>
                                    @foreach (portOfShipment() as $key => $value)
                                        <option @if (old('port_shipment', $indent->port_shipment) == $key) selected @endif
                                            value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Port of Destination</label>
                                <select name="port_destination" class="form-select port_destination select2">
                                    <option value="" selected>Select Destination</option>
                                    @foreach (portOfDestination() as $key => $value)
                                        <option @if (old('port_destination', $indent->port_destination) == $key) selected @endif
                                            value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Partial Ship</label>
                                <select name="partial_ship" class="form-select partial_ship">
                                    @foreach (partialShipment() as $key => $value)
                                        <option @if (old('partial_ship', $indent->partial_ship) == $key) selected @endif
                                            value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Trans Shipment</label>
                                <select name="trans_shipment" class="form-select trans_shipment">
                                    @foreach (transShipment() as $key => $value)
                                        <option @if (old('trans_shipment', $indent->trans_shipment) == $key) selected @endif
                                            value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Packing</label>
                                <select name="packing" class="form-select packing">
                                    @foreach (packing() as $key => $value)
                                        <option @if (old('packing', $indent->packing) == $key) selected @endif
                                            value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Shipment</label>
                                <select name="shipment" class="form-select shipment">
                                    @foreach (shipment() as $key => $value)
                                        <option @if (old('shipment', $indent->shipment) == $key) selected @endif
                                            value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2 col-12">
                            <div class="mb-3">
                                <label class="form-label">Last Date of Shipment</label>
                                <input type="date" name="latest_date_of_shipment"
                                    value="{{ old('latest_date_of_shipment', $indent->latest_date_of_shipment) }}"
                                    class="form-control last_date_of_shipment" placeholder="Date" />
                            </div>
                        </div>

                        <div class="col-md-2 col-12">
                            <div class="mb-3">
                                <label class="form-label">Date of Negotiation</label>
                                <input type="date" name="date_of_negotiation"
                                    value="{{ old('date_of_negotiation', $indent->date_of_negotiation) }}"
                                    class="form-control date_of_negotiation" placeholder="Date of Negotiation" />
                            </div>
                        </div>

                        <div class="col-md-2 col-12">
                            <div class="mb-3">
                                <label class="form-label">Validity</label>
                                <input type="date" name="validity" value="{{ old('validity', $indent->validity) }}"
                                    class="form-control validity" placeholder="Validity" />
                            </div>
                        </div>

                        <div class="col-md-2 col-12">
                            <div class="form-check mb-3">
                                <input class="form-check-input" @if ($indent->revised == 1) checked @endif
                                    type="checkbox" value="1" id="revised" name="revised">
                                <label class="form-check-label" for="revised">
                                    Revised
                                </label>
                            </div>
                        </div>

                        <div class="col-md-2 col-12">
                            <div class="mb-3">
                                <label class="form-label">Origin</label>
                                <select name="origin" class="form-select origin">
                                    @foreach (origin() as $key => $value)
                                        <option @if (old('origin', $indent->origin) == $key) selected @endif
                                            value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2 col-12">
                            <div class="mb-3">
                                <label class="form-label">Shipping Type</label>
                                <select name="shipping_type" class="form-select shipping_type">
                                    @foreach (shippingType() as $key => $value)
                                        <option @if (old('shipping_type', $indent->shipping_type) == $key) selected @endif
                                            value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2 col-12">
                            <div class="mb-3">
                                <label class="form-label">Payment</label>
                                <select name="payment" class="form-select payment">
                                    @foreach (paymentTerms() as $key => $value)
                                        <option @if (old('payment', $indent->payment) == $key) selected @endif
                                            value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2 col-12">
                            <div class="mb-3">
                                <label class="form-label">Currency</label>
                                <select class="select2 form-select currency" name="currency" disabled>
                                    @foreach (currency() as $key => $value)
                                        <option @if (old('currency', $indent->currency) == $key) selected @endif
                                            value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Bank Detail</label>
                                <textarea name="bank_detail" class="form-control bank_detail" readonly placeholder="Bank Detail">{{ old('bank_detail', @$indent->supplier->band_detail) }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Remarks</label>
                                <textarea name="remark" class="form-control" placeholder="Remarks">{{ old('remark', $indent->remark) }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Remark 2</label>
                                <textarea name="remark_2" class="form-control" placeholder="Remark 2">{{ old('remark_2', $indent->remark_2) }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Shipping Marks</label>
                                <textarea name="shipping_marks" class="form-control" placeholder="Shipping Marks">{{ old('shipping_marks', $indent->shipping_marks) }}</textarea>
                            </div>
                        </div>

                        <!-- Product Repeater -->
                        <div class="col-12">
                            <h4>
                                Items: &nbsp;
                                <button onclick="addProductRow(this)" type="button" class="btn btn-info btn-sm"><i
                                        class="fa fa-plus"></i></button>
                            </h4>
                            <div id="product_table">
                                @php
                                    $p = old('product', $indent->items);
                                @endphp

                                @forelse ($p as $k => $v)
                                    @include('indent.product_row', [
                                        'sno' => $k + 1,
                                        'product_id' => old('product_id')[$k] ?? ($v->item_id ?? ''),
                                        'product_description' =>
                                            old('product_description')[$k] ?? ($v->item_desc ?? ''),
                                        'product_qty' => old('product_qty')[$k] ?? ($v->qty ?? ''),
                                        'product_unit' => old('product_unit')[$k] ?? ($v->unit ?? ''),
                                        'product_rate' => old('product_rate')[$k] ?? ($v->rate ?? ''),
                                        'product_total' => old('product_total')[$k] ?? ($v->total ?? ''),
                                        'product_shipment' =>
                                            old('product_shipment')[$k] ?? ($v->shipment_mode ?? ''),
                                        'product_payment_term' =>
                                            old('product_payment_term')[$k] ?? ($v->payment_term ?? ''),
                                        'product_po_id' => old('product_po_id')[$k] ?? ($v->po_id ?? ''),
                                        'product_po_date' => old('product_po_date')[$k] ?? ($v->po_date ?? ''),
                                        'product_lot_detail' =>
                                            old('product_lot_detail')[$k] ?? ($v->lot_detail ?? ''),
                                        'product_other_desc' =>
                                            old('product_other_desc')[$k] ?? ($v->other_desc ?? ''),
                                        'products' => $products,
                                    ])
                                @empty
                                    @include('indent.product_row', [
                                        'sno' => 1,
                                        'product_id' => '',
                                        'product_description' => '',
                                        'product_qty' => '',
                                        'product_unit' => '',
                                        'product_rate' => '',
                                        'product_total' => '',
                                        'product_shipment' => '',
                                        'product_payment_term' => '',
                                        'product_po_id' => '',
                                        'product_po_date' => '',
                                        'product_lot_detail' => '',
                                        'product_other_desc' => '',
                                        'products' => $products,
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
