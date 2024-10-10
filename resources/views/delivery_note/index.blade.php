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
                    <a href="{{ route('delivery_note.create') }}" class="btn btn-primary">Add New Delivery Note</a>
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
                url: "{{ route('delivery_note') }}",
                type: "get",
                data: function(d) {},
            },
            columns: [{
                    data: "DT_RowIndex",
                    title: "S.No",
                },
                {
                    data: "text",
                    title: "Delivery Note",
                    render: function(data, type, full, meta) {
                        return decodeHtmlEntities(data);
                    }
                },
                {
                    data: "for_type",
                    title: "Type",
                    render: function(data, type, full, meta) {
                        if (data == "Invoice") {
                            return `<span class="badge bg-success">Invoice<span>`;
                        } else if (data == "Quotation") {
                            return `<span class="badge bg-info">Quotation<span>`;
                        } else {
                            return '-';
                        }
                    }
                },
                {
                    title: "Options",
                    class: "text-nowrap",
                    render: function(data, type, full, meta) {
                        let button = '';
                        button += `<a href="/delivery-note/edit/${full.id}" class="btn btn-warning btn-sm">Edit</a> `;
                        button += `<a onclick="return checkDelete()" href="/delivery-note/delete/${full.id}" class="btn btn-danger btn-sm">Delete</a> `;

                        return button;
                    },
                }
            ],
            rowCallback: function(row, data) {},
        });
    });
</script>
@endpush