@extends('layouts.auth.mst_admin')
@section('title', 'The Rabbits: Service Types Table | Rabbit Media – Digital Creative Service')
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
            <h1>Service Types Table</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('home-admin')}}">Dashboard</a></div>
                <div class="breadcrumb-item">Data Master</div>
                <div class="breadcrumb-item">Features</div>
                <div class="breadcrumb-item">Service Types</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-form">
                                <button onclick="createServiceType()" class="btn btn-primary text-uppercase">
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
                                        <th class="text-center">Category</th>
                                        <th class="text-center">Created at</th>
                                        <th class="text-center">Last Update</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $no = 1; @endphp
                                    @foreach($types as $type)
                                        <tr>
                                            <td style="vertical-align: middle" align="center">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" id="cb-{{$type->id}}"
                                                           class="custom-control-input dt-checkboxes">
                                                    <label for="cb-{{$type->id}}"
                                                           class="custom-control-label">{{$no++}}</label>
                                                </div>
                                            </td>
                                            <td style="vertical-align: middle" align="center">{{$type->id}}</td>
                                            <td style="vertical-align: middle;">
                                                <img class="img-fluid float-left mr-2" alt="icon" width="64"
                                                     src="{{asset('images/services/'.$type->icon)}}">
                                                <strong>{{$type->nama}}</strong>
                                                <p>{{$type->deskripsi}}</p>
                                            </td>
                                            <td style="vertical-align: middle" align="center">
                                                <span class="badge badge-{{$type->isPack == true ? 'primary' :
                                                'info'}}"><strong>{{$type->isPack == true ? 'PACK' :
                                                'SINGLE'}}</strong></span>
                                            </td>
                                            <td style="vertical-align: middle" align="center">
                                                {{\Carbon\Carbon::parse($type->created_at)->format('j F Y')}}</td>
                                            <td style="vertical-align: middle" align="center">
                                                {{$type->updated_at->diffForHumans()}}</td>
                                            <td style="vertical-align: middle" align="center">
                                                <button data-placement="left" data-toggle="tooltip" title="Edit"
                                                        type="button" class="btn btn-warning" onclick="editServiceType
                                                        ('{{$type->id}}','{{$type->icon}}','{{$type->nama}}',
                                                        '{{$type->deskripsi}}','{{$type->isPack}}')">
                                                    <i class="fa fa-edit"></i></button>
                                                <hr class="mt-1 mb-1">
                                                <a href="{{route('delete.service-types',['id'=>encrypt($type->id)])}}"
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
                                    <input type="hidden" name="type_ids">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="serviceTypeModal" tabindex="-1" role="dialog" aria-labelledby="serviceTypeModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-serviceType" method="post" action="{{route('create.service-types')}}"
                      enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="hidden" name="_method">
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="row form-group">
                            <div class="col-2 text-center align-self-center" style="display: none">
                                <img class="img-fluid" id="btn_img" style="cursor: pointer"
                                     data-toggle="tooltip" data-placement="bottom" alt="cover" src="#"
                                     title="Click here to change the icon!">
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <label for="icon">Icon</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-image"></i></span>
                                            </div>
                                            <div class="custom-file">
                                                <input type="file" name="icon" class="custom-file-input" id="icon"
                                                       accept="image/*" required>
                                                <label class="custom-file-label" id="txt_icon">Choose File</label>
                                            </div>
                                        </div>
                                        <div class="form-text text-muted">
                                            Allowed extension: jpg, jpeg, gif, png. Allowed size: < 2 MB
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <label for="isPack">Category</label><br>
                                        <div class="custom-control custom-radio custom-control-inline" id="isPack">
                                            <input type="radio" class="custom-control-input" id="single" name="isPack"
                                                   value="0" required>
                                            <label class="custom-control-label" for="single">SINGLE</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" class="custom-control-input" id="pack" name="isPack"
                                                   value="1">
                                            <label class="custom-control-label" for="pack">PACK</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group has-feedback">
                            <div class="col">
                                <label for="nama">Name</label>
                                <input id="nama" type="text" maxlength="191" name="nama" class="form-control"
                                       placeholder="Write the service type name here&hellip;" required>
                                <span class="glyphicon glyphicon-text-width form-control-feedback"></span>
                            </div>
                        </div>
                        <div class="row has-feedback">
                            <div class="col">
                                <label for="deskripsi">Description</label>
                                <textarea id="deskripsi" type="text" name="deskripsi" class="form-control"
                                          placeholder="Describe it here&hellip;" required></textarea>
                                <span class="glyphicon glyphicon-text-height form-control-feedback"></span>
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
    <script>
        $(function () {
            var export_filename = 'Service Types Table ({{now()->format('j F Y')}})',
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
                            $("#form-mass input[name=type_ids]").val(ids);
                            $("#form-mass").attr("action", "{{route('massDelete.service-types')}}");

                            if (ids.length > 0) {
                                swal({
                                    title: 'Delete Service Types',
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

        function createServiceType() {
            $("#serviceTypeModal .modal-title").text('Create Form');
            $("#form-serviceType").attr('action', '{{route('create.service-types')}}');
            $("#form-serviceType input[name=_method]").val('');
            $("#form-serviceType input[name=id]").val('');
            $("#form-serviceType button[type=submit]").text('Submit');
            $("#icon").attr('required', 'required');
            $("#txt_icon").text('Choose File');
            $("#icon, #nama, #deskripsi").val('');
            $("#single, #pack").prop('checked', false).trigger('change');

            $("#btn_img").attr('src', '#').parent().hide();
            $("#serviceTypeModal").modal('show');
        }

        function editServiceType(id, icon, nama, deskripsi, isPack) {
            $("#serviceTypeModal .modal-title").text('Edit Form');
            $("#form-serviceType").attr('action', '{{route('update.service-types')}}');
            $("#form-serviceType input[name=_method]").val('PUT');
            $("#form-serviceType input[name=id]").val(id);
            $("#form-serviceType button[type=submit]").text('Save Changes');
            $("#icon").removeAttr('required');
            $("#txt_icon").text(icon.length > 30 ? icon.slice(0, 30) + "..." : icon);
            $("#nama").val(nama);
            $("#deskripsi").val(deskripsi);

            if (isPack == true) {
                $("#pack").prop('checked', true).trigger('change');
                $("#single").prop('checked', false).trigger('change');
            } else {
                $("#single").prop('checked', true).trigger('change');
                $("#pack").prop('checked', false).trigger('change');
            }

            $("#btn_img").attr('src', '{{asset('images/services')}}/' + icon).on('click', function () {
                $("#icon").click();
            }).parent().show();

            $("#serviceTypeModal").modal('show');
        }

        $("#icon").on('change', function () {
            var files = $(this).prop("files"), names = $.map(files, function (val) {
                return val.name;
            }), text = names[0];
            $("#txt_icon").text(text.length > 30 ? text.slice(0, 30) + "..." : text);
        });
    </script>
@endpush