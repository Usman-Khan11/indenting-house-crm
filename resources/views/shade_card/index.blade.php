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
                        <a href="{{ route('shade_card.create') }}" class="btn btn-primary">Add New Shade Card</a>
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
                    url: "{{ route('shade_card') }}",
                    type: "get",
                    data: function(d) {},
                },
                columns: [{
                        title: "Options",
                        class: "text-nowrap",
                        render: function(data, type, full, meta) {
                            let button = '';
                            // button +=
                            //     `<a href="/shade-card/view/${full.id}" class="btn btn-info btn-xs">View</a> `;
                            button +=
                                `<a href="/shade-card/edit/${full.id}" class="btn btn-warning btn-xs">Edit</a> `;
                            button +=
                                `<a onclick="return checkDelete()" href="/shade-card/delete/${full.id}" class="btn btn-danger btn-xs">Delete</a> `;

                            return button;
                        },
                    },
                    {
                        data: "card_no",
                        title: "Card #",
                    },
                    {
                        title: "artwork #",
                        "render": function(data, type, full, meta) {
                            if (full.artwork) {
                                return full.artwork.artwork_no;
                            } else {
                                return '-';
                            }
                        }
                    },
                    {
                        title: 'Date',
                        "render": function(data, type, full, meta) {
                            return getDate(full.date);
                        }
                    },
                    {
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
                        title: "Product",
                        render: function(data, type, full, meta) {
                            if (full.item) {
                                return full.item.name;
                            } else {
                                return '-';
                            }
                        }
                    },
                    {
                        title: "Size",
                        render: function(data, type, full, meta) {
                            if (full.size) {
                                return full.size.name;
                            } else {
                                return '-';
                            }
                        }
                    },
                ],
                rowCallback: function(row, data) {},
            });
        });
    </script>
@endpush
