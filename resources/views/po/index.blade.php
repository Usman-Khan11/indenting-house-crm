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
                        <a href="{{ route('po.create') }}" class="btn btn-primary">Add New Purchase Order</a>
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
                    [1, 'desc']
                ],
                pageLength: '{{ general()->page_length }}',
                scrollX: true,
                ajax: {
                    url: "{{ route('po') }}",
                    type: "get",
                    data: function(d) {},
                },
                columns: [{
                        title: "Options",
                        class: "text-nowrap",
                        render: function(data, type, full, meta) {
                            let button = '';
                            button +=
                                `<a href="/po/view/${full.id}" target="_blank" class="btn btn-info btn-xs">View</a> `;
                            button +=
                                `<a href="/po/edit/${full.id}" class="btn btn-warning btn-xs">Edit</a> `;
                            button +=
                                `<a onclick="return checkDelete()" href="/po/delete/${full.id}" class="btn btn-danger btn-xs">Delete</a> `;

                            return button;
                        },
                    },
                    {
                        data: "po_no",
                        title: "PO #",
                        render: function(data, type, full, meta) {
                            if (full.indent) {
                                return `<span class="text-success fw-bold">${data}</span>`;
                            }

                            return data;
                        }
                    },
                    {
                        data: "offer.offer_no",
                        title: "Offer #",
                        render: function(data, type, full, meta) {
                            if (full.offer) {
                                return full.offer.offer_no;
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
                        data: "added_by.name",
                        title: "Added By",
                        render: function(data, type, full, meta) {
                            if (full.added_by) {
                                return full.added_by.name;
                            } else {
                                return '-';
                            }
                        }
                    },
                    {
                        data: "currency",
                        title: "currency",
                    }
                ],
                rowCallback: function(row, data) {},
            });
        });
    </script>
@endpush
