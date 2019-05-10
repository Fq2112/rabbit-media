@extends('layouts.auth.mst_admin')
@section('title', 'The Rabbits: Studio Types Table | Rabbit Media – Digital Creative Service')
@push('styles')
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/datatables.min.css')}}">
    <link rel="stylesheet"
          href="{{asset('admins/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Buttons-1.5.6/css/buttons.dataTables.min.css')}}">
    <style>
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
            <h1>Studio Types Table</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('home-admin')}}">Dashboard</a></div>
                <div class="breadcrumb-item">Data Master</div>
                <div class="breadcrumb-item">Company Profile</div>
                <div class="breadcrumb-item">Studio Types</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-form">
                                <button onclick="createStudioType()" class="btn btn-primary text-uppercase">
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
                                        <th>Created at / Last Update</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $no = 1; @endphp
                                    @foreach($types as $type)
                                        <tr>
                                            <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                            <td style="vertical-align: middle;">
                                                <strong>{{ucwords($type->nama)}}</strong>
                                            </td>
                                            <td style="vertical-align: middle">{{\Carbon\Carbon::parse($type->created_at)
                                            ->format('j F Y').' / '.$type->updated_at->diffForHumans()}}</td>
                                            <td style="vertical-align: middle" align="center">
                                                <button data-placement="left" data-toggle="tooltip" title="Edit"
                                                        type="button" class="btn btn-warning" onclick="editStudioType
                                                        ('{{$type->id}}','{{$type->icon}}','{{$type->nama}}')">
                                                    <i class="fa fa-edit"></i></button>
                                                <a href="{{route('delete.studio-types',['id'=>encrypt($type->id)])}}"
                                                   class="btn btn-danger delete-data ml-2" data-toggle="tooltip"
                                                   title="Delete" data-placement="top">
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

    <div class="modal fade" id="studioTypeModal" tabindex="-1" role="dialog" aria-labelledby="studioTypeModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-studioType" method="post" action="{{route('create.studio-types')}}">
                    {{csrf_field()}}
                    <input type="hidden" name="_method">
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <label for="nama">Name</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-door-open"></i></span>
                                    </div>
                                    <input id="nama" type="text" maxlength="191" name="nama" class="form-control"
                                           placeholder="Write the studio type name here&hellip;" required>
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
            var export_filename = 'Studio Types Table ({{now()->format('j F Y')}})';
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
                    $('[data-toggle="tooltip"]').tooltip();
                },
            });
        });

        function createStudioType() {
            $("#studioTypeModal .modal-title").text('Create Form');
            $("#form-studioType").attr('action', '{{route('create.studio-types')}}');
            $("#form-studioType input[name=_method]").val('');
            $("#form-studioType input[name=id]").val('');
            $("#form-studioType button[type=submit]").text('Submit');
            $("#nama").val('');
            $("#studioTypeModal").modal('show');
        }

        function editStudioType(id, icon, nama) {
            $("#studioTypeModal .modal-title").text('Edit Form');
            $("#form-studioType").attr('action', '{{route('update.studio-types')}}');
            $("#form-studioType input[name=_method]").val('PUT');
            $("#form-studioType input[name=id]").val(id);
            $("#form-studioType button[type=submit]").text('Save Changes');
            $("#nama").val(nama);
            $("#studioTypeModal").modal('show');
        }
    </script>
@endpush