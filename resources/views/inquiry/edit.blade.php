@extends('layout.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <form method="post" action="{{ route('inquiry.update') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $inquiry->id }}">

            <div class="card">
                <div class="card-header">
                    <h4 class="fw-bold">{{ $page_title }}</h4>
                    <hr />
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 col-12">
                            <div class="mb-3">
                                <label class="form-label">Inquiry #</label>
                                <input type="text" name="inq_no" value="{{ $inquiry->inq_no }}" class="form-control"
                                    readonly />
                            </div>
                        </div>

                        <div class="col-md-3 col-12">
                            <div class="mb-3">
                                <label class="form-label">Date</label>
                                <input type="date" name="date" value="{{ old('date', $inquiry->date) }}"
                                    class="form-control date" placeholder="Date" onchange="inquiryDates()" />
                            </div>
                        </div>

                        <div class="col-md-3 col-12">
                            <div class="mb-3">
                                <label class="form-label">Validity</label>
                                <input type="date" name="validity" value="{{ old('validity', $inquiry->validity) }}"
                                    class="form-control validity" placeholder="Validity" />
                            </div>
                        </div>

                        <div class="col-md-3 col-12">
                            <div class="mb-3">
                                <label class="form-label">Currency</label>
                                <select class="select2 form-select" name="currency">
                                    @foreach (currency() as $key => $value)
                                        <option @if (old('currency', $inquiry->currency) == $key) selected @endif
                                            value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Customer</label>
                                <select class="select2 form-select customer_id" name="customer_id" required>
                                    <option selected disabled value="">Select Customer</option>
                                    @foreach ($customers as $customer)
                                        <option @if (old('customer_id', $inquiry->customer_id) == $customer->id) selected @endif
                                            data-sales_person="{{ $customer->sales_person }}" value="{{ $customer->id }}">
                                            {{ $customer->id }} -- {{ $customer->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Supplier</label>
                                <select class="select2 form-select supplier_id" name="supplier_id" required
                                    onchange="getSupplierProducts(this)">
                                    <option selected disabled value="">Select Supplier</option>
                                    @foreach ($suppliers as $supplier)
                                        <option @if (old('supplier_id', $inquiry->supplier_id) == $supplier->id) selected @endif
                                            data-sourcing_person="{{ $supplier->sourcing_person }}"
                                            value="{{ $supplier->id }}">{{ $supplier->id }} -- {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Remarks</label>
                                <textarea name="remark" class="form-control" placeholder="Remarks">{{ old('remark', $inquiry->remark) }}</textarea>
                            </div>
                        </div>

                        @php
                            $sales_person = array_map('trim', explode('|', $inquiry->customer->sales_person));
                            $sourcing_person = array_map('trim', explode('|', $inquiry->supplier->sourcing_person));
                        @endphp

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Sales Person</label>
                                <select class="select2 form-select sales_person" name="sales_person">
                                    <option selected value="">Select Sales Person</option>
                                    @foreach ($sales_person as $v)
                                        <option @if (old('sales_person', $inquiry->sales_person) == $v) selected @endif
                                            value="{{ $v }}">{{ $v }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Sourcing Person</label>
                                <select class="select2 form-select sourcing_person" name="sourcing_person">
                                    <option selected value="">Select Sourcing Person</option>
                                    @foreach ($sourcing_person as $v)
                                        <option @if (old('sourcing_person', $inquiry->sourcing_person) == $v) selected @endif
                                            value="{{ $v }}">{{ $v }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Remarks 2</label>
                                <textarea name="remark_2" class="form-control" placeholder="Remarks 2">{{ old('remark_2', $inquiry->remark_2) }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Signature</label>
                                <input type="text" name="signature" value="{{ old('signature', $inquiry->signature) }}"
                                    class="form-control" placeholder="Signature" />
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            {{-- <a href="/email/inquiry/{{ $inquiry->id }}" class="btn btn-primary mt-3">Send Email to
                                Supplier</a> --}}
                            <button type="button" class="btn btn-primary mt-3 supplier_email_btn">
                                Send Email to Suppliers
                            </button>
                        </div>

                        <!-- Product Repeater -->
                        <div class="col-12">
                            <h4>
                                Items: &nbsp;
                                <button onclick="addProductRow(this)" type="button" class="btn btn-info btn-sm"><i
                                        class="fa fa-plus"></i></button>
                            </h4>
                            <div id="product_table">
                                @php
                                    $p = old('product', $inquiry->items);
                                @endphp

                                @forelse ($p as $k => $v)
                                    @include('inquiry.product_row', [
                                        'sno' => $k + 1,
                                        'product_id' => old('product_id')[$k] ?? ($v->item_id ?? ''),
                                        'product_description' =>
                                            old('product_description')[$k] ?? ($v->item_desc ?? ''),
                                        'product_qty' => old('product_qty')[$k] ?? ($v->qty ?? ''),
                                        'product_unit' => old('product_unit')[$k] ?? ($v->unit ?? ''),
                                        'product_rate' => old('product_rate')[$k] ?? ($v->rate ?? ''),
                                        'product_total' => old('product_total')[$k] ?? ($v->total ?? ''),
                                        'product_shipping_type' =>
                                            old('product_shipping_type')[$k] ?? ($v->shipping_type ?? ''),
                                        'product_shipment' =>
                                            old('product_shipment')[$k] ?? ($v->shipment_mode ?? ''),
                                        'product_payment_term' =>
                                            old('product_payment_term')[$k] ?? ($v->payment_term ?? ''),
                                        'product_delivery' => old('product_delivery')[$k] ?? ($v->delivery ?? ''),
                                        'product_supplier' =>
                                            old('product_supplier')[$k] ?? ($v->supplier_id ?? ''),
                                        'suppliers' => $suppliers,
                                        'products' => $products,
                                    ])
                                @empty
                                    @include('inquiry.product_row', [
                                        'sno' => 1,
                                        'product_id' => '',
                                        'product_description' => '',
                                        'product_qty' => '',
                                        'product_unit' => '',
                                        'product_rate' => '',
                                        'product_total' => '',
                                        'product_shipping_type' => '',
                                        'product_shipment' => '',
                                        'product_payment_term' => '',
                                        'product_delivery' => '',
                                        'product_supplier' => '',
                                        'suppliers' => $suppliers,
                                        'products' => $products,
                                    ])
                                @endforelse
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-check mb-3">
                                <input class="form-check-input" @if ($inquiry->is_close) checked @endif
                                    type="checkbox" value="1" id="is_close" name="is_close">
                                <label class="form-check-label" for="is_close">
                                    Inquiry Close
                                </label>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Reason of Close</label>
                                <textarea name="reason_of_close" class="form-control" placeholder="Reason of Close">{{ old('reason_of_close', $inquiry->reason_of_close) }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-12 col-12 mt-3">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @include('inquiry.partials.suppliers_modal')
@endsection

@push('script')
    <script>
        $(".supplier_email_btn").click(function() {
            $(".loader").show();
            $("#supplier_mail_modal .modal-body table tbody").html(null);

            let product_ids = $("select.product").map(function() {
                return $(this).val();
            }).get();

            if (product_ids.length) {
                $.get("{{ route('inquiry') }}", {
                    type: 'get_suppliers',
                    product_ids
                }, function(res) {
                    $(res).each(function(i, v) {
                        $("#supplier_mail_modal .modal-body table tbody").append(`
                            <tr>
                                <td>
                                    <input type="checkbox" class="form-check-input" name="supplier[]" id="sup_${i}" value="${v.supplier_id}">
                                </td>
                                <td>
                                    <label class="cursor-pointer" for="sup_${i}">${v.supplier_id} -- ${v.supplier.name}</label>
                                </td>
                            </tr>
                        `);
                        $("input[name=inquiry_id]").val("{{ $inquiry->id }}");
                        $("#supplier_mail_modal").modal("show");
                    });
                    $(".loader").hide();
                });
            } else {
                $(".loader").hide();
            }
        });
    </script>
@endpush
