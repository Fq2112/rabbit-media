@extends('layouts.auth.mst_admin')
@section('title', 'The Rabbits: Orders Table | Rabbit Media – Digital Creative Service')
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
            <h1>Orders Table</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('home-admin')}}">Dashboard</a></div>
                <div class="breadcrumb-item">Data Transaction</div>
                <div class="breadcrumb-item">Clients</div>
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
                                                <a href="{{route('invoice.order',['id'=>encrypt($row->id)])}}">
                                                    <img class="img-fluid float-left mr-2" alt="icon" width="80"
                                                         src="{{asset('images/services/'.$plan->getJenisLayanan->icon)}}">
                                                    <strong>#{{$invoice}}</strong></a><br>
                                                <h6>{{$plan->paket}} (Rp{{number_format($price, 2,'.',',')}})</h6>
                                                <strong>{{$user->name}}</strong> / <a href="mailto:{{$user->email}}">
                                                    {{$user->email}}</a> / <a href="tel:{{$user->no_telp}}">
                                                    {{$user->no_telp}}</a>
                                                <hr class="mt-0 mb-1">
                                                <strong>Order Details</strong>
                                                <ul class="mb-0">
                                                    <li>
                                                        <strong data-toggle="tooltip" data-placement="left"
                                                                title="Title"><i class="fa fa-text-width mr-1"></i>
                                                            {{$row->judul}}</strong>
                                                    </li>
                                                    <li>
                                                        <strong data-toggle="tooltip" data-placement="left"
                                                                title="Booking Date"><i
                                                                    class="fa fa-calendar-day mr-1"></i>
                                                            {{$start}}</strong> &ndash; <strong>{{$end}}</strong>
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
                                                                    title="Total Item"><i class="fa fa-users mr-1"></i>
                                                                {{$row->qty}}</strong> items
                                                        </li>
                                                    @endif
                                                    @if($plan->isStudio == true)
                                                        <li>
                                                            <strong data-toggle="tooltip" data-placement="left"
                                                                    title="Studio"><i class="fa fa-door-open mr-1"></i>
                                                                {{$row->getStudio->nama}}</strong> ({{$row->getStudio
                                                            ->getJenisStudio->nama}})
                                                        </li>
                                                    @endif
                                                    <li>
                                                        <span data-toggle="tooltip" data-placement="left"
                                                              title="Meeting Location">
                                                            <i class="fa fa-map-marked-alt mr-1"></i>{{$row
                                                            ->meeting_location != "" ? $row->meeting_location : '(empty)'}}
                                                        </span>
                                                    </li>
                                                    <li>
                                                        <span data-toggle="tooltip" data-placement="left"
                                                              title="Additional Info">
                                                            <i class="fa fa-comments mr-1"></i>{{$row->deskripsi}}
                                                        </span>
                                                    </li>
                                                </ul>
                                                @if($row->payment_id != "")
                                                    <hr class="mt-0 mb-1"><strong>Payment Details</strong><br>
                                                    @if($row->payment_proof != "" &&
                                                    substr($row->payment_proof,0,18) != 'https://lorempixel')
                                                        <img class="img-thumbnail float-left mr-2" width="80"
                                                             src="{{asset('storage/users/payment/'.$row->payment_proof)}}"
                                                             style="cursor: pointer" onclick="paymentProofModal('{{asset
                                                             ('storage/users/payment/'.$row->payment_proof)}}')"
                                                             data-toggle="tooltip" title="Payment Proof" alt="Proof">
                                                    @elseif($row->payment_proof != "" &&
                                                    substr($row->payment_proof,0,18) == 'https://lorempixel')
                                                        <img class="img-thumbnail float-left mr-2" width="80"
                                                             src="{{$row->payment_proof}}" style="cursor: pointer"
                                                             onclick="paymentProofModal('{{$row->payment_proof}}')"
                                                             data-toggle="tooltip" title="Payment Proof" alt="Proof">
                                                    @else
                                                        <img class="img-thumbnail float-left mr-2" width="80"
                                                             alt="Proof" src="{{asset('admins/img/no_image.png')}}">
                                                    @endif
                                                    <ul>
                                                        <li style="list-style: none">
                                                            <strong data-toggle="tooltip" data-placement="right"
                                                                    title="Payment Type">
                                                                <i class="fa fa-handshake mr-1"></i>
                                                                {{$row->payment_type}}</strong>
                                                        </li>
                                                        <li style="list-style: none">
                                                            <strong data-toggle="tooltip" data-placement="right"
                                                                    title="Payment Method">
                                                                <i class="fa fa-wallet mr-1"></i>
                                                                {{$row->getPayment->name}}</strong>
                                                        </li>
                                                    </ul>
                                                @endif
                                            </td>
                                            <td style="vertical-align: middle;" align="center">
                                                @if($row->isAccept == false)
                                                    <span class="badge badge-primary">
                                                        <strong>Waiting for Confirmation</strong></span>
                                                @else
                                                    @if($row->status_payment == 0)
                                                        <span class="badge badge-danger">
                                                            <strong>Waiting for Payment</strong></span>
                                                    @elseif($row->status_payment == 1)
                                                        <span class="badge badge-warning"><strong>DP 30%</strong></span>
                                                    @else
                                                        <span class="badge badge-success"><strong>Fully Paid</strong></span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td style="vertical-align: middle" align="center">
                                                @if(Auth::guard('admin')->user()->isRoot())
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-primary"
                                                                onclick="">
                                                            <strong><i class="fa fa-user-edit mr-2"></i>EDIT</strong>
                                                        </button>
                                                        <button id="option" type="button"
                                                                class="btn btn-primary dropdown-toggle"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false"></button>
                                                        <div class="dropdown-menu" aria-labelledby="option">
                                                            <a class="dropdown-item" href="javascript:void(0)"
                                                               onclick="">
                                                                <i class="fas fa-info-circle mr-2"></i>Details</a>
                                                            <a class="dropdown-item" href="javascript:void(0)"
                                                               onclick="">
                                                                <i class="fa fa-user-cog mr-2"></i>Settings</a>
                                                            <a class="dropdown-item delete-data"
                                                               href="{{route('delete.orders',['id'=> encrypt($row->id)])}}">
                                                                <i class="fa fa-trash-alt mr-2"></i>Delete</a>
                                                        </div>
                                                    </div>
                                                @else
                                                    <button class="btn btn-info" data-toggle="tooltip" title="Details"
                                                            data-placement="left" onclick="">
                                                        <i class="fas fa-info-circle"></i>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <form method="post" id="form-order">
                                    {{csrf_field()}}
                                    <input id="order_ids" type="hidden" name="order_ids">
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
                    {"sortable": false, "targets": 4},
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
                    });
                },
            });

            @if($find != "")
            $(".dataTables_filter input[type=search]").val('{{$find}}').trigger('keyup');
            @endif
        });

        function paymentProofModal(asset) {
            $("#paymentProof").attr('src', asset);
            $("#paymentProofModal").modal('show');
        }
    </script>
@endpush