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
            var datatable = $("#my_table").DataTable({
                select: {
                    style: "api",
                },
                processing: true,
                searching: true,
                serverSide: true,
                lengthChange: true,
                ordering: false,
                paging: false,
                pageLength: '{{ general()->page_length }}',
                scrollX: true,
                ajax: {
                    url: "{{ route('report.customer') }}",
                    type: "get",
                    data: function(d) {},
                },
                columns: [{
                        data: "id",
                        title: "Cus ID",
                    },
                    {
                        data: "name",
                        title: "Name",
                    },
                    {
                        data: "location",
                        title: "Location",
                    },
                    {
                        data: "fax_number",
                        title: "Fax Number",
                    },
                    {
                        data: "email",
                        title: "Email",
                    },
                    {
                        data: "person",
                        title: "Contact Person",
                    },
                    {
                        data: "email_2",
                        title: "Email 2",
                    },
                    {
                        data: "person_2",
                        title: "Contact Person 2",
                    },
                    {
                        data: "email_3",
                        title: "Sale Person Email",
                    },
                    {
                        data: "person_3",
                        title: "Sale Person",
                    },
                    {
                        data: "address_office",
                        title: "Address",
                        class: "text-wrap",
                    },
                    {
                        data: "address_factory",
                        title: "Address Factory",
                        class: "text-wrap",
                    },
                    {
                        data: "cell_1",
                        title: "Cell 1",
                    },
                    {
                        data: "cell_2",
                        title: "Cell 2",
                    },
                    {
                        data: "cell_3",
                        title: "Cell 3",
                    },
                    {
                        data: "phone_1",
                        title: "Phone 1",
                    },
                    {
                        data: "phone_2",
                        title: "Phone 2",
                    },
                    {
                        data: "status",
                        title: "Status",
                    }
                ],
                rowCallback: function(row, data) {},
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excelHtml5',
                        text: 'Export Excel',
                        title: 'Customer List',
                        className: "btn-warning",
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'Export PDF',
                        title: 'Customer List',
                        className: "btn-warning",
                        orientation: 'landscape',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        text: 'Print Table',
                        title: 'Customer List',
                        className: "btn-warning",
                        orientation: 'landscape',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'colvis',
                        text: 'Column Visibility',
                        className: "btn-warning",
                    }
                ],
                columnDefs: [{
                    targets: [2, 3, 4, 6, 7, 8, 11, 12, 13, 14, 16],
                    visible: false
                }]
            });
        });
    </script>
@endpush
