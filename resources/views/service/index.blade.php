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
                    <a href="{{ route('service.create') }}" class="btn btn-primary">Add New Service</a>
                </div>
            </div>
            <hr />
        </div>
        <div class="card-body">
            <div class="responsive text-nowra">
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
                url: "{{ route('service') }}",
                type: "get",
                data: function(d) {},
            },
            columns: [{
                    data: "DT_RowIndex",
                    title: "S.No",
                },
                {
                    data: "name",
                    title: "Name",
                },
                {
                    data: "amount",
                    title: "Amount",
                },
                {
                    title: "Options",
                    class: "text-nowrap",
                    render: function(data, type, full, meta) {
                        let button = '';
                        button += `<a href="/service/edit/${full.id}" class="btn btn-warning btn-sm">Edit</a> `;
                        button += `<a onclick="return checkDelete()" href="/service/delete/${full.id}" class="btn btn-danger btn-sm">Delete</a> `;

                        return button;
                    },
                }
            ],
            rowCallback: function(row, data) {},
        });
    });
</script>
@endpush