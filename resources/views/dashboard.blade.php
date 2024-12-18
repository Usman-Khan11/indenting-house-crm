@extends('layout.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-xl-3 mb-4 col-lg-3 col-6">
                    <div class="card h-100 cursor-pointer">
                        <div class="card-body">
                            <div class="d-flex align-items-center" onclick="window.location.assign('/products')">
                                <div class="badge rounded-pill bg-label-success me-3 p-2">
                                    <i class="ti ti-stack ti-lg"></i>
                                </div>
                                <div class="card-info">
                                    <h5 class="mb-0">{{ \App\Models\Product::count() }}</h5>
                                    <small>Materials</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 mb-4 col-lg-3 col-6">
                    <div class="card h-100 cursor-pointer">
                        <div class="card-body">
                            <div class="d-flex align-items-center" onclick="window.location.assign('/customers')">
                                <div class="badge rounded-pill bg-label-success me-3 p-2">
                                    <i class="ti ti-users ti-lg"></i>
                                </div>
                                <div class="card-info">
                                    <h5 class="mb-0">{{ \App\Models\Customer::count() }}</h5>
                                    <small>Customers</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 mb-4 col-lg-3 col-6">
                    <div class="card h-100 cursor-pointer">
                        <div class="card-body">
                            <div class="d-flex align-items-center" onclick="window.location.assign('/suppliers')">
                                <div class="badge rounded-pill bg-label-success me-3 p-2">
                                    <i class="ti ti-users ti-lg"></i>
                                </div>
                                <div class="card-info">
                                    <h5 class="mb-0">{{ \App\Models\Supplier::count() }}</h5>
                                    <small>Suppliers</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 mb-4 col-lg-3 col-6">
                    <div class="card h-100 cursor-pointer">
                        <div class="card-body">
                            <div class="d-flex align-items-center" onclick="window.location.assign('/inquiry')">
                                <div class="badge rounded-pill bg-label-success me-3 p-2">
                                    <i class="ti ti-message-circle ti-lg"></i>
                                </div>
                                <div class="card-info">
                                    <h5 class="mb-0">{{ \App\Models\Inquiry::count() }}</h5>
                                    <small>Inquiries</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 mb-4 col-lg-3 col-6">
                    <div class="card h-100 cursor-pointer">
                        <div class="card-body">
                            <div class="d-flex align-items-center" onclick="window.location.assign('/offers')">
                                <div class="badge rounded-pill bg-label-success me-3 p-2">
                                    <i class="ti ti-star ti-lg"></i>
                                </div>
                                <div class="card-info">
                                    <h5 class="mb-0">{{ \App\Models\Offer::count() }}</h5>
                                    <small>Offers</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 mb-4 col-lg-3 col-6">
                    <div class="card h-100 cursor-pointer">
                        <div class="card-body">
                            <div class="d-flex align-items-center" onclick="window.location.assign('/po')">
                                <div class="badge rounded-pill bg-label-success me-3 p-2">
                                    <i class="ti ti-package ti-lg"></i>
                                </div>
                                <div class="card-info">
                                    <h5 class="mb-0">{{ \App\Models\PurchaseOrder::count() }}</h5>
                                    <small>Purchase Orders</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 mb-4 col-lg-3 col-6">
                    <div class="card h-100 cursor-pointer">
                        <div class="card-body">
                            <div class="d-flex align-items-center" onclick="window.location.assign('/indents')">
                                <div class="badge rounded-pill bg-label-success me-3 p-2">
                                    <i class="ti ti-check ti-lg"></i>
                                </div>
                                <div class="card-info">
                                    <h5 class="mb-0">{{ \App\Models\Indent::count() }}</h5>
                                    <small>Indents</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 mb-4 col-lg-3 col-6">
                    <div class="card h-100 cursor-pointer">
                        <div class="card-body">
                            <div class="d-flex align-items-center" onclick="window.location.assign('/shipments')">
                                <div class="badge rounded-pill bg-label-success me-3 p-2">
                                    <i class="ti ti-truck ti-lg"></i>
                                </div>
                                <div class="card-info">
                                    <h5 class="mb-0">{{ \App\Models\Shipment::count() }}</h5>
                                    <small>Shipments</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 mb-4 col-lg-3 col-6">
                    <div class="card h-100 cursor-pointer">
                        <div class="card-body">
                            <div class="d-flex align-items-center" onclick="window.location.assign('/sizes')">
                                <div class="badge rounded-pill bg-label-success me-3 p-2">
                                    <i class="ti ti-ruler ti-lg"></i>
                                </div>
                                <div class="card-info">
                                    <h5 class="mb-0">{{ \App\Models\Size::count() }}</h5>
                                    <small>Sizes</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 mb-4 col-lg-3 col-6">
                    <div class="card h-100 cursor-pointer">
                        <div class="card-body">
                            <div class="d-flex align-items-center" onclick="window.location.assign('/shade-cards')">
                                <div class="badge rounded-pill bg-label-success me-3 p-2">
                                    <i class="ti ti-palette ti-lg"></i>
                                </div>
                                <div class="card-info">
                                    <h5 class="mb-0">{{ \App\Models\Card::count() }}</h5>
                                    <small>Shade Card & Artwork</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 mb-4 col-lg-3 col-6">
                    <div class="card h-100 cursor-pointer">
                        <div class="card-body">
                            <div class="d-flex align-items-center" onclick="window.location.assign('/proforma-invoices')">
                                <div class="badge rounded-pill bg-label-success me-3 p-2">
                                    <i class="ti ti-file-invoice ti-lg"></i>
                                </div>
                                <div class="card-info">
                                    <h5 class="mb-0">{{ \App\Models\ProformaInvoice::count() }}</h5>
                                    <small>Proforma Invoices</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
