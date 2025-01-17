@extends('layout.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-6">
                        <h4 class="card-title m-0">{{ $page_title }}</h4>
                    </div>
                    <div class="col-6 text-end">
                        <a href="{{ route('shipment.create') }}" class="btn btn-primary">Add New Shipment</a>
                    </div>
                </div>
                <hr />
            </div>
            <div class="card-body">
                <div class="responsive text-nowrap">
                    <table class="table table-sm" id="my_table"></table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var datatable = $("#my_table").DataTable({
                select: {
                    style: "api",
                },
                processing: true,
                searching: true,
                serverSide: true,
                lengthChange: false,
                ordering: false,
                pageLength: '{{ general()->page_length }}',
                scrollX: true,
                ajax: {
                    url: "{{ route('shipment') }}",
                    type: "get",
                    data: function(d) {},
                },
                columns: [{
                        title: "Options",
                        class: "text-nowrap",
                        render: function(data, type, full, meta) {
                            let button = '';
                            button +=
                                `<a href="/shipment/view/${full.id}" target="_blank" class="btn btn-info btn-xs">View</a> `;
                            button +=
                                `<a href="/shipment/edit/${full.id}" class="btn btn-warning btn-xs">Edit</a> `;
                            button +=
                                `<a onclick="return checkDelete()" href="/shipment/delete/${full.id}" class="btn btn-danger btn-xs">Delete</a> `;

                            return button;
                        },
                    },
                    {
                        data: "shipment_no",
                        title: "Shipment #",
                    },
                    {
                        title: "Indent #",
                        data: "indent_no",
                    },
                    {
                        title: "Customer",
                        data: "customer_name",
                    },
                    {
                        title: "Supplier",
                        data: "supplier_name",
                    },
                    {
                        title: 'Date',
                        "render": function(data, type, full, meta) {
                            return getDate(full.shipment_date);
                        }
                    },
                    {
                        data: "currency",
                        title: "currency",
                    },
                    {
                        title: "Added By",
                        data: "user_name",
                    }
                ],
                rowCallback: function(row, data) {},
            });
        });
    </script>
@endpush
