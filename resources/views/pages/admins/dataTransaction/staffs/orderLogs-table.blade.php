@extends('layouts.auth.mst_admin')
@section('title', 'The Rabbits: Order Logs Table | Rabbit Media – Digital Creative Service')
@push('styles')
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/datatables.min.css')}}">
    <link rel="stylesheet"
          href="{{asset('admins/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Buttons-1.5.6/css/buttons.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/chocolat/dist/css/chocolat.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/bootstrap-social/bootstrap-social.css')}}">
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

        .btn-instagram {
            background-color: #C13584;
        }

        .btn-instagram:focus, .btn-instagram.focus {
            background-color: #a52f6e;
        }

        .btn-instagram:hover {
            background-color: #a52f6e;
        }

        .btn-instagram:active, .btn-instagram.active, .open > .dropdown-toggle.btn-instagram {
            background-color: #a52f6e;
        }

        .btn-instagram:active:hover, .btn-instagram.active:hover, .open > .dropdown-toggle.btn-instagram:hover, .btn-instagram:active:focus, .btn-instagram.active:focus, .open > .dropdown-toggle.btn-instagram:focus, .btn-instagram:active.focus, .btn-instagram.active.focus, .open > .dropdown-toggle.btn-instagram.focus {
            background-color: #872a55;
        }

        .btn-instagram.disabled:hover, .btn-instagram[disabled]:hover, fieldset[disabled] .btn-instagram:hover, .btn-instagram.disabled:focus, .btn-instagram[disabled]:focus, fieldset[disabled] .btn-instagram:focus, .btn-instagram.disabled.focus, .btn-instagram[disabled].focus, fieldset[disabled] .btn-instagram.focus {
            background-color: #C13584;
        }

        .btn-instagram .badge {
            color: #C13584;
        }

        .btn-whatsapp {
            color: #fff;
            background-color: #25d366;
            border-color: rgba(0, 0, 0, 0.2)
        }

        .btn-whatsapp:focus, .btn-whatsapp.focus {
            color: #fff;
            background-color: #20af57;
            border-color: rgba(0, 0, 0, 0.2)
        }

        .btn-whatsapp:hover {
            color: #fff;
            background-color: #20af57;
            border-color: rgba(0, 0, 0, 0.2)
        }

        .btn-whatsapp:active, .btn-whatsapp.active, .open > .dropdown-toggle.btn-whatsapp {
            color: #fff;
            background-color: #20af57;
            border-color: rgba(0, 0, 0, 0.2)
        }

        .btn-whatsapp:active:hover, .btn-whatsapp.active:hover, .open > .dropdown-toggle.btn-whatsapp:hover, .btn-whatsapp:active:focus, .btn-whatsapp.active:focus, .open > .dropdown-toggle.btn-whatsapp:focus, .btn-whatsapp:active.focus, .btn-whatsapp.active.focus, .open > .dropdown-toggle.btn-whatsapp.focus {
            color: #fff;
            background-color: #16873c;
            border-color: rgba(0, 0, 0, 0.2)
        }

        .btn-whatsapp:active, .btn-whatsapp.active, .open > .dropdown-toggle.btn-whatsapp {
            background-image: none
        }

        .btn-whatsapp.disabled:hover, .btn-whatsapp[disabled]:hover, fieldset[disabled] .btn-whatsapp:hover, .btn-whatsapp.disabled:focus, .btn-whatsapp[disabled]:focus, fieldset[disabled] .btn-whatsapp:focus, .btn-whatsapp.disabled.focus, .btn-whatsapp[disabled].focus, fieldset[disabled] .btn-whatsapp.focus {
            background-color: #25d366;
            border-color: rgba(0, 0, 0, 0.2)
        }

        .btn-whatsapp .badge {
            color: #25d366;
            background-color: #fff
        }
    </style>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Order Logs Table</h1>
            <div class="section-header-breadcrumb">
                @if(Auth::guard('admin')->user()->isRoot())
                    <div class="breadcrumb-item active"><a href="{{route('home-admin')}}">Dashboard</a></div>
                    <div class="breadcrumb-item">Data Transaction</div>
                    <div class="breadcrumb-item"><a href="{{route('table.admins')}}">Staffs</a></div>
                @else
                    <div class="breadcrumb-item active">Dashboard</div>
                    <div class="breadcrumb-item">Data Transaction</div>
                    <div class="breadcrumb-item">Staffs</div>
                @endif
                <div class="breadcrumb-item">Order Logs</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-form">
                                <button onclick="createLog()" class="btn btn-primary text-uppercase">
                                    <strong><i class="fas fa-plus mr-2"></i>Create</strong>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="dt-buttons">
                                    <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Details</th>
                                        <th class="text-center">Status</th>
                                        <th>Author</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $no = 1; @endphp
                                    @foreach($logs as $row)
                                        @php
                                            $order = $row->getPemesanan;
                                            $plan = $order->getLayanan;
                                            $romanDate = \App\Support\RomanConverter::numberToRoman($order->created_at
                                            ->format('y')).'/'.\App\Support\RomanConverter::numberToRoman($order
                                            ->created_at->format('m'));
                                            $invoice = 'INV/'.$order->created_at->format('Ymd').'/'.$romanDate.'/'.$order->id;
                                            $admin = $row->getAdmin;
                                            $created_at = \Carbon\Carbon::parse($admin->created_at)->format('j F Y');
                                            $updated_at = \Carbon\Carbon::parse($admin->updated_at)->diffForHumans();
                                            $total_order = $admin->getOrderLog != null ? $admin->getOrderLog->count() : 0;
                                        @endphp
                                        <tr>
                                            <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                            <td style="vertical-align: middle">
                                                <div class="row {{$row->getOrderRevision->count() > 0 ? 'mb-1' : ''}}"
                                                     style="border-bottom: {{$row->getOrderRevision->count() > 0 ?
                                                     '1px solid #eee' : 'none'}}">
                                                    <div class="col">
                                                        <a href="{{route('invoice.order',['id'=>encrypt($order->id)])}}">
                                                            <strong>#{{$invoice}}</strong></a>
                                                        <p class="mb-0">{{$row->deskripsi}}</p>
                                                        <ul class="m-0">
                                                            <li><strong class="text-uppercase">Attachments</strong></li>
                                                            <li style="list-style: none">
                                                                <div class="use-choc" data-chocolat-title="Attachments">
                                                                    @if($row->files != "")
                                                                        @foreach($row->files as $file)
                                                                            @php
                                                                                $asset = $file == 'nature_big_1.jpg' ||
                                                                                $file == 'nature_big_2.jpg' ||
                                                                                $file == 'nature_big_3.jpg' ||
                                                                                $file == 'nature_big_4.jpg' ||
                                                                                $file == 'nature_big_5.jpg' ?
                                                                                asset('images/big-images/'.$file) :
                                                                                asset('storage/order-logs/'.$file)
                                                                            @endphp
                                                                            <a class="chocolat-image mr-2"
                                                                               href="{{$asset}}">
                                                                                <img class="img-thumbnail" width="64"
                                                                                     src="{{$asset}}"></a>
                                                                        @endforeach
                                                                    @else
                                                                        (empty)
                                                                    @endif
                                                                </div>
                                                            </li>
                                                            <li><strong class="text-uppercase">Link</strong></li>
                                                            <li style="list-style: none">
                                                                @if($row->link != "")
                                                                    <a href="{{$row->link}}" target="_blank">
                                                                        {{$row->link}}</a>
                                                                @else
                                                                    (empty)
                                                                @endif
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                @if($row->getOrderRevision->count() > 0)
                                                    <div class="row">
                                                        <div class="col">
                                                            @foreach($row->getOrderRevision as $i => $rev)
                                                                @php $i = $i + 1 @endphp
                                                                <strong>Rev #{{$i}}</strong>
                                                                {!! $rev->deskripsi !!}
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                            <td style="vertical-align: middle" align="center">
                                                @if ($row->isComplete == true)
                                                    <span class="badge badge-success text-uppercase">
                                                        <strong>Completed</strong></span>
                                                @else
                                                    @if ($row->isReady == false)
                                                        <span class="badge badge-info text-uppercase">
                                                            <strong>In Progress</strong></span>
                                                    @else
                                                        <span class="badge badge-primary">Revision Chance: <strong>{{2 -
                                                        $row->getOrderRevision->count()}}</strong>x</span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td style="vertical-align: middle" align="center">
                                                <a href="javascript:void(0)" onclick="openProfile('{{$admin->id}}',
                                                        '{{$admin->ava}}','{{$admin->email}}','{{$admin->name}}',
                                                        '{{$admin->jabatan}}','{{$admin->role}}','{{$admin->deskripsi}}',
                                                        '{{$admin->facebook}}','{{$admin->twitter}}',
                                                        '{{$admin->instagram}}','{{$admin->whatsapp}}','{{$created_at}}',
                                                        '{{$updated_at}}','{{$total_order}}')" data-toggle="tooltip"
                                                   title="View Profile">{{$admin->name}}</a>
                                            </td>
                                            <td style="vertical-align: middle" align="center">
                                                <button data-toggle="tooltip" title="Edit"
                                                        type="button" class="btn btn-warning" onclick="editLog
                                                        ('{{$row->id}}','{{$row->pemesanan_id}}','{{$invoice}}',
                                                        '{{$row->deskripsi}}','{{$row->link}}','{{$row->isReady}}',
                                                        '{{$row->isComplete}}','{{encrypt($row->pemesanan_id)}}',
                                                        '{{$row->files != "" ? implode(",",$row->files) : null}}',
                                                        '{{$row->files != "" ? count($row->files) : 0}}')">
                                                    <i class="fa fa-edit"></i></button>
                                                @if($row->isComplete == false)
                                                    <hr class="mt-1 mb-1">
                                                    <a href="{{route('delete.order-logs',['id'=>encrypt($row->id)])}}"
                                                       class="btn btn-danger delete-data" data-toggle="tooltip"
                                                       data-placement="bottom" title="Delete">
                                                        <i class="fas fa-trash-alt"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <form method="post" id="form-mass">
                                    {{csrf_field()}}
                                    <input type="hidden" name="log_ids">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="logModal" tabindex="-1" role="dialog" aria-labelledby="logModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Order Log Setup</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-log" method="post" action="{{route('create.order-logs')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="hidden" name="_method">
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="row form-group" id="div_order">
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
                        <div class="row form-group has-feedback">
                            <div class="col">
                                <label for="deskripsi">Description</label>
                                <textarea id="deskripsi" type="text" name="deskripsi" class="form-control"
                                          placeholder="Describe it here&hellip;" required></textarea>
                                <span class="glyphicon glyphicon-text-height form-control-feedback"></span>
                            </div>
                            <div class="col-3">
                                <label for="isReady">Ready to be Revised?</label><br>
                                <div class="custom-control custom-radio custom-control-inline" id="isPack">
                                    <input type="radio" class="custom-control-input" id="not_yet" name="isReady"
                                           value="0" required>
                                    <label class="custom-control-label" for="not_yet">NOT YET</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" id="ready" name="isReady"
                                           value="1">
                                    <label class="custom-control-label" for="ready">READY</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="files">Attachments <sub>(optional)</sub></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-image"></i></span>
                                    </div>
                                    <div class="custom-file" data-toggle="tooltip"
                                         title="Allowed extension: jpg, jpeg, gif, png. Allowed size: < 5 MB">
                                        <input type="file" name="files[]" class="custom-file-input" id="files"
                                               accept="image/*" multiple>
                                        <label class="custom-file-label" id="txt_file">Choose Files</label>
                                    </div>
                                </div>
                                <div class="form-text text-muted" id="count_files" style="display: none"></div>
                            </div>
                            <div class="col">
                                <label for="link">Link <sub>(optional)</sub></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-globe"></i></span>
                                    </div>
                                    <input id="link" type="text" name="link" class="form-control"
                                           placeholder="If there's any link, write it here&hellip;">
                                </div>
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

    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="card profile-widget">
                                <div class="profile-widget-header">
                                    <img id="avatar" alt="avatar" src="#" class="rounded-circle profile-widget-picture">
                                    <div class="profile-widget-items">
                                        <div class="profile-widget-item">
                                            <div class="profile-widget-item-label">Orders</div>
                                            <div class="profile-widget-item-value" id="orders" data-toggle="tooltip"
                                                 title="Order Managed" data-placement="bottom"></div>
                                        </div>
                                        <div class="profile-widget-item">
                                            <div class="profile-widget-item-label">Member Since</div>
                                            <div class="profile-widget-item-value" id="create"></div>
                                        </div>
                                        <div class="profile-widget-item">
                                            <div class="profile-widget-item-label">Last Update</div>
                                            <div class="profile-widget-item-value" id="update"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="profile-widget-description"></div>
                                <div class="card-footer pt-0">
                                    <div class="font-weight-bold mb-2" id="socmed_title"></div>
                                    <a href="#" class="btn btn-social-icon btn-google">
                                        <i class="fas fa-envelope"></i>
                                    </a>
                                    <a href="#" class="btn btn-social-icon btn-facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="#" class="btn btn-social-icon btn-twitter">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="#" class="btn btn-social-icon btn-instagram">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                    <a href="#" class="btn btn-social-icon btn-whatsapp">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
    <script src="{{asset('admins/modules/chocolat/dist/js/jquery.chocolat.min.js')}}"></script>
    <script>
        $(function () {
            var export_filename = 'Order Logs Table ({{now()->format('j F Y')}})';
            $("#dt-buttons").DataTable({
                dom: "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'B><'col-sm-12 col-md-4'f>>" +
                    "<'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                columnDefs: [
                    {sortable: false, targets: 4},
                ],
                buttons: [
                    {
                        text: '<strong class="text-uppercase"><i class="far fa-file-pdf mr-2"></i>PDF</strong>',
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        },
                        className: 'btn btn-danger assets-export-btn export-pdf ttip',
                        title: export_filename,
                        extension: '.pdf'
                    }, {
                        text: '<strong class="text-uppercase"><i class="far fa-clipboard mr-2"></i>Copy</strong>',
                        extend: 'copy',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        },
                        className: 'btn btn-warning assets-export-btn export-copy ttip'
                    }, {
                        text: '<strong class="text-uppercase"><i class="far fa-file-excel mr-2"></i>Excel</strong>',
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        },
                        className: 'btn btn-success assets-export-btn export-xls ttip',
                        title: export_filename,
                        extension: '.xls'
                    }, {
                        text: '<strong class="text-uppercase"><i class="fa fa-print mr-2"></i>Print</strong>',
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        },
                        className: 'btn btn-info assets-select-btn export-print'
                    }
                ],
                fnDrawCallback: function (oSettings) {
                    $('.use-nicescroll').getNiceScroll().resize();
                    $('[data-toggle="tooltip"]').tooltip();
                    $(".use-choc").Chocolat();
                },
            });

            @if($find != "")
            createLog();
            $(".fix-label-group .bootstrap-select").addClass('p-0');
            $(".fix-label-group .bootstrap-select button").css('border-color', '#e4e6fc');
            $("#div_order").show();
            $("#pemesanan_id").val('{{$find}}').prop('disabled', false).selectpicker('refresh');
            $("#invoice_details").attr('href', '{{route('invoice.order',['id' => encrypt($find)])}}').parent().show();
            @endif
        });

        function createLog() {
            @if(count($orders) > 0)
            $(".fix-label-group .bootstrap-select").addClass('p-0');
            $(".fix-label-group .bootstrap-select button").css('border-color', '#e4e6fc');

            $("#logModal .modal-title").text('Order Log Setup');
            $("#form-log").attr('action', '{{route('create.order-logs')}}');
            $("#form-log button[type=submit] strong").text('Submit');
            $("#form-log input[name=_method], #form-log input[name=id], #files, #link, #deskripsi").val('');
            $("#not_yet, #ready").prop('checked', false).trigger('change');
            $("#div_order").show();
            $("#pemesanan_id").val('').prop('disabled', false).selectpicker('refresh');
            $("#invoice_details").attr('href', '#').parent().hide();
            $("#txt_file").text('Choose Files');
            $("#count_files").html('').hide();

            $("#logModal").modal('show');
            @else
            swal('ATTENTION!', 'There seems to be no order that needs to be set its log.', 'warning');
            @endif
        }

        function editLog(id, pemesanan_id, invoice, deskripsi, link, isReady, isComplete, encryptID, names, count) {
            $(".fix-label-group .bootstrap-select").addClass('p-0');
            $(".fix-label-group .bootstrap-select button").css('border-color', '#e4e6fc');

            $("#logModal .modal-title").html('Edit Log #<strong>' + invoice + '</strong>');
            $("#form-log").attr('action', '{{route('update.order-logs')}}');
            $("#form-log input[name=_method]").val('PUT');
            $("#form-log input[name=id]").val(id);
            $("#form-log button[type=submit] strong").text('Submit');
            $("#div_order").hide();
            $("#pemesanan_id").val('').prop('disabled', true).selectpicker('refresh');
            $("#not_yet").prop('checked', isReady == 1 ? false : true).trigger('change');
            $("#ready").prop('checked', isReady == 1 ? true : false).trigger('change');
            $("#link").val(link);
            $("#deskripsi").val(deskripsi);

            $("#invoice_details").attr('href', '{{route('invoice.order',['id' => ''])}}/' + encryptID).parent().show();

            if (count > 0) {
                $("#txt_file").text(names.length > 30 ? names.slice(0, 30) + "..." : names);
                $("#count_files").html(count > 1 ? "<strong>" + count + "</strong> files selected" :
                    "<strong>" + count + "</strong> file selected").show();
            } else {
                $("#txt_file").text('Choose Files');
                $("#count_files").html('').hide();
            }

            $("#logModal").modal('show');
        }

        $("#pemesanan_id").on('change', function () {
            $("#invoice_details").attr('href', '#').parent().hide();

            $.get('{{route('get.orders', ['id' => ''])}}/' + $(this).val(), function (data) {
                $("#invoice_details").attr('href', data).parent().show();
            });
        });

        $("#files").on('change', function () {
            var files = $(this).prop("files"), count = $(this).get(0).files.length,
                names = $.map(files, function (val) {
                    return val.name;
                }), text = names.join();

            $("#txt_file").text(text.length > 30 ? text.slice(0, 30) + "..." : text);
            $("#count_files").html(count > 1 ? "<strong>" + count + "</strong> files selected" :
                "<strong>" + count + "</strong> file selected").show();
        });

        function openProfile(id, ava, email, name, jabatan, role, deskripsi, facebook, twitter, instagram, whatsapp,
                             create, update, orders) {
            var $path = ava == "" ? '{{asset('images/avatar.png')}}' : '{{asset('storage/admins/ava/')}}/' + ava,
                $desc = deskripsi != "" ? deskripsi : '(empty)', $orders = orders > 999 ? '999+' : orders,
                $fb = facebook != "" ? 'https://fb.com/' + facebook : '#',
                $tw = twitter != "" ? 'https://twitter.com/' + twitter : '#',
                $ig = instagram != "" ? 'https://instagram.com/' + instagram : '#',
                $wa = whatsapp != "" ?
                    'https://web.whatsapp.com/send?text=Halo, ' + name + '!&phone=' + whatsapp + '&abid=' + whatsapp : '#';

            $("#detailModal .modal-title").text(name.split(/\s+/).slice(0, 1).join(" ") + "'s Profile");
            $("#avatar").attr('src', $path);
            $("#orders").text($orders);
            $("#create").text(create);
            $("#update").text(update);

            $(".profile-widget-description").html(
                '<div class="profile-widget-name">' + name + ' ' +
                '<div class="text-muted d-inline font-weight-normal text-uppercase">' +
                '<div class="slash"></div> <strong>' + jabatan + '</strong>' +
                '<div class="slash"></div> ' + role + '</div></div>' + $desc
            );

            $("#socmed_title").text('Follow ' + name.split(/\s+/).slice(0, 1).join(" ") + ' On');
            $(".btn-google").attr('href', 'mailto:' + email);
            $(".btn-facebook").attr('href', $fb);
            $(".btn-twitter").attr('href', $tw);
            $(".btn-instagram").attr('href', $ig);
            $(".btn-whatsapp").attr('href', $wa);

            $("#detailModal").modal('show');
        }
    </script>
@endpush