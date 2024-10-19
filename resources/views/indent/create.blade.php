@extends('layout.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <form method="post" action="{{ route('indent.store') }}" enctype="multipart/form-data">
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
                            <input type="text" name="indent_no" value="IND-{{ $indent_no }}" class="form-control" readonly />
                        </div>
                    </div>

                    <div class="col-md-2 col-12">
                        <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" required name="date" value="{{ old('date', date('Y-m-d')) }}" class="form-control date" placeholder="Date" onchange="indentDates(this)" />
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Purchase Orders</label>
                            <select class="select2 form-select" name="po_id" required onchange="getPurchaseOrderData(this)">
                                <option selected disabled value="">Select Purchase Order</option>
                                @foreach($purchase_orders as $purchase_order)
                                <option @if(old('po_id')==$purchase_order->id) selected @endif value="{{ $purchase_order->id }}">{{ $purchase_order->po_no }}</option>
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
                            <select class="select2 form-select supplier_id" name="supplier_id" required onchange="getBankDetail(this)">
                                <option selected disabled value="">Select Supplier</option>
                                @foreach($suppliers as $supplier)
                                <option @if(old('supplier_id')==$supplier->id) selected @endif value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Port of Shipment</label>
                            <select name="port_shipment" class="form-select port_shipment select2">
                                <option value="" selected>Select Shipment</option>
                                @foreach(portOfShipment() as $key => $value)
                                <option @if(old('port_shipment')==$key) selected @endif value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Port of Destination</label>
                            <select name="port_destination" class="form-select port_destination select2">
                                <option value="" selected>Select Destination</option>
                                @foreach(portOfDestination() as $key => $value)
                                <option @if(old('port_destination')==$key) selected @endif value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Partial Ship</label>
                            <select name="partial_ship" class="form-select partial_ship">
                                @foreach(partialShipment() as $key => $value)
                                <option @if(old('partial_ship')==$key) selected @endif value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Trans Shipment</label>
                            <select name="trans_shipment" class="form-select trans_shipment">
                                @foreach(transShipment() as $key => $value)
                                <option @if(old('trans_shipment')==$key) selected @endif value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Packing</label>
                            <select name="packing" class="form-select packing">
                                @foreach(packing() as $key => $value)
                                <option @if(old('packing')==$key) selected @endif value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Shipment</label>
                            <select name="shipment" class="form-select shipment">
                                @foreach(shipment() as $key => $value)
                                <option @if(old('shipment')==$key) selected @endif value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2 col-12">
                        <div class="mb-3">
                            <label class="form-label">Last Date of Shipment</label>
                            <input type="date" name="latest_date_of_shipment" value="{{ old('latest_date_of_shipment') }}" class="form-control last_date_of_shipment" placeholder="Date" />
                        </div>
                    </div>

                    <div class="col-md-2 col-12">
                        <div class="mb-3">
                            <label class="form-label">Date of Negotiation</label>
                            <input type="date" name="date_of_negotiation" value="{{ old('date_of_negotiation') }}" class="form-control date_of_negotiation" placeholder="Date of Negotiation" />
                        </div>
                    </div>

                    <div class="col-md-2 col-12">
                        <div class="mb-3">
                            <label class="form-label">Validity</label>
                            <input type="date" name="validity" value="{{ old('validity') }}" class="form-control validity" placeholder="Validity" />
                        </div>
                    </div>

                    <div class="col-md-2 col-12">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="1" id="revised" name="revised">
                            <label class="form-check-label" for="revised">
                                Revised
                            </label>
                        </div>
                    </div>

                    <div class="col-md-2 col-12">
                        <div class="mb-3">
                            <label class="form-label">Origin</label>
                            <select name="origin" class="form-select origin">
                                @foreach(origin() as $key => $value)
                                <option @if(old('origin')==$key) selected @endif value="{{ $key }}">{{ $value }}</option>
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

                    <div class="col-md-2 col-12">
                        <div class="mb-3">
                            <label class="form-label">Payment</label>
                            <select name="payment" class="form-select payment">
                                @foreach(paymentTerms() as $key => $value)
                                <option @if(old('payment')==$key) selected @endif value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
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

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Bank Detail</label>
                            <textarea name="bank_detail" class="form-control bank_detail" placeholder="Bank Detail">{{ old('bank_detail') }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Remark</label>
                            <textarea name="remark" class="form-control remark" placeholder="Remark">{{ old('remark') }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Remark 2</label>
                            <textarea name="remark_2" class="form-control" placeholder="Remark 2">{{ old('remark_2') }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label class="form-label">Shipping Marks</label>
                            <textarea name="shipping_marks" class="form-control" placeholder="Shipping Marks">{{ old('shipping_marks') }}</textarea>
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
                                    <!-- <th>PONO</th>
                                    <th>PODT</th>
                                    <th>Lot Detail</th>
                                    <th>Other Desc</th> -->
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
                                    <td>
                                        <select name="product_shipment[]" class="form-select product_shipment">
                                            <option selected value="">Select Shipment Mode</option>
                                            @foreach(shippingMode() as $key => $value)
                                            <option @if(old('product_shipment')[$k]==$key) selected @endif value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select name="product_payment_term[]" class="form-select product_payment_term">
                                            <option selected value="">Select Payment Term</option>
                                            @foreach(paymentTerms() as $key => $value)
                                            <option @if(old('product_payment_term')[$k]==$key) selected @endif value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="d-none">
                                        <select name="product_po_id[]" class="form-select product_po_id">
                                            <option selected disabled value="">Select Purchase Order</option>
                                            @foreach($purchase_orders as $purchase_order)
                                            <option @if(old('product_po_id')[$k]==$purchase_order->id ) selected @endif value="{{ $purchase_order->id }}">{{ $purchase_order->po_no }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="d-none">
                                        <input type="text" value="{{ old('product_po_date')[$k] }}" name="product_po_date[]" class="form-control product_po_date">
                                    </td>
                                    <td class="d-none">
                                        <input type="text" value="{{ old('product_lot_detail')[$k] }}" name="product_lot_detail[]" class="form-control product_lot_detail">
                                    </td>
                                    <td class="d-none">
                                        <input type="text" value="{{ old('product_other_desc')[$k] }}" name="product_other_desc[]" class="form-control product_other_desc">
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
                                    <td class="d-none">
                                        <select name="product_po_id[]" class="form-select product_po_id">
                                            <option selected disabled value="">Select Purchase Order</option>
                                            @foreach($purchase_orders as $purchase_order)
                                            <option value="{{ $purchase_order->id }}">{{ $purchase_order->po_no }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="d-none">
                                        <input type="text" name="product_po_date[]" class="form-control product_po_date">
                                    </td>
                                    <td class="d-none">
                                        <input type="text" name="product_lot_detail[]" class="form-control product_lot_detail">
                                    </td>
                                    <td class="d-none">
                                        <input type="text" name="product_other_desc[]" class="form-control product_other_desc">
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

@push('script')
<script>
    $(document).ready(function() {
        $('.date').change();
    })
</script>
@endpush