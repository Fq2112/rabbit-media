@extends('layouts.auth.mst_admin')
@section('title', 'The Rabbits: Orders Table | Rabbit Media – Digital Creative Service')
@push('styles')
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/datatables.min.css')}}">
    <link rel="stylesheet"
          href="{{asset('admins/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Buttons-1.5.6/css/buttons.dataTables.min.css')}}">
    <style>
        .swal-button--dp {
            background-color: #eec60a;
            font-size: 12px;
            border: 1px solid #cdac0a;
            color: #212529;
            text-shadow: 0 -1px 0 rgba(255, 255, 255, 0.3);
            box-shadow: 0 2px 6px #ffd30b;
        }

        .swal-button--dp:focus {
            opacity: 0.8;
        }

        .swal-button--dp:active {
            background-color: #af8e0a;
        }

        .swal-button--fp {
            background-color: #35C189;
            font-size: 12px;
            border: 1px solid #2da575;
            text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.3);
            box-shadow: 0 2px 6px #46ffb6;
        }

        .swal-button--fp:focus {
            opacity: 0.8;
        }

        .swal-button--fp:active {
            background-color: #238761;
        }
    </style>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Orders Table</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('home-admin')}}">Dashboard</a></div>
                <div class="breadcrumb-item">Data Transaction</div>
                <div class="breadcrumb-item"><a href="{{route('table.users')}}">Clients</a></div>
                <div class="breadcrumb-item">Orders</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
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
                                        <th class="text-center">Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $no=1; @endphp
                                    @foreach($orders as $row)
                                        @php
                                            $user = $row->getUser;
                                            $plan = $row->getLayanan;
                                            $price = $plan->harga - ($plan->harga * $plan->diskon/100);
                                            $start = \Carbon\Carbon::parse($row->start)->format('j F Y');
                                            $end = \Carbon\Carbon::parse($row->end)->format('j F Y');
                                            $date = $row->created_at;
                                            $romanDate = \App\Support\RomanConverter::numberToRoman($date->format('y')).'/'.
                                            \App\Support\RomanConverter::numberToRoman($date->format('m'));
                                            $invoice = 'INV/'.$date->format('Ymd').'/'.$romanDate.'/'.$row->id;
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
                                                <div class="row mb-1" style="border-bottom: 1px solid #eee">
                                                    <div class="col">
                                                        <a href="{{route('invoice.order',['id'=>encrypt($row->id)])}}">
                                                            <img class="img-fluid float-left mr-2" alt="icon"
                                                                 width="80" src="{{asset('images/services/'.$plan
                                                                 ->getJenisLayanan->icon)}}">
                                                            <strong>#{{$invoice}}</strong></a><br>
                                                        <h6>{{$plan->paket}}:
                                                            Rp{{number_format($price, 2,'.',',')}}</h6>
                                                        <strong>{{$user->name}}</strong> / <a
                                                                href="mailto:{{$user->email}}">
                                                            {{$user->email}}</a> / <a href="tel:{{$user->no_telp}}">
                                                            {{$user->no_telp}}</a>
                                                    </div>
                                                </div>
                                                <div class="row mb-1" style="border-bottom: {{$row->payment_id != "" ?
                                                '1px solid #eee' : 'none'}}">
                                                    <div class="col">
                                                        <strong>Order Details</strong>
                                                        <ul class="mb-0">
                                                            <li>
                                                                <strong data-toggle="tooltip" data-placement="left"
                                                                        title="Title">
                                                                    <i class="fa fa-text-width mr-1"></i>{{$row->judul}}
                                                                </strong>
                                                            </li>
                                                            <li>
                                                                <strong data-toggle="tooltip" data-placement="left"
                                                                        title="Booking Date">
                                                                    <i class="fa fa-calendar-day mr-1"></i>{{$start}}
                                                                </strong> &ndash; <strong>{{$end}}</strong>
                                                            </li>
                                                            @if($plan->isHours == true)
                                                                <li>
                                                                    <strong data-toggle="tooltip" data-placement="left"
                                                                            title="Total Duration">
                                                                        <i class="fa fa-stopwatch mr-1"></i>{{$row->hours}}
                                                                    </strong> hours
                                                                </li>
                                                            @endif
                                                            @if($plan->isQty == true)
                                                                <li>
                                                                    <strong data-toggle="tooltip" data-placement="left"
                                                                            title="Total Item">
                                                                        <i class="fa fa-users mr-1"></i>{{$row->qty}}
                                                                    </strong> items
                                                                </li>
                                                            @endif
                                                            @if($plan->isStudio == true)
                                                                <li>
                                                                    <strong data-toggle="tooltip" data-placement="left"
                                                                            title="Studio">
                                                                        <i class="fa fa-door-open mr-1"></i>
                                                                        {{$row->getStudio->nama}}
                                                                    </strong>({{$row->getStudio->getJenisStudio->nama}})
                                                                </li>
                                                            @endif
                                                            <li>
                                                                <span data-toggle="tooltip" data-placement="left"
                                                                      title="Meeting Location">
                                                                    <i class="fa fa-map-marked-alt mr-1"></i>
                                                                    {{$row->meeting_location != "" ?
                                                                    $row->meeting_location : '(empty)'}}
                                                                </span>
                                                            </li>
                                                            <li>
                                                                <span data-toggle="tooltip" data-placement="left"
                                                                      title="Additional Info">
                                                                    <i class="fa fa-comments mr-1"></i>{{$row->deskripsi}}
                                                                </span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                @if($row->payment_id != "")
                                                    <div class="row">
                                                        <div class="col">
                                                            <strong>Payment Details</strong><br>
                                                            @if($row->payment_proof != "" &&
                                                            substr($row->payment_proof,0,18) != 'https://lorempixel')
                                                                <img class="img-thumbnail float-left mr-2" width="80"
                                                                     src="{{asset('storage/users/payment/'.$row
                                                                     ->payment_proof)}}" style="cursor: pointer"
                                                                     alt="Proof" onclick="paymentProofModal('{{asset
                                                                     ('storage/users/payment/'.$row->payment_proof)}}')"
                                                                     data-toggle="tooltip" title="Payment Proof">
                                                            @elseif($row->payment_proof != "" &&
                                                            substr($row->payment_proof,0,18) == 'https://lorempixel')
                                                                <img class="img-thumbnail float-left mr-2" width="80"
                                                                     src="{{$row->payment_proof}}"
                                                                     style="cursor: pointer"
                                                                     onclick="paymentProofModal('{{$row->payment_proof}}')"
                                                                     data-toggle="tooltip" title="Payment Proof"
                                                                     alt="Proof">
                                                            @else
                                                                <img class="img-thumbnail float-left mr-2" width="80"
                                                                     alt="Proof"
                                                                     src="{{asset('admins/img/no_image.png')}}">
                                                            @endif
                                                            <ul>
                                                                <li style="list-style: none">
                                                                    <strong data-toggle="tooltip" data-placement="right"
                                                                            title="Payment Type">
                                                                        <i class="fa fa-handshake mr-1"></i>
                                                                        {{$row->payment_type}}
                                                                    </strong>
                                                                </li>
                                                                <li style="list-style: none">
                                                                    <strong data-toggle="tooltip" data-placement="right"
                                                                            title="Payment Method">
                                                                        <i class="fa fa-wallet mr-1"></i>
                                                                        {{$row->getPayment->name}}
                                                                    </strong>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                            <td style="vertical-align: middle;" align="center">
                                                @if(now() >= \Carbon\Carbon::parse($row['start'])->subDays(2) &&
                                                $row->status_payment == 0)
                                                    <span class="badge badge-dark"><strong>EXPIRED</strong></span>
                                                @else
                                                    @if($row->isAccept == false && $row->isReject == false)
                                                        <span class="badge badge-primary">
                                                        <strong>Waiting for Confirmation</strong></span>
                                                    @elseif($row->isAccept == false && $row->isReject == true)
                                                        <span class="badge badge-danger"><strong>REJECTED</strong></span>
                                                    @else
                                                        @if($row->status_payment == 0 &&
                                                        $row->payment_id != "" && $row->payment_proof != "")
                                                            <span class="badge badge-secondary">
                                                            <strong>Waiting for Verification</strong></span>
                                                        @elseif($row->status_payment == 0 &&
                                                        $row->payment_id == "" && $row->payment_proof == "")
                                                            <span class="badge badge-warning">
                                                                <strong>Waiting for Payment</strong></span>
                                                        @elseif($row->status_payment == 1)
                                                            <span class="badge badge-info">
                                                                <strong>DP 30%</strong></span>
                                                        @else
                                                            <span class="badge badge-success">
                                                                <strong>Fully Paid</strong></span>
                                                        @endif
                                                    @endif
                                                @endif
                                            </td>
                                            <td style="vertical-align: middle" align="center">
                                                @if(Auth::guard('admin')->user()->isRoot())
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-primary text-uppercase"
                                                                onclick="updateOrder('{{$row->id}}', '{{$invoice}}',
                                                                        'accept')" {{$row->isAccept == true ||
                                                                        $row->isReject == true || now() >=
                                                                        \Carbon\Carbon::parse($row['start'])->subDays(2)
                                                                        ? 'disabled' : ''}}>
                                                            <strong><i class="fa fa-check-circle mr-2"></i>
                                                                @if($row->isAccept == true)
                                                                    Accepted
                                                                @elseif($row->isReject == true)
                                                                    Rejected
                                                                @else
                                                                    Accept
                                                                @endif
                                                            </strong>
                                                        </button>
                                                        <button type="button" class="btn btn-primary dropdown-toggle"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false"></button>
                                                        <div class="dropdown-menu" aria-labelledby="option">
                                                            @if($row->status_payment < 1 && now() <
                                                            \Carbon\Carbon::parse($row['start'])->subDays(2))
                                                                <a class="dropdown-item" href="javascript:void(0)"
                                                                   onclick="updateOrder('{{$row->id}}', '{{$invoice}}',
                                                                           '{{$row->isAccept == true ||$row->isReject ==
                                                                           true ? 'revert' : 'reject'}}')">
                                                                    <i class="fa fa-{{$row->isAccept == true ||
                                                                    $row->isReject == true ? 'undo-alt' : 'ban'}} mr-2">
                                                                    </i>{{$row->isAccept == true ||
                                                                    $row->isReject == true ? 'Revert' : 'Reject'}}</a>
                                                            @endif
                                                            <a class="dropdown-item delete-data" href="{{route
                                                            ('delete.orders',['id' => encrypt($row->id)])}}">
                                                                <i class="fa fa-trash-alt mr-2"></i>Delete</a>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-primary text-uppercase"
                                                                onclick="updateOrder('{{$row->id}}', '{{$invoice}}',
                                                                        'confirm')" {{$row->isAbort == true ||
                                                                        $row->status_payment > 1 || $row->payment_id ==
                                                                        "" && $row->payment_proof == "" || now() >=
                                                                        \Carbon\Carbon::parse($row['start'])->subDays(2)
                                                                        ? 'disabled' : ''}}>
                                                            <strong><i class="fa fa-check-circle mr-2"></i>
                                                                @if($row->isAbort == true)
                                                                    Aborted
                                                                @else
                                                                    @if($row->status_payment > 1)
                                                                        Verified
                                                                    @else
                                                                        Verify
                                                                    @endif
                                                                @endif
                                                            </strong>
                                                        </button>
                                                        @if((now() >= \Carbon\Carbon::parse($row['start'])
                                                            ->subDays(2) && $row->status_payment < 1 &&
                                                            $row->isAbort == false) || now() < \Carbon\Carbon::parse
                                                            ($row['start']) ->subDays(2) &&
                                                            $row->status_payment >= 1 && $row->isAbort == false)
                                                            <button type="button"
                                                                    class="btn btn-primary dropdown-toggle"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false"></button>
                                                            <div class="dropdown-menu" aria-labelledby="option">
                                                                @if(now() >= \Carbon\Carbon::parse($row['start'])
                                                                ->subDays(2) && $row->status_payment < 1 &&
                                                                $row->isAbort == false)
                                                                    <a class="dropdown-item" href="javascript:void(0)"
                                                                       onclick="updateOrder('{{$row->id}}',
                                                                               '{{$invoice}}','abort')">
                                                                        <i class="fa fa-undo-alt mr-2"></i>Abort</a>
                                                                @elseif(now() < \Carbon\Carbon::parse($row['start'])
                                                                ->subDays(2) && $row->status_payment >= 1 &&
                                                                $row->isAbort == false)
                                                                    <a class="dropdown-item" href="javascript:void(0)"
                                                                       onclick="updateOrder('{{$row->id}}',
                                                                               '{{$invoice}}','revert_pay')">
                                                                        <i class="fa fa-undo-alt mr-2"></i>Revert</a>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <form method="post" id="form-order">
                                    {{csrf_field()}}
                                    <input type="hidden" name="order_ids">
                                    <input type="hidden" name="check_form">
                                    <input type="hidden" name="invoice">
                                    @if(Auth::guard('admin')->user()->isRoot())
                                        <input type="hidden" name="isAccept">
                                        <input type="hidden" name="isReject">
                                    @else
                                        <input type="hidden" name="isAbort">
                                        <input type="hidden" name="status_payment">
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="paymentProofModal" tabindex="-1" role="dialog" aria-labelledby="paymentProofModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg text-center" role="document">
            <img id="paymentProof" src="#" alt="Payment Proof" class="img-thumbnail">
        </div>
    </div>
@endsection
@push("scripts")
    <script src="{{asset('admins/modules/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('admins/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('admins/modules/datatables/Select-1.2.4/js/dataTables.select.min.js')}}"></script>
    <script src="{{asset('admins/modules/datatables/Buttons-1.5.6/js/buttons.dataTables.min.js')}}"></script>
    <script src="{{asset('admins/modules/jquery-ui/jquery-ui.min.js')}}"></script>
    <script>
        $(function () {
            var export_filename = 'Orders Table ({{now()->format('j F Y')}})', table = $("#dt-buttons").DataTable({
                dom: "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'B><'col-sm-12 col-md-4'f>>" +
                    "<'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                columnDefs: [
                    {sortable: false, targets: 4},
                    {targets: 1, visible: false, searchable: false}
                ],
                buttons: [
                    {
                        text: '<strong class="text-uppercase"><i class="far fa-clipboard mr-2"></i>Copy</strong>',
                        extend: 'copy',
                        exportOptions: {
                            columns: [0, 2, 3]
                        },
                        className: 'btn btn-warning assets-export-btn export-copy ttip'
                    }, {
                        text: '<strong class="text-uppercase"><i class="far fa-file-excel mr-2"></i>Excel</strong>',
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 2, 3]
                        },
                        className: 'btn btn-success assets-export-btn export-xls ttip',
                        title: export_filename,
                        extension: '.xls'
                    }, {
                        text: '<strong class="text-uppercase"><i class="fa fa-print mr-2"></i>Print</strong>',
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 2, 3]
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
                        $("#form-order input[name=order_ids]").val(ids);
                        $("#form-order").attr("action", "{{route('massDelete.orders')}}");

                        @if(Auth::guard('admin')->user()->isRoot())
                        if (ids.length > 0) {
                            swal({
                                title: 'Delete Orders',
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
                                    $("#form-order")[0].submit();
                                }
                            });
                        } else {
                            $("#cb-all").prop("checked", false).trigger('change');
                            swal("Error!", "There's no any selected record!", "error");
                        }
                        @else
                        swal('ATTENTION!', 'This feature only for ROOT.', 'warning');
                        @endif
                    });
                },
            });

            @if($find != "")
            $(".dataTables_filter input[type=search]").val('#{{$find}}').trigger('keyup');
            @endif
        });

        function paymentProofModal(asset) {
            $("#paymentProof").attr('src', asset);
            $("#paymentProofModal").modal('show');
        }

        function updateOrder(id, invoice, check) {
            if (check == 'accept') {
                swal({
                    title: 'Accept Order #' + invoice,
                    text: 'Are you sure to accept it? You won\'t be able to revert this!',
                    icon: 'warning',
                    dangerMode: true,
                    buttons: ['No', 'Yes'],
                    closeOnEsc: false,
                    closeOnClickOutside: false,
                }).then((confirm) => {
                    if (confirm) {
                        $("#form-order input[name=order_ids]").val(id);
                        $("#form-order input[name=check_form]").val('confirm_order');
                        $("#form-order input[name=invoice]").val(invoice);
                        $("#form-order input[name=isAccept]").val(1);
                        $("#form-order input[name=isReject]").val(0);
                        $("#form-order").attr("action", "{{route('update.orders')}}")[0].submit();
                    }
                });

            } else if (check == 'reject') {
                swal({
                    title: 'Reject Order #' + invoice,
                    text: 'Are you sure to reject it? You won\'t be able to revert this!',
                    icon: 'warning',
                    dangerMode: true,
                    buttons: ['No', 'Yes'],
                    closeOnEsc: false,
                    closeOnClickOutside: false,
                }).then((confirm) => {
                    if (confirm) {
                        $("#form-order input[name=order_ids]").val(id);
                        $("#form-order input[name=check_form]").val('confirm_order');
                        $("#form-order input[name=invoice]").val(invoice);
                        $("#form-order input[name=isAccept]").val(0);
                        $("#form-order input[name=isReject]").val(1);
                        $("#form-order").attr("action", "{{route('update.orders')}}")[0].submit();
                    }
                });

            } else if (check == 'revert') {
                swal({
                    title: 'Revert Order Confirmation #' + invoice,
                    text: 'By proceeding this action, you\'ll be asked to confirm this order again! ' +
                        'Are you sure to revert it?',
                    icon: 'warning',
                    dangerMode: true,
                    buttons: ['No', 'Yes'],
                    closeOnEsc: false,
                    closeOnClickOutside: false,
                }).then((confirm) => {
                    if (confirm) {
                        $("#form-order input[name=order_ids]").val(id);
                        $("#form-order input[name=check_form]").val('confirm_order');
                        $("#form-order input[name=invoice]").val(invoice);
                        $("#form-order input[name=isAccept]").val(0);
                        $("#form-order input[name=isReject]").val(0);
                        $("#form-order").attr("action", "{{route('update.orders')}}")[0].submit();
                    }
                });

            } else if (check == 'confirm') {
                swal({
                    title: 'Order Payment Confirmation #' + invoice,
                    text: 'Please verify this order payment whether its DP 30% or Fully Paid!',
                    icon: 'warning',
                    dangerMode: true,
                    buttons: {
                        cancel: "Cancel",
                        dp: {
                            text: "DP 30%",
                            value: "dp",
                        },
                        fp: {
                            text: "Fully Paid",
                            value: "fp",
                        },
                    },
                    closeOnEsc: false,
                    closeOnClickOutside: false,
                }).then((value) => {
                    if (value) {
                        $("#form-order input[name=order_ids]").val(id);
                        $("#form-order input[name=check_form]").val('confirm_payment');
                        $("#form-order input[name=invoice]").val(invoice);
                        $("#form-order input[name=isAbort]").val(0);
                        $("#form-order input[name=status_payment]").val(value == 'dp' ? 1 : 2);
                        $("#form-order").attr("action", "{{route('update.orders')}}")[0].submit();
                    }
                });
            } else if (check == 'abort') {
                swal({
                    title: 'Abort Order Payment #' + invoice,
                    text: 'Are you sure to abort it? You won\'t be able to revert this!',
                    icon: 'warning',
                    dangerMode: true,
                    buttons: ['No', 'Yes'],
                    closeOnEsc: false,
                    closeOnClickOutside: false,
                }).then((confirm) => {
                    if (confirm) {
                        $("#form-order input[name=order_ids]").val(id);
                        $("#form-order input[name=check_form]").val('confirm_payment');
                        $("#form-order input[name=invoice]").val(invoice);
                        $("#form-order input[name=isAbort]").val(1);
                        $("#form-order input[name=status_payment]").val(0);
                        $("#form-order").attr("action", "{{route('update.orders')}}")[0].submit();
                    }
                });

            } else if (check == 'revert_pay') {
                swal({
                    title: 'Revert Order Payment Confirmation #' + invoice,
                    text: 'By proceeding this action, you\'ll be asked to verify this order payment again! ' +
                        'Are you sure to revert it?',
                    icon: 'warning',
                    dangerMode: true,
                    buttons: ['No', 'Yes'],
                    closeOnEsc: false,
                    closeOnClickOutside: false,
                }).then((confirm) => {
                    if (confirm) {
                        $("#form-order input[name=order_ids]").val(id);
                        $("#form-order input[name=check_form]").val('confirm_payment');
                        $("#form-order input[name=invoice]").val(invoice);
                        $("#form-order input[name=isAbort]").val(0);
                        $("#form-order input[name=status_payment]").val(0);
                        $("#form-order").attr("action", "{{route('update.orders')}}")[0].submit();
                    }
                });
            }
        }
    </script>
@endpush