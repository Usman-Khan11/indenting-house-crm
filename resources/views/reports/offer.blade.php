@extends('layout.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-6">
                        <h4 class="card-title m-0">{{ $page_title }}</h4>
                    </div>
                </div>
                <hr />
            </div>
            <div class="card-body">
                <div class="row mb-1">
                    <div class="col-md-2 mb-2">
                        <label class="form-label">From</label>
                        <input type="date" id="from" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>

                    <div class="col-md-2 mb-2">
                        <label class="form-label">To</label>
                        <input type="date" id="to" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>

                    <div class="col-md-4 mb-2">
                        <label class="form-label">Customers</label>
                        <select id="customer_id" class="select2 form-select">
                            <option value="">All</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-2">
                        <label class="form-label">Suppliers</label>
                        <select id="supplier_id" class="select2 form-select">
                            <option value="">All</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-2">
                        <label class="form-label">Materials</label>
                        <select id="product_id" class="select2 form-select">
                            <option value="">All</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-2 mt-4">
                        <button type="button" class="btn btn-primary w-100 d-block" id="filter_btn">Filter Data</button>
                    </div>
                </div>
                <div class="responsive text-nowrap">
                    <table class="table table-bordered table-sm" id="my_table"></table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script type="text/javascript">
        $(document).ready(function() {
            let title = 'MRI Offer Report';
            let filename = 'offer-report';

            var datatable = $("#my_table").DataTable({
                select: {
                    style: "api",
                },
                processing: true,
                searching: false,
                serverSide: true,
                lengthChange: true,
                ordering: false,
                paging: false,
                pageLength: '{{ general()->page_length }}',
                scrollX: true,
                ajax: {
                    url: "{{ route('report.offer') }}",
                    type: "get",
                    data: function(d) {
                        d.from = $("#from").val();
                        d.to = $("#to").val();
                        d.customer_id = $("#customer_id").val();
                        d.supplier_id = $("#supplier_id").val();
                        d.product_id = $("#product_id").val();
                    },
                },
                columns: [{
                        data: "offer_no",
                        title: "offer #",
                    },
                    {
                        title: 'Date',
                        "render": function(data, type, full, meta) {
                            return getDate(full.offer_date);
                        }
                    },
                    {
                        data: "customer_name",
                        title: "Customer",
                    },
                    {
                        data: "location",
                        title: "Location",
                    },
                    {
                        data: "product_name",
                        title: "Item Description",
                        class: 'text-wrap',
                        render: function(data, type, full, meta) {
                            var p = `
                            <div><strong>${full.product_name}</strong></div>
                            <div><small>${full.product_description}</small></div>`;

                            return p;
                        }
                    },
                    {
                        data: "qty",
                        title: "Qty",
                        render: function(data, type, full, meta) {
                            return `${full.qty} ${full.unit}`;
                        }
                    },
                    {
                        data: "rate",
                        title: "Rate",
                        render: function(data, type, full, meta) {
                            return parseFloat(data).toFixed(3);
                        }
                    },
                    {
                        data: "currency",
                        title: "currency",
                    },
                    {
                        data: "supplier_name",
                        title: "Supplier",
                    },
                    {
                        data: "sales_person",
                        title: "Sales Person",
                    },
                    {
                        data: "sourcing_person",
                        title: "Sourcing Person",
                    },
                    {
                        title: "Inquiry Close",
                        render: function(data, type, full, meta) {
                            if (full.is_close == 1) {
                                return `<span class="badge bg-success">Yes</span>`;
                            } else {
                                return `<span class="badge bg-danger">No</span>`;
                            }
                        }
                    },
                    {
                        data: "reason_of_close",
                        title: "Reason of Close",
                    },
                ],
                rowCallback: function(row, data) {},
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excelHtml5',
                        text: 'Export Excel',
                        title: function() {
                            return title;
                        },
                        className: "btn-success",
                        filename: filename
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'Export PDF',
                        title: function() {
                            return title;
                        },
                        className: "btn-success",
                        filename: filename
                    },
                    {
                        extend: 'print',
                        text: 'Print Table',
                        title: function() {
                            return title;
                        },
                        className: "btn-success",
                        filename: filename
                    }
                ]
            });

            $("#filter_btn").click(function() {
                let from = $("#from").val();
                let to = $("#to").val();
                let customer_id = $("#customer_id").val();
                let supplier_id = $("#supplier_id").val();
                let product_id = $("#product_id").val();

                datatable.ajax.reload();
                title = `MRI Offer Report ${getDate(from)} to ${getDate(to)}`;
            })
        });
    </script>
@endpush
