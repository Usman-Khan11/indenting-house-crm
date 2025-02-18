<div class="row align-items-top border border-primary py-2 mb-3 product_row">
    {{-- <div class="col-md-1 mb-3 text-center">
        <button onclick="delProductRow(this)" type="button" class="btn btn-danger btn-sm"><i
                class="fa fa-trash"></i></button>
    </div> --}}

    <div class="col-md-8 mb-3">
        <label class="form-label">Item</label>
        <select name="product[]" class="form-select select2 product" required onchange="productData(this)">
            <option selected disabled value="">Select Item</option>
            @foreach ($products as $product)
                <option @if ($product_id == $product->id) selected @endif title="{{ $product->description }}"
                    value="{{ $product->id }}">{{ $product->id }} -- {{ $product->name }}</option>
            @endforeach
        </select>

        <div class="row align-items-center mt-2">
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
                <label class="form-label">Remarks</label>
                <textarea name="product_remark[]" class="form-control product_remark" rows="2">{{ $product_remark }}</textarea>
            </div>

            <div class="col-md-3">
                <label class="form-label">Sizes</label>
                <select name="product_size_id[]" class="form-select select2 product_size_id">
                    <option selected value="">Select value</option>
                    @foreach ($sizes as $key => $value)
                        <option @if ($product_size_id == $value->id) selected @endif value="{{ $value->id }}">
                            {{ $value->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Artworks</label>
                <select name="product_artwork_id[]" class="form-select select2 product_artwork_id">
                    <option selected value="">Select value</option>
                    @foreach ($artworks as $key => $value)
                        <option @if ($product_artwork_id == $value->id) selected @endif value="{{ $value->id }}">
                            {{ $value->artwork_no }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Item Code</label>
                <input type="text" name="product_code[]" value="{{ $product_code }}"
                    class="form-control product_code" readonly>
            </div>

            <div class="col-2 mb-0 text-end">
                <h5 class="mb-0 sno text-warning">S.No: &nbsp; <span>{{ $sno }}</span></h5>
            </div>

            <div class="col-1 mb-3 text-end">
                <button onclick="delProductRow(this)" type="button" class="btn btn-danger btn-sm"><i
                        class="fa fa-trash"></i></button>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <label class="form-label">Item Desc.</label>
        <textarea name="product_description[]" class="form-control product_description" rows="8" readonly>{{ $product_description }}</textarea>
    </div>
</div>
