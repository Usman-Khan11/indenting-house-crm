@extends('layout.app')

@push('style')
<style>
    body {
        background: #fff;
        color: black !important;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        color: black !important;
    }

    p,
    a,
    small,
    td,
    span {
        color: black !important;
    }

    #layout-navbar,
    #layout-menu {
        display: none !important;
    }

    .layout-page {
        padding: 0 !important;
    }

    .layout-navbar-fixed .layout-wrapper:not(.layout-horizontal):not(.layout-without-menu) .layout-page {
        padding-top: 0px !important;
    }

    .layout-page:before {
        display: none !important;
    }

    table th {
        font-weight: bold !important;
        text-align: center !important;
        color: black !important;
        font-size: 15px !important;
    }

    .low-padding-table td,
    .low-padding-table th {
        padding: 4px;
    }

    .border-dark {
        border-color: black !important;
    }
</style>
@endpush

@section('content')
<div class="w-100">
    <div class="invoice-print p-4">
        <div class="d-flex justify-content-between flex-row">
            <div class="mb-4">
                <div class="d-flex svg-illustration mb-3 gap-2">
                    <img src="{{ asset(general()->logo) }}" width="150px" alt="Logo">
                </div>
                <!-- <p class="mb-1">Office 149, 450 South Brand Brooklyn</p>
                <p class="mb-1">San Diego County, CA 91905, USA</p>
                <p class="mb-0">+1 (123) 456 7891, +44 (876) 543 2198</p> -->
            </div>
            <div class="col-6 col-lg-4">
                <!-- <h4 class="fw-bold">INVOICE #86423</h4> -->
                <div class="mb-2">
                    <span class="">Plot No 391, Office No 303, 3rd Floor, Al Reef Tower, Near Alamgir Masjid, Block 3, Bahadur Yar Jung Cooperative Housing Society, Bahadurabad Karachi.</span>
                </div>
                <div>
                    <span class="fw-bold">Tel:</span>
                    <span class="">+92-21-34920554</span>
                </div>
                <div>
                    <span class="fw-bold">Fax:</span>
                    <span class="">+92-21-34920555</span>
                </div>
                <div>
                    <span class="fw-bold">E-mail:</span>
                    <span class="">mri@mri.com.pk</span>
                </div>
            </div>
        </div>

        <div class="mb-2 mt-3">
            <h3 class="text-center fw-bolder">INDENT</h3>
            <div class="row">
                <div class="col-6">
                    <table class="table table-bordered table-sm border-dark">
                        <tbody>
                            <tr>
                                <td width="60%">
                                    <h5 class="mb-1">
                                        <b>Indent No.</b> &nbsp; {{ @$indent->indent_no }}
                                        @if($indent->revised)
                                        <small>(Revised)</small>
                                        @endif
                                    </h5>
                                </td>
                            </tr>
                            <tr>
                                <td width="60%">
                                    <h5 class="mb-1"><b>Indent Date:</b> &nbsp; {{ date("d-M-Y", strtotime($indent->date)) }}</h5>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-6">
                    <table class="table table-bordered table-sm border-dark">
                        <tbody>
                            <tr>
                                <td width="60%">
                                    <h5 class="mb-1"><b>Indent Validity:</b> &nbsp; {{ ($indent->validity) ? date("d-M-Y", strtotime($indent->validity)) : '-' }}</h5>
                                </td>
                            </tr>
                            <tr>
                                <td width="60%">
                                    <h5 class="mb-1"><b>NTN No.</b> &nbsp; 2734223-9</h5>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mb-2">
            <table class="table table-bordered table-sm border-dark">
                <tbody>
                    <tr>
                        <th width="50%">
                            <h5 class="mb-0">Supplier Information</h5>
                        </th>
                        <th width="50%">
                            <h5 class="mb-0">Buyer Information</h5>
                        </th>
                    </tr>
                    <tr>
                        <td width="50%">
                            <h6 class="mb-1">{{ @$indent->supplier->name }}</h6>
                            <small>{{ @$indent->supplier->address }}</small>
                        </td>
                        <td width="50%">
                            <h6 class="mb-1">{{ @$indent->customer->name }}</h6>
                            <small>{{ @$indent->customer->address_office }}</small>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        @if($indent->items)
        <div class="w-100">
            <table class="table table-sm text-wrap w-100 table-bordered border-dark">
                <thead>
                    <tr>
                        <th>S.#</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Rate</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $qty = 0;
                    $total = 0;
                    @endphp
                    @foreach($indent->items as $k => $v)
                    <tr>
                        <td class="text-center">{{ $k+1 }}</td>
                        <td>
                            <h6 class="mb-1">{{ @$v->item->name }}</h6>
                            <small class="d-block">{{ @$v->item->description }}</small>
                            <small><b>HS Code:</b> {{ @$v->item->hs_code }}</small>
                        </td>
                        <td class="text-center">
                            {{ number_format($v->qty) }}
                            {{ @$v->unit }}
                        </td>
                        <td class="text-center">
                            {{ $indent->currency }} &nbsp;
                            {{ number_format($v->rate, 3) }}/
                            {{ @$v->unit }}
                        </td>
                        <td class="text-center">
                            {{ $indent->currency }} &nbsp;
                            {{ number_format($v->total, 3) }}
                        </td>
                    </tr>
                    @php
                    $qty += $v->qty;
                    $total += $v->total;
                    @endphp
                    @endforeach
                    <tr>
                        <td colspan="2" class="text-end">
                            <h5 class="mb-0">
                                Total:
                            </h5>
                        </td>
                        <td class="text-center">
                            <h6 class="fw-bold mb-0">
                                {{ number_format($qty) }}
                            </h6>
                        </td>
                        <td></td>
                        <td class="text-center">
                            <h6 class="fw-bold mb-0">
                                {{ $indent->currency }} &nbsp;
                                {{ number_format($total, 3) }}
                            </h6>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endif

        <div class="mb-2 mt-2">
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered table-sm border-dark align-top">
                        <tbody>
                            <tr>
                                <td width="18.33%">
                                    <h6 class="mb-0"><b>Partial Shipment:</b></h6>
                                </td>
                                <td width="15%">
                                    <p class="m-0">{{ $indent->partial_ship }}</p>
                                </td>
                                <td width="18.33%">
                                    <h6 class="mb-0"><b>Last Date of Shipment:</b></h6>
                                </td>
                                <td width="15%">
                                    <p class="m-0">{{ ($indent->latest_date_of_shipment) ? date("d-M-Y", strtotime($indent->latest_date_of_shipment)) : '-' }}</p>
                                </td>
                                <td width="18.33%">
                                    <h6 class="mb-0"><b>Shipment Mode:</b></h6>
                                </td>
                                <td width="15%">
                                    <p class="m-0">{{ $indent->shipping_type }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td width="18.33%">
                                    <h6 class="mb-0"><b>Trans Shipment:</b></h6>
                                </td>
                                <td width="15%">
                                    <p class="m-0">{{ $indent->trans_shipment }}</p>
                                </td>
                                <td width="18.33%">
                                    <h6 class="mb-0"><b>Date of Negotiation:</b></h6>
                                </td>
                                <td width="15%">
                                    <p class="m-0">{{ ($indent->date_of_negotiation) ? date("d-M-Y", strtotime($indent->date_of_negotiation)) : '-' }}</p>
                                </td>
                                <td width="18.33%">
                                    <h6 class="mb-0"><b>Payment:</b></h6>
                                </td>
                                <td width="15%">
                                    <p class="m-0">{{ $indent->payment }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td width="18.33%">
                                    <h6 class="mb-0"><b>Packing:</b></h6>
                                </td>
                                <td width="15%">
                                    <p class="m-0">{{ $indent->packing }}</p>
                                </td>
                                <td width="18.33%">
                                    <h6 class="mb-0"><b>Shipment:</b></h6>
                                </td>
                                <td width="15%">
                                    <p class="m-0">{{ $indent->shipment }}</p>
                                </td>
                                <td width="18.33%">
                                    <h6 class="mb-0"><b>Origin:</b></h6>
                                </td>
                                <td width="15%">
                                    <p class="m-0">{{ $indent->origin }}</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mb-2">
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered table-sm border-dark align-top">
                        <tbody>
                            <tr>
                                <td width="50%">
                                    <h5 class="mb-1"><b>Shipping Mark:</b></h5>
                                    <p class="mb-0">
                                        {{ $indent->shipping_marks }}
                                    </p>
                                </td>
                                <td width="50%">
                                    <h5 class="mb-1"><b>Port of Shipment:</b> &nbsp; {{ $indent->port_shipment }}</h5>
                                    <h5 class="mb-0"><b>Destination:</b> &nbsp; {{ $indent->port_destination }}</h5>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mb-2">
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered table-sm border-dark align-top">
                        <tbody>
                            <tr>
                                <td width="50%">
                                    <h5 class="mb-1"><b>Bank Detail:</b></h5>
                                    <p class="mb-0">
                                        {{ $indent->bank_detail }}
                                    </p>

                                    <h5 class="mb-1"><b>Swift Code:</b></h5>
                                    <p class="mb-0">
                                        {{ @$indent->supplier->swift_code }}
                                    </p>
                                </td>
                                <td width="50%">
                                    <h5 class="mb-1"><b>Special Note:</b></h5>
                                    <p class="mb-0">
                                        {{-- $indent->remark --}}
                                        Manually signed Non-Negotiable copies of Invoice, Form 3, Form 7. Analysis Certificate & Export Packing List Must Accompany Shipping Documents and complete sets thereof should be sent by courier to buyer and indenters prior to shipment.
                                        <br /><br />
                                        Manufacturer & Expiry dates should be mentioned on each Export packing. Shelf life of material should be 80% minimum at the time of arrival.
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mb-2 mt-1">
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered table-sm border-dark align-top">
                        <tbody>
                            <tr>
                                <td width="100%">
                                    <p class="mb-0 fw-bold">
                                        Bank Charges: Inside Pakistan are opener's & outside on beneficiary's A/C Tolerance: Plus Minus 10% allowed in quantity and value (For Packaging Only)
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-6 border border-dark pb-5 pt-2">
                <h5 class="mb-1">Sign & Stamp: <small>(For <b>MRI Indenting House</b>)</small></h5>
                <br /><br /><br />
            </div>
            <div class="col-6 border border-dark pb-5 pt-2">
                <h5 class="mb-1">Sign & Stamp: <small>(For <b>{{ @$indent->customer->name }}</b>)</span></h5>
                <br /><br /><br />
            </div>
        </div>
    </div>
</div>

@endsection