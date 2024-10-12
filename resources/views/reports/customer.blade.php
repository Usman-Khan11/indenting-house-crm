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
            <div class="responsive">
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
                    data: "person",
                    title: "Contact Person",
                },
                {
                    data: "address_office",
                    title: "Address",
                },
                {
                    data: "phone_1",
                    title: "Phone",
                },
                {
                    data: "fax_number",
                    title: "Fax",
                },
                {
                    data: "email",
                    title: "Email",
                }
            ],
            rowCallback: function(row, data) {},
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'excelHtml5',
                    text: 'Export Excel',
                    title: 'Customer List',
                    className: "btn btn-success",
                },
                {
                    extend: 'pdfHtml5',
                    text: 'Export PDF',
                    title: 'Customer List',
                    className: "btn btn-success",
                },
                {
                    extend: 'print',
                    text: 'Print Table',
                    title: 'Customer List',
                    className: "btn btn-success",
                }
            ]
        });
    });
</script>
@endpush