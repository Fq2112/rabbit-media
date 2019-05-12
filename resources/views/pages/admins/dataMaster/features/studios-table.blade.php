@extends('layouts.auth.mst_admin')
@section('title', 'The Rabbits: Studios Table | Rabbit Media – Digital Creative Service')
@push('styles')
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/datatables.min.css')}}">
    <link rel="stylesheet"
          href="{{asset('admins/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Buttons-1.5.6/css/buttons.dataTables.min.css')}}">
    <style>
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
            <h1>Studios Table</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('home-admin')}}">Dashboard</a></div>
                <div class="breadcrumb-item">Data Master</div>
                <div class="breadcrumb-item">Features</div>
                <div class="breadcrumb-item">Studios</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-form">
                                <button onclick="createStudio()" class="btn btn-primary text-uppercase">
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
                                        <th>Type</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th class="text-center">Created at</th>
                                        <th class="text-center">Last Update</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $no = 1; @endphp
                                    @foreach($studios as $row)
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
                                            <td style="vertical-align: middle;">{{ucwords($row->getJenisStudio->nama)}}
                                            </td>
                                            <td style="vertical-align: middle;"><strong>{{$row->nama}}</strong></td>
                                            <td style="vertical-align: middle;"><strong>Rp{{number_format($row
                                            ->harga,2,',','.')}}/hour</strong></td>
                                            <td style="vertical-align: middle" align="center">
                                                {{\Carbon\Carbon::parse($row->created_at)->format('j F Y')}}</td>
                                            <td style="vertical-align: middle" align="center">
                                                {{$row->updated_at->diffForHumans()}}</td>
                                            <td style="vertical-align: middle" align="center">
                                                <button data-placement="left" data-toggle="tooltip" title="Edit"
                                                        type="button" class="btn btn-warning" onclick="editStudio
                                                        ('{{$row->id}}','{{$row->jenis_id}}','{{$row->nama}}',
                                                        '{{$row->harga}}')"><i class="fa fa-edit"></i></button>
                                                <hr class="mt-1 mb-1">
                                                <a href="{{route('delete.studios',['id'=>encrypt($row->id)])}}"
                                                   class="btn btn-danger delete-data" data-toggle="tooltip"
                                                   title="Delete" data-placement="left">
                                                    <i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <form method="post" id="form-mass">
                                    {{csrf_field()}}
                                    <input type="hidden" name="studio_ids">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="studioModal" tabindex="-1" role="dialog" aria-labelledby="studioModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-studio" method="post" action="{{route('create.studios')}}"
                      enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="hidden" name="_method">
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="row form-group">
                            <div class="col fix-label-group">
                                <label for="jenis_id">Type</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fix-label-item" style="height: 2.25rem">
                                            <i class="fa fa-door-open"></i></span>
                                    </div>
                                    <select id="jenis_id" class="form-control selectpicker" title="-- Choose --"
                                            name="jenis_id" data-live-search="true" required>
                                        @foreach(\App\Models\JenisStudio::orderBy('nama')->get() as $type)
                                            <option value="{{$type->id}}">{{$type->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label for="nama">Name</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-text-width"></i></span>
                                    </div>
                                    <input id="nama" type="text" maxlength="191" name="nama" class="form-control"
                                           placeholder="Write the studio name here&hellip;" required>
                                </div>
                            </div>
                            <div class="col">
                                <label for="harga">Price/hours</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><strong>Rp</strong></span>
                                    </div>
                                    <input id="harga" type="text" class="form-control rupiah" name="harga"
                                           placeholder="0" min="0" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-money-bill-wave"></i></span>
                                    </div>
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
@endsection
@push("scripts")
    <script src="{{asset('admins/modules/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('admins/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('admins/modules/datatables/Select-1.2.4/js/dataTables.select.min.js')}}"></script>
    <script src="{{asset('admins/modules/datatables/Buttons-1.5.6/js/buttons.dataTables.min.js')}}"></script>
    <script src="{{asset('admins/modules/jquery-ui/jquery-ui.min.js')}}"></script>
    <script src="{{asset('admins/modules/jquery.maskMoney.js')}}"></script>
    <script>
        $(function () {
            var export_filename = 'Studios Table ({{now()->format('j F Y')}})', table = $("#dt-buttons").DataTable({
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
                        $("#form-mass input[name=studio_ids]").val(ids);
                        $("#form-mass").attr("action", "{{route('massDelete.studios')}}");

                        if (ids.length > 0) {
                            swal({
                                title: 'Delete Studios',
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

            $(".rupiah").maskMoney({thousands: '.', decimal: ',', precision: '0'});
        });

        function createStudio() {
            $(".fix-label-group .bootstrap-select").addClass('p-0');
            $(".fix-label-group .bootstrap-select button").css('border-color', '#e4e6fc');

            $("#studioModal .modal-title").text('Create Form');
            $("#form-studio").attr('action', '{{route('create.studios')}}');
            $("#form-studio input[name=_method]").val('');
            $("#form-studio input[name=id]").val('');
            $("#form-studio button[type=submit]").text('Submit');
            $("#jenis_id").val('').selectpicker('refresh');
            $("#nama, #harga").val('');

            $("#studioModal").modal('show');
        }

        function editStudio(id, jenis_id, nama, harga) {
            $(".fix-label-group .bootstrap-select").addClass('p-0');
            $(".fix-label-group .bootstrap-select button").css('border-color', '#e4e6fc');

            $("#studioModal .modal-title").text('Edit Form');
            $("#form-studio").attr('action', '{{route('update.studios')}}');
            $("#form-studio input[name=_method]").val('PUT');
            $("#form-studio input[name=id]").val(id);
            $("#form-studio button[type=submit]").text('Save Changes');
            $("#nama").val(nama);
            $("#harga").val(thousandSeparator(harga));
            $("#jenis_id").val(jenis_id).selectpicker('refresh');

            $("#studioModal").modal('show');
        }

        $('#harga').on('keyup', function () {
            var val = $(this).val().split('.').join("");
            if (val == "" || parseInt(val) <= 0) {
                $(this).val(0);
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