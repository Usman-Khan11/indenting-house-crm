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
    <form method="post" action="{{ route('quotation.store') }}" enctype="multipart/form-data">
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
                            <label class="form-label">Quotation #</label>
                            <input type="text" name="num" value="QN-{{ $quotation_num }}" class="form-control" readonly />
                        </div>
                    </div>

                    <div class="col-md-5 col-12">
                        <div class="mb-3">
                            <label class="form-label">Customer</label>
                            <select class="select2 form-select" name="customer_id">
                                <option selected disabled value="">Select Customer</option>
                                @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-5 col-12">
                        <div class="mb-3">
                            <label class="form-label">Validity</label>
                            <input type="text" name="validity" value="{{ old('validity') }}" class="form-control" placeholder="Validity" />
                        </div>
                    </div>

                    <div class="col-md-5 col-12">
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input type="text" name="subject" value="{{ old('subject') }}" class="form-control" placeholder="Subject" />
                        </div>
                    </div>

                    <div class="col-md-3 col-12">
                        <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" class="form-control" placeholder="Date" />
                        </div>
                    </div>

                    <div class="col-md-2 col-12">
                        <div class="mb-3">
                            <label class="form-label">Product Discount</label>
                            <input type="number" step="any" name="discount" value="{{ old('discount', 0) }}" class="form-control" placeholder="Product Discount" />
                        </div>
                    </div>

                    <div class="col-md-2 col-12">
                        <div class="mb-3">
                            <label class="form-label">Service Discount</label>
                            <input type="number" step="any" name="s_discount" value="{{ old('s_discount', 0) }}" class="form-control" placeholder="Service Discount" />
                        </div>
                    </div>

                    <div class="col-md-3 col-12">
                        <div class="mb-3">
                            <label class="form-label">Taxable</label>
                            <select onchange="taxToggle(this)" name="tax" class="select2 form-select">
                                <option @if(old('tax')=="0" ) selected @endif value="0">No</option>
                                <option @if(old('tax')=="1" ) selected @endif value="1">Yes</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2 col-12 tax_toggle">
                        <div class="mb-3">
                            <label class="form-label">GST %</label>
                            <input type="number" step="any" name="gst" value="{{ old('gst', 0) }}" class="form-control" placeholder="GST %" />
                        </div>
                    </div>

                    <div class="col-md-2 col-12 tax_toggle">
                        <div class="mb-3">
                            <label class="form-label">SST %</label>
                            <input type="number" step="any" name="sst" value="{{ old('sst', 0) }}" class="form-control" placeholder="SST %" />
                        </div>
                    </div>

                    <div class="col-md-3 col-12">
                        <div class="mb-3">
                            <label class="form-label">Select Notes</label>
                            <select onchange="notesToggle(this)" name="show_txt[]" class="select2 show_txt" multiple>
                                <option @if(is_array(old('show_txt')) && in_array("note", old('show_txt'))) selected @endif value="note">Note</option>
                                <option @if(is_array(old('show_txt')) && in_array("delivery", old('show_txt'))) selected @endif value="delivery">Delivery</option>
                                <option @if(is_array(old('show_txt')) && in_array("payment", old('show_txt'))) selected @endif value="payment">Payment</option>
                                <option @if(is_array(old('show_txt')) && in_array("warranty", old('show_txt'))) selected @endif value="warranty">Warranty</option>
                            </select>
                        </div>
                    </div>

                    <!-- Product Repeater -->
                    <div class="col-12 mb-4">
                        <h4>
                            Products: &nbsp;
                            <button onclick="addProductRow(this)" type="button" class="btn btn-info btn-sm"><i class="fa fa-plus"></i></button>
                        </h4>
                        <table class="table table-bordered" id="product_table">
                            <thead>
                                <tr>
                                    <th width="5%">...</th>
                                    <th width="45%">Product</th>
                                    <th width="15%">Qty</th>
                                    <th width="15%">Rate</th>
                                    <th width="10%">Unit</th>
                                    <th width="10%">Order</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $p = (!empty(old('product'))) ? old('product') : [];
                                @endphp
                                @forelse($p as $k => $v)
                                <tr>
                                    <td width="5%">
                                        <button onclick="delProductRow(this)" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                    </td>
                                    <td width="50%">
                                        <select name="product[]" class="form-select select2" onchange="productPrice(this)">
                                            <option selected disabled value="">Select Product</option>
                                            @foreach($products as $product)
                                            <option @if($v==$product->id) selected @endif data-price="{{ $product->unit_price }}" value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td width="15%">
                                        <input type="number" value="{{ old('product_qty')[$k] }}" name="product_qty[]" class="form-control product_qty" step="any">
                                    </td>
                                    <td width="15%">
                                        <input type="number" value="{{ old('product_rate')[$k] }}" name="product_rate[]" class="form-control product_rate" step="any">
                                    </td>
                                    <td width="10%">
                                        <input type="text" value="{{ old('product_unit')[$k] }}" name="product_unit[]" class="form-control product_unit">
                                    </td>
                                    <td width="10%">
                                        <input type="number" value="{{ old('product_order')[$k] }}" name="product_order[]" class="form-control product_order" value="1">
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td width="5%">
                                        <button onclick="delProductRow(this)" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                    </td>
                                    <td width="50%">
                                        <select name="product[]" class="form-select select2" onchange="productPrice(this)">
                                            <option selected disabled value="">Select Product</option>
                                            @foreach($products as $product)
                                            <option data-price="{{ $product->unit_price }}" value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td width="15%">
                                        <input type="number" name="product_qty[]" class="form-control product_qty" step="any">
                                    </td>
                                    <td width="15%">
                                        <input type="number" name="product_rate[]" class="form-control product_rate" step="any">
                                    </td>
                                    <td width="10%">
                                        <input type="text" name="product_unit[]" class="form-control product_unit">
                                    </td>
                                    <td width="10%">
                                        <input type="number" name="product_order[]" class="form-control product_order" value="1">
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Service Repeater -->
                    <div class="col-12 mb-4">
                        <h4>
                            Services: &nbsp;
                            <button onclick="addServiceRow(this)" type="button" class="btn btn-info btn-sm"><i class="fa fa-plus"></i></button>
                        </h4>
                        <table class="table table-bordered" id="service_table">
                            <thead>
                                <tr>
                                    <th width="5%">...</th>
                                    <th width="45%">Service</th>
                                    <th width="15%">Qty</th>
                                    <th width="15%">Rate</th>
                                    <th width="10%">Unit</th>
                                    <th width="10%">Order</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $p = (!empty(old('service'))) ? old('service') : [];
                                @endphp
                                @forelse($p as $k => $v)
                                <tr>
                                    <td width="5%">
                                        <button onclick="delProductRow(this)" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                    </td>
                                    <td width="50%">
                                        <select name="service[]" class="form-select select2" onchange="servicePrice(this)">
                                            <option selected disabled value="">Select Service</option>
                                            @foreach($services as $service)
                                            <option @if($v==$service->id) selected @endif data-price="{{ $service->amount }}" value="{{ $service->id }}">{{ $service->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td width="15%">
                                        <input type="number" value="{{ old('service_qty')[$k] }}" name="service_qty[]" class="form-control service_qty" step="any">
                                    </td>
                                    <td width="15%">
                                        <input type="number" value="{{ old('service_rate')[$k] }}" name="service_rate[]" class="form-control service_rate" step="any">
                                    </td>
                                    <td width="10%">
                                        <input type="text" value="{{ old('service_unit')[$k] }}" name="service_unit[]" class="form-control service_unit">
                                    </td>
                                    <td width="10%">
                                        <input type="number" value="{{ old('service_order')[$k] }}" name="service_order[]" class="form-control service_order" value="1">
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td width="5%">
                                        <button onclick="delServiceRow(this)" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                    </td>
                                    <td width="50%">
                                        <select name="service[]" class="form-select select2" onchange="servicePrice(this)">
                                            <option selected disabled value="">Select Service</option>
                                            @foreach($services as $service)
                                            <option data-price="{{ $service->amount }}" value="{{ $service->id }}">{{ $service->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td width="15%">
                                        <input type="number" name="service_qty[]" class="form-control service_qty" step="any">
                                    </td>
                                    <td width="15%">
                                        <input type="number" name="service_rate[]" class="form-control service_rate" step="any">
                                    </td>
                                    <td width="10%">
                                        <input type="text" name="service_unit[]" class="form-control service_unit">
                                    </td>
                                    <td width="10%">
                                        <input type="number" name="service_order[]" class="form-control service_order" value="1">
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="col-12 note">
                        <div class="mb-3">
                            <label class="form-label">Note</label>
                            <textarea name="note" class="form-control editor">{{ old('note') }}</textarea>
                        </div>
                    </div>

                    <div class="col-12 delivery">
                        <div class="mb-3">
                            <label class="form-label">Delivery</label>
                            <textarea name="delivery" class="form-control editor">{{ old('delivery') }}</textarea>
                        </div>
                    </div>

                    <div class="col-12 payment">
                        <div class="mb-3">
                            <label class="form-label">Payment</label>
                            <textarea name="payment" class="form-control editor">{{ old('payment') }}</textarea>
                        </div>
                    </div>

                    <div class="col-12 warranty">
                        <div class="mb-3">
                            <label class="form-label">Warranty</label>
                            <textarea name="warranty" class="form-control editor">{{ old('warranty') }}</textarea>
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

@push('script')
<script>
    function taxToggle(e) {
        let val = $(e).val();
        if (val == 1) {
            $(".tax_toggle").show();
        } else {
            $(".tax_toggle").hide();
        }
    }

    function productPrice(e) {
        let price = $(e).find("option:selected").attr("data-price");
        $(e).parent().parent().parent().find(".product_rate").val(price);
    }

    function addProductRow(e) {
        let order = parseInt($("#product_table tbody tr:last").find(".product_order").val());
        $("#product_table tbody tr:last").clone().prependTo("#product_table tbody");
        $("#product_table tbody tr:last").find("input").val(null);
        $("#product_table tbody tr:last").find(".product_order").val(order + 1);
    }

    function delProductRow(e) {
        if ($("#product_table tbody tr").length > 1) {
            $(e).parent().parent().remove();
        }
    }

    function servicePrice(e) {
        let price = $(e).find("option:selected").attr("data-price");
        $(e).parent().parent().parent().find(".service_rate").val(price);
    }

    function addServiceRow(e) {
        let order = parseInt($("#service_table tbody tr:last").find(".service_order").val());
        $("#service_table tbody tr:last").clone().prependTo("#service_table tbody");
        $("#service_table tbody tr:last").find("input").val(null);
        $("#service_table tbody tr:last").find(".service_order").val(order + 1);
    }

    function delServiceRow(e) {
        if ($("#service_table tbody tr").length > 1) {
            $(e).parent().parent().remove();
        }
    }

    function notesToggle(e) {
        let val = $(e).val();
        $(".note").hide();
        $(".delivery").hide();
        $(".payment").hide();
        $(".warranty").hide();

        $(val).each(function(i, v) {
            $("." + v).show();
        })
    }

    $(document).ready(function() {
        $("select[name=tax]").change();
        $("select.show_txt").change();
    })
</script>
@endpush