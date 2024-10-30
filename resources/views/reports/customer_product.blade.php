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
            <div class="row justify-content-end">
                <div class="col-md-4">
                    <select class="select2" id="products">
                        <option value="all" selected>All Items</option>
                        @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
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
            paging: false,
            pageLength: '{{ general()->page_length }}',
            scrollX: true,
            ajax: {
                url: "{{ route('report.customer_product') }}",
                type: "get",
                data: function(d) {
                    d.product_id = $("#products").val();
                },
            },
            columns: [{
                    title: "Cus ID",
                    render: function(data, type, full, meta) {
                        if (full.customer) {
                            return full.customer.id;
                        } else {
                            return '-';
                        }
                    }
                },
                {
                    title: "Name",
                    render: function(data, type, full, meta) {
                        if (full.customer) {
                            return full.customer.name;
                        } else {
                            return '-';
                        }
                    }
                },
                {
                    title: "Contact Person",
                    render: function(data, type, full, meta) {
                        if (full.customer) {
                            return full.customer.person;
                        } else {
                            return '-';
                        }
                    }
                },
                {
                    title: "Address",
                    render: function(data, type, full, meta) {
                        if (full.customer) {
                            return full.customer.address_office;
                        } else {
                            return '-';
                        }
                    }
                },
                {
                    title: "Phone",
                    render: function(data, type, full, meta) {
                        if (full.customer) {
                            return full.customer.phone_1;
                        } else {
                            return '-';
                        }
                    }
                },
                {
                    title: "Fax",
                    render: function(data, type, full, meta) {
                        if (full.customer) {
                            return full.customer.fax_number;
                        } else {
                            return '-';
                        }
                    }
                },
                {
                    title: "Email",
                    render: function(data, type, full, meta) {
                        if (full.customer) {
                            return full.customer.email;
                        } else {
                            return '-';
                        }
                    }
                }
            ],
            rowCallback: function(row, data) {},
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'excelHtml5',
                    text: 'Export Excel',
                    title: 'Item Wise Customer List',
                    className: "btn btn-success",
                },
                {
                    extend: 'pdfHtml5',
                    text: 'Export PDF',
                    title: 'Item Wise Customer List',
                    className: "btn btn-success",
                },
                {
                    extend: 'print',
                    text: 'Print Table',
                    title: 'Item Wise Customer List',
                    className: "btn btn-success",
                }
            ]
        });

        $("#products").change(function() {
            datatable.ajax.reload();
        })
    });
</script>
@endpush