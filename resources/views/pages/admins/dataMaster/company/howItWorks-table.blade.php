@extends('layouts.auth.mst_admin')
@section('title', 'The Rabbits: How It Works Table | Rabbit Media – Digital Creative Service')
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

        .custom-radio.red .custom-control-input:checked ~ .custom-control-label::before {
            background-color: #fa5555 !important;
        }

        .custom-radio.red .custom-control-input:checked ~ .custom-control-label {
            color: #fa5555 !important;
            font-weight: 600;
        }

        .custom-radio.green .custom-control-input:checked ~ .custom-control-label::before {
            background-color: #35C189 !important;
        }

        .custom-radio.green .custom-control-input:checked ~ .custom-control-label {
            color: #35C189 !important;
            font-weight: 600;
        }

        .custom-radio.blue .custom-control-input:checked ~ .custom-control-label::before {
            background-color: #17a2b8 !important;
        }

        .custom-radio.blue .custom-control-input:checked ~ .custom-control-label {
            color: #17a2b8 !important;
            font-weight: 600;
        }
    </style>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>How It Works Table</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('home-admin')}}">Dashboard</a></div>
                <div class="breadcrumb-item">Data Master</div>
                <div class="breadcrumb-item"><a href="{{route('show.company.profile')}}">Company Profile</a></div>
                <div class="breadcrumb-item">How It Works</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-form">
                                <button onclick="createHowItWorks()" class="btn btn-primary text-uppercase">
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
                                        <th class="text-center">Stem Color</th>
                                        <th class="text-center">Created at</th>
                                        <th class="text-center">Last Update</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $no = 1; @endphp
                                    @foreach($works as $work)
                                        <tr>
                                            <td style="vertical-align: middle" align="center">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" id="cb-{{$work->id}}"
                                                           class="custom-control-input dt-checkboxes">
                                                    <label for="cb-{{$work->id}}"
                                                           class="custom-control-label">{{$no++}}</label>
                                                </div>
                                            </td>
                                            <td style="vertical-align: middle" align="center">{{$work->id}}</td>
                                            <td style="vertical-align: middle;">
                                                <img class="img-fluid float-left mr-2" alt="icon" width="100"
                                                     src="{{asset('images/how-it-works/'.$work->icon)}}">
                                                <strong>{{$work->title}}</strong> <sub>{{$work->caption}}</sub>
                                                <p>{{$work->description}}</p>
                                            </td>
                                            <td style="vertical-align: middle" align="center">
                                                @if($work->stem_color == 'blue')
                                                    <span class="badge badge-info text-uppercase"
                                                          style="background-color: #17a2b8;">
                                                    <strong>{{$work->stem_color}}</strong></span>
                                                @elseif($work->stem_color == 'red')
                                                    <span class="badge badge-info text-uppercase"
                                                          style="background-color: #fa5555">
                                                    <strong>{{$work->stem_color}}</strong></span>
                                                @else
                                                    <span class="badge badge-info text-uppercase"
                                                          style="background-color: #35C189">
                                                    <strong>{{$work->stem_color}}</strong></span>
                                                @endif
                                            </td>
                                            <td style="vertical-align: middle" align="center">
                                                {{\Carbon\Carbon::parse($work->created_at)->format('j F Y')}}</td>
                                            <td style="vertical-align: middle" align="center">
                                                {{$work->updated_at->diffForHumans()}}</td>
                                            <td style="vertical-align: middle" align="center">
                                                <button data-placement="left" data-toggle="tooltip" title="Edit"
                                                        type="button" class="btn btn-warning" onclick="editHowItWorks
                                                        ('{{$work->id}}','{{$work->icon}}','{{$work->stem_color}}',
                                                        '{{$work->title}}','{{$work->caption}}','{{$work->description}}')">
                                                    <i class="fa fa-edit"></i></button>
                                                <hr class="mt-1 mb-1">
                                                <a href="{{route('delete.howItWorks',['id'=>encrypt($work->id)])}}"
                                                   class="btn btn-danger delete-data" data-toggle="tooltip"
                                                   title="Delete" data-placement="left">
                                                    <i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <form method="post" id="form-work">
                                    {{csrf_field()}}
                                    <input type="hidden" name="work_ids">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="howItWorksModal" tabindex="-1" role="dialog" aria-labelledby="howItWorksModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-howItWorks" method="post" action="{{route('create.howItWorks')}}"
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
                                    <div class="col-5">
                                        <label for="stem_color">Stem Color</label><br>
                                        <div class="custom-control custom-radio custom-control-inline red"
                                             id="stem_color">
                                            <input type="radio" class="custom-control-input" id="red"
                                                   name="stem_color" value="red" required>
                                            <label class="custom-control-label" for="red">RED</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline green">
                                            <input type="radio" class="custom-control-input" id="green"
                                                   name="stem_color" value="green">
                                            <label class="custom-control-label" for="green">GREEN</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline blue">
                                            <input type="radio" class="custom-control-input" id="blue"
                                                   name="stem_color" value="green">
                                            <label class="custom-control-label" for="blue">BLUE</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col">
                                <label for="title">Title & Caption</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-text-width"></i></span>
                                    </div>
                                    <input id="title" type="text" maxlength="191" name="title" class="form-control"
                                           placeholder="Write the step title here&hellip;" required>
                                    <input id="caption" type="text" maxlength="191" name="caption" class="form-control"
                                           placeholder="Write the step caption here&hellip;" required>
                                </div>
                            </div>
                        </div>

                        <div class="row has-feedback">
                            <div class="col">
                                <label for="description">Description</label>
                                <textarea id="description" type="text" name="description" class="form-control"
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
            var export_filename = 'How It Works Table ({{now()->format('j F Y')}})',
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
                            $("#form-work input[name=work_ids]").val(ids);
                            $("#form-work").attr("action", "{{route('massDelete.howItWorks')}}");

                            if (ids.length > 0) {
                                swal({
                                    title: 'Delete "How It Works" Steps',
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
                                        $("#form-work")[0].submit();
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

        function createHowItWorks() {
            $("#howItWorksModal .modal-title").text('Create Form');
            $("#form-howItWorks").attr('action', '{{route('create.howItWorks')}}');
            $("#form-howItWorks input[name=_method]").val('');
            $("#form-howItWorks input[name=id]").val('');
            $("#form-howItWorks button[type=submit]").text('Submit');
            $("#icon").attr('required', 'required');
            $("#txt_icon").text('Choose File');
            $("#icon, #title, #caption, #description").val('');
            $("#red, #green, #blue").prop('checked', false).trigger('change');

            $("#btn_img").attr('src', '#').parent().hide();
            $("#howItWorksModal").modal('show');
        }

        function editHowItWorks(id, icon, stem_color, title, caption, description) {
            $("#howItWorksModal .modal-title").text('Edit Form');
            $("#form-howItWorks").attr('action', '{{route('update.howItWorks')}}');
            $("#form-howItWorks input[name=_method]").val('PUT');
            $("#form-howItWorks input[name=id]").val(id);
            $("#form-howItWorks button[type=submit]").text('Save Changes');
            $("#icon").removeAttr('required');
            $("#txt_icon").text(icon.length > 20 ? icon.slice(0, 20) + "..." : icon);
            $("#title").val(title);
            $("#caption").val(caption);
            $("#description").val(description);

            if (stem_color == 'red') {
                $("#red").prop('checked', true).trigger('change');
                $("#green, #blue").prop('checked', false).trigger('change');
            } else if (stem_color == 'green') {
                $("#green").prop('checked', true).trigger('change');
                $("#red, #blue").prop('checked', false).trigger('change');
            } else {
                $("#blue").prop('checked', true).trigger('change');
                $("#red, #green").prop('checked', false).trigger('change');
            }

            $("#btn_img").attr('src', '{{asset('images/how-it-works')}}/' + icon).on('click', function () {
                $("#icon").click();
            }).parent().show();

            $("#howItWorksModal").modal('show');
        }

        $("#icon").on('change', function () {
            var files = $(this).prop("files"), names = $.map(files, function (val) {
                return val.name;
            }), text = names[0];
            $("#txt_icon").text(text.length > 20 ? text.slice(0, 20) + "..." : text);
        });
    </script>
@endpush
