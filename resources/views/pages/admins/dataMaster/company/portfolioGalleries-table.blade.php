@extends('layouts.auth.mst_admin')
@section('title', 'The Rabbits: Portfolio Galleries Table | Rabbit Media – Digital Creative Service')
@push('styles')
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/datatables.min.css')}}">
    <link rel="stylesheet"
          href="{{asset('admins/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Buttons-1.5.6/css/buttons.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/lightgallery.min.css')}}">
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
            <h1>Portfolio Galleries Table</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('home-admin')}}">Dashboard</a></div>
                <div class="breadcrumb-item">Data Master</div>
                <div class="breadcrumb-item"><a href="{{route('show.company.profile')}}">Company Profile</a></div>
                <div class="breadcrumb-item">Portfolio Galleries</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-form">
                                <button onclick="createGallery()" class="btn btn-primary text-uppercase">
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
                                        <th>Portfolio</th>
                                        <th>Details</th>
                                        <th class="text-center">Created at</th>
                                        <th class="text-center">Last Update</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $no = 1; @endphp
                                    @foreach($galleries as $row)
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
                                            <td style="vertical-align: middle;">
                                                <a href="{{route('show.portfolio.gallery', ['jenis' => strtolower
                                                (str_replace(' ', '-',$row->getPortofolio->getJenisPortofolio->nama)),
                                                'id' => encrypt($row->getPortofolio->id)])}}" target="_blank">
                                                    <div class="row m-0 p-0">
                                                        <div class="col-2 mb-0 mt-0 ml-0 mr-1 p-0">
                                                            <i class="{{$row->getPortofolio->getJenisPortofolio->icon}}"></i>
                                                        </div>
                                                        <div class="col m-0 p-0">
                                                            <strong>{{$row->getPortofolio->nama}}</strong>
                                                        </div>
                                                    </div>
                                                </a>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <div class="row lightgallery float-left mr-0">
                                                    @if($row->photo == 'nature_big_1.jpg' ||
                                                    $row->photo == 'nature_big_2.jpg' ||
                                                    $row->photo == 'nature_big_3.jpg' ||
                                                    $row->photo == 'nature_big_4.jpg' ||
                                                    $row->photo == 'nature_big_5.jpg' ||
                                                    $row->photo == 'nature_big_6.jpg' ||
                                                    $row->photo == 'nature_big_7.jpg' ||
                                                    $row->photo == 'nature_big_8.jpg' ||
                                                    $row->photo == 'nature_big_9.jpg' ||
                                                    $row->thumbnail == 'nature_big_1.jpg' ||
                                                    $row->thumbnail == 'nature_big_2.jpg' ||
                                                    $row->thumbnail == 'nature_big_3.jpg' ||
                                                    $row->thumbnail == 'nature_big_4.jpg' ||
                                                    $row->thumbnail == 'nature_big_5.jpg' ||
                                                    $row->thumbnail == 'nature_big_6.jpg' ||
                                                    $row->thumbnail == 'nature_big_7.jpg' ||
                                                    $row->thumbnail == 'nature_big_8.jpg' ||
                                                    $row->thumbnail == 'nature_big_9.jpg')
                                                        <div class="col item" data-src="{{$row->photo != "" ?
                                                        asset('images/big-images/'.$row->photo) : $row->video}}"
                                                             data-sub-html="<h4>{{$row->nama}}</h4><p>{{$row->deskripsi}}</p>">
                                                            <a href="javascript:void(0)">
                                                                <img width="100" src="{{$row->photo != "" ?
                                                                asset('images/big-images/'.$row->photo) :
                                                                asset('images/big-images/'.$row->thumbnail)}}"
                                                                     alt="Thumbnail" class="img-thumbnail"></a>
                                                        </div>
                                                    @else
                                                        <div class="col item" data-src="{{$row->photo!= "" ?
                                                        asset('storage/portofolio/gallery/'.$row->photo) : $row->video}}"
                                                             data-sub-html="<h4>{{$row->nama}}</h4><p>{{$row->deskripsi}}</p>">
                                                            <a href="javascript:void(0)">
                                                                <img width="100" src="{{$row->photo != "" ?
                                                                asset('storage/portofolio/gallery/'.$row->photo) :
                                                                asset('storage/portofolio/thumbnail/'.$row->thumbnail)}}"
                                                                     alt="Thumbnail" class="img-thumbnail"></a>
                                                        </div>
                                                    @endif
                                                </div>
                                                <strong>{{$row->nama}}</strong>
                                                <p>{{$row->deskripsi}}
                                                    @if($row->video != "")
                                                        <br><a href="{{$row->video}}"
                                                               target="_blank">{{$row->video}}</a>
                                                    @endif
                                                </p>
                                            </td>
                                            <td style="vertical-align: middle" align="center">
                                                {{\Carbon\Carbon::parse($row->created_at)->format('j F Y')}}</td>
                                            <td style="vertical-align: middle" align="center">
                                                {{$row->updated_at->diffForHumans()}}</td>
                                            <td style="vertical-align: middle" align="center">
                                                <button data-placement="left" data-toggle="tooltip" title="Edit"
                                                        type="button" class="btn btn-warning" onclick="editGallery
                                                        ('{{$row->id}}','{{$row->portofolio_id}}','{{$row->nama}}',
                                                        '{{$row->deskripsi}}','{{$row->photo}}','{{$row->thumbnail}}',
                                                        '{{$row->video}}')">
                                                    <i class="fa fa-edit"></i></button>
                                                <hr class="mt-1 mb-1">
                                                <a href="{{route('delete.portfolio-galleries',['id'=>encrypt($row->id)])}}"
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
                                    <input type="hidden" name="gallery_ids">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="galleryModal" tabindex="-1" role="dialog" aria-labelledby="galleryModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-gallery" method="post" action="{{route('create.portfolio-galleries')}}"
                      enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="hidden" name="_method">
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="row form-group">
                            <div class="col fix-label-group">
                                <label for="portofolio_id">Portfolio</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fix-label-item" style="height: 2.25rem">
                                            <i class="fab fa-font-awesome-flag"></i></span>
                                    </div>
                                    <select id="portofolio_id" class="form-control selectpicker" title="-- Choose --"
                                            name="portofolio_id" data-live-search="true" required>
                                        @foreach(\App\Models\JenisPortofolio::orderBy('nama')->get() as $type)
                                            <optgroup label="{{ucwords($type->nama)}}">
                                                @foreach($type->getPortofolio as $row)
                                                    <option value="{{$row->id}}">{{$row->nama}}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group has-feedback">
                            <div class="col">
                                <label for="nama">Name</label>
                                <input id="nama" type="text" maxlength="191" name="nama" class="form-control"
                                       placeholder="Write the portfolio name here&hellip;" required>
                                <span class="glyphicon glyphicon-text-width form-control-feedback"></span>
                            </div>
                        </div>
                        <div class="row form-group has-feedback">
                            <div class="col">
                                <label for="deskripsi">Description</label>
                                <textarea id="deskripsi" type="text" name="deskripsi" class="form-control"
                                          placeholder="Describe it here&hellip;" required></textarea>
                                <span class="glyphicon glyphicon-text-height form-control-feedback"></span>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col">
                                <label for="photo">Photo</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <input id="rb-photo" type="radio"
                                                   aria-label="Radio button for following text input"
                                                   name="rb-gallery" required>
                                        </div>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" name="photo" class="custom-file-input" id="photo"
                                               accept="image/*" disabled>
                                        <label class="custom-file-label" id="txt_photo">Choose File</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-images"></i></span>
                                    </div>
                                </div>
                                <div class="form-text text-muted">
                                    Allowed extension: jpg, jpeg, gif, png. Allowed size: < 5 MB
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="thumbnail">Video Thumbnail & URL</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <input id="rb-thumbnail" type="radio"
                                                   aria-label="Radio button for following text input"
                                                   name="rb-gallery">
                                        </div>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" name="thumbnail" class="custom-file-input" id="thumbnail"
                                               accept="image/*" disabled>
                                        <label class="custom-file-label" id="txt_thumbnail">Choose File</label>
                                    </div>
                                    <input id="video" type="text" name="video" class="form-control"
                                           placeholder="Enter the video URL here&hellip;" disabled>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-video"></i></span>
                                    </div>
                                </div>
                                <div class="form-text text-muted">
                                    Allowed extension: jpg, jpeg, gif, png. Allowed size: < 2 MB
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
    <script src="{{asset('js/lightgallery-all.min.js')}}"></script>
    <script>
        $(function () {
            var export_filename = 'Portfolio Galleries Table ({{now()->format('j F Y')}})',
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

                        $('.lightgallery').lightGallery({
                            loadYoutubeThumbnail: true,
                            youtubeThumbSize: 'default',
                        });

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
                            $("#form-mass input[name=gallery_ids]").val(ids);
                            $("#form-mass").attr("action", "{{route('massDelete.portfolio-galleries')}}");

                            if (ids.length > 0) {
                                swal({
                                    title: 'Delete Galleries',
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

        function createGallery() {
            $(".fix-label-group .bootstrap-select").addClass('p-0');
            $(".fix-label-group .bootstrap-select button").css('border-color', '#e4e6fc');

            $("#galleryModal .modal-title").text('Create Form');
            $("#form-gallery").attr('action', '{{route('create.portfolio-galleries')}}');
            $("#form-gallery input[name=_method]").val('');
            $("#form-gallery input[name=id]").val('');
            $("#form-gallery button[type=submit]").text('Submit');
            $("#portofolio_id").val('').selectpicker('refresh');
            $("#nama, #deskripsi, #photo, #thumbnail, #video").val('');
            $("#txt_photo, #txt_thumbnail").text('Choose File');
            $("#rb-thumbnail, #rb-photo").prop("checked", false).trigger('change');
            $("#photo, #thumbnail, #video").attr('disabled', 'disabled');
            $("#galleryModal").modal('show');
        }

        function editGallery(id, portofolio_id, nama, deskripsi, photo, thumbnail, video) {
            $(".fix-label-group .bootstrap-select").addClass('p-0');
            $(".fix-label-group .bootstrap-select button").css('border-color', '#e4e6fc');

            $("#galleryModal .modal-title").text('Edit Form');
            $("#form-gallery").attr('action', '{{route('update.portfolio-galleries')}}');
            $("#form-gallery input[name=_method]").val('PUT');
            $("#form-gallery input[name=id]").val(id);
            $("#form-gallery button[type=submit]").text('Save Changes');
            $("#portofolio_id").val(portofolio_id).selectpicker('refresh');
            $("#nama").val(nama);
            $("#deskripsi").val(deskripsi);
            $("#video").val(video);

            if (photo != "") {
                $("#txt_photo").text(photo.length > 60 ? photo.slice(0, 60) + "..." : photo);
                $("#rb-photo").click();
            } else {
                $("#txt_photo").text('Choose File');
                $("#rb-thumbnail").click();
            }

            if (thumbnail != "") {
                $("#txt_thumbnail").text(thumbnail.length > 60 ? thumbnail.slice(0, 60) + "..." : thumbnail);
                $("#rb-thumbnail").click();
            } else {
                $("#txt_thumbnail").text('Choose File');
                $("#rb-photo").click();
            }

            $("#photo, #thumbnail, #video").removeAttr('required');

            $("#galleryModal").modal('show');
        }

        $("#photo").on('change', function () {
            var files = $(this).prop("files"), names = $.map(files, function (val) {
                return val.name;
            }), text = names[0];
            $("#txt_photo").text(text.length > 60 ? text.slice(0, 60) + "..." : text);
        });

        $("#thumbnail").on('change', function () {
            var files = $(this).prop("files"), names = $.map(files, function (val) {
                return val.name;
            }), text = names[0];
            $("#txt_thumbnail").text(text.length > 30 ? text.slice(0, 30) + "..." : text);
        });

        $("#rb-photo").on('click', function () {
            if ($(this).is(':checked')) {
                $("#photo").removeAttr('disabled').attr('required', 'required');
                $("#thumbnail, #video").val('').removeAttr('required').attr('disabled', 'disabled');
                $("#txt_thumbnail").text('Choose File');
            } else {
                $("#photo").val('').removeAttr('required').attr('disabled', 'disabled');
                $("#txt_photo").text('Choose File');
                $("#thumbnail, #video").removeAttr('disabled').attr('required', 'required');
            }
        });

        $("#rb-thumbnail").on('click', function () {
            if ($(this).is(':checked')) {
                $("#thumbnail, #video").removeAttr('disabled').attr('required', 'required');
                $("#photo").val('').removeAttr('required').attr('disabled', 'disabled');
                $("#txt_photo").text('Choose File');
            } else {
                $("#thumbnail, #video").val('').removeAttr('required').attr('disabled', 'disabled');
                $("#txt_thumbnail").text('Choose File');
                $("#photo").removeAttr('disabled').attr('required', 'required');
            }
        });
    </script>
@endpush