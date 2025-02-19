<div class="modal fade" id="search_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Search</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Card No</span>
                            <input type="text" class="form-control card_no" name="card_no">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Item Code</span>
                            <input type="text" class="form-control item_code" name="item_code">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Product</span>
                            <input type="text" class="form-control product" name="product">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Width</span>
                            <input type="text" class="form-control width" name="width">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="order_by" id="order_by1"
                                value="code">
                            <label class="form-check-label" for="order_by1">
                                Order By Code
                            </label>
                        </div>
                        <br />
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="order_by" id="order_by2"
                                value="desc">
                            <label class="form-check-label" for="order_by2">
                                Order By Desc
                            </label>
                        </div>

                        <button type="button" id="search_now" class="btn btn-primary btn-sm mt-3">Search</button>
                    </div>
                </div>
                <div class="result mt-2"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        document.addEventListener('keydown', function(event) {
            if (event.key === 'F1') {
                event.preventDefault();
                if ($("#search_modal").is(":visible")) {
                    $("#search_modal").modal("hide");
                } else {
                    $("#search_modal").modal("show");
                }
            }
        });

        $("#search_now").click(function() {
            $(".loader").show();
            let card_no = $("#search_modal").find(".card_no").val();
            let item_code = $("#search_modal").find(".item_code").val();
            let product = $("#search_modal").find(".product").val();
            let width = $("#search_modal").find(".width").val();
            let order_by = $("#search_modal").find('input[name="order_by"]:checked').val();

            $.get("{{ route('proforma_invoice.search') }}", {
                _token: '{{ csrf_token() }}',
                card_no,
                item_code,
                product,
                order_by,
                width,
            }, function(res) {
                $("#search_modal .result").html(res);
                $(".loader").hide();
            })
        })

        function search_selection(e, card_id) {
            $(".loader").show();

            $.get("{{ route('proforma_invoice') }}", {
                _token: '{{ csrf_token() }}',
                search_card_id: card_id,
                type: 'search_card_id'
            }, function(res) {
                if (res.length) {
                    let items = res;

                    if ($('select.product, select.product_size_id, select.product_artwork_id').hasClass(
                            'select2-hidden-accessible')) {
                        $('select.product, select.product_size_id, select.product_artwork_id').select2('destroy');
                    }

                    $(items).each(function(key, value) {
                        let $newRow = $("#product_table .row:first").clone();

                        $newRow.find('.product').val(value.item_id).trigger('change');
                        $newRow.find('.product_size_id').val(value.size_id).trigger('change');
                        $newRow.find('.product_artwork_id').val(value.artwork.id).trigger('change');

                        $("#product_table").append($newRow);
                    });

                    $("#product_table select.product").each(function(key, value) {
                        let v = $(value).val();
                        if (!v) {
                            $(value).closest(".product_row").remove();
                        }
                    })

                    $('select.product, select.product_size_id, select.product_artwork_id').select2();
                    notify('success', 'Product added successfully.');
                } else {
                    notify('success', 'Product not found.');
                }

                $(".loader").hide();
            })
        }
    </script>
@endpush
