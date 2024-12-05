<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="" class="app-brand-link">
            <img src="{{ asset(general()->logo) }}" width="35%" />
            {{-- <span class="app-brand-text demo menu-text fw-bold">MRI</span> --}}
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    @php
        $role_id = 0;
        if (isset(auth()->user()->role_id)) {
            $role_id = auth()->user()->role_id;
        }
    @endphp

    <ul class="menu-inner">
        <li class="menu-item {{ menuActive('dashboard') }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>

        @if (checkSidebar($role_id, 1, 'view') || checkSidebar($role_id, 1, 'map'))
            {{-- <li class="menu-item {{ menuActive('product*') }}">
                <a href="{{ route('product') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-stack"></i>
                    <div data-i18n="Materials">Materials</div>
                </a>
            </li> --}}

            <li class="menu-item {{ menuActive('product*', 2) }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-stack"></i>
                    <div data-i18n="Materials">Materials</div>
                </a>
                <ul class="menu-sub">
                    @if (checkSidebar($role_id, 1, 'view'))
                        <li class="menu-item {{ menuActive('product*') }}">
                            <a href="{{ route('product') }}" class="menu-link">
                                <div data-i18n="Lists">Lists</div>
                            </a>
                        </li>
                    @endif

                    @if (checkSidebar($role_id, 1, 'map'))
                        <li class="menu-item">
                            <a href="{{ route('product.map') }}" class="menu-link">
                                <div data-i18n="Map">Map</div>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        @if (checkSidebar($role_id, 2, 'view') || checkSidebar($role_id, 2, 'map product'))
            <li class="menu-item {{ menuActive('customer*', 2) }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-users"></i>
                    <div data-i18n="Customers">Customers</div>
                </a>
                <ul class="menu-sub">
                    @if (checkSidebar($role_id, 2, 'view'))
                        <li class="menu-item {{ menuActive('customer*') }}">
                            <a href="{{ route('customer') }}" class="menu-link">
                                <div data-i18n="Lists">Lists</div>
                            </a>
                        </li>
                    @endif

                    @if (checkSidebar($role_id, 2, 'map product'))
                        <li class="menu-item">
                            <a href="{{ route('customer.map') }}" class="menu-link">
                                <div data-i18n="Map Materials">Map Materials</div>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        @if (checkSidebar($role_id, 3, 'view') || checkSidebar($role_id, 3, 'map product'))
            <li class="menu-item {{ menuActive('supplier*', 2) }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-users"></i>
                    <div data-i18n="Suppliers">Suppliers</div>
                </a>
                <ul class="menu-sub">
                    @if (checkSidebar($role_id, 3, 'view'))
                        <li class="menu-item {{ menuActive('supplier*') }}">
                            <a href="{{ route('supplier') }}" class="menu-link">
                                <div data-i18n="Lists">Lists</div>
                            </a>
                        </li>
                    @endif

                    @if (checkSidebar($role_id, 3, 'map product'))
                        <li class="menu-item">
                            <a href="{{ route('supplier.map') }}" class="menu-link">
                                <div data-i18n="Map Materials">Map Materials</div>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        @if (checkSidebar($role_id, 4, 'view'))
            <li class="menu-item {{ menuActive('inquiry*') }}">
                <a href="{{ route('inquiry') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-message-circle"></i>
                    <div data-i18n="Inquiry">Inquiry</div>
                </a>
            </li>
        @endif

        @if (checkSidebar($role_id, 5, 'view'))
            <li class="menu-item {{ menuActive('offer*') }}">
                <a href="{{ route('offer') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-star"></i>
                    <div data-i18n="Offers">Offers</div>
                </a>
            </li>
        @endif

        @if (checkSidebar($role_id, 6, 'view'))
            <li class="menu-item {{ menuActive('po*') }}">
                <a href="{{ route('po') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-package"></i>
                    <div data-i18n="Purchase Orders">Purchase Orders</div>
                </a>
            </li>
        @endif

        @if (checkSidebar($role_id, 7, 'view'))
            <li class="menu-item {{ menuActive('indent*') }}">
                <a href="{{ route('indent') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-check"></i>
                    <div data-i18n="Indents">Indents</div>
                </a>
            </li>
        @endif

        @if (checkSidebar($role_id, 9, 'view'))
            <li class="menu-item {{ menuActive('shipment*') }}">
                <a href="{{ route('shipment') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-truck"></i>
                    <div data-i18n="Shipments">Shipments</div>
                </a>
            </li>
        @endif

        @if (checkSidebar($role_id, 10, 'view'))
            <li class="menu-item {{ menuActive('size*') }}">
                <a href="{{ route('size') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-ruler"></i>
                    <div data-i18n="Sizes">Sizes</div>
                </a>
            </li>
        @endif

        @if (checkSidebar($role_id, 11, 'view'))
            <li class="menu-item {{ menuActive('shade_card*') }}">
                <a href="{{ route('shade_card') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-palette"></i>
                    <div data-i18n="Shade Card & Artwork">Shade Card & Artwork</div>
                </a>
            </li>
        @endif

        @if (checkSidebar($role_id, 12, 'view'))
            <li class="menu-item {{ menuActive('proforma_invoice*') }}">
                <a href="{{ route('proforma_invoice') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-file-invoice"></i>
                    <div data-i18n="Proforma Invoices">Proforma Invoices</div>
                </a>
            </li>
        @endif

        @if (checkSidebar($role_id, 8, 'supplier list') ||
                checkSidebar($role_id, 8, 'customer list') ||
                checkSidebar($role_id, 8, 'material list') ||
                checkSidebar($role_id, 8, 'item wise supplier') ||
                checkSidebar($role_id, 8, 'item wise customer') ||
                checkSidebar($role_id, 8, 'inquiry') ||
                checkSidebar($role_id, 8, 'offer') ||
                checkSidebar($role_id, 8, 'po') ||
                checkSidebar($role_id, 8, 'indent') ||
                checkSidebar($role_id, 8, 'shipment'))
            <li class="menu-item {{ menuActive('report*', 2) }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-chart-bar"></i>
                    <div data-i18n="Reports">Reports</div>
                </a>
                <ul class="menu-sub">
                    @if (checkSidebar($role_id, 8, 'supplier list'))
                        <li class="menu-item {{ menuActive('report.supplier') }}">
                            <a href="{{ route('report.supplier') }}" class="menu-link">
                                <div data-i18n="Supplier List">Supplier List</div>
                            </a>
                        </li>
                    @endif

                    @if (checkSidebar($role_id, 8, 'customer list'))
                        <li class="menu-item {{ menuActive('report.customer') }}">
                            <a href="{{ route('report.customer') }}" class="menu-link">
                                <div data-i18n="Customer List">Customer List</div>
                            </a>
                        </li>
                    @endif

                    @if (checkSidebar($role_id, 8, 'material list'))
                        <li class="menu-item {{ menuActive('report.product') }}">
                            <a href="{{ route('report.product') }}" class="menu-link">
                                <div data-i18n="Materials List">Materials List</div>
                            </a>
                        </li>
                    @endif

                    @if (checkSidebar($role_id, 8, 'item wise supplier'))
                        <li class="menu-item {{ menuActive('report.supplier_product') }}">
                            <a href="{{ route('report.supplier_product') }}" class="menu-link">
                                <div data-i18n="Item Wise Supplier">Item Wise Supplier</div>
                            </a>
                        </li>
                    @endif

                    @if (checkSidebar($role_id, 8, 'item wise customer'))
                        <li class="menu-item {{ menuActive('report.customer_product') }}">
                            <a href="{{ route('report.customer_product') }}" class="menu-link">
                                <div data-i18n="Item Wise Customer">Item Wise Customer</div>
                            </a>
                        </li>
                    @endif

                    @if (checkSidebar($role_id, 8, 'inquiry'))
                        <li class="menu-item {{ menuActive('report.inquiry') }}">
                            <a href="{{ route('report.inquiry') }}" class="menu-link">
                                <div data-i18n="Inquiry">Inquiry</div>
                            </a>
                        </li>
                    @endif

                    @if (checkSidebar($role_id, 8, 'offer'))
                        <li class="menu-item {{ menuActive('report.offer') }}">
                            <a href="{{ route('report.offer') }}" class="menu-link">
                                <div data-i18n="Offer">Offer</div>
                            </a>
                        </li>
                    @endif

                    @if (checkSidebar($role_id, 8, 'po'))
                        <li class="menu-item {{ menuActive('report.po') }}">
                            <a href="{{ route('report.po') }}" class="menu-link">
                                <div data-i18n="Purchase Order">Purchase Order</div>
                            </a>
                        </li>
                    @endif

                    @if (checkSidebar($role_id, 8, 'indent'))
                        <li class="menu-item {{ menuActive('report.indent') }}">
                            <a href="{{ route('report.indent') }}" class="menu-link">
                                <div data-i18n="Indent">Indent</div>
                            </a>
                        </li>
                    @endif

                    @if (checkSidebar($role_id, 8, 'shipment'))
                        <li class="menu-item {{ menuActive('report.shipment') }}">
                            <a href="{{ route('report.shipment') }}" class="menu-link">
                                <div data-i18n="Shipment">Shipment</div>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif
    </ul>
</aside>
