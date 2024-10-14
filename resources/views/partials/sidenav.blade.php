<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="" class="app-brand-link">
            <img src="{{ asset(general()->logo) }}" width="40%" />
            <!-- <span class="app-brand-text demo menu-text fw-bold">Power Tech</span> -->
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-item {{ menuActive('dashboard') }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>

        <li class="menu-item {{ menuActive('product*') }}">
            <a href="{{ route('product') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-shopping-cart"></i>
                <div data-i18n="Materials">Materials</div>
            </a>
        </li>

        <li class="menu-item {{ menuActive('customer*', 2) }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div data-i18n="Customers">Customers</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ menuActive('customer*') }}">
                    <a href="{{ route('customer') }}" class="menu-link">
                        <div data-i18n="Lists">Lists</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('customer.map') }}" class="menu-link">
                        <div data-i18n="Map Materials">Map Materials</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ menuActive('supplier*', 2) }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div data-i18n="Suppliers">Suppliers</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ menuActive('supplier*') }}">
                    <a href="{{ route('supplier') }}" class="menu-link">
                        <div data-i18n="Lists">Lists</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('supplier.map') }}" class="menu-link">
                        <div data-i18n="Map Materials">Map Materials</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ menuActive('inquiry*') }}">
            <a href="{{ route('inquiry') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-file"></i>
                <div data-i18n="Inquiry">Inquiry</div>
            </a>
        </li>

        <li class="menu-item {{ menuActive('offer*') }}">
            <a href="{{ route('offer') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-file"></i>
                <div data-i18n="Offers">Offers</div>
            </a>
        </li>

        <li class="menu-item {{ menuActive('po*') }}">
            <a href="{{ route('po') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-file"></i>
                <div data-i18n="Purchase Orders">Purchase Orders</div>
            </a>
        </li>

        <li class="menu-item {{ menuActive('indent*') }}">
            <a href="{{ route('indent') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-file"></i>
                <div data-i18n="Indents">Indents</div>
            </a>
        </li>

        <li class="menu-item {{ menuActive('report*', 2) }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div data-i18n="Reports">Reports</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ menuActive('report.supplier') }}">
                    <a href="{{ route('report.supplier') }}" class="menu-link">
                        <div data-i18n="Supplier List">Supplier List</div>
                    </a>
                </li>
                <li class="menu-item {{ menuActive('report.customer') }}">
                    <a href="{{ route('report.customer') }}" class="menu-link">
                        <div data-i18n="Customer List">Customer List</div>
                    </a>
                </li>
                <li class="menu-item {{ menuActive('report.product') }}">
                    <a href="{{ route('report.product') }}" class="menu-link">
                        <div data-i18n="Materials List">Materials List</div>
                    </a>
                </li>
                <li class="menu-item {{ menuActive('report.supplier_product') }}">
                    <a href="{{ route('report.supplier_product') }}" class="menu-link">
                        <div data-i18n="Item Wise Supplier">Item Wise Supplier</div>
                    </a>
                </li>
                <li class="menu-item {{ menuActive('report.customer_product') }}">
                    <a href="{{ route('report.customer_product') }}" class="menu-link">
                        <div data-i18n="Item Wise Customer">Item Wise Customer</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- <li class="menu-item {{ menuActive('quotation*') }}">
            <a href="{{ route('quotation') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-database"></i>
                <div data-i18n="Quotations">Quotations</div>
            </a>
        </li>

        <li class="menu-item {{ menuActive('service*') }}">
            <a href="{{ route('service') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-file"></i>
                <div data-i18n="Services">Services</div>
            </a>
        </li>

        <li class="menu-item {{ menuActive('note*') }}">
            <a href="{{ route('note') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-edit"></i>
                <div data-i18n="Notes">Notes</div>
            </a>
        </li>

        <li class="menu-item {{ menuActive('delivery_note*') }}">
            <a href="{{ route('delivery_note') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-edit"></i>
                <div data-i18n="Delivery Notes">Delivery Notes</div>
            </a>
        </li>

        <li class="menu-item {{ menuActive('payment_note*') }}">
            <a href="{{ route('payment_note') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-edit"></i>
                <div data-i18n="Payment Notes">Payment Notes</div>
            </a>
        </li>

        <li class="menu-item {{ menuActive('warranty_note*') }}">
            <a href="{{ route('warranty_note') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-edit"></i>
                <div data-i18n="Warranty Notes">Warranty Notes</div>
            </a>
        </li> -->
    </ul>
</aside>