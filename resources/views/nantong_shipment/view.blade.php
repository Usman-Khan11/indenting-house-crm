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
            </div>

            <div class="mb-2 mt-3">
                <h3 class="text-center fw-bolder">SHIPMENT</h3>
                <div class="row g-0">
                    <div class="col-4">
                        <table class="table table-bordered table-sm border-dark">
                            <tbody>
                                <tr>
                                    <td width="100%">
                                        <h5 class="mb-1"><b>Shipment No.</b> &nbsp; {{ @$shipment->shipment_no }}</h5>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-4">
                        <table class="table table-bordered table-sm border-dark">
                            <tbody>
                                <tr>
                                    <td width="100%">
                                        <h5 class="mb-1"><b>Indent No.</b> &nbsp; {{ @$shipment->indent->indent_no }}</h5>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-4">
                        <table class="table table-bordered table-sm border-dark">
                            <tbody>
                                <tr>
                                    <td width="100%">
                                        <h5 class="mb-1"><b>Date:</b> &nbsp;
                                            {{ $shipment->date ? date('d-M-Y', strtotime($shipment->date)) : '-' }}</h5>
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
                                <h6 class="mb-1">{{ @$shipment->supplier->name ?? '-' }}</h6>
                                <small>{{ @$shipment->supplier->address }}</small>
                            </td>
                            <td width="50%">
                                <h6 class="mb-1">{{ @$shipment->customer->name ?? '-' }}</h6>
                                <small>{{ @$shipment->customer->address_office }}</small>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            @if ($shipment->items)
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
                            @foreach ($shipment->items as $k => $v)
                                <tr>
                                    <td class="text-center">{{ $k + 1 }}</td>
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
                                        {{ $shipment->currency }} &nbsp;
                                        {{ number_format($v->rate, 3) }}/
                                        {{ @$v->unit }}
                                    </td>
                                    <td class="text-center">
                                        {{ $shipment->currency }} &nbsp;
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
                                        {{ $shipment->currency }} &nbsp;
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
                                        <h6 class="mb-0"><b>{{ $shipment->indent->payment ?? 'LC/BC/TT No' }}</b></h6>
                                    </td>
                                    <td width="15%">
                                        <p class="m-0">{{ $shipment->lc_bt_tt_no }}</p>
                                    </td>
                                    <td width="18.33%">
                                        <h6 class="mb-0"><b>LC Issue Date:</b></h6>
                                    </td>
                                    <td width="15%">
                                        <p class="m-0">
                                            {{ $shipment->lc_issue_date ? date('d-M-Y', strtotime($shipment->lc_issue_date)) : '-' }}
                                        </p>
                                    </td>
                                    <td width="18.33%">
                                        <h6 class="mb-0"><b>LC Exp Date:</b></h6>
                                    </td>
                                    <td width="15%">
                                        <p class="m-0">
                                            {{ $shipment->lc_exp_date ? date('d-M-Y', strtotime($shipment->lc_exp_date)) : '-' }}
                                        </p>
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
                        <table class="table align-top">
                            <tbody>
                                <tr>
                                    <td width="100%">
                                        <h5 class="mb-1"><b>Shipment Lot Details:</b></h5>
                                        <table class="table table-bordered table-sm border-dark align-top">
                                            <thead>
                                                <tr>
                                                    <th>Shipment Lot</th>
                                                    <th>Invoice #</th>
                                                    <th>Invoice Date</th>
                                                    <th>BL #</th>
                                                    <th>BL Date</th>
                                                    <th>Payment to Supplier</th>
                                                    <th>Payment to MRI</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($shipment->lot_no as $k => $v)
                                                    <tr>
                                                        <td>{{ $v['lot_no'] ?? '' }}</td>
                                                        <td>{{ $v['inv_no'] ?? '' }}</td>
                                                        <td>{{ $v['inv_date'] ? date('d-M-Y', strtotime($v['inv_date'])) : '-' }}
                                                        </td>
                                                        <td>{{ $v['bl_no'] ?? '' }}</td>
                                                        <td>{{ $v['bl_date'] ? date('d-M-Y', strtotime($v['bl_date'])) : '-' }}
                                                        </td>
                                                        <td>{{ $v['payment_remark'] ?? '' }}</td>
                                                        <td>{{ $v['payment_remark_2'] ?? '' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
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
                                    <td width="100%">
                                        <h5 class="mb-1"><b>Final Remark:</b></h5>
                                        <p class="mb-0">
                                            {{ $shipment->final_remark }}
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="">
                <div class="row">
                    <div class="col-6">
                        <div class="border border-dark p-2 pb-5 pt-2">
                            <h5 class="mb-1">Sign & Stamp: <small>(For <b>MRI Indenting House</b>)</small></h5>
                            <br /><br /><br />
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border border-dark p-2 pb-5 pt-2">
                            <h5 class="mb-1">Sign & Stamp: <small>(For <b>{{ @$shipment->customer->name }}</b>)</span>
                            </h5>
                            <br /><br /><br />
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="row mt-2">
                                                <div class="col-12 mb-2">
                                                    <span>We hope our offer will prove competitive & we look forward to your order confirmation.</span>
                                                </div>
                                                <div class="col-12">
                                                    <span>Thank you</span>
                                                </div>
                                                <div class="col-12">
                                                    <span>Best Regards,</span>
                                                </div>
                                                <div class="col-12">
                                                    <span>For <b>MRI Indenting House</b></span>
                                                </div>
                                            </div> -->
        </div>
    </div>

@endsection
