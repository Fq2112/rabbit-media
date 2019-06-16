@extends('layouts.auth.mst_admin')
@section('title', 'The Rabbits: Non-Order Outcomes Table | Rabbit Media – Digital Creative Service')
@push('styles')
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/datatables.min.css')}}">
    <link rel="stylesheet"
          href="{{asset('admins/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Buttons-1.5.6/css/buttons.dataTables.min.css')}}">
    <style>
        .bootstrap-select .dropdown-menu {
            min-width: 100% !important;
        }

        .form-control-feedback {
            position: absolute;
            top: 3em;
            right: 2em;
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
            <h1>Non-Order Outcomes Table</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('home-admin')}}">Dashboard</a></div>
                <div class="breadcrumb-item">Data Transaction</div>
                <div class="breadcrumb-item"><a href="{{route('table.admins')}}">Staffs</a></div>
                <div class="breadcrumb-item">Outcomes</div>
                <div class="breadcrumb-item">Non-Order</div>
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
                                        <th>Description</th>
                                        <th>Item</th>
                                        <th class="text-center">Qty.</th>
                                        <th class="text-right">Price/Item (IDR)</th>
                                        <th class="text-right">Total Price (IDR)</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $no = 1; @endphp
                                    @foreach($outcomes as $row)
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
                                            <td style="vertical-align: middle">{{$row->description}}</td>
                                            <td style="vertical-align: middle"><strong>{{$row->item}}</strong></td>
                                            <td style="vertical-align: middle"
                                                align="center">{{number_format($row->qty,0,',','.')}}</td>
                                            <td style="vertical-align: middle" align="right">{{number_format
                                            ($row->price_per_qty,2,',','.')}}</td>
                                            <td style="vertical-align: middle" align="right"><strong>{{number_format
                                            ($row->price_total,2,',','.')}}</strong></td>
                                            <td style="vertical-align: middle" align="center">
                                                <button data-placement="left" data-toggle="tooltip" title="Edit"
                                                        type="button" class="btn btn-warning" onclick="editOutcome
                                                        ('{{$row->id}}','{{$row->description}}','{{$row->item}}',
                                                        '{{$row->qty}}','{{$row->price_per_qty}}','{{$row->price_total}}')">
                                                    <i class="fa fa-edit"></i></button>
                                                <hr class="mt-1 mb-1">
                                                <a href="{{route('delete.nonOrder-outcomes',['id'=>encrypt($row->id)])}}"
                                                   class="btn btn-danger delete-data" data-toggle="tooltip"
                                                   data-placement="left" title="Delete"><i class="fas fa-trash-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
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
                    <h5 class="modal-title">Non-Order Outcome <strong></strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-outcome" method="post" action="{{route('create.nonOrder-outcomes')}}">
                    {{csrf_field()}}
                    <input type="hidden" name="_method">
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="row form-group has-feedback">
                            <div class="col">
                                <label for="description">Description</label>
                                <textarea id="description" type="text" name="description" class="form-control"
                                          placeholder="Describe it here&hellip;" required></textarea>
                                <span class="glyphicon glyphicon-text-height form-control-feedback"></span>
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
    <script>
        var qty = 0, price_per_qty = 0, price_total = 0, i = 0;

        $(function () {
            var export_filename = 'Non-Order Outcomes Table ({{now()->format('j F Y')}})',
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
                            $("#form-mass").attr("action", "{{route('massDelete.nonOrder-outcomes')}}");

                            if (ids.length > 0) {
                                swal({
                                    title: 'Delete Non-Order Outcomes',
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
        });

        function createOutcome() {
            $("#outcomeModal .modal-title strong").text('Setup');
            $("#form-outcome").attr('action', '{{route('create.nonOrder-outcomes')}}');
            $("#form-outcome button[type=submit] strong").text('Submit');
            $("#form-outcome input[name=_method], #form-outcome input[name=id]").val('');
            $("#description").val('');
            $("#inputs").html('');
            $(".add-field").prop('disabled', true).show();

            $("#outcomeModal").modal('show');
        }

        function editOutcome(id, description, item, ed_qty, ed_price_per_qty, ed_price_total) {
            $("#outcomeModal .modal-title strong").text('Edit');
            $("#form-outcome").attr('action', '{{route('update.nonOrder-outcomes')}}');
            $("#form-outcome input[name=_method]").val('PUT');
            $("#form-outcome input[name=id]").val(id);
            $("#form-outcome button[type=submit] strong").text('Submit');
            $("#description").val(description);
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

        $("#description").on('keypress', function () {
            $(".add-field").prop('disabled', false);
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