@extends('layout.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <form method="post" action="{{ route('proforma_invoice.update') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $proforma_invoice->id }}">

            <div class="card">
                <div class="card-header">
                    <h4 class="fw-bold">{{ $page_title }}</h4>
                    <hr />
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 col-12">
                            <div class="mb-3">
                                <label class="form-label">PI #</label>
                                <input type="text" name="pi_no" value="{{ $proforma_invoice->pi_no }}"
                                    class="form-control" @if (auth()->user()->role_id != 1) readonly @endif />
                            </div>
                        </div>

                        <div class="col-md-2 col-12">
                            <div class="mb-3">
                                <label class="form-label">Date</label>
                                <input type="date" required name="date"
                                    value="{{ old('date', $proforma_invoice->date) }}" class="form-control"
                                    placeholder="Date" onchange="indentDates(this)" />
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Customer</label>
                                <select class="select2 form-select" name="customer_id" required disabled>
                                    <option selected disabled value="">Select Customer</option>
                                    @foreach ($customers as $customer)
                                        <option @if (old('customer_id', $proforma_invoice->customer_id) == $customer->id) selected @endif
                                            value="{{ $customer->id }}">{{ $customer->name }}</option>
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
                                        <option @if (old('supplier_id', $proforma_invoice->supplier_id) == $supplier->id) selected @endif
                                            value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Port of Shipment</label>
                                <select name="port_of_ship" class="form-select port_shipment select2">
                                    <option value="" selected>Select Shipment</option>
                                    @foreach (portOfShipment() as $key => $value)
                                        <option @if (old('port_of_ship', $proforma_invoice->port_of_ship) == $key) selected @endif
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
                                        <option @if (old('port_destination', $proforma_invoice->port_destination) == $key) selected @endif
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
                                        <option @if (old('partial_ship', $proforma_invoice->partial_ship) == $key) selected @endif
                                            value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2 col-12">
                            <div class="mb-3">
                                <label class="form-label">Trans Shipment</label>
                                <select name="trans_shipment" class="form-select trans_shipment">
                                    @foreach (transShipment() as $key => $value)
                                        <option @if (old('trans_shipment', $proforma_invoice->trans_shipment) == $key) selected @endif
                                            value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 col-12">
                            <div class="mb-3">
                                <label class="form-label">Packing</label>
                                <select name="packing" class="form-select packing">
                                    @foreach (packing() as $key => $value)
                                        <option @if (old('packing', $proforma_invoice->packing) == $key) selected @endif
                                            value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2 col-12">
                            <div class="mb-3">
                                <label class="form-label">Shipment</label>
                                <select name="shipment" class="form-select shipment">
                                    @foreach (shipment() as $key => $value)
                                        <option @if (old('shipment', $proforma_invoice->shipment) == $key) selected @endif
                                            value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <label class="form-label">Shipment Text</label>
                            <input type="text" name="shipment_text"
                                value="{{ old('shipment_text', $proforma_invoice->shipment_text) }}"
                                class="form-control shipment_text" placeholder="Shipment Text" />
                        </div>

                        <div class="col-md-2 col-12">
                            <div class="mb-3">
                                <label class="form-label">Last Date of Shipment</label>
                                <input type="date" name="last_date_of_shipment"
                                    value="{{ old('last_date_of_shipment', $proforma_invoice->last_date_of_shipment) }}"
                                    class="form-control last_date_of_shipment" placeholder="Date" />
                            </div>
                        </div>

                        <div class="col-md-2 col-12">
                            <div class="mb-3">
                                <label class="form-label">Date of Negotiation</label>
                                <input type="date" name="date_of_negotiation"
                                    value="{{ old('date_of_negotiation', $proforma_invoice->date_of_negotiation) }}"
                                    class="form-control date_of_negotiation" placeholder="Date of Negotiation" />
                            </div>
                        </div>

                        <div class="col-md-2 col-12">
                            <div class="mb-3">
                                <label class="form-label">Validity</label>
                                <input type="date" name="validity"
                                    value="{{ old('validity', $proforma_invoice->validity) }}"
                                    class="form-control validity" placeholder="Validity" />
                            </div>
                        </div>

                        <div class="col-md-2 col-12">
                            <div class="form-check mb-3">
                                <input class="form-check-input" @if ($proforma_invoice->revised == 1) checked @endif
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
                                        <option @if (old('origin', $proforma_invoice->origin) == $key) selected @endif
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
                                        <option @if (old('shipping_type', $proforma_invoice->shipping_type) == $key) selected @endif
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
                                        <option @if (old('payment', $proforma_invoice->payment) == $key) selected @endif
                                            value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <label class="form-label">Payment Text</label>
                            <input type="text" name="payment_text"
                                value="{{ old('payment_text', $proforma_invoice->payment_text) }}"
                                class="form-control payment_text" placeholder="Payment Text" />
                        </div>

                        <div class="col-md-2 col-12">
                            <div class="mb-3">
                                <label class="form-label">Currency</label>
                                <select class="select2 form-select currency" name="currency">
                                    @foreach (currency() as $key => $value)
                                        <option @if (old('currency', $proforma_invoice->currency) == $key) selected @endif
                                            value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Bank Detail</label>
                                <textarea name="bank_detail" class="form-control bank_detail" placeholder="Bank Detail">{{ old('bank_detail', $proforma_invoice->bank_detail) }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Remarks</label>
                                <textarea name="remark" class="form-control" placeholder="Remarks">{{ old('remark', $proforma_invoice->remark) }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Remark 2</label>
                                <textarea name="remark_2" class="form-control" placeholder="Remark 2">{{ old('remark_2', $proforma_invoice->remark_2) }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Shipping Marks</label>
                                <textarea name="shipping_marks" class="form-control" placeholder="Shipping Marks">{{ old('shipping_marks', $proforma_invoice->shipping_marks) }}</textarea>
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
                                    $p = old('product', $proforma_invoice->items);
                                @endphp

                                @forelse ($p as $k => $v)
                                    @include('proforma_invoice.product_row', [
                                        'sno' => $k + 1,
                                        'product_id' => old('product_id')[$k] ?? ($v->item_id ?? ''),
                                        'product_qty' => old('product_qty')[$k] ?? ($v->qty ?? ''),
                                        'product_unit' => old('product_unit')[$k] ?? ($v->unit ?? ''),
                                        'product_rate' => old('product_rate')[$k] ?? ($v->rate ?? ''),
                                        'product_total' => old('product_total')[$k] ?? ($v->total ?? ''),
                                        'product_size_id' => old('product_size_id')[$k] ?? ($v->size_id ?? ''),
                                        'product_artwork_id' =>
                                            old('product_artwork_id')[$k] ?? ($v->artwork_id ?? ''),
                                        'product_code' => old('product_code')[$k] ?? (@$v->item->code ?? ''),
                                        'product_description' =>
                                            old('product_description')[$k] ?? (@$v->item->description ?? ''),
                                        'product_remark' => old('product_remark')[$k] ?? (@$v->remark ?? ''),
                                        'products' => $products,
                                        'sizes' => $sizes,
                                        'artworks' => $artworks,
                                    ])
                                @empty
                                    @include('proforma_invoice.product_row', [
                                        'sno' => 1,
                                        'product_id' => '',
                                        'product_qty' => '',
                                        'product_unit' => '',
                                        'product_rate' => '',
                                        'product_total' => '',
                                        'product_size_id' => '',
                                        'product_artwork_id' => '',
                                        'product_code' => '',
                                        'product_description' => '',
                                        'product_remark' => '',
                                        'products' => $products,
                                        'sizes' => $sizes,
                                        'artworks' => $artworks,
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

    @include('proforma_invoice.partials.search_modal')
@endsection
