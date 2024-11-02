<div class="row align-items-center border border-primary py-2 mb-3">
    <div class="col-md-1 mb-3 text-center">
        <button onclick="delProductRow(this)" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
    </div>

    <div class="col-md-5 mb-3">
        <label class="form-label">Item</label>
        <select name="product[]" class="form-select select2 product" required onchange="productData(this)">
            <option selected disabled value="">Select Item</option>
            @foreach($products as $product)
            <option @if($product_id==$product->id) selected @endif title="{{ $product->description }}" value="{{ $product->id }}">{{ $product->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-2 mb-3">
        <label class="form-label">Qty</label>
        <input type="number" onkeyup="calculation(this)" value="{{ $product_qty }}" name="product_qty[]" class="form-control product_qty" step="any" required>
    </div>

    <div class="col-md-2 mb-3">
        <label class="form-label">Unit</label>
        <input type="text" name="product_unit[]" value="{{ $product_unit }}" class="form-control product_unit">
    </div>

    <div class="col-md-2 mb-3">
        <label class="form-label">Rate</label>
        <input type="number" onkeyup="calculation(this)" value="{{ $product_rate }}" name="product_rate[]" class="form-control product_rate" step="any" required>
    </div>

    <div class="col-md-2 mb-3 d-none">
        <label class="form-label">Total</label>
        <input type="number" name="product_total[]" value="{{ $product_total }}" class="form-control product_total" step="any" readonly>
    </div>

    <div class="col-md-3 mb-3">
        <label class="form-label">Shipment Mode</label>
        <select name="product_shipment[]" class="form-select product_shipment">
            <option selected value="">Select value</option>
            @foreach(shippingMode() as $key => $value)
            <option @if($product_shipment==$key) selected @endif value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3 mb-3">
        <label class="form-label">Payment Term</label>
        <select name="product_payment_term[]" class="form-select product_payment_term">
            <option selected value="">Select value</option>
            @foreach(paymentTerms() as $key => $value)
            <option @if($product_payment_term==$key) selected @endif value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-2 d-none">
        <select name="product_po_id[]" class="form-select product_po_id">
            <option selected disabled value="">Select Purchase Order</option>
        </select>

        <input type="hidden" name="product_po_date[]" class="form-control product_po_date">
        <input type="hidden" name="product_lot_detail[]" class="form-control product_lot_detail">
        <input type="hidden" name="product_other_desc[]" class="form-control product_other_desc">
    </div>

</div>