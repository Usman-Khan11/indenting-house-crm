<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('assets') }}/" data-template="vertical-menu-template-starter">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page_title }} - {{ general()->sitename }}</title>
    <meta name="description" content="" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-advance.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/spinkit/spinkit.css') }}" />
    <!-- <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-invoice-print.css') }}" /> -->

    <script src="{{ asset('assets/vendor/js/helpers.js') }}">
    </script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
    @stack('style')
    <style>
        .loader {
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 9999;
            background-color: rgba(255, 255, 255, 0.65);
            display: none;
        }

        .loader .inner {
            width: 100%;
            height: 100%;
            display: grid;
            place-items: center;
            transform: scale(1.5);
        }
    </style>
</head>

<body>

    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @include('partials.sidenav')
            <div class="layout-page">
                @include('partials.topnav')
                <div class="content-wrapper">
                    @yield('content')
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
        <div class="drag-target"></div>
    </div>

    <div class="loader">
        <div class="inner">
            <div class="sk-wave sk-primary">
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
                <div class="sk-wave-rect"></div>
            </div>
        </div>
    </div>


    <script>
        function checkDelete() {
            return confirm('Are you sure?');
        }
    </script>
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.9.2/ckeditor.js" integrity="sha512-OF6VwfoBrM/wE3gt0I/lTh1ElROdq3etwAquhEm2YI45Um4ird+0ZFX1IwuBDBRufdXBuYoBb0mqXrmUA2VnOA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @stack('script')
    @include('partials.notify')

    <script>
        $(document).ready(function() {
            if ($(".editor").length) {
                CKEDITOR.replaceAll('editor');
            }

            //$(".loader").hide();
        })

        function decodeHtmlEntities(str) {
            let txt = document.createElement('textarea');
            txt.innerHTML = str;
            return txt.value;
        }

        function getDate(date, full = false) {
            if (!date) {
                return '-';
            }

            date = new Date(date);
            let options = {
                month: 'short',
                day: '2-digit',
                year: 'numeric',
            };

            if (full) {
                options = {
                    ...options,
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: true
                };
            }

            let formattedDateTime = date.toLocaleString('en-US', options);

            return formattedDateTime;
        }

        function productData(e) {
            let id = $(e).val();
            $(".loader").show();

            if (id) {
                $.get("{{ route('product.get') }}", {
                    _token: '{{ csrf_token() }}',
                    id,
                }, function(res) {
                    if (res) {
                        $(e).parent().parent().find(".product_unit").val(res.unit);
                        $(e).parent().find("p").remove();
                        $(e).parent().append(`<p class="m-0 p-0 mt-2">${res.description}</p>`);
                    }

                    $(".loader").hide();
                })
            } else {
                $(e).parent().find("p").remove();
                $(".loader").hide();
            }
        }

        function addProductRow(e) {
            $("#product_table tbody tr:last").clone().appendTo("#product_table tbody");
            $("#product_table tbody tr:last").find("input").val(null).prop("disabled", false);
            $("#product_table tbody tr:last").find("select").val(null).trigger('change').prop("disabled", false);
        }

        function delProductRow(e) {
            if ($("#product_table tbody tr").length > 1) {
                $(e).parent().parent().remove();
            }
        }

        function calculation(e) {
            let qty = parseFloat($(e).parent().parent().find('.product_qty').val());
            let rate = parseFloat($(e).parent().parent().find('.product_rate').val());
            let t = qty * rate;
            $(e).parent().parent().find('.product_total').val(t)
        }

        function getInquiryData(e) {
            let inqId = $(e).val();
            $(".loader").show();

            $.get("{{ route('offer') }}", {
                _token: '{{ csrf_token() }}',
                inqId,
                type: 'getInquiryData'
            }, function(res) {
                $(".customer_id").val(res.customer_id).trigger("change");
                $(".customer_id").prop("disabled", true);
                $(".supplier_id").val(res.supplier_id).trigger("change");
                $(".supplier_id").prop("disabled", true);
                $(".validity").val(res.validity);
                $(".currency").val(res.currency).trigger("change");
                $(".signature").val(res.signature);
                $(".remark").val(res.remark);

                if (res.items.length) {
                    let items = res.items;
                    $("#product_table tbody tr:gt(0)").remove();

                    $(items).each(function(key, value) {
                        let $newRow = $("#product_table tbody tr:first").clone();

                        $newRow.find('.product').val(value.item_id).trigger('change');
                        $newRow.find('.product_qty').val(value.qty);
                        $newRow.find('.product_unit').val(value.unit);
                        $newRow.find('.product_rate').val(value.rate);
                        $newRow.find('.product_total').val(value.total);
                        $newRow.find('.product_shipping_type').val(value.shipping_type).trigger("change");
                        $newRow.find('.product_shipment').val(value.shipment_mode).trigger("change");
                        $newRow.find('.product_payment_term').val(value.payment_term).trigger("change");
                        $newRow.find('.product_delivery').val(value.delivery);
                        $newRow.find('.product_supplier').val(value.supplier_id).trigger('change');

                        $("#product_table tbody").append($newRow);
                    });

                    $("#product_table tbody tr:first").remove();
                }

                $(".loader").hide();
            });
        }

        function getOfferData(e) {
            let offerId = $(e).val();
            $(".loader").show();

            $.get("{{ route('po') }}", {
                _token: '{{ csrf_token() }}',
                offerId,
                type: 'getOfferData'
            }, function(res) {
                $(".customer_id").val(res.customer_id).trigger("change");
                $(".customer_id").prop("disabled", true);
                $(".supplier_id").val(res.supplier_id).trigger("change");
                $(".supplier_id").prop("disabled", true);
                $(".currency").val(res.currency).trigger("change");
                $(".remark").val(res.remark);

                if (res.items.length) {
                    let items = res.items;
                    $("#product_table tbody tr:gt(0)").remove();

                    $(items).each(function(key, value) {
                        let $newRow = $("#product_table tbody tr:first").clone();

                        $newRow.find('.product').val(value.item_id).trigger('change');
                        $newRow.find('.product_qty').val(value.qty);
                        $newRow.find('.product_unit').val(value.unit);
                        $newRow.find('.product_rate').val(value.rate);
                        $newRow.find('.product_total').val(value.total);
                        $newRow.find('.product_shipping_type').val(value.shipping_type).trigger('change');

                        $("#product_table tbody").append($newRow);
                    });

                    $("#product_table tbody tr:first").remove();
                }

                $(".loader").hide();
            });
        }

        function getPurchaseOrderData(e) {
            let poId = $(e).val();
            $(".loader").show();

            $.get("{{ route('indent') }}", {
                _token: '{{ csrf_token() }}',
                poId,
                type: 'getPurchaseOrderData'
            }, function(res) {
                $(".customer_id").val(res.customer_id).trigger("change");
                $(".customer_id").prop("disabled", true);
                $(".supplier_id").val(res.supplier_id).trigger("change");
                $(".supplier_id").prop("disabled", true);
                $(".currency").val(res.currency).trigger("change");
                $(".currency").prop("disabled", true);
                $(".shipping_type").val(res.shipping_type).trigger("change");
                $(".remark").val(res.remark);

                if (res.items.length) {
                    let items = res.items;
                    $("#product_table tbody tr:gt(0)").remove();

                    $(items).each(function(key, value) {
                        let $newRow = $("#product_table tbody tr:first").clone();

                        $newRow.find('.product').val(value.item_id).trigger('change').prop("disabled", true);
                        $newRow.find('.product_qty').val(value.qty).prop("disabled", true);
                        $newRow.find('.product_unit').val(value.unit).prop("disabled", true);
                        $newRow.find('.product_rate').val(value.rate).prop("disabled", true);
                        $newRow.find('.product_total').val(value.total).prop("disabled", true);
                        // $newRow.find('.product_po_id').val(value.po_id).trigger('change');

                        $("#product_table tbody").append($newRow);
                    });

                    $("#product_table tbody tr:first").remove();
                }

                $(".loader").hide();
            });
        }

        $("form").on('submit', function() {
            $("select, input, textarea").prop("disabled", false);
            $(".loader").show();
        })

        function indentDates(e) {
            let indentDate = new Date($(e).val());

            const validityDate = new Date(indentDate);
            validityDate.setMonth(validityDate.getMonth() + 1);

            const lastShipmentDate = new Date(validityDate);
            lastShipmentDate.setMonth(lastShipmentDate.getMonth() + 1);

            const negotiationDate = new Date(lastShipmentDate);
            negotiationDate.setDate(negotiationDate.getDate() + 15);

            const formatDate = (date) => date.toISOString().split('T')[0];

            $(".validity").val(formatDate(validityDate));
            $(".last_date_of_shipment").val(formatDate(lastShipmentDate));
            $(".date_of_negotiation").val(formatDate(negotiationDate));
        }

        function getBankDetail(e) {
            let supId = $(e).val();
            if (supId) {
                $.get("{{ route('indent') }}", {
                    _token: '{{ csrf_token() }}',
                    supId,
                    type: 'getSupplierBankDetail'
                }, function(res) {
                    $(".bank_detail").val(res)
                })
            }
        }
    </script>
</body>

</html>