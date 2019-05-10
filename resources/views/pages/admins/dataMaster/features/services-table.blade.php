@extends('layouts.auth.mst_admin')
@section('title', 'The Rabbits: Services Table | Rabbit Media – Digital Creative Service')
@push('styles')
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/datatables.min.css')}}">
    <link rel="stylesheet"
          href="{{asset('admins/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Buttons-1.5.6/css/buttons.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/summernote/summernote-bs4.css')}}">
    <style>
        .price-before-disc {
            text-decoration: line-through;
            font-size: 15px;
            color: #ddd
        }

        .discount {
            font-size: 13px;
            color: #592f83;
        }
    </style>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Services Table</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('home-admin')}}">Dashboard</a></div>
                <div class="breadcrumb-item">Data Master</div>
                <div class="breadcrumb-item">Features</div>
                <div class="breadcrumb-item">Services</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-form">
                                <button id="btn_create" onclick="createService()"
                                        class="btn btn-primary text-uppercase">
                                    <strong><i class="fas fa-plus mr-2"></i>Create</strong>
                                </button>
                                <button id="btn_back" onclick="createService()" class="btn btn-primary text-uppercase"
                                        style="display: none">
                                    <strong><i class="fa fa-chevron-left mr-2"></i>Back</strong>
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
                                        <th>Benefits</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $no = 1; @endphp
                                    @foreach($services as $row)
                                        <tr>
                                            <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                            <td style="vertical-align: middle">
                                                <a href="{{route('show.service.pricing', ['jenis' => strtolower
                                                (str_replace(' ', '-',$row->getJenisLayanan->nama)),
                                                'id' => encrypt($row->getJenisLayanan->id)])}}" target="_blank">
                                                    <img class="img-fluid float-left mr-2" alt="icon" width="100"
                                                         src="{{asset('images/services/'.$row->getJenisLayanan->icon)}}">
                                                    <strong>{{$row->getJenisLayanan->nama}} &ndash; {{$row->paket}}
                                                    </strong></a><br>
                                                <span class="price-before-disc">
                                                    Rp{{number_format($row->harga,2,',','.')}}</span>
                                                <h6 class="m-0 p-0">Rp{{number_format($row->harga - ($row->harga *
                                                $row->diskon/100),2,',','.')}}</h6>
                                                <strong class="discount">Save {{$row->diskon}}%</strong>
                                            </td>
                                            <td style="vertical-align: middle;text-transform: capitalize">
                                                @if($row->isQty == true || $row->isHours == true || $row->isStudio == true)
                                                    <ul>
                                                        @if($row->isStudio == true)
                                                            <li><strong>Studio opsional</strong></li>
                                                        @endif
                                                        @if($row->isHours == true)
                                                            <li>Durasi max. <strong>{{$row->hours}}</strong>
                                                                jam (over time <strong>+Rp{{number_format($row
                                                                ->price_per_hours,0, ',', '.')}}/jam</strong>)
                                                            </li>
                                                        @endif
                                                        @if($row->isQty == true)
                                                            <li>Total item (orang/produk) max.
                                                                <strong>{{$row->qty}}</strong> item (over item
                                                                <strong>+Rp{{number_format($row
                                                                ->price_per_qty,0,',', '.')}}/item</strong>)
                                                            </li>
                                                        @endif
                                                    </ul>
                                                @endif
                                                {!! $row->keuntungan !!}
                                                <ul>
                                                    @if($row->isStudio == true)
                                                        <li>Harga belum termasuk studio</li>
                                                    @endif
                                                </ul>
                                            </td>
                                            <td style="vertical-align: middle" align="center">
                                                <button data-placement="top" data-toggle="tooltip" title="Edit"
                                                        type="button" class="btn btn-warning" onclick="editService
                                                        ('{{$row->id}}','{{$row->jenis_id}}','{{$row->paket}}',
                                                        '{{$row->harga}}','{{$row->diskon}}','{{$row->isHours}}',
                                                        '{{$row->hours}}','{{$row->price_per_hours}}',
                                                        '{{$row->isQty}}','{{$row->qty}}','{{$row->price_per_qty}}',
                                                        '{{$row->isStudio}}','{{$row->keuntungan}}')">
                                                    <i class="fa fa-edit"></i></button>
                                                <hr class="mt-1 mb-1">
                                                <a href="{{route('delete.services', ['id' => encrypt($row->id)])}}"
                                                   class="btn btn-danger delete-data" data-toggle="tooltip"
                                                   title="Delete" data-placement="bottom">
                                                    <i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <form id="form-service" method="post" action="{{route('create.services')}}"
                                  style="display: none">
                                {{csrf_field()}}
                                <input type="hidden" name="_method">
                                <input type="hidden" name="id">
                                <div class="row form-group">
                                    <div class="col-4 fix-label-group">
                                        <label for="jenis_id">Type</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                        <span class="input-group-text fix-label-item" style="height: 2.25rem">
                                            <i class="fab fa-font-awesome-flag"></i></span>
                                            </div>
                                            <select id="jenis_id" class="form-control selectpicker" title="-- Choose --"
                                                    name="jenis_id" data-live-search="true" required>
                                                @foreach(\App\Models\JenisLayanan::orderBy('nama')->get() as $type)
                                                    <option value="{{$type->id}}">{{$type->nama}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="paket">Package Name</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-thumbtack"></i></span>
                                            </div>
                                            <input id="paket" type="text" class="form-control" name="paket"
                                                   placeholder="Write the service pack name here&hellip;" required>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <label for="isStudio">Custom Studio</label><br>
                                        <div class="custom-control custom-radio custom-control-inline" id="isStudio">
                                            <input type="radio" class="custom-control-input" id="unavailable"
                                                   name="isStudio" value="0" checked>
                                            <label class="custom-control-label" for="unavailable">Unavailable</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" class="custom-control-input" id="available"
                                                   name="isStudio" value="1">
                                            <label class="custom-control-label" for="available">Available</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col">
                                        <label for="harga">Price</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><strong>Rp</strong></span>
                                            </div>
                                            <input id="harga" type="text" class="form-control rupiah" name="harga"
                                                   placeholder="0" min="0" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="fa fa-money-bill-wave"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label for="diskon">Discount</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><strong>%</strong></span>
                                            </div>
                                            <input id="diskon" type="number" class="form-control" name="diskon"
                                                   placeholder="0" min="0" max="100" required>
                                            <input id="new_price" type="text" class="form-control rupiah"
                                                   placeholder="0" readonly>
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="fa fa-money-bill-wave"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col">
                                        <label for="hours">Total Duration (hours) & Price/hours (IDR)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input id="cb-hours" type="checkbox" name="isHours" value="1"
                                                           aria-label="Checkbox for following text input">
                                                </div>
                                            </div>
                                            <input id="hours" name="hours" type="number" class="form-control"
                                                   placeholder="0" min="0" disabled>
                                            <input id="price_per_hours" name="price_per_hours" type="text"
                                                   class="form-control rupiah" placeholder="0" min="0" disabled>
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-stopwatch"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col">
                                        <label for="qty">Total Item (product/person) & Price/item (IDR)</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input id="cb-qty" type="checkbox" name="isQty" value="1"
                                                           aria-label="Checkbox for following text input">
                                                </div>
                                            </div>
                                            <input id="qty" name="qty" type="number" class="form-control"
                                                   placeholder="0" min="0" disabled>
                                            <input id="price_per_qty" name="price_per_qty" type="text"
                                                   class="form-control rupiah" placeholder="0" min="0" disabled>
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-users"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <label for="keuntungan">Benefits</label>
                                        <textarea id="keuntungan" class="form-control" name="keuntungan"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <button type="submit" class="btn btn-primary btn-block text-uppercase">
                                            <strong>Submit</strong></button>
                                    </div>
                                </div>
                            </form>
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
    <script src="{{asset('admins/modules/summernote/summernote-bs4.js')}}"></script>
    <script src="{{asset('admins/modules/jquery.maskMoney.js')}}"></script>
    <script>
        var price = 0, discount = 0, new_price = 0;

        $(function () {
            var export_filename = 'Services Table ({{now()->format('j F Y')}})';
            $("#dt-buttons").DataTable({
                dom: "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'B><'col-sm-12 col-md-4'f>>" +
                    "<'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                columnDefs: [
                    {"sortable": false, "targets": 3}
                ],
                buttons: [
                    {
                        text: '<i class="far fa-clipboard mr-2"></i>Copy',
                        extend: 'copy',
                        exportOptions: {
                            columns: [0, 1, 2]
                        },
                        className: 'btn btn-primary assets-export-btn export-copy ttip'
                    }, {
                        text: '<i class="fa fa-file-csv mr-2"></i>CSV',
                        extend: 'csv',
                        exportOptions: {
                            columns: [0, 1, 2]
                        },
                        className: 'btn btn-primary assets-export-btn export-csv ttip',
                        title: export_filename,
                        extension: '.csv'
                    }, {
                        text: '<i class="far fa-file-excel mr-2"></i>Excel',
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2]
                        },
                        className: 'btn btn-primary assets-export-btn export-xls ttip',
                        title: export_filename,
                        extension: '.xls'
                    }, {
                        text: '<i class="far fa-file-pdf mr-2"></i>PDF',
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2]
                        },
                        className: 'btn btn-primary assets-export-btn export-pdf ttip',
                        title: export_filename,
                        extension: '.pdf'
                    }, {
                        text: '<i class="fa fa-print mr-2"></i>Print',
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1, 2]
                        },
                        className: 'btn btn-primary assets-select-btn export-print'
                    }
                ],
                fnDrawCallback: function (oSettings) {
                    $('.use-nicescroll').getNiceScroll().resize();
                    $("#dt-buttons_wrapper ul").addClass('m-0');
                    $('[data-toggle="tooltip"]').tooltip();
                },
            });

            $(".rupiah").maskMoney({thousands: '.', decimal: ',', precision: '0'});

            $("#keuntungan").summernote({
                dialogsInBody: true,
                minHeight: 300,
            });
        });

        function createService() {
            $(".table-responsive").toggle(300);
            $("#btn_create").toggle(300);
            $("#btn_back").toggle(300);
            $(".fix-label-group .bootstrap-select").addClass('p-0');
            $(".fix-label-group .bootstrap-select button").css('border-color', '#e4e6fc');

            $("#form-service").attr('action', '{{route('create.services')}}').toggle(300);
            $("#form-service input[name=_method]").val('');
            $("#form-service input[name=id]").val('');
            $("#form-service button[type=submit] strong").text('Submit');
            $("#jenis_id").val('').selectpicker('refresh');
            $("#paket, #harga, #diskon, #new_price, #hours, #price_per_hours, #qty, #price_per_qty").val('');
            $("#unavailable").prop('checked', true).trigger('change');
            $("#available, #cb-hours, #cb-qty").prop('checked', false).trigger('change');
            $("#keuntungan").summernote('code', '');
        }

        function editService(id, jenis_id, paket, harga, diskon, isHours, hours, price_per_hours,
                             isQty, qty, price_per_qty, isStudio, keuntungan) {
            $(".table-responsive").hide('slide');
            $("#btn_create").hide('slide');
            $("#btn_back").show('slide');
            $(".fix-label-group .bootstrap-select").addClass('p-0');
            $(".fix-label-group .bootstrap-select button").css('border-color', '#e4e6fc');

            $("#form-service").attr('action', '{{route('update.services')}}').show('slide');
            $("#form-service input[name=_method]").val('PUT');
            $("#form-service input[name=id]").val(id);
            $("#form-service button[type=submit] strong").text('Save Changes');
            $("#jenis_id").val(jenis_id).selectpicker('refresh');
            $("#paket").val(paket);
            $("#harga").val(thousandSeparator(harga));
            $("#diskon").val(diskon);
            $("#new_price").val(thousandSeparator(parseInt(harga) - (parseInt(harga * diskon / 100))));

            $("#cb-hours").prop('checked', isHours == true ? true : false).trigger('change');
            $("#hours").val(hours).prop('disabled', isHours == true ? false : true);
            $("#price_per_hours").val(thousandSeparator(price_per_hours)).prop('disabled', isHours == true ? false : true);

            $("#cb-qty").prop('checked', isQty == true ? true : false).trigger('change');
            $("#qty").val(qty).prop('disabled', isQty == true ? false : true);
            $("#price_per_qty").val(thousandSeparator(price_per_qty)).prop('disabled', isQty == true ? false : true);

            $("#available").prop('checked', isStudio == true ? true : false).trigger('change');
            $("#unavailable").prop('checked', isStudio == true ? false : true).trigger('change');

            $("#keuntungan").summernote('code', keuntungan);
        }

        $('#harga').on('keyup', function () {
            var val = $(this).val().split('.').join("");
            if (val == "" || parseInt(val) <= 0) {
                $(this).val(0);
            }
            price = val;
            new_price = parseInt(price) - (parseInt(price * discount / 100));
            $("#new_price").val(thousandSeparator(new_price));
        });

        $('#diskon').on('keyup', function () {
            if ($(this).val() == "" || parseInt($(this).val()) <= 0) {
                $(this).val(0);
            } else if (parseInt($(this).val()) > 100) {
                $(this).val(100);
            }
            discount = $(this).val();
            new_price = parseInt(price) - (parseInt(price * discount / 100));
            $("#new_price").val(thousandSeparator(new_price));
        });

        $("#cb-hours").on('click', function () {
            if ($(this).is(':checked')) {
                $("#hours, #price_per_hours").prop('disabled', false).prop('required', true);
            } else {
                $("#hours, #price_per_hours").prop('disabled', true).prop('required', false);
            }
        });

        $("#hours").on("keyup", function () {
            if ($(this).val() == "" || parseInt($(this).val()) <= 0) {
                $(this).val(0);
            }
        });

        $("#price_per_hours").on("keyup", function () {
            var val = $(this).val().split('.').join("");
            if (val == "" || parseInt(val) <= 0) {
                $(this).val(0);
            }
        });

        $("#cb-qty").on('click', function () {
            if ($(this).is(':checked')) {
                $("#qty, #price_per_qty").prop('disabled', false).prop('required', true);
            } else {
                $("#qty, #price_per_qty").prop('disabled', true).prop('required', false);
            }
        });

        $("#qty").on("keyup", function () {
            if ($(this).val() == "" || parseInt($(this).val()) <= 0) {
                $(this).val(0);
            }
        });

        $("#price_per_qty").on("keyup", function () {
            var val = $(this).val().split('.').join("");
            if (val == "" || parseInt(val) <= 0) {
                $(this).val(0);
            }
        });

        $("#form-service").on('submit', function (e) {
            e.preventDefault();
            if ($("#keuntungan").summernote('isEmpty')) {
                swal('ATTENTION!', 'Please, write something about its benefit!', 'warning');
            } else {
                $(this)[0].submit();
            }
        });

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