@extends('layouts.auth.mst_admin')
@section('title', 'The Rabbits: Order Outcomes Table | Rabbit Media – Digital Creative Service')
@push('styles')
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/datatables.min.css')}}">
    <link rel="stylesheet"
          href="{{asset('admins/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Buttons-1.5.6/css/buttons.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-datepicker.css')}}">
    <style>
        button[data-id="jenisLayanan_id"] {
            margin-top: -10px !important;
        }

        .bootstrap-select .dropdown-menu {
            min-width: 100% !important;
        }

        .modal-header {
            padding: 1rem !important;
            border-bottom: 1px solid #e9ecef !important;
        }

        .modal-footer {
            padding: 1rem !important;
            border-top: 1px solid #e9ecef !important;
        }
    </style>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Order Outcomes Table</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('home-admin')}}">Dashboard</a></div>
                <div class="breadcrumb-item">Data Transaction</div>
                <div class="breadcrumb-item"><a href="{{route('table.admins')}}">Staffs</a></div>
                <div class="breadcrumb-item">Outcomes</div>
                <div class="breadcrumb-item">Order</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-form">
                                <button onclick="createOutcome()" class="btn btn-primary text-uppercase">
                                    <strong><i class="fas fa-plus mr-2"></i>Create</strong>
                                </button>
                            </div>
                            <div class="card-header-form" style="margin-left: auto;">
                                <form id="form-filter" action="{{route('table.order-outcomes')}}">
                                    <div class="row">
                                        <div class="col">
                                            <select id="jenisLayanan_id" class="form-control selectpicker"
                                                    title="-- Service Types Filter --" name="service"
                                                    data-live-search="true">
                                                <option value="any">Any</option>
                                                @foreach(\App\Models\JenisLayanan::orderBy('nama')->get() as $type)
                                                    <option value="{{$type->id}}">{{$type->nama}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <input id="period" type="text" class="form-control monthpicker"
                                                   placeholder="Period Filter (mm-yyyy)" name="period"
                                                   autocomplete="off" readonly>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="dt-buttons">
                                    <thead>
                                    <tr>
                                        <th class="text-center">
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox" class="custom-control-input" id="cb-all">
                                                <label for="cb-all" class="custom-control-label">#</label>
                                            </div>
                                        </th>
                                        <th class="text-center">ID</th>
                                        <th>Invoice</th>
                                        <th>Item</th>
                                        <th class="text-center">Qty.</th>
                                        <th class="text-right">Price/Item (IDR)</th>
                                        <th class="text-right">Total Price (IDR)</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $no = 1; $outcome = 0; @endphp
                                    @foreach($outcomes as $row)
                                        @php
                                            $order = $row->getPemesanan;
                                            $user = $order->getUser;
                                            $plan = $order->getLayanan;
                                            $price = $plan->harga - ($plan->harga * $plan->diskon/100);
                                            $romanDate = \App\Support\RomanConverter::numberToRoman($order->created_at
                                            ->format('y')).'/'.\App\Support\RomanConverter::numberToRoman($order
                                            ->created_at->format('m'));
                                            $invoice = 'INV/'.$order->created_at->format('Ymd').'/'.$romanDate.'/'.$order->id;
                                            $outcome += $row->price_total;
                                        @endphp
                                        <tr>
                                            <td style="vertical-align: middle" align="center">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" id="cb-{{$row->id}}"
                                                           class="custom-control-input dt-checkboxes">
                                                    <label for="cb-{{$row->id}}"
                                                           class="custom-control-label">{{$no++}}</label>
                                                </div>
                                            </td>
                                            <td style="vertical-align: middle" align="center">{{$row->id}}</td>
                                            <td style="vertical-align: middle">
                                                <div class="row">
                                                    <div class="col">
                                                        <a href="{{route('invoice.order',['id'=>encrypt($order->id)])}}">
                                                            <img class="img-fluid float-left mr-2" alt="icon"
                                                                 width="80" src="{{asset('images/services/'.$plan
                                                                 ->getJenisLayanan->icon)}}">
                                                            <strong><u>#{{$invoice}}</u></strong></a><br>
                                                        <h6>{{$plan->paket}}:
                                                            Rp{{number_format($price, 2,'.',',')}}</h6>
                                                        <strong>{{$user->name}}</strong> / <a
                                                            href="mailto:{{$user->email}}">
                                                            {{$user->email}}</a> / <a href="tel:{{$user->no_telp}}">
                                                            {{$user->no_telp}}</a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="vertical-align: middle"><strong>{{$row->item}}</strong></td>
                                            <td style="vertical-align: middle" align="center">{{number_format
                                            ($row->qty,0,',','.')}}</td>
                                            <td style="vertical-align: middle" align="right">{{number_format
                                            ($row->price_per_qty,2,',','.')}}</td>
                                            <td style="vertical-align: middle" align="right"><strong>{{number_format
                                            ($row->price_total,2,',','.')}}</strong></td>
                                            <td style="vertical-align: middle" align="center">
                                                <button data-placement="left" data-toggle="tooltip" title="Edit"
                                                        type="button" class="btn btn-warning" onclick="editOutcome
                                                        ('{{$row->id}}','{{$row->pemesanan_id}}','{{$invoice}}',
                                                        '{{$row->item}}','{{$row->qty}}','{{$row->price_per_qty}}',
                                                        '{{$row->price_total}}','{{encrypt($row->pemesanan_id)}}')">
                                                    <i class="fa fa-edit"></i></button>
                                                <hr class="mt-1 mb-1">
                                                <a href="{{route('delete.order-outcomes',['id'=>encrypt($row->id)])}}"
                                                   class="btn btn-danger delete-data" data-toggle="tooltip"
                                                   data-placement="left" title="Delete"><i class="fas fa-trash-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                        <th><em>Total Outcome (IDR)</em></th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                        <th>{{number_format($outcome, 2,',','.')}}</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                    </tfoot>
                                </table>
                                <form method="post" id="form-mass">
                                    {{csrf_field()}}
                                    <input type="hidden" name="outcome_ids">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="outcomeModal" tabindex="-1" role="dialog" aria-labelledby="outcomeModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Order Outcome Setup</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-outcome" method="post" action="{{route('create.order-outcomes')}}">
                    {{csrf_field()}}
                    <input type="hidden" name="_method">
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="row form-group">
                            <div class="col fix-label-group">
                                <label for="pemesanan_id" class="m-0">Order Invoice</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fix-label-item" style="height: 2.25rem">
                                            <i class="fa fa-file-invoice-dollar"></i></span>
                                    </div>
                                    <select id="pemesanan_id" class="form-control selectpicker" title="-- Choose --"
                                            name="pemesanan_id" data-live-search="true" required>
                                        @foreach($orders as $order)
                                            @php
                                                $romanDate = \App\Support\RomanConverter::numberToRoman($order->created_at
                                                ->format('y')).'/'.\App\Support\RomanConverter::numberToRoman($order
                                                ->created_at->format('m'));
                                                $invoice = 'INV/'.$order->created_at->format('Ymd').'/'.$romanDate.'/'.$order->id;
                                            @endphp
                                            <option value="{{$order->id}}" data-subtext="{{$order->judul.' - '.$order
                                            ->getLayanan->paket}}">#{{$invoice}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-text text-muted" style="display: none">
                                    <a id="invoice_details" target="_blank">Click here</a> to check the invoice details!
                                </div>
                            </div>
                        </div>

                        <div id="inputs"></div>
                        <div class="row">
                            <div class="col">
                                <button type="button" class="btn btn-primary btn-block add-field text-uppercase"
                                        disabled>
                                    <strong><i class="fa fa-cart-plus mr-2"></i>Add Item</strong>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push("scripts")
    <script src="{{asset('admins/modules/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('admins/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('admins/modules/datatables/Select-1.2.4/js/dataTables.select.min.js')}}"></script>
    <script src="{{asset('admins/modules/datatables/Buttons-1.5.6/js/buttons.dataTables.min.js')}}"></script>
    <script src="{{asset('admins/modules/jquery-ui/jquery-ui.min.js')}}"></script>
    <script src="{{asset('admins/modules/jquery.maskMoney.js')}}"></script>
    <script src="{{asset('js/bootstrap-datepicker.js')}}"></script>
    <script>
        var qty = 0, price_per_qty = 0, price_total = 0, i = 0;

        $(function () {
            var export_filename = 'Order Outcomes Table ({{now()->format('j F Y')}})',
                table = $("#dt-buttons").DataTable({
                    dom: "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'B><'col-sm-12 col-md-4'f>>" +
                        "<'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    columnDefs: [
                        {sortable: false, targets: 7},
                        {targets: 1, visible: false, searchable: false}
                    ],
                    buttons: [
                        {
                            text: '<strong class="text-uppercase"><i class="far fa-clipboard mr-2"></i>Copy</strong>',
                            extend: 'copy',
                            exportOptions: {
                                columns: [0, 2, 3, 4, 5, 6]
                            },
                            className: 'btn btn-warning assets-export-btn export-copy ttip'
                        }, {
                            text: '<strong class="text-uppercase"><i class="far fa-file-excel mr-2"></i>Excel</strong>',
                            extend: 'excel',
                            exportOptions: {
                                columns: [0, 2, 3, 4, 5, 6]
                            },
                            className: 'btn btn-success assets-export-btn export-xls ttip',
                            title: export_filename,
                            extension: '.xls'
                        }, {
                            text: '<strong class="text-uppercase"><i class="fa fa-print mr-2"></i>Print</strong>',
                            extend: 'print',
                            footer: true,
                            exportOptions: {
                                columns: [0, 2, 3, 4, 5, 6]
                            },
                            className: 'btn btn-info assets-select-btn export-print'
                        }, {
                            text: '<strong class="text-uppercase"><i class="fa fa-trash-alt mr-2"></i>Deletes</strong>',
                            className: 'btn btn-danger btn_massDelete'
                        }
                    ],
                    fnDrawCallback: function (oSettings) {
                        $('.use-nicescroll').getNiceScroll().resize();
                        $('[data-toggle="tooltip"]').tooltip();

                        $("#cb-all").on('click', function () {
                            if ($(this).is(":checked")) {
                                $("#dt-buttons tbody tr").addClass("terpilih")
                                    .find('.dt-checkboxes').prop("checked", true).trigger('change');
                            } else {
                                $("#dt-buttons tbody tr").removeClass("terpilih")
                                    .find('.dt-checkboxes').prop("checked", false).trigger('change');
                            }
                        });

                        $("#dt-buttons tbody tr").on("click", function () {
                            $(this).toggleClass("terpilih");
                            if ($(this).hasClass('terpilih')) {
                                $(this).find('.dt-checkboxes').prop("checked", true).trigger('change');
                            } else {
                                $(this).find('.dt-checkboxes').prop("checked", false).trigger('change');
                            }
                        });

                        $('.dt-checkboxes').on('click', function () {
                            if ($(this).is(':checked')) {
                                $(this).parent().parent().parent().addClass("terpilih");
                            } else {
                                $(this).parent().parent().parent().removeClass("terpilih");
                            }
                        });

                        $('.btn_massDelete').on("click", function () {
                            var ids = $.map(table.rows('.terpilih').data(), function (item) {
                                return item[1]
                            });
                            $("#form-mass input[name=outcome_ids]").val(ids);
                            $("#form-mass").attr("action", "{{route('massDelete.order-outcomes')}}");

                            if (ids.length > 0) {
                                swal({
                                    title: 'Delete Order Outcomes',
                                    text: 'Are you sure to delete this ' + ids.length + ' selected record(s)? ' +
                                        'You won\'t be able to revert this!',
                                    icon: 'warning',
                                    dangerMode: true,
                                    buttons: ["No", "Yes"],
                                    closeOnEsc: false,
                                    closeOnClickOutside: false,
                                }).then((confirm) => {
                                    if (confirm) {
                                        swal({icon: "success", buttons: false});
                                        $("#form-mass")[0].submit();
                                    }
                                });
                            } else {
                                $("#cb-all").prop("checked", false).trigger('change');
                                swal("Error!", "There's no any selected record!", "error");
                            }
                        });
                    },
                });

            $("#period").datepicker({
                format: "mm-yyyy",
                viewMode: "months",
                minViewMode: "months",
                todayBtn: false,
            });

            @if($find != "")
            createOutcome();
            $(".fix-label-group .bootstrap-select").addClass('p-0');
            $(".fix-label-group .bootstrap-select button").css('border-color', '#e4e6fc');
            $("label[for=pemesanan_id]").parent().parent().show();
            $("#pemesanan_id").val('{{$find}}').prop('disabled', false).selectpicker('refresh');
            $("#invoice_details").attr('href', '{{route('invoice.order',['id' => encrypt($find)])}}').parent().show();
            $(".add-field").prop('disabled', false).show();
            @endif

            @if($service != "")
            $("#jenisLayanan_id").val('{{$service}}').selectpicker('refresh');
            @endif
            @if($period != "")
            $("#period").val('{{$period}}');
            @endif
        });

        $("#jenisLayanan_id, #period").on('change', function () {
            $("#form-filter")[0].submit();
        });

        function createOutcome() {
            @if(count($orders) > 0)
            $(".fix-label-group .bootstrap-select").addClass('p-0');
            $(".fix-label-group .bootstrap-select button").css('border-color', '#e4e6fc');

            $("#outcomeModal .modal-title").text('Order Outcome Setup');
            $("#form-outcome").attr('action', '{{route('create.order-outcomes')}}');
            $("#form-outcome button[type=submit] strong").text('Submit');
            $("#form-outcome input[name=_method], #form-outcome input[name=id]").val('');
            $("label[for=pemesanan_id]").parent().parent().show();
            $("#pemesanan_id").val('').prop('disabled', false).selectpicker('refresh');
            $("#invoice_details").attr('href', '#').parent().hide();
            $("#inputs").html('');
            $(".add-field").prop('disabled', true).show();

            $("#outcomeModal").modal('show');
            @else
            swal('ATTENTION!', 'There seems to be no order that needs to be set its log.', 'warning');
            @endif
        }

        function editOutcome(id, pemesanan_id, invoice, item, ed_qty, ed_price_per_qty, ed_price_total, encryptID) {
            $(".fix-label-group .bootstrap-select").addClass('p-0');
            $(".fix-label-group .bootstrap-select button").css('border-color', '#e4e6fc');

            $("#outcomeModal .modal-title").html('Edit Outcome #<strong>' + invoice + '</strong>');
            $("#form-outcome").attr('action', '{{route('update.order-outcomes')}}');
            $("#form-outcome input[name=_method]").val('PUT');
            $("#form-outcome input[name=id]").val(id);
            $("#form-outcome button[type=submit] strong").text('Submit');
            $("label[for=pemesanan_id]").parent().parent().hide();
            $("#pemesanan_id").val(pemesanan_id).prop('disabled', true).selectpicker('refresh');
            $("#invoice_details").attr('href', '{{route('invoice.order',['id' => ''])}}/' + encryptID).parent().show();
            $(".add-field").prop('disabled', true).hide();

            qty = ed_qty;
            price_per_qty = ed_price_per_qty;
            price_total = ed_price_total;
            $("#inputs").html(
                '<div class="row form-group">' +
                '<div class="col">' +
                '<label class="m-0">Item</label>' +
                '<div class="input-group">' +
                '<div class="input-group-prepend">' +
                '<span class="input-group-text"><i class="fa fa-shopping-cart"></i></span></div>' +
                '<input id="item' + id + '" type="text" class="form-control input-item" ' +
                'name="item" value="' + item + '" placeholder="Write the item\'s name here&hellip;" required></div></div></div>' +
                '<div class="row">' +
                '<div class="col">' +
                '<label class="m-0">Total Qty & Price/pcs (IDR)</label>' +
                '<div class="input-group">' +
                '<div class="input-group-prepend"><span class="input-group-text"><strong>@</strong></span></div>' +
                '<input id="qty' + id + '" type="text" class="form-control input-qty" name="qty" ' +
                'value="' + thousandSeparator(qty) + '" placeholder="0" onkeyup="checkQty(' + id + ')" required>' +
                '<input id="price_per_qty' + id + '" type="text" class="form-control input-price" ' +
                'name="price_per_qty" value="' + thousandSeparator(price_per_qty) + '" placeholder="0" required ' +
                'onkeyup="checkPricePerQty(' + id + ')">' +
                '<div class="input-group-append">' +
                '<span class="input-group-text"><i class="fa fa-money-bill-wave"></i></span></div></div></div>' +
                '<div class="col"><label class="m-0">Total Price</label>' +
                '<div class="input-group">' +
                '<div class="input-group-prepend"><span class="input-group-text"><strong>Rp</strong></span></div>' +
                '<input id="price_total' + id + '" type="text" class="form-control" name="price_total" ' +
                'value="' + thousandSeparator(price_total) + '" readonly>' +
                '<div class="input-group-append"><span class="input-group-text"><i class="fa fa-money-bill-wave"></i>' +
                '</span></div></div></div></div>'
            );

            $("#qty" + id).maskMoney({thousands: '.', decimal: ',', precision: '0'});
            $("#price_per_qty" + id).maskMoney({thousands: '.', decimal: ',', precision: '0'});

            $("#outcomeModal").modal('show');
        }

        $("#pemesanan_id").on('change', function () {
            $("#invoice_details").attr('href', '#').parent().hide();
            $(".add-field").prop('disabled', false).show();

            $.get('{{route('get.orders', ['id' => ''])}}/' + $(this).val(), function (data) {
                $("#invoice_details").attr('href', data).parent().show();
            });
        });

        $(".add-field").on("click", function () {
            i = i + 1;
            $("#inputs").append(
                '<div id="div_item' + i + '" class="row form-group align-items-center">' +
                '<div class="col">' +
                '<div class="row mb-2">' +
                '<div class="col">' +
                '<label class="m-0">Item</label>' +
                '<div class="input-group">' +
                '<div class="input-group-prepend">' +
                '<span class="input-group-text"><i class="fa fa-shopping-cart"></i></span></div>' +
                '<input id="item' + i + '" type="text" class="form-control input-item" name="item[]" ' +
                'placeholder="Write the item\'s name here&hellip;" required></div></div></div>' +
                '<div class="row">' +
                '<div class="col">' +
                '<label class="m-0">Total Qty & Price/pcs (IDR)</label>' +
                '<div class="input-group">' +
                '<div class="input-group-prepend"><span class="input-group-text"><strong>@</strong></span></div>' +
                '<input id="qty' + i + '" type="text" class="form-control input-qty" name="qty[]" ' +
                'placeholder="0" onkeyup="checkQty(' + i + ')" required>' +
                '<input id="price_per_qty' + i + '" type="text" class="form-control input-price" ' +
                'name="price_per_qty[]" placeholder="0" onkeyup="checkPricePerQty(' + i + ')" required>' +
                '<div class="input-group-append">' +
                '<span class="input-group-text"><i class="fa fa-money-bill-wave"></i></span></div></div></div>' +
                '<div class="col"><label class="m-0">Total Price</label>' +
                '<div class="input-group">' +
                '<div class="input-group-prepend"><span class="input-group-text"><strong>Rp</strong></span></div>' +
                '<input id="price_total' + i + '" type="text" class="form-control" name="price_total[]" readonly>' +
                '<div class="input-group-append">' +
                '<span class="input-group-text"><i class="fa fa-money-bill-wave"></i></span></div>' +
                '</div></div></div></div>' +
                '<div class="col-1">' +
                '<button onclick="removeField(' + i + ')" type="button" class="btn btn-danger">' +
                '<i class="fa fa-trash-alt"></i></button></div></div>'
            );

            $("#qty" + i).maskMoney({thousands: '.', decimal: ',', precision: '0'});
            $("#price_per_qty" + i).maskMoney({thousands: '.', decimal: ',', precision: '0'});
        });

        $("#form-outcome").on('submit', function (e) {
            e.preventDefault();
            if (!$(".input-item, .input-qty, .input-price").val()) {
                swal('ATTENTION!', 'Please add some items and fill its field correctly!', 'warning');
            } else {
                $(this)[0].submit();
            }
        });

        function removeField(i) {
            if ($("#item" + i).val() || $("#qty" + i).val() || $("#price_per_qty" + i).val()) {
                swal({
                    title: 'Delete ' + $("#item" + i).val(),
                    text: 'Are you sure to delete it? You won\'t be able to revert this!',
                    icon: 'warning',
                    dangerMode: true,
                    buttons: ["No", "Yes"],
                    closeOnEsc: false,
                    closeOnClickOutside: false,
                }).then((confirm) => {
                    if (confirm) {
                        $("#div_item" + i).remove();
                    }
                });

            } else {
                $("#div_item" + i).remove();
            }
        }

        function checkQty(i) {
            price_total = 0;

            var val = $("#qty" + i).val().split('.').join("");
            if (val == "" || parseInt(val) <= 0) {
                $("#qty" + i).val(0);
            } else {
                $("#qty" + i).val(val);
            }
            qty = val;
            price_total = parseInt(qty) * parseInt(price_per_qty);
            $("#price_total" + i).val(thousandSeparator(price_total));
        }

        function checkPricePerQty(i) {
            price_total = 0;

            var val = $("#price_per_qty" + i).val().split('.').join("");
            if (val == "" || parseInt(val) <= 0) {
                $("#price_per_qty" + i).val(0);
            } else {
                $("#price_per_qty" + i).val(val);
            }
            price_per_qty = val;
            price_total = parseInt(qty) * parseInt(price_per_qty);
            $("#price_total" + i).val(thousandSeparator(price_total));
        }

        function thousandSeparator(nStr) {
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + '.' + '$2');
            }
            return x1 + x2;
        }
    </script>
@endpush
