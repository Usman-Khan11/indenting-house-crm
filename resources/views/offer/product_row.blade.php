<div class="row border border-primary py-2 mb-3 product_row">
    <div class="col-md-4">
        <label class="form-label">Item</label>
        <select name="product[]" class="form-select select2 product" required onchange="productData(this)">
            <option selected disabled value="">Select Item</option>
            @foreach ($products as $product)
                <option @if ($product_id == $product->id) selected @endif title="{{ $product->description }}"
                    value="{{ $product->id }}">{{ $product->id }} -- {{ $product->name }}</option>
            @endforeach
        </select>

        <textarea name="product_description[]" class="form-control mt-2 product_description" rows="5"
            placeholder="Description">{{ $product_description }}</textarea>
    </div>

    <div class="col-md-8">
        <div class="row justify-content-end">
            <div class="col-md-3 mb-3">
                <label class="form-label">Qty</label>
                <input type="number" onkeyup="calculation(this)" value="{{ $product_qty }}" name="product_qty[]"
                    class="form-control product_qty" step="any" required>
            </div>

            <div class="col-md-2 mb-3">
                <label class="form-label">Unit</label>
                <input type="text" name="product_unit[]" value="{{ $product_unit }}"
                    class="form-control product_unit">
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">Rate</label>
                <input type="number" onkeyup="calculation(this)" value="{{ $product_rate }}" name="product_rate[]"
                    class="form-control product_rate" step="any" required>
            </div>

            <div class="col-md-2 mb-3 d-none">
                <label class="form-label">Total</label>
                <input type="number" name="product_total[]" value="{{ $product_total }}"
                    class="form-control product_total" step="any" readonly>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Supplier/Mfg</label>
                <select name="product_supplier[]" class="form-select select2 product_supplier" required>
                    <option selected disabled value="">Select value</option>
                    @foreach ($suppliers as $supplier)
                        <option @if ($product_supplier == $supplier->id) selected @endif value="{{ $supplier->id }}">
                            {{ $supplier->id }} -- {{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">Shipping Type</label>
                <select name="product_shipping_type[]" class="form-select product_shipping_type">
                    <option selected value="">Select value</option>
                    @foreach (shippingType() as $key => $value)
                        <option @if ($product_shipping_type == $key) selected @endif value="{{ $key }}">
                            {{ $value }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">Shipment Mode</label>
                <select name="product_shipment[]" class="form-select product_shipment">
                    <option selected value="">Select value</option>
                    @foreach (shippingMode() as $key => $value)
                        <option @if ($product_shipment == $key) selected @endif value="{{ $key }}">
                            {{ $value }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">Payment Term</label>
                <select name="product_payment_term[]" class="form-select product_payment_term">
                    <option selected value="">Select value</option>
                    @foreach (paymentTerms() as $key => $value)
                        <option @if ($product_payment_term == $key) selected @endif value="{{ $key }}">
                            {{ $value }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">Delivery</label>
                <input type="text" name="product_delivery[]" value="{{ $product_delivery }}"
                    class="form-control product_delivery">
            </div>

            <div class="col-md-2 mb-0 text-center">
                <h5 class="mb-0 sno text-warning">S.No: &nbsp; <span>{{ $sno }}</span></h5>
            </div>

            <div class="col-md-1 mb-3 text-center">
                <button onclick="delProductRow(this)" type="button" class="btn btn-danger btn-sm"><i
                        class="fa fa-trash"></i></button>
            </div>
        </div>
    </div>
</div>
