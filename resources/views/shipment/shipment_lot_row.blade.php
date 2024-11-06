<div class="row">
    <div class="col-md-2 col-12">
        <div class="mb-3">
            <label class="form-label">Shipment Lot No</label>
            <select name="lot_no[]" class="form-select" required>
                <option value="" selected disabled>Select Shipment Lot</option>
                @foreach (shipmentLotDetails() as $key => $value)
                    <option @if($key == $lot_no) selected @endif value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-2 col-12">
        <div class="mb-3">
            <label class="form-label">Invoice No</label>
            <input type="text" name="inv_no[]" value="{{ $inv_no }}" class="form-control" placeholder="Invoice No" />
        </div>
    </div>

    <div class="col-md-2 col-12">
        <div class="mb-3">
            <label class="form-label">Invoice Date</label>
            <input type="date" name="inv_date[]" value="{{ $inv_date }}" class="form-control" placeholder="Invoice Date" />
        </div>
    </div>

    <div class="col-md-2 col-12">
        <div class="mb-3">
            <label class="form-label">BL No</label>
            <input type="text" name="bl_no[]" value="{{ $bl_no }}" class="form-control" placeholder="BL No" />
        </div>
    </div>

    <div class="col-md-2 col-12">
        <div class="mb-3">
            <label class="form-label">BL Date</label>
            <input type="date" name="bl_date[]" value="{{ $bl_date }}" class="form-control" placeholder="BL Date" />
        </div>
    </div>

    <div class="col-md-2 col-12">
        <div class="mb-3">
            <label class="form-label">Payment Remarks</label>
            <select name="payment_remark[]" class="form-select">
                @foreach (paymentRemarks() as $key => $value)
                    <option @if($key == $payment_remark) selected @endif value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>