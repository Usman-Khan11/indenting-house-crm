<div class="row align-items-center border border-primary py-2 mb-3">
    <div class="col-md-1 mb-3 text-center">
        <button onclick="delProductRow(this)" type="button" class="btn btn-danger btn-sm"><i
                class="fa fa-trash"></i></button>
    </div>

    <div class="col-md-5 mb-3">
        <label class="form-label">Item</label>
        <select name="product[]" class="form-select select2 product" required onchange="productData(this)">
            <option selected disabled value="">Select Item</option>
            @foreach ($products as $product)
                <option @if ($product_id == $product->id) selected @endif title="{{ $product->description }}"
                    value="{{ $product->id }}">{{ $product->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-2 mb-3">
        <label class="form-label">Qty</label>
        <input type="number" onkeyup="calculation(this)" value="{{ $product_qty }}" name="product_qty[]"
            class="form-control product_qty" step="any" required>
    </div>

    <div class="col-md-2 mb-3">
        <label class="form-label">Unit</label>
        <input type="text" name="product_unit[]" value="{{ $product_unit }}" class="form-control product_unit">
    </div>

    <div class="col-md-2 mb-3">
        <label class="form-label">Rate</label>
        <input type="number" onkeyup="calculation(this)" value="{{ $product_rate }}" name="product_rate[]"
            class="form-control product_rate" step="any" required>
    </div>

    <div class="col-md-2 mb-3 d-none">
        <label class="form-label">Total</label>
        <input type="number" name="product_total[]" value="{{ $product_total }}" class="form-control product_total"
            step="any" readonly>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Sizes</label>
        <select name="product_size_id[]" class="form-select select2 product_size_id">
            <option selected value="">Select value</option>
            @foreach ($sizes as $key => $value)
                <option @if ($product_size_id == $value->id) selected @endif value="{{ $value->id }}">
                    {{ $value->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Artworks</label>
        <select name="product_artwork_id[]" class="form-select select2 product_artwork_id">
            <option selected value="">Select value</option>
            @foreach ($artworks as $key => $value)
                <option @if ($product_artwork_id == $value->id) selected @endif value="{{ $value->id }}">
                    {{ $value->artwork_no }}</option>
            @endforeach
        </select>
    </div>
</div>
