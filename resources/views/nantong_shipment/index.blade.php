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
                        <a href="{{ route('nantong_shipment.create') }}" class="btn btn-primary">Add New Nantong Shipment</a>
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
                ordering: true,
                order: [
                    [5, 'desc']
                ],
                pageLength: '{{ general()->page_length }}',
                scrollX: true,
                ajax: {
                    url: "{{ route('nantong_shipment') }}",
                    type: "get",
                    data: function(d) {},
                },
                columns: [{
                        title: "Options",
                        class: "text-nowrap",
                        render: function(data, type, full, meta) {
                            let button = '';
                            button +=
                                `<a href="/nantong-shipment/view/${full.id}" target="_blank" class="btn btn-info btn-xs">View</a> `;
                            button +=
                                `<a href="/nantong-shipment/edit/${full.id}" class="btn btn-warning btn-xs">Edit</a> `;
                            button +=
                                `<a onclick="return checkDelete()" href="/nantong-shipment/delete/${full.id}" class="btn btn-danger btn-xs">Delete</a> `;

                            return button;
                        },
                    },
                    {
                        data: "shipment_no",
                        title: "Shipment #",
                    },
                    {
                        data: "pi.pi_no",
                        title: "PI #",
                        render: function(data, type, full, meta) {
                            if (full.pi) {
                                return full.pi.pi_no;
                            } else {
                                return '-';
                            }
                        }
                    },
                    {
                        data: "customer.name",
                        title: "Customer",
                        render: function(data, type, full, meta) {
                            if (full.customer) {
                                return full.customer.name;
                            } else {
                                return '-';
                            }
                        }
                    },
                    {
                        data: "supplier.name",
                        title: "Supplier",
                        render: function(data, type, full, meta) {
                            if (full.supplier) {
                                return full.supplier.name;
                            } else {
                                return '-';
                            }
                        }
                    },
                    {
                        data: "date",
                        title: 'Date',
                        "render": function(data, type, full, meta) {
                            return getDate(full.date);
                        }
                    },
                    {
                        data: "currency",
                        title: "currency",
                    },
                    {
                        data: "added_by.name",
                        title: "Added By",
                        render: function(data, type, full, meta) {
                            if (full.added_by) {
                                return full.added_by.name;
                            } else {
                                return '-';
                            }
                        }
                    }
                ],
                rowCallback: function(row, data) {},
            });
        });
    </script>
@endpush
