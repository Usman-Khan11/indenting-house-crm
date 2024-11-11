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
                        <a href="{{ route('supplier.create') }}" class="btn btn-primary">Add New Supplier</a>
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
                    url: "{{ route('supplier') }}",
                    type: "get",
                    data: function(d) {},
                },
                columns: [{
                        title: "Options",
                        class: "text-nowrap",
                        render: function(data, type, full, meta) {
                            let button = '';
                            button +=
                                `<a href="/supplier/view/${full.id}" class="btn btn-info btn-xs">View</a> `;
                            button +=
                                `<a href="/supplier/edit/${full.id}" class="btn btn-warning btn-xs">Edit</a> `;
                            button +=
                                `<a onclick="return checkDelete()" href="/supplier/delete/${full.id}" class="btn btn-danger btn-xs">Delete</a> `;

                            return button;
                        },
                    },
                    {
                        data: "id",
                        title: "ID",
                    },
                    {
                        data: "name",
                        title: "Name",
                    },
                    {
                        data: "origin",
                        title: "origin",
                    },
                    {
                        data: "email",
                        title: "email",
                    },
                    {
                        data: "phone",
                        title: "phone",
                    },
                    {
                        data: "person_3",
                        title: "Sourcing Person",
                    }
                ],
                rowCallback: function(row, data) {},
            });
        });
    </script>
@endpush
