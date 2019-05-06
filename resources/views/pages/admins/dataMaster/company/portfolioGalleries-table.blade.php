@extends('layouts.auth.mst_admin')
@section('title', 'The Rabbits: Portfolio Galleries Table | Rabbit Media – Digital Creative Service')
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
            <h1>Portfolios Table</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('home-admin')}}">Dashboard</a></div>
                <div class="breadcrumb-item">Data Master</div>
                <div class="breadcrumb-item">Company Profile</div>
                <div class="breadcrumb-item">Portfolios</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-form">
                                <button onclick="createPortfolio()" class="btn btn-primary text-uppercase">
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
                                        <th>Type</th>
                                        <th>Details</th>
                                        <th>Created at / Last Update</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $no = 1; @endphp
                                    @foreach($portfolios as $row)
                                        @php
                                            $cover = $row->cover == 'img_1.jpg' || $row->cover == 'img_2.jpg' ||
                                            $row->cover == 'img_3.jpg' || $row->cover == 'img_4.jpg' ||
                                            $row->cover == 'img_5.jpg' || $row->cover == 'img_6.jpg' ||
                                            $row->cover == 'img_7jpg' ? asset('images/'.$row->cover) :
                                            asset('storage/portofolio/cover/'.$row->cover);
                                        @endphp
                                        <tr>
                                            <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                            <td style="vertical-align: middle;">
                                                <strong><i class="{{$row->getJenisPortofolio->icon}} mr-2"></i>{{ucfirst
                                                ($row->getJenisPortofolio->nama)}}</strong>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <img class="img-thumbnail float-left mr-2" alt="Cover" src="{{$cover}}"
                                                     width="100px">
                                                <strong>{{$row->nama}}</strong>
                                                <p>{{$row->deskripsi}}</p>
                                            </td>
                                            <td style="vertical-align: middle">{{\Carbon\Carbon::parse($row->created_at)
                                            ->format('j F Y').' / '.$row->updated_at->diffForHumans()}}</td>
                                            <td style="vertical-align: middle" align="center">
                                                <button data-placement="left" data-toggle="tooltip" title="Edit"
                                                        type="button" class="btn btn-warning" onclick="editPortfolio
                                                        ('{{$row->id}}','{{$row->jenis_id}}','{{$row->nama}}',
                                                        '{{$row->deskripsi}}','{{$row->cover}}')">
                                                    <i class="fa fa-edit"></i></button>
                                                <hr class="mt-1 mb-1">
                                                <a href="{{route('delete.portfolios',['id'=>encrypt($row->id)])}}"
                                                   class="btn btn-danger delete-data" data-toggle="tooltip"
                                                   title="Delete" data-placement="left">
                                                    <i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="portfolioModal" tabindex="-1" role="dialog" aria-labelledby="portfolioModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-portfolio" method="post" action="{{route('create.portfolios')}}"
                      enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="hidden" name="_method">
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="row form-group">
                            <div class="col">
                                <label class="control-label mb-0" for="cover">Cover</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-image"></i></span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" name="cover" class="custom-file-input" id="cover" required>
                                        <label class="custom-file-label" id="txt_cover">Choose File</label>
                                    </div>
                                </div>
                                <div class="form-text text-muted">
                                    Allowed extension: jpg, jpeg, gif, png. Allowed size: < 2 MB
                                </div>
                            </div>
                            <div class="col fix-label-group">
                                <label for="jenis_id">Type</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fix-label-item" style="height: 2.25rem">
                                            <i class="fab fa-font-awesome-flag"></i></span>
                                    </div>
                                    <select id="jenis_id" class="form-control selectpicker" title="-- Choose --"
                                            name="jenis_id" data-live-search="true" required>
                                        @foreach(\App\Models\JenisPortofolio::orderBy('nama')->get() as $type)
                                            <option value="{{$type->id}}">
                                                <i class="{{$type->icon}} mr-2"></i>{{$type->nama}}</option>
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
                        <div class="row has-feedback">
                            <div class="col">
                                <label for="deskripsi">Description</label>
                                <div class="input-group">
                                    <textarea id="deskripsi" type="text" name="deskripsi" class="form-control"
                                              placeholder="Describe it here&hellip;" required></textarea>
                                    <span class="glyphicon glyphicon-text-height form-control-feedback"
                                          style="top: 1.5rem;right: 1em;"></span>
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
    <script>
        $(function () {
            var export_filename = 'Portfolios Table ({{now()->format('j F Y')}})';
            $("#dt-buttons").DataTable({
                dom: "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'B><'col-sm-12 col-md-4'f>>" +
                    "<'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                columnDefs: [
                    {"sortable": false, "targets": 4}
                ],
                buttons: [
                    {
                        text: '<i class="far fa-clipboard mr-2"></i>Copy',
                        extend: 'copy',
                        className: 'btn btn-primary assets-export-btn export-copy ttip'
                    }, {
                        text: '<i class="fa fa-file-csv mr-2"></i>CSV',
                        extend: 'csv',
                        className: 'btn btn-primary assets-export-btn export-csv ttip',
                        title: export_filename,
                        extension: '.csv'
                    }, {
                        text: '<i class="far fa-file-excel mr-2"></i>Excel',
                        extend: 'excel',
                        className: 'btn btn-primary assets-export-btn export-xls ttip',
                        title: export_filename,
                        extension: '.xls'
                    }, {
                        text: '<i class="far fa-file-pdf mr-2"></i>PDF',
                        extend: 'pdf',
                        className: 'btn btn-primary assets-export-btn export-pdf ttip',
                        title: export_filename,
                        extension: '.pdf'
                    }, {
                        text: '<i class="fa fa-print mr-2"></i>Print',
                        extend: 'print',
                        className: 'btn btn-primary assets-select-btn export-print'
                    }
                ]
            });
        });

        function createPortfolio() {
            $(".fix-label-group .bootstrap-select").addClass('p-0');
            $(".fix-label-group .bootstrap-select button").css('border-color', '#e4e6fc');

            $("#portfolioModal .modal-title").text('Create Form');
            $("#form-portfolio").attr('action', '{{route('create.portfolios')}}');
            $("#form-portfolio input[name=_method]").val('');
            $("#form-portfolio input[name=id]").val('');
            $("#form-portfolio button[type=submit]").text('Submit');
            $("#cover").attr('required', 'required');
            $("#txt_cover").text('Choose File');
            $("#cover, #nama, #deskripsi").val('');
            $("#jenis_id").val('').selectpicker('refresh');
            $("#portfolioModal").modal('show');
        }

        function editPortfolio(id, jenis_id, nama, deskripsi, cover) {
            $(".fix-label-group .bootstrap-select").addClass('p-0');
            $(".fix-label-group .bootstrap-select button").css('border-color', '#e4e6fc');

            $("#portfolioModal .modal-title").text('Edit Form');
            $("#form-portfolio").attr('action', '{{route('update.portfolios')}}');
            $("#form-portfolio input[name=_method]").val('PUT');
            $("#form-portfolio input[name=id]").val(id);
            $("#form-portfolio button[type=submit]").text('Save Changes');
            $("#cover").removeAttr('required');
            $("#txt_cover").text(cover.length > 30 ? cover.slice(0, 30) + "..." : cover);
            $("#nama").val(nama);
            $("#deskripsi").val(deskripsi);
            $("#jenis_id").val(jenis_id).selectpicker('refresh');
            $("#portfolioModal").modal('show');
        }

        $("#cover").on('change', function () {
            var files = $(this).prop("files"), names = $.map(files, function (val) {
                return val.name;
            }), text = names[0];
            $("#txt_cover").text(text.length > 30 ? text.slice(0, 30) + "..." : text);
        });
    </script>
@endpush