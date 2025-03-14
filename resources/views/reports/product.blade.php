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
                scrollCollapse: true,
                ajax: {
                    url: "{{ route('report.product') }}",
                    type: "get",
                    data: function(d) {},
                },
                columns: [{
                        data: "id",
                        title: "ID",
                    },
                    {
                        data: "name",
                        title: "Name",
                    },
                    {
                        data: "description",
                        title: "description",
                        class: "text-wrap",
                    },
                    {
                        data: "code",
                        title: "Code",
                    },
                    {
                        data: "hs_code",
                        title: "HS Code",
                    },
                    {
                        data: "unit",
                        title: "Unit",
                    },
                    {
                        data: "type",
                        title: "Type",
                    },
                    {
                        data: "scode",
                        title: "S Code",
                    },
                    {
                        data: "pup",
                        title: "pup",
                    }
                ],
                rowCallback: function(row, data) {},
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excelHtml5',
                        text: 'Export Excel',
                        title: 'Materials List',
                        className: "btn-warning",
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'Export PDF',
                        title: 'Materials List',
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
                        title: 'Materials List',
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
                ]
            });
        });
    </script>
@endpush
