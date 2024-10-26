@extends('layout.app')

@push('style')
<style>
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
    }

    .low-padding-table td,
    .low-padding-table th {
        padding: 4px;
        /* Adjust padding as needed */
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
            <h3 class="text-center fw-bolder">OFFER</h3>
            <table class="table table-bordered table-sm border-dark">
                <tbody>
                    <tr>
                        <td width="60%">
                            <h5 class="mb-1">{{ @$offer->customer->name ?? '-' }}</h5>
                            <small class="mb-0">{{ @$offer->customer->address_office }}</small>
                        </td>
                        <td width="22%">
                            <h5 class="mb-0">Offer No.</h5>
                        </td>
                        <td width="18%">
                            <h6 class="m-0 text-center">{{ $offer->offer_no }}</h6>
                        </td>
                    </tr>
                    <tr>
                        <td width="60%">
                            <h4 class="mb-1">{{ @$offer->customer->person ?? '-' }}</h4>
                        </td>
                        <td width="22%">
                            <h5 class="mb-1">Offer Date</h5>
                            <h5 class="mb-1">Offer Validity</h5>
                        </td>
                        <td width="18%">
                            <h6 class="m-0 mb-1 text-center">{{ date("d-M-Y", strtotime($offer->date)) }}</h6>
                            <h6 class="m-0 mb-1 text-center">{{ date("d-M-Y", strtotime($offer->validity)) }}</h6>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row d-flex justify-content-between mb-3">
            <div class="col-sm-12">
                <h6>
                    Dear Sir, <br> With reference to your inquiry, we feel pleased to quote you, as under subject to final confirmation..
                </h6>
            </div>
        </div>

        @if($offer->items)
        <div class="w-100">
            <table class="table table-sm text-wrap w-100 table-bordered border-dark">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Rate</th>
                        <th>Shipping Type</th>
                        <th>Shipment Mode</th>
                        <th>Payment Term</th>
                        <th>Delivery</th>
                        <th>Supplier</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($offer->items as $k => $v)
                    <tr>
                        <td>
                            {{ @$v->item->name }} <br>
                            <small>{{ @$v->item->description }}</small>
                        </td>
                        <td>
                            {{ number_format(@$v->qty) }}
                            {{ @$v->unit }}
                        </td>
                        <td>
                            {{ $offer->currency }} &nbsp;
                            {{ number_format(@$v->rate, 3) }}/
                            {{ @$v->unit }}
                        </td>
                        <td>{{ @$v->shipping_type }}</td>
                        <td>{{ @$v->shipment_mode }}</td>
                        <td>{{ @$v->payment_term }}</td>
                        <td>{{ @$v->delivery }}</td>
                        <td>{{ @$v->supplier->name }}</td>
                    </tr>
                    @endforeach
                    <!-- <tr>
                        <td colspan="3" class="align-top px-4 py-3">
                            <p class="mb-2">
                                <span class="me-1 fw-bold">Salesperson:</span>
                                <span>Alfie Solomons</span>
                            </p>
                            <span>Thanks for your business</span>
                        </td>
                        <td class="text-end px-4 py-3">
                            <p class="mb-2">Subtotal:</p>
                            <p class="mb-2">Discount:</p>
                            <p class="mb-2">Tax:</p>
                            <p class="mb-0">Total:</p>
                        </td>
                        <td class="px-4 py-3">
                            <p class="fw-bold mb-2">$154.25</p>
                            <p class="fw-bold mb-2">$00.00</p>
                            <p class="fw-bold mb-2">$50.00</p>
                            <p class="fw-bold mb-0">$204.25</p>
                        </td>
                    </tr> -->
                </tbody>
            </table>
        </div>
        @endif

        <div class="row mt-2">
            <div class="col-12 mb-2">
                <span>We hope our offer will prove competitive & we look forward to your order confirmation.</span>
            </div>
            <div class="col-12 mt-5">
                <span>Thank you</span>
            </div>
            <div class="col-12">
                <span>Best Regards,</span>
            </div>
            <div class="col-12">
                <span>For <b>MRI Indenting House</b></span>
            </div>
        </div>
    </div>
</div>

@endsection