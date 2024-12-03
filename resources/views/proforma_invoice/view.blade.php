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

        .newpage {
            page-break-before: always;
        }

        .newpage:last-child {
            page-break-after: auto;
        }

        @media print {

            .content-block,
            p {
                page-break-inside: avoid;
            }
        }
    </style>
@endpush

@section('content')
    <div class="w-100">
        @if (isset($_GET['letter_head']))
            <div>
                <img src="{{ asset('assets/img/proforma-logo.jpg') }}" width="100%" alt="Logo">
            </div>
        @endif

        <div class="invoice-print p-4">
            {{-- <div class="d-flex justify-content-between flex-row">
                <div class="mb-4">
                    <div class="d-flex svg-illustration mb-3 gap-2">
                        <img src="{{ asset(general()->logo) }}" width="150px" alt="Logo">
                    </div>
                    <p class="mb-1">Office 149, 450 South Brand Brooklyn</p>
                    <p class="mb-1">San Diego County, CA 91905, USA</p>
                    <p class="mb-0">+1 (123) 456 7891, +44 (876) 543 2198</p>
                </div>
                <div class="col-6 col-lg-4">
                    <!-- <h4 class="fw-bold">INVOICE #86423</h4> -->
                    <div class="mb-2">
                        <span class="">Plot No 391, Office No 303, 3rd Floor, Al Reef Tower, Near Alamgir Masjid,
                            Block 3, Bahadur Yar Jung Cooperative Housing Society, Bahadurabad Karachi.</span>
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
            </div> --}}

            <div class="mb-3 mt-0">
                <h3 class="text-center fw-bolder">PROFORMA INVOICE</h3>
                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered table-sm border-dark">
                            <tbody>
                                <tr>
                                    <td width="35%">
                                        <h5 class="mb-0">
                                            <b>PI No.</b> {{ @$proforma_invoice->pi_no }}
                                            @if ($proforma_invoice->revised)
                                                <small>(Revised)</small>
                                            @endif
                                        </h5>
                                    </td>
                                    <td width="30%">
                                        <h5 class="mb-0"><b>PI Date:</b>
                                            {{ date('d-M-Y', strtotime($proforma_invoice->date)) }}</h5>
                                    </td>
                                    <td width="35%">
                                        <h5 class="mb-0"><b>PI Validity:</b>
                                            {{ $proforma_invoice->validity ? date('d-M-Y', strtotime($proforma_invoice->validity)) : '-' }}
                                        </h5>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mb-3">
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
                                <h5 class="mb-1 fw-bold">{{ @$proforma_invoice->supplier->name }}</h5>
                                <small>{{ @$proforma_invoice->supplier->address }}</small>
                            </td>
                            <td width="50%">
                                <h5 class="mb-1 fw-bold">{{ @$proforma_invoice->customer->name }}</h5>
                                <small>{{ @$proforma_invoice->customer->address_office }}</small>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            @if ($proforma_invoice->items)
                <div class="w-100">
                    <table class="table table-sm text-wrap w-100 table-bordered border-dark">
                        <thead>
                            <tr>
                                <th colspan="5">
                                    <h5 class="mb-0 fw-bolder">Product Appendix</h5>
                                </th>
                            </tr>
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
                            @foreach ($proforma_invoice->items as $k => $v)
                                <tr>
                                    <td class="text-center">{{ $k + 1 }}</td>
                                    <td>
                                        <h6 class="mb-1">{{ @$v->item->name }}</h6>
                                        <small class="d-block">{{ @$v->item->description }}</small>
                                        <small><b>Item Code:</b> {{ @$v->item->code }}</small> <br />
                                        <small><b>Size:</b> {{ @$v->size->name }}</small> <br />
                                        <small><b>HS Code:</b> {{ @$v->item->hs_code }}</small>
                                    </td>
                                    <td class="text-center">
                                        {{ number_format($v->qty) }}
                                        {{ @$v->unit }}
                                    </td>
                                    <td class="text-center">
                                        {{ $proforma_invoice->currency }} &nbsp;
                                        {{ number_format($v->rate, 5) }}/
                                        {{ @$v->unit }}
                                    </td>
                                    <td class="text-center">
                                        {{ $proforma_invoice->currency }} &nbsp;
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
                                        {{ $proforma_invoice->currency }} &nbsp;
                                        {{ number_format($total, 3) }}
                                    </h6>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif

            <div class="mb-2 mt-3">
                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered table-sm border-dark align-top">
                            <tbody>
                                <tr>
                                    <th colspan="6">
                                        <h5 class="mb-0 fw-bolder">Terms and Conditions</h5>
                                    </th>
                                </tr>
                                <tr>
                                    <td width="18.33%">
                                        <h6 class="mb-0"><b>Partial Shipment:</b></h6>
                                    </td>
                                    <td width="15%">
                                        <p class="m-0">{{ $proforma_invoice->partial_ship }}</p>
                                    </td>
                                    <td width="18.33%">
                                        <h6 class="mb-0"><b>Last Date of Shipment:</b></h6>
                                    </td>
                                    <td width="15%">
                                        <p class="m-0">
                                            {{ $proforma_invoice->last_date_of_shipment ? date('d-M-Y', strtotime($proforma_invoice->last_date_of_shipment)) : '-' }}
                                        </p>
                                    </td>
                                    <td width="18.33%">
                                        <h6 class="mb-0"><b>Shipment Mode:</b></h6>
                                    </td>
                                    <td width="15%">
                                        <p class="m-0">{{ $proforma_invoice->shipping_type }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="18.33%">
                                        <h6 class="mb-0"><b>Trans Shipment:</b></h6>
                                    </td>
                                    <td width="15%">
                                        <p class="m-0">{{ $proforma_invoice->trans_shipment }}</p>
                                    </td>
                                    <td width="18.33%">
                                        <h6 class="mb-0"><b>Date of Negotiation:</b></h6>
                                    </td>
                                    <td width="15%">
                                        <p class="m-0">
                                            {{ $proforma_invoice->date_of_negotiation ? date('d-M-Y', strtotime($proforma_invoice->date_of_negotiation)) : '-' }}
                                        </p>
                                    </td>
                                    <td width="18.33%">
                                        <h6 class="mb-0"><b>Payment:</b></h6>
                                    </td>
                                    <td width="15%">
                                        <p class="m-0">{{ $proforma_invoice->payment }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="18.33%">
                                        <h6 class="mb-0"><b>Packing:</b></h6>
                                    </td>
                                    <td width="15%">
                                        <p class="m-0">{{ $proforma_invoice->packing }}</p>
                                    </td>
                                    <td width="18.33%">
                                        <h6 class="mb-0"><b>Shipment:</b></h6>
                                    </td>
                                    <td width="15%">
                                        <p class="m-0">{{ $proforma_invoice->shipment }}</p>
                                    </td>
                                    <td width="18.33%">
                                        <h6 class="mb-0"><b>Origin:</b></h6>
                                    </td>
                                    <td width="15%">
                                        <p class="m-0">{{ $proforma_invoice->origin }}</p>
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
                                            {{ $proforma_invoice->shipping_marks }}
                                        </p>
                                    </td>
                                    <td width="50%">
                                        <h5 class="mb-1"><b>Port of Shipment:</b> &nbsp;
                                            {{ $proforma_invoice->port_of_ship }}
                                        </h5>
                                        <h5 class="mb-0"><b>Destination:</b> &nbsp;
                                            {{ $proforma_invoice->port_destination }}</h5>
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
                                            {{ $proforma_invoice->bank_detail }}
                                        </p>

                                        <h5 class="mb-1"><b>Swift Code:</b></h5>
                                        <p class="mb-0">
                                            {{ @$proforma_invoice->supplier->swift_code }}
                                        </p>
                                    </td>
                                    <td width="50%">
                                        <h5 class="mb-1"><b>Special Note:</b></h5>
                                        <p class="mb-0">
                                            {{-- $proforma_invoice->remark --}}
                                            Manually signed Non-Negotiable copies of Invoice, Form 3, Form 7. Analysis
                                            Certificate & Export Packing List Must Accompany Shipping Documents and complete
                                            sets thereof should be sent by courier to buyer and indenters prior to shipment.
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mb-3 mt-2">
                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered table-sm border-dark align-top">
                            <tbody>
                                <tr>
                                    <td width="100%">
                                        <p class="mb-0 fw-bold">
                                            Bank Charges: Inside Pakistan are opener's & outside on beneficiary's A/C
                                            Tolerance: Plus Minus 10% allowed in quantity and value (For Packaging Only)
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mb-3 mt-2">
                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered table-sm border-dark align-top">
                            <tbody>
                                <tr>
                                    <td width="100%">
                                        <p class="mb-0 fw-bold">
                                            Manufacturer & Expiry dates should be mentioned on each Export packing. Shelf
                                            life of material should be 80% minimum at the time of arrival.
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
                    <h5 class="mb-1">Sign & Stamp: <small>(For <b>{{ @$proforma_invoice->supplier->name }}</b>)</small>
                    </h5>
                    <br /><br /><br />
                </div>
                <div class="col-6 border border-dark pb-5 pt-2">
                    <h5 class="mb-1">Sign & Stamp: <small>(For <b>{{ @$proforma_invoice->customer->name }}</b>)</span>
                    </h5>
                    <br /><br /><br />
                </div>
            </div>
        </div>
    </div>

@endsection
