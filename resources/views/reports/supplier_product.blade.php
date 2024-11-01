@extends('layout.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="card-title m-0">{{ $page_title }}</h4>
                </div>
            </div>
            <hr />
        </div>
        <div class="card-body">
            <div class="row justify-content-end">
                <div class="col-md-4">
                    <select class="select2" id="suppliers">
                        <option value="all" selected>All Suppliers</option>
                        @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>
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
            searching: false,
            serverSide: true,
            lengthChange: true,
            ordering: false,
            paging: false,
            pageLength: '{{ general()->page_length }}',
            scrollX: true,
            ajax: {
                url: "{{ route('report.supplier_product') }}",
                type: "get",
                data: function(d) {
                    d.product_id = $("#products").val();
                    d.supplier_id = $("#suppliers").val();
                },
            },
            columns: [{
                    data: "DT_RowIndex",
                    title: "S.No",
                },
                {
                    title: "Name",
                    render: function(data, type, full, meta) {
                        if (full.supplier) {
                            return full.supplier.name;
                        } else {
                            return '-';
                        }
                    }
                },
                {
                    title: "Origin",
                    render: function(data, type, full, meta) {
                        if (full.supplier) {
                            return full.supplier.origin;
                        } else {
                            return '-';
                        }
                    }
                },
                {
                    title: "Contact Person",
                    render: function(data, type, full, meta) {
                        if (full.supplier) {
                            return full.supplier.person;
                        } else {
                            return '-';
                        }
                    }
                },
                {
                    title: "Item",
                    render: function(data, type, full, meta) {
                        if (full.product) {
                            return full.product.name;
                        } else {
                            return '-';
                        }
                    }
                },
                {
                    title: "Item Description",
                    render: function(data, type, full, meta) {
                        if (full.product) {
                            return full.product.description;
                        } else {
                            return '-';
                        }
                    }
                },
                {
                    title: "HS Code",
                    render: function(data, type, full, meta) {
                        if (full.product) {
                            return full.product.hs_code;
                        } else {
                            return '-';
                        }
                    }
                },
                {
                    title: "Unit",
                    render: function(data, type, full, meta) {
                        if (full.product) {
                            return full.product.unit;
                        } else {
                            return '-';
                        }
                    }
                },
                {
                    title: "Type",
                    render: function(data, type, full, meta) {
                        if (full.product) {
                            return full.product.type;
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
                    title: 'Item Wise Supplier List',
                    className: "btn btn-success",
                },
                {
                    extend: 'pdfHtml5',
                    text: 'Export PDF',
                    title: 'Item Wise Supplier List',
                    className: "btn btn-success",
                },
                {
                    extend: 'print',
                    text: 'Print Table',
                    title: 'Item Wise Supplier List',
                    className: "btn btn-success",
                }
            ]
        });

        $("#products, #suppliers").change(function() {
            datatable.ajax.reload();
        })
    });
</script>
@endpush