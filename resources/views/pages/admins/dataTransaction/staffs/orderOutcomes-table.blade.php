@extends('layouts.auth.mst_admin')
@section('title', 'The Rabbits: Order Outcomes Table | Rabbit Media – Digital Creative Service')
@push('styles')
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/datatables.min.css')}}">
    <link rel="stylesheet"
          href="{{asset('admins/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Buttons-1.5.6/css/buttons.dataTables.min.css')}}">
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Order Outcomes Table</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('home-admin')}}">Dashboard</a></div>
                <div class="breadcrumb-item">Data Transaction</div>
                <div class="breadcrumb-item"><a href="{{route('table.admins')}}">Staffs</a></div>
                <div class="breadcrumb-item">Order Outcomes</div>
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
                                        <th>Details</th>
                                        <th>Total Price</th>
                                        <th class="text-center">Created at</th>
                                        <th class="text-center">Last Update</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $no = 1; @endphp
                                    @foreach($outcomes as $row)
                                        @php
                                            $order = $row->getPemesanan;
                                            $plan = $order->getLayanan;
                                            $romanDate = \App\Support\RomanConverter::numberToRoman($order->created_at
                                            ->format('y')).'/'.\App\Support\RomanConverter::numberToRoman($order
                                            ->created_at->format('m'));
                                            $invoice = 'INV/'.$order->created_at->format('Ymd').'/'.$romanDate.'/'.$order->id;
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
                                                <a href="{{route('invoice.order',['id'=>encrypt($order->id)])}}">
                                                    <img class="img-fluid float-left mr-2" alt="icon" width="80"
                                                         src="{{asset('images/services/'.$plan->getJenisLayanan->icon)}}">
                                                    <strong>#{{$invoice}}</strong>
                                                </a><br>
                                                <i class="fa fa-shopping-cart mr-2"></i>Item: <b>{{$row->item}}</b> @
                                                <b>Rp{{number_format($row->price_per_qty,0,',','.')}}</b>
                                            </td>
                                            <td style="vertical-align: middle" align="right"><strong>Rp{{number_format($row
                                            ->price_total,2,',','.')}}</strong></td>
                                            <td style="vertical-align: middle" align="center">
                                                {{\Carbon\Carbon::parse($row->created_at)->format('j F Y')}}</td>
                                            <td style="vertical-align: middle"
                                                align="center">{{$row->updated_at->diffForHumans()}}</td>
                                            <td style="vertical-align: middle" align="center">
                                                <a href="{{route('delete.order-outcomes',['id'=>encrypt($row->id)])}}"
                                                   class="btn btn-danger delete-data" data-toggle="tooltip"
                                                   title="Delete"><i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <form method="post" id="form-outcome">
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
@endsection
@push("scripts")
    <script src="{{asset('admins/modules/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('admins/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('admins/modules/datatables/Select-1.2.4/js/dataTables.select.min.js')}}"></script>
    <script src="{{asset('admins/modules/datatables/Buttons-1.5.6/js/buttons.dataTables.min.js')}}"></script>
    <script src="{{asset('admins/modules/jquery-ui/jquery-ui.min.js')}}"></script>
    <script>
        $(function () {
            var export_filename = 'Order outcomes Table ({{now()->format('j F Y')}})',
                table = $("#dt-buttons").DataTable({
                    dom: "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'B><'col-sm-12 col-md-4'f>>" +
                        "<'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    columnDefs: [
                        {sortable: false, targets: 6},
                        {targets: 1, visible: false, searchable: false}
                    ],
                    buttons: [
                        {
                            text: '<strong class="text-uppercase"><i class="far fa-clipboard mr-2"></i>Copy</strong>',
                            extend: 'copy',
                            exportOptions: {
                                columns: [0, 2, 3, 4, 5]
                            },
                            className: 'btn btn-warning assets-export-btn export-copy ttip'
                        }, {
                            text: '<strong class="text-uppercase"><i class="far fa-file-excel mr-2"></i>Excel</strong>',
                            extend: 'excel',
                            exportOptions: {
                                columns: [0, 2, 3, 4, 5]
                            },
                            className: 'btn btn-success assets-export-btn export-xls ttip',
                            title: export_filename,
                            extension: '.xls'
                        }, {
                            text: '<strong class="text-uppercase"><i class="fa fa-print mr-2"></i>Print</strong>',
                            extend: 'print',
                            exportOptions: {
                                columns: [0, 2, 3, 4, 5]
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
                            $("#form-outcome input[name=outcome_ids]").val(ids);
                            $("#form-outcome").attr("action", "{{route('massDelete.order-outcomes')}}");

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
                                        $("#form-outcome")[0].submit();
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
    </script>
@endpush