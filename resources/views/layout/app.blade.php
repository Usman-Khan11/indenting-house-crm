<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('assets') }}/" data-template="vertical-menu-template-starter">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page_title }} - {{ general()->sitename }}</title>
    <meta name="description" content="" />
    <link rel="icon" href="{{ asset('assets/img/favicon/favicon.png') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-advance.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/spinkit/spinkit.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-invoice-print.css') }}" /> --}}

    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
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

        html.dark-style .loader {
            background-color: rgba(0, 0, 0, 0.7) !important;
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
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.9.2/ckeditor.js"
        integrity="sha512-OF6VwfoBrM/wE3gt0I/lTh1ElROdq3etwAquhEm2YI45Um4ird+0ZFX1IwuBDBRufdXBuYoBb0mqXrmUA2VnOA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @stack('script')
    @include('partials.notify')

    <script>
        $(document).ready(function() {
            if ($(".editor").length) {
                CKEDITOR.replaceAll('editor');
            }
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

            // Format the date as DD-MM-YYYY
            let day = String(date.getDate()).padStart(2, '0');
            let month = String(date.getMonth() + 1).padStart(2, '0');
            let year = date.getFullYear();

            let formattedDate = `${day}-${month}-${year}`;

            // If full datetime is requested, add time formatting
            if (full) {
                let hours = date.getHours();
                let minutes = String(date.getMinutes()).padStart(2, '0');
                let seconds = String(date.getSeconds()).padStart(2, '0');
                let ampm = hours >= 12 ? 'PM' : 'AM';

                hours = hours % 12 || 12; // Convert to 12-hour format
                hours = String(hours).padStart(2, '0');

                let formattedTime = `${hours}:${minutes}:${seconds} ${ampm}`;
                formattedDate += ` ${formattedTime}`;
            }

            return formattedDate;
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
                        $(e).parent().parent().parent().find(".product_unit").val(res.unit);
                        $(e).parent().parent().parent().find(".product_code").val(res.code);
                        $(e).parent().parent().parent().find(".product_description").val(res.description);
                    } else {
                        $(e).parent().parent().parent().find(".product_unit").val(null);
                        $(e).parent().parent().parent().find(".product_code").val(null);
                        $(e).parent().parent().parent().find(".product_description").val(null);
                    }

                    $(".loader").hide();
                })
            } else {
                $(".loader").hide();
            }
        }

        function addProductRow(e) {
            if ($('select.product, select.product_supplier').hasClass('select2-hidden-accessible')) {
                $('select.product, select.product_supplier').select2('destroy');
            }

            if ($('select.product_size_id, select.product_artwork_id').hasClass('select2-hidden-accessible')) {
                $('select.product_size_id, select.product_artwork_id').select2('destroy');
            }

            let sno = parseInt($("#product_table .product_row:last .sno span").text()) + 1;
            $("#product_table .product_row:last").clone().appendTo("#product_table");
            $("#product_table .product_row:last").find("input").val(null).prop("disabled", false);
            $("#product_table .product_row:last").find("textarea").val(null).prop("disabled", false);
            $("#product_table .product_row:last").find("select").val(null).trigger('change').prop("disabled", false);
            $("#product_table .product_row:last .sno span").text(sno)

            $('select.product, select.product_supplier, select.product_size_id, select.product_artwork_id').select2();
        }

        function delProductRow(e) {
            if ($("#product_table .product_row").length > 1) {
                $(e).parent().parent().parent().parent().remove();
                $("#product_table .product_row .sno span").each(function(index) {
                    $(this).text(index + 1)
                })
            }
        }

        function addShipmentLotRow(e) {
            if ($(".shipment_lot_row .row").length >= 10) {
                return;
            }
            $(".shipment_lot_row .row:last").clone().appendTo(".shipment_lot_row");
            $(".shipment_lot_row .row:last").find("input").val(null).prop("disabled", false);
            $(".shipment_lot_row .row:last").find("select").val(null).trigger('change').prop("disabled", false);
        }

        function delShipmentLotRow(e) {
            if ($(".shipment_lot_row .row").length > 1) {
                $(".shipment_lot_row .row:last").remove();
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
                $(".date").val(res.date);
                $(".customer_id").val(res.customer_id).trigger("change");
                $(".customer_id").prop("disabled", true);
                $(".supplier_id").val(res.supplier_id).trigger("change");
                $(".supplier_id").prop("disabled", true);
                $(".validity").val(res.validity);
                $(".currency").val(res.currency).trigger("change");
                $(".signature").val(res.signature);
                $(".remark").val(res.remark);
                $(".sales_person").val(res.sales_person).trigger("change").prop("disabled", true);
                $(".sourcing_person").val(res.sourcing_person).trigger("change").prop("disabled", true);

                if (res.items.length) {
                    let items = res.items;
                    $("#product_table .product_row:gt(0)").remove();

                    if ($('select.product, select.product_supplier').hasClass('select2-hidden-accessible')) {
                        $('select.product, select.product_supplier').select2('destroy');
                    }

                    $(items).each(function(key, value) {
                        let $newRow = $("#product_table .product_row:first").clone();

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
                        $newRow.find('.product_description').val(value.item_desc);

                        $("#product_table").append($newRow);
                    });

                    $("#product_table .product_row:first").remove();
                    $('select.product, select.product_supplier').select2();
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
                $(".sales_person").val(res.sales_person).trigger("change").prop("disabled", true);
                $(".sourcing_person").val(res.sourcing_person).trigger("change").prop("disabled", true);

                if (res.items.length) {
                    let items = res.items;
                    $("#product_table .product_row:gt(0)").remove();

                    if ($('select.product, select.product_supplier').hasClass('select2-hidden-accessible')) {
                        $('select.product, select.product_supplier').select2('destroy');
                    }

                    $(items).each(function(key, value) {
                        let $newRow = $("#product_table .product_row:first").clone();

                        $newRow.find('.product').val(value.item_id).trigger('change');
                        $newRow.find('.product_qty').val(value.qty);
                        $newRow.find('.product_unit').val(value.unit);
                        $newRow.find('.product_rate').val(value.rate);
                        $newRow.find('.product_total').val(value.total);
                        $newRow.find('.product_shipping_type').val(value.shipping_type).trigger('change');
                        $newRow.find('.product_description').val(value.item_desc);

                        $("#product_table").append($newRow);
                    });

                    $("#product_table .product_row:first").remove();
                    $('select.product, select.product_supplier').select2();
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
                $(".sales_person").val(res.sales_person).trigger("change").prop("disabled", true);
                $(".sourcing_person").val(res.sourcing_person).trigger("change").prop("disabled", true);

                if (res.items.length) {
                    let items = res.items;
                    $("#product_table .product_row:gt(0)").remove();

                    if ($('select.product, select.product_supplier').hasClass('select2-hidden-accessible')) {
                        $('select.product, select.product_supplier').select2('destroy');
                    }

                    $(items).each(function(key, value) {
                        let $newRow = $("#product_table .product_row:first").clone();

                        $newRow.find('.product').val(value.item_id).trigger('change').prop("disabled",
                            true);
                        $newRow.find('.product_qty').val(value.qty).prop("disabled", true);
                        $newRow.find('.product_unit').val(value.unit).prop("disabled", true);
                        $newRow.find('.product_rate').val(value.rate).prop("disabled", true);
                        $newRow.find('.product_total').val(value.total).prop("disabled", true);
                        $newRow.find('.product_description').val(value.item_desc).prop("disabled", false);

                        $("#product_table").append($newRow);
                    });

                    $("#product_table .product_row:first").remove();
                    $('select.product, select.product_supplier').select2();
                }

                $(".loader").hide();
            });
        }

        function getIndentData(e) {
            let indentId = $(e).val();
            $(".loader").show();

            $.get("{{ route('shipment') }}", {
                _token: '{{ csrf_token() }}',
                indentId,
                type: 'getIndentData'
            }, function(res) {
                $(".customer_id").val(res.customer_id).trigger("change");
                $(".customer_id").prop("disabled", true);
                $(".supplier_id").val(res.supplier_id).trigger("change");
                $(".supplier_id").prop("disabled", true);
                $(".currency").val(res.currency).trigger("change");
                $(".currency").prop("disabled", true);

                $(".lc_bt_tt_no").parent().find('label').text(res.payment);
                $(".lc_bt_tt_no").attr('placeholder', res.payment);

                if (res.items.length) {
                    let items = res.items;
                    $("#product_table .row:gt(0)").remove();

                    if ($('select.product, select.product_supplier').hasClass('select2-hidden-accessible')) {
                        $('select.product, select.product_supplier').select2('destroy');
                    }

                    $(items).each(function(key, value) {
                        let $newRow = $("#product_table .row:first").clone();

                        $newRow.find('.product').val(value.item_id).trigger('change').prop("disabled",
                            true);
                        $newRow.find('.product_qty').val(value.qty);
                        $newRow.find('.product_unit').val(value.unit).prop("disabled", true);
                        $newRow.find('.product_rate').val(value.rate).prop("disabled", true);
                        $newRow.find('.product_total').val(value.total).prop("disabled", true);
                        // $newRow.find('.product_po_id').val(value.po_id).trigger('change');

                        $("#product_table").append($newRow);
                    });

                    $("#product_table .row:first").remove();
                    $('select.product, select.product_supplier').select2();
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

        function productSelect2(elem, url) {
            if ($(elem).hasClass('select2-hidden-accessible')) {
                $(elem).select2('destroy');
            }

            $(elem).select2({
                ajax: {
                    url: url,
                    dataType: 'json',
                    data: function(params) {
                        var query = {
                            search: params.term,
                            type: 'get_product_data'
                        }
                        return query;
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    }
                },
                cache: true,
                allowClear: true,
                placeholder: 'Search for...',
                minimumInputLength: 1,
                minimumResultsForSearch: 50
            });
        }

        function getSupplierProducts(e) {
            $(".loader").show();
            let supID = $(e).val();
            $("select.product").html(null);

            let data = $(e).find("option:selected").data('sourcing_person');
            showSourcingPerson(data);

            if (supID) {
                $.get("{{ route('supplier.supplier_product') }}", {
                    _token: '{{ csrf_token() }}',
                    supID,
                    type: 'getSupplierProducts'
                }, function(res) {
                    if (res) {
                        $("select.product").append(`<option title="" value=""></option>`);
                        $(res).each(function(i, v) {
                            var id = (v.product) ? v.product.id : '';
                            var name = (v.product) ? v.product.name : '';
                            var description = (v.product) ? v.product.description : '';

                            $("select.product").append(
                                `<option title="${description}" value="${id}">${id} -- ${name}</option>`
                            );
                        });
                        $(".loader").hide();
                    }
                })
            } else {
                $(".loader").hide();
            }
        }

        function getCustomerProducts(e) {
            $(".loader").show();
            let cusID = $(e).val();
            $("select.product").html(null);

            let data = $(e).find("option:selected").data('sales_person');
            showSalesPerson(data);

            if (cusID) {
                $.get("{{ route('customer.customer_product') }}", {
                    _token: '{{ csrf_token() }}',
                    cusID,
                    type: 'getCustomerProducts'
                }, function(res) {
                    if (res) {
                        $("select.product").append(`<option title="" value=""></option>`);
                        $(res).each(function(i, v) {
                            var id = (v.product) ? v.product.id : '';
                            var name = (v.product) ? v.product.name : '';
                            var description = (v.product) ? v.product.description : '';

                            $("select.product").append(
                                `<option title="${description}" value="${id}">${id} -- ${name}</option>`
                            );
                        });
                        $(".loader").hide();
                    }
                })
            } else {
                $(".loader").hide();
            }
        }

        function getMappedProducts() {
            $(".loader").show();
            const customer_id = $("select.customer_id").val();
            const supplier_id = $("select.supplier_id").val();
            const item = $('select.item_id');

            $.get("{{ route('shade_card') }}", {
                _token: '{{ csrf_token() }}',
                customer_id,
                supplier_id,
                type: "getMappedProducts"
            }, function(res) {
                let text = '';
                ['customer_products', 'supplier_products'].forEach(group => {
                    if (res[group]) {
                        text +=
                            `<optgroup label="${group.replace('_', ' ').replace(/\b\w/g, c => c.toUpperCase())}">`;
                        res[group].forEach(({
                            product
                        }) => {
                            var id = (product) ? product.id : '';
                            var name = (product) ? product.name : '';
                            text += `<option value="${id}">${id} -- ${name}</option>`;
                        });
                        text += `</optgroup>`;
                    }
                });
                item.html(text);
                $(".loader").hide();
            });
        }

        function inquiryDates() {
            let date = new Date($('.date').val());

            const validityDate = new Date(date);
            validityDate.setDate(validityDate.getDate() + 3);

            const formatDate = (date) => date.toISOString().split('T')[0];

            $(".validity").val(formatDate(validityDate));
        }

        function getProformaInvoiceData(e) {
            let piId = $(e).val();
            $(".loader").show();

            $.get("{{ route('nantong_shipment') }}", {
                _token: '{{ csrf_token() }}',
                piId,
                type: 'getProformaInvoiceData'
            }, function(res) {
                $(".customer_id").val(res.customer_id).trigger("change");
                $(".customer_id").prop("disabled", true);
                $(".supplier_id").val(res.supplier_id).trigger("change");
                $(".supplier_id").prop("disabled", true);
                $(".currency").val(res.currency).trigger("change");
                $(".currency").prop("disabled", true);

                $(".lc_bt_tt_no").parent().find('label').text(res.payment);
                $(".lc_bt_tt_no").attr('placeholder', res.payment);

                if (res.items.length) {
                    let items = res.items;
                    $("#product_table .product_row:gt(0)").remove();

                    if ($('select.product, select.product_size_id').hasClass('select2-hidden-accessible')) {
                        $('select.product, select.product_size_id').select2('destroy');
                    }

                    $(items).each(function(key, value) {
                        let $newRow = $("#product_table .product_row:first").clone();

                        $newRow.find('.product').val(value.item_id).trigger('change').prop("disabled",
                            true);
                        $newRow.find('.product_qty').val(value.qty);
                        $newRow.find('.product_unit').val(value.unit).prop("disabled", true);
                        $newRow.find('.product_rate').val(value.rate).prop("disabled", true);
                        $newRow.find('.product_total').val(value.total).prop("disabled", true);
                        $newRow.find('.product_size_id').val(value.size_id).trigger('change').prop(
                            "disabled",
                            true);

                        $("#product_table").append($newRow);
                    });

                    $("#product_table .product_row:first").remove();
                    $('select.product, select.product_size_id').select2();
                }

                $(".loader").hide();
            });
        }

        function showSalesPerson(data) {
            $("select.sales_person").html(null);
            $("select.sales_person").append(`<option selected value="">Select Sales Person</option>`);

            if (!data) {
                return;
            }

            data = data.split('|').map(item => item.trim());
            $(data).each(function(i, v) {
                $("select.sales_person").append(`<option value="${v}">${v}</option>`);
            })
        }

        function showSourcingPerson(data) {
            $("select.sourcing_person").html(null);
            $("select.sourcing_person").append(`<option selected value="">Select Sourcing Person</option>`);

            if (!data) {
                return;
            }

            data = data.split('|').map(item => item.trim());
            console.log(data)
            $(data).each(function(i, v) {
                $("select.sourcing_person").append(`<option value="${v}">${v}</option>`);
            })
        }

        $("select.customer_id").change(function() {
            let data = $(this).find("option:selected").data('sales_person');
            showSalesPerson(data);
        })

        $("select.supplier_id").change(function() {
            let data = $(this).find("option:selected").data('sourcing_person');
            showSourcingPerson(data);
        })
    </script>
</body>

</html>
