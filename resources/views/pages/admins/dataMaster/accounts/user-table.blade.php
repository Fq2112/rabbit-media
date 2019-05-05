@extends('layouts.auth.mst_admin')
@section('title', 'The Rabbits: Users Table | Rabbit Media – Digital Creative Service')
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
            <h1>Users Table</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('home-admin')}}">Dashboard</a></div>
                <div class="breadcrumb-item">Tables</div>
                <div class="breadcrumb-item">Data Master</div>
                <div class="breadcrumb-item">Accounts</div>
                <div class="breadcrumb-item">Users</div>
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
                                        <th class="text-center">#</th>
                                        <th>Ava</th>
                                        <th>Contact</th>
                                        <th>Status</th>
                                        <th>Joined at</th>
                                        <th>Last Update</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $no = 1; @endphp
                                    @foreach($users as $user)
                                        <tr>
                                            <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                            <td style="vertical-align: middle" align="center">
                                                <img class="img-fluid" width="100" alt="avatar.png"
                                                     src="{{$user->ava == "" ? asset('images/avatar.png') :
                                                     asset('storage/users/ava/'.$user->ava)}}">
                                            </td>
                                            <td style="vertical-align: middle">
                                                <strong>{{$user->name}}</strong><br>
                                                <a href="mailto:{{$user->email}}">{{$user->email}}</a></td>
                                            <td style="vertical-align: middle;text-transform: uppercase" align="center">
                                                <span class="badge badge-{{$user->status == true ? 'success' :
                                                'warning'}}">{{$user->status == true ? 'Active' : 'Inactive'}}</span>
                                            </td>
                                            <td style="vertical-align: middle">
                                                {{\Carbon\Carbon::parse($user->created_at)->format('j F Y')}}</td>
                                            <td style="vertical-align: middle">{{$user->updated_at->diffForHumans()}}</td>
                                            <td style="vertical-align: middle" align="center">
                                                <button class="btn btn-info" data-toggle="tooltip" title="Details"
                                                        onclick="openProfile('{{$user->id}}','{{$user->ava}}',
                                                                '{{$user->email}}','{{$user->name}}','{{$user->status}}',
                                                                '{{$user->jk}}','{{$user->tgl_lahir}}','{{$user->no_telp}}',
                                                                '{{$user->alamat}}','{{$user->lat}}','{{$user->long}}',
                                                                '{{\Carbon\Carbon::parse($user->created_at)->format('j F Y')}}',
                                                                '{{$user->updated_at->diffForHumans()}}')">
                                                    <i class="fas fa-info-circle"></i>
                                                </button>
                                                <hr class="mt-1 mb-1">
                                                <a href="{{route('delete.users', ['id' => encrypt($user->id)])}}"
                                                   class="btn btn-danger delete-data" data-toggle="tooltip"
                                                   title="Delete" data-placement="bottom">
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

    <div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel"
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
                                            <div class="profile-widget-item-value" id="orders"></div>
                                        </div>
                                        <div class="profile-widget-item">
                                            <div class="profile-widget-item-label">Contacts</div>
                                            <div class="profile-widget-item-value" id="contacts"></div>
                                        </div>
                                        <div class="profile-widget-item">
                                            <div class="profile-widget-item-label">Feedback</div>
                                            <div class="profile-widget-item-value" id="feedback"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="profile-widget-description">
                                    <div class="profile-widget-name"></div>
                                    <table class="mt-0">
                                        <tr data-toggle="tooltip" data-placement="left" title="Email">
                                            <td><i class="fa fa-envelope"></i></td>
                                            <td>&nbsp;</td>
                                            <td id="email"></td>
                                        </tr>
                                        <tr data-toggle="tooltip" data-placement="left" title="Gender">
                                            <td><i class="fa fa-transgender"></i></td>
                                            <td>&nbsp;</td>
                                            <td id="jk"></td>
                                        </tr>
                                        <tr data-toggle="tooltip" data-placement="left" title="Birthday">
                                            <td><i class="fa fa-birthday-cake"></i></td>
                                            <td>&nbsp;</td>
                                            <td id="tgl_lahir"></td>
                                        </tr>
                                        <tr data-toggle="tooltip" data-placement="left" title="Phone">
                                            <td><i class="fa fa-phone"></i></td>
                                            <td>&nbsp;</td>
                                            <td id="no_telp"></td>
                                        </tr>
                                        <tr data-toggle="tooltip" data-placement="left" title="Address">
                                            <td><i class="fa fa-map-marked-alt"></i></td>
                                            <td>&nbsp;</td>
                                            <td id="alamat"></td>
                                        </tr>
                                    </table>
                                    <hr>
                                    <table class="mt-0">
                                        <tr>
                                            <td><i class="fa fa-calendar-check"></i></td>
                                            <td>&nbsp;Member Since</td>
                                            <td id="create"></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-clock"></i></td>
                                            <td>&nbsp;Last Update</td>
                                            <td id="update"></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="card-footer text-center">
                                    <div class="font-weight-bold mb-2" id="map_title"></div>
                                    <div id="map"></div>
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
    <script>
        $(function () {
            var export_filename = 'Users Table ({{now()->format('j F Y')}})';
            $("#dt-buttons").DataTable({
                dom: "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'B><'col-sm-12 col-md-4'f>>" +
                    "<'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                columnDefs: [
                    {"sortable": false, "targets": [1, 6]}
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

        function openProfile(id, ava, email, name, status, jk, tgl_lahir, no_telp, alamat, lat, long, create, update) {
            var $path = ava == "" ? '{{asset('images/avatar.png')}}' : '{{asset('storage/users/ava/')}}/' + ava,
                $status = status == false ? 'Inactive' : 'Active';

            $("#avatar").attr('src', $path);
            $(".profile-widget-name").html(name + ' <div class="text-muted d-inline font-weight-normal">' +
                '<div class="slash"></div> ' + $status + '</div>');

            $("#email").html('<a href="mailto:' + email + '">' + email + '</a>');
            $("#jk").text(jk);
            $("#tgl_lahir").text(tgl_lahir);
            $("#no_telp").html('<a href="tel:' + no_telp + '">' + no_telp + '</a>');
            $("#alamat").text(alamat);
            $("#create").text(': ' + create);
            $("#update").text(': ' + update);

            $("#profileModal .modal-title").text(name.split(/\s+/).slice(0, 1).join(" ") + "'s Profile");
            $("#map_title").text(name.split(/\s+/).slice(0, 1).join(" ") + "'s Address");

            $("#profileModal").modal('show');
        }
    </script>
@endpush