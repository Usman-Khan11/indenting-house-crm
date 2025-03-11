@extends('layout.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <form method="post" action="{{ route('po.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h4 class="fw-bold">{{ $page_title }}</h4>
                    <hr />
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 col-12">
                            <div class="mb-3">
                                <label class="form-label">PO #</label>
                                <input type="text" name="po_no" value="PO-{{ $po_no }}" class="form-control"
                                    readonly />
                            </div>
                        </div>

                        <div class="col-md-2 col-12">
                            <div class="mb-3">
                                <label class="form-label">Date</label>
                                <input type="date" required name="date" value="{{ old('date', date('Y-m-d')) }}"
                                    class="form-control" placeholder="Date" />
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Offers</label>
                                <select class="select2 form-select" name="offer_id" required onchange="getOfferData(this)">
                                    <option selected disabled value="">Select Offer</option>
                                    @foreach ($offers as $offer)
                                        <option @if (old('offer_id') == $offer->id) selected @endif
                                            value="{{ $offer->id }}">{{ $offer->offer_no }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2 col-12">
                            <div class="mb-3">
                                <label class="form-label">Currency</label>
                                <select class="select2 form-select currency" name="currency">
                                    @foreach (currency() as $key => $value)
                                        <option @if (old('currency') == $key) selected @endif
                                            value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Customers</label>
                                <select class="select2 form-select customer_id" name="customer_id" required>
                                    <option selected disabled value="">Select Customer</option>
                                    @foreach ($customers as $customer)
                                        <option @if (old('customer_id') == $customer->id) selected @endif
                                            data-sales_person="{{ $customer->sales_person }}" value="{{ $customer->id }}">
                                            {{ $customer->id }} -- {{ $customer->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Suppliers</label>
                                <select class="select2 form-select supplier_id" name="supplier_id" required>
                                    <option selected disabled value="">Select Supplier</option>
                                    @foreach ($suppliers as $supplier)
                                        <option @if (old('supplier_id') == $supplier->id) selected @endif
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
                                <textarea name="remark" class="form-control remark" placeholder="Remarks">{{ old('remark') }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Sales Person</label>
                                <select class="select2 form-select sales_person" name="sales_person">
                                    <option selected value="">Select Sales Person</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="mb-3">
                                <label class="form-label">Sourcing Person</label>
                                <select class="select2 form-select sourcing_person" name="sourcing_person">
                                    <option selected value="">Select Sourcing Person</option>
                                </select>
                            </div>
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
                                    $p = old('product', []);
                                @endphp

                                @forelse ($p as $k => $v)
                                    @include('po.product_row', [
                                        'sno' => $k + 1,
                                        'product_id' => $v,
                                        'product_description' => old('product_description')[$k] ?? '',
                                        'product_qty' => old('product_qty')[$k] ?? '',
                                        'product_unit' => old('product_unit')[$k] ?? '',
                                        'product_rate' => old('product_rate')[$k] ?? '',
                                        'product_total' => old('product_total')[$k] ?? '',
                                        'product_shipping_type' => old('product_shipping_type')[$k] ?? '',
                                        'products' => $products,
                                    ])
                                @empty
                                    @include('po.product_row', [
                                        'sno' => 1,
                                        'product_id' => '',
                                        'product_description' => '',
                                        'product_qty' => '',
                                        'product_unit' => '',
                                        'product_rate' => '',
                                        'product_total' => '',
                                        'product_shipping_type' => '',
                                        'products' => $products,
                                    ])
                                @endforelse
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
@endsection
