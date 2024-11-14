<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="" class="app-brand-link">
            <img src="{{ asset(general()->logo) }}" width="40%" />
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    @php
        $sidebar = [];
        if (isset(auth()->user()->role_id)) {
            $sidebar = Get_Sidebar_User(auth()->user()->role_id);
        }
    @endphp

    <ul class="menu-inner py-1">
        <li class="menu-item {{ menuActive('dashboard') }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>

        @foreach ($sidebar as $key => $value)
            @if ($value->nav_id == 1 && in_array('view', Get_Permission($value->nav_id, auth()->user()->role_id)))
                <li class="menu-item {{ menuActive('product*') }}">
                    <a href="{{ route('product') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-stack"></i>
                        <div data-i18n="Materials">Materials</div>
                    </a>
                </li>
            @endif

            @if (
                $value->nav_id == 2 &&
                    (in_array('view', Get_Permission($value->nav_id, auth()->user()->role_id)) ||
                        in_array('map product', Get_Permission($value->nav_id, auth()->user()->role_id))))
                <li class="menu-item {{ menuActive('customer*', 2) }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-users"></i>
                        <div data-i18n="Customers">Customers</div>
                    </a>
                    <ul class="menu-sub">
                        @if (in_array('view', Get_Permission($value->nav_id, auth()->user()->role_id)))
                            <li class="menu-item {{ menuActive('customer*') }}">
                                <a href="{{ route('customer') }}" class="menu-link">
                                    <div data-i18n="Lists">Lists</div>
                                </a>
                            </li>
                        @endif

                        @if (in_array('map product', Get_Permission($value->nav_id, auth()->user()->role_id)))
                            <li class="menu-item">
                                <a href="{{ route('customer.map') }}" class="menu-link">
                                    <div data-i18n="Map Materials">Map Materials</div>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (
                $value->nav_id == 3 &&
                    (in_array('view', Get_Permission($value->nav_id, auth()->user()->role_id)) ||
                        in_array('map product', Get_Permission($value->nav_id, auth()->user()->role_id))))
                <li class="menu-item {{ menuActive('supplier*', 2) }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-users"></i>
                        <div data-i18n="Suppliers">Suppliers</div>
                    </a>
                    <ul class="menu-sub">
                        @if (in_array('view', Get_Permission($value->nav_id, auth()->user()->role_id)))
                            <li class="menu-item {{ menuActive('supplier*') }}">
                                <a href="{{ route('supplier') }}" class="menu-link">
                                    <div data-i18n="Lists">Lists</div>
                                </a>
                            </li>
                        @endif

                        @if (in_array('map product', Get_Permission($value->nav_id, auth()->user()->role_id)))
                            <li class="menu-item">
                                <a href="{{ route('supplier.map') }}" class="menu-link">
                                    <div data-i18n="Map Materials">Map Materials</div>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if ($value->nav_id == 4 && in_array('view', Get_Permission($value->nav_id, auth()->user()->role_id)))
                <li class="menu-item {{ menuActive('inquiry*') }}">
                    <a href="{{ route('inquiry') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-message-circle"></i>
                        <div data-i18n="Inquiry">Inquiry</div>
                    </a>
                </li>
            @endif

            @if ($value->nav_id == 5 && in_array('view', Get_Permission($value->nav_id, auth()->user()->role_id)))
                <li class="menu-item {{ menuActive('offer*') }}">
                    <a href="{{ route('offer') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-star"></i>
                        <div data-i18n="Offers">Offers</div>
                    </a>
                </li>
            @endif

            @if ($value->nav_id == 6 && in_array('view', Get_Permission($value->nav_id, auth()->user()->role_id)))
                <li class="menu-item {{ menuActive('po*') }}">
                    <a href="{{ route('po') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-package"></i>
                        <div data-i18n="Purchase Orders">Purchase Orders</div>
                    </a>
                </li>
            @endif

            @if ($value->nav_id == 7 && in_array('view', Get_Permission($value->nav_id, auth()->user()->role_id)))
                <li class="menu-item {{ menuActive('indent*') }}">
                    <a href="{{ route('indent') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-check"></i>
                        <div data-i18n="Indents">Indents</div>
                    </a>
                </li>
            @endif

            @if ($value->nav_id == 9 && in_array('view', Get_Permission($value->nav_id, auth()->user()->role_id)))
                <li class="menu-item {{ menuActive('shipment*') }}">
                    <a href="{{ route('shipment') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-truck"></i>
                        <div data-i18n="Shipments">Shipments</div>
                    </a>
                </li>
            @endif

            @if (
                $value->nav_id == 8 &&
                    (in_array('supplier list', Get_Permission($value->nav_id, auth()->user()->role_id)) ||
                        in_array('customer list', Get_Permission($value->nav_id, auth()->user()->role_id)) ||
                        in_array('material list', Get_Permission($value->nav_id, auth()->user()->role_id)) ||
                        in_array('item wise supplier', Get_Permission($value->nav_id, auth()->user()->role_id)) ||
                        in_array('item wise customer', Get_Permission($value->nav_id, auth()->user()->role_id)) ||
                        in_array('inquiry', Get_Permission($value->nav_id, auth()->user()->role_id)) ||
                        in_array('offer', Get_Permission($value->nav_id, auth()->user()->role_id)) ||
                        in_array('po', Get_Permission($value->nav_id, auth()->user()->role_id)) ||
                        in_array('indent', Get_Permission($value->nav_id, auth()->user()->role_id)) ||
                        in_array('shipment', Get_Permission($value->nav_id, auth()->user()->role_id))))
                <li class="menu-item {{ menuActive('report*', 2) }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-chart-bar"></i>
                        <div data-i18n="Reports">Reports</div>
                    </a>
                    <ul class="menu-sub">
                        @if (in_array('supplier list', Get_Permission($value->nav_id, auth()->user()->role_id)))
                            <li class="menu-item {{ menuActive('report.supplier') }}">
                                <a href="{{ route('report.supplier') }}" class="menu-link">
                                    <div data-i18n="Supplier List">Supplier List</div>
                                </a>
                            </li>
                        @endif

                        @if (in_array('customer list', Get_Permission($value->nav_id, auth()->user()->role_id)))
                            <li class="menu-item {{ menuActive('report.customer') }}">
                                <a href="{{ route('report.customer') }}" class="menu-link">
                                    <div data-i18n="Customer List">Customer List</div>
                                </a>
                            </li>
                        @endif

                        @if (in_array('material list', Get_Permission($value->nav_id, auth()->user()->role_id)))
                            <li class="menu-item {{ menuActive('report.product') }}">
                                <a href="{{ route('report.product') }}" class="menu-link">
                                    <div data-i18n="Materials List">Materials List</div>
                                </a>
                            </li>
                        @endif

                        @if (in_array('item wise supplier', Get_Permission($value->nav_id, auth()->user()->role_id)))
                            <li class="menu-item {{ menuActive('report.supplier_product') }}">
                                <a href="{{ route('report.supplier_product') }}" class="menu-link">
                                    <div data-i18n="Item Wise Supplier">Item Wise Supplier</div>
                                </a>
                            </li>
                        @endif

                        @if (in_array('item wise customer', Get_Permission($value->nav_id, auth()->user()->role_id)))
                            <li class="menu-item {{ menuActive('report.customer_product') }}">
                                <a href="{{ route('report.customer_product') }}" class="menu-link">
                                    <div data-i18n="Item Wise Customer">Item Wise Customer</div>
                                </a>
                            </li>
                        @endif

                        @if (in_array('inquiry', Get_Permission($value->nav_id, auth()->user()->role_id)))
                            <li class="menu-item {{ menuActive('report.inquiry') }}">
                                <a href="{{ route('report.inquiry') }}" class="menu-link">
                                    <div data-i18n="Inquiry">Inquiry</div>
                                </a>
                            </li>
                        @endif

                        @if (in_array('offer', Get_Permission($value->nav_id, auth()->user()->role_id)))
                            <li class="menu-item {{ menuActive('report.offer') }}">
                                <a href="{{ route('report.offer') }}" class="menu-link">
                                    <div data-i18n="Offer">Offer</div>
                                </a>
                            </li>
                        @endif

                        @if (in_array('po', Get_Permission($value->nav_id, auth()->user()->role_id)))
                            <li class="menu-item {{ menuActive('report.po') }}">
                                <a href="{{ route('report.po') }}" class="menu-link">
                                    <div data-i18n="Purchase Order">Purchase Order</div>
                                </a>
                            </li>
                        @endif

                        @if (in_array('indent', Get_Permission($value->nav_id, auth()->user()->role_id)))
                            <li class="menu-item {{ menuActive('report.indent') }}">
                                <a href="{{ route('report.indent') }}" class="menu-link">
                                    <div data-i18n="Indent">Indent</div>
                                </a>
                            </li>
                        @endif

                        @if (in_array('shipment', Get_Permission($value->nav_id, auth()->user()->role_id)))
                            <li class="menu-item {{ menuActive('report.shipment') }}">
                                <a href="{{ route('report.shipment') }}" class="menu-link">
                                    <div data-i18n="Shipment">Shipment</div>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if ($value->nav_id == 10 && in_array('view', Get_Permission($value->nav_id, auth()->user()->role_id)))
                <li class="menu-item {{ menuActive('size*') }}">
                    <a href="{{ route('size') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-ruler"></i>
                        <div data-i18n="Sizes">Sizes</div>
                    </a>
                </li>
            @endif

            @if ($value->nav_id == 11 && in_array('view', Get_Permission($value->nav_id, auth()->user()->role_id)))
                <li class="menu-item {{ menuActive('shade_card*') }}">
                    <a href="{{ route('shade_card') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-palette"></i>
                        <div data-i18n="Shade Card & Artwork">Shade Card & Artwork</div>
                    </a>
                </li>
            @endif
        @endforeach

        @if (auth()->user()->id == 1)
            <li class="menu-item {{ menuActive('role*') }}">
                <a href="{{ route('role') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-shield"></i>
                    <div data-i18n="Roles">Roles</div>
                </a>
            </li>

            <li class="menu-item {{ menuActive('user*') }}">
                <a href="{{ route('user') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-users"></i>
                    <div data-i18n="Users">Users</div>
                </a>
            </li>

            <li class="menu-item {{ menuActive('email.setting') }}">
                <a href="{{ route('email.setting') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-mail"></i>
                    <div data-i18n="Email Setting">Email Setting</div>
                </a>
            </li>
        @endif
    </ul>
</aside>
