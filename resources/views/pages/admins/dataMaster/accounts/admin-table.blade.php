@extends('layouts.auth.mst_admin')
@section('title', 'The Rabbits: Admins Table | Rabbit Media – Digital Creative Service')
@push('styles')
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/datatables.min.css')}}">
    <link rel="stylesheet"
          href="{{asset('admins/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Buttons-1.5.6/css/buttons.dataTables.min.css')}}">
    <style>
        #password + .glyphicon, #confirm + .glyphicon,
        #curr_password + .glyphicon, #as-password + .glyphicon, #as-confirm + .glyphicon {
            cursor: pointer;
            pointer-events: all;
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
            <h1>Admins Table</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('home-admin')}}">Dashboard</a></div>
                <div class="breadcrumb-item">Tables</div>
                <div class="breadcrumb-item">Data Master</div>
                <div class="breadcrumb-item">Accounts</div>
                <div class="breadcrumb-item">Admins</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-form">
                                <button onclick="createAdmin()" class="btn btn-primary text-uppercase">
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
                                        <th>Ava</th>
                                        <th>Contact</th>
                                        <th>Role</th>
                                        <th>Created at</th>
                                        <th>Last Update</th>
                                        @if(Auth::guard('admin')->user()->isRoot())
                                            <th>Action</th>@endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $no = 1; @endphp
                                    @foreach($admins as $admin)
                                        @php
                                            if($admin->isRoot()){
                                                $badge = 'primary';
                                            } elseif($admin->isCEO()){
                                                $badge = 'secondary';
                                            } elseif($admin->isCTO()){
                                                $badge = 'info';
                                            } elseif($admin->isAdmin()){
                                                $badge = 'success';
                                            } elseif($admin->isCOO()){
                                                $badge = 'warning';
                                            } else{
                                                $badge = 'danger';
                                            }
                                        @endphp
                                        <tr>
                                            <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                            <td style="vertical-align: middle" align="center">
                                                <img class="img-fluid" width="100" alt="avatar.png"
                                                     src="{{$admin->ava == "" ? asset('images/avatar.png') : 
                                                     asset('storage/admins/ava/'.$admin->ava)}}">
                                            </td>
                                            <td style="vertical-align: middle">
                                                <strong>{{$admin->name}}</strong><br>
                                                <a href="mailto:{{$admin->email}}">{{$admin->email}}</a></td>
                                            <td style="vertical-align: middle;text-transform: uppercase;"
                                                align="center"><span class="badge badge-{{$badge}}">
                                                    <strong>{{$admin->role}}</strong></span>
                                            </td>
                                            <td style="vertical-align: middle" align="center">
                                                {{\Carbon\Carbon::parse($admin->created_at)->format('j F Y')}}</td>
                                            <td style="vertical-align: middle"
                                                align="center">{{$admin->updated_at->diffForHumans()}}</td>
                                            @if(Auth::guard('admin')->user()->isRoot())
                                                <td style="vertical-align: middle" align="center">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-primary"
                                                                onclick="editProfile('{{$admin->id}}',
                                                                        '{{$admin->ava}}','{{$admin->name}}')">
                                                            <strong><i class="fa fa-user-edit mr-2"></i>EDIT</strong>
                                                        </button>
                                                        <button id="option" type="button"
                                                                class="btn btn-primary dropdown-toggle"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false"></button>
                                                        <div class="dropdown-menu" aria-labelledby="option">
                                                            <a class="dropdown-item" href="javascript:void(0)"
                                                               onclick="accountSettings('{{$admin->id}}',
                                                                       '{{$admin->email}}','{{$admin->role}}')">
                                                                <i class="fa fa-user-cog mr-2"></i>Settings</a>
                                                            <a class="dropdown-item delete-data"
                                                               href="{{route('delete.admins',['id'=> encrypt($admin->id)])}}">
                                                                <i class="fa fa-trash-alt mr-2"></i>Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            @endif
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

    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="create-form" method="post" action="{{route('create.admins')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="row form-group">
                            <div class="col">
                                <label class="control-label mb-0" for="ava">Avatar <sub>(optional)</sub></label>
                                <input type="file" name="ava" style="display: none;" accept="image/*" id="ava">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                    </div>
                                    <input type="text" id="txt_ava" class="browse_files form-control"
                                           placeholder="Upload file here..." readonly style="cursor: pointer"
                                           data-toggle="tooltip" data-placement="top"
                                           title="Allowed extension: jpg, jpeg, gif, png. Allowed size: < 2 MB">
                                    <div class="input-group-append">
                                        <button class="browse_files btn btn-primary" type="button">
                                            <i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <label class="control-label mb-0" for="name">Full Name</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                    </div>
                                    <input id="name" type="text" class="form-control" maxlength="191" name="name"
                                           placeholder="Full name" required>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col">
                                <label class="control-label mb-0" for="email">Email</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                    </div>
                                    <input id="email" type="email" class="form-control" name="email" placeholder="Email"
                                           required>
                                </div>
                            </div>
                            <div class="col fix-label-group">
                                <label class="control-label mb-0" for="role">Role</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fix-label-item" style="height: 2.25rem">
                                            <i class="fa fa-user-shield"></i></span>
                                    </div>
                                    <select id="role" class="form-control selectpicker" title="-- Choose --" name="role"
                                            required data-live-search="true">
                                        <option value="ceo" data-subtext="Chief Executive Officer"
                                                {{\App\Admin::where('role', \App\Support\Role::CEO)->count() > 0 ?
                                                'disabled' : ''}}>CEO
                                        </option>
                                        <option value="cto" data-subtext="Chief Technology Officer"
                                                {{\App\Admin::where('role', \App\Support\Role::CTO)->count() > 0 ?
                                                'disabled' : ''}}>CTO
                                        </option>
                                        <option value="coo" data-subtext="Chief Operational Officer"
                                                {{\App\Admin::where('role', \App\Support\Role::COO)->count() > 0 ?
                                                'disabled' : ''}}>COO
                                        </option>
                                        <option value="admin">Admin</option>
                                        <option value="photographer">Photographer</option>
                                        <option value="videographer">Videographer</option>
                                        <option value="designer">Designer</option>
                                    </select>
                                    <span class="invalid-feedback" style="display: block">
                                        <strong>Disabled option means that role was already exist!</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col has-feedback">
                                <label for="password">Password</label>
                                <input id="password" type="password" class="form-control" minlength="6" name="password"
                                       placeholder="Password" required>
                                <span class="glyphicon glyphicon-eye-open form-control-feedback right"
                                      aria-hidden="true"></span>
                            </div>
                            <div class="col has-feedback">
                                <label for="confirm">Password Confirmation</label>
                                <input id="confirm" type="password" class="form-control" minlength="6"
                                       name="password_confirmation" placeholder="Retype password" required
                                       onkeyup="return checkPassword($('#password').val(), $(this).val(), 'create')">
                                <span class="glyphicon glyphicon-eye-open form-control-feedback right"
                                      aria-hidden="true"></span>
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

    <div class="modal fade" id="settingsModal" tabindex="-1" role="dialog" aria-labelledby="settingsModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Account Settings</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="as-form" method="post" action="{{route('update.account.admins')}}">
                    {{csrf_field()}}
                    {{method_field('PUT')}}
                    <div class="modal-body">
                        <input type="hidden" name="admin_id">
                        <div class="row form-group">
                            <div class="col">
                                <label class="control-label mb-0" for="as-email">Email</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                    </div>
                                    <input id="as-email" type="email" class="form-control" name="email"
                                           placeholder="Email" required>
                                </div>
                            </div>
                            <div class="col fix-label-group">
                                <label class="control-label mb-0" for="as-role">Role</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fix-label-item" style="height: 2.25rem">
                                            <i class="fa fa-user-shield"></i></span>
                                    </div>
                                    <select id="as-role" class="form-control selectpicker" title="-- Choose --"
                                            name="role" required data-live-search="true">
                                        <option value="ceo" data-subtext="Chief Executive Officer"
                                                {{\App\Admin::where('role', \App\Support\Role::CEO)->count() > 0 ?
                                                'disabled' : ''}}>CEO
                                        </option>
                                        <option value="cto" data-subtext="Chief Technology Officer"
                                                {{\App\Admin::where('role', \App\Support\Role::CTO)->count() > 0 ?
                                                'disabled' : ''}}>CTO
                                        </option>
                                        <option value="coo" data-subtext="Chief Operational Officer"
                                                {{\App\Admin::where('role', \App\Support\Role::COO)->count() > 0 ?
                                                'disabled' : ''}}>COO
                                        </option>
                                        <option value="admin">Admin</option>
                                        <option value="photographer">Photographer</option>
                                        <option value="videographer">Videographer</option>
                                        <option value="designer">Designer</option>
                                    </select>
                                    <span class="invalid-feedback" style="display: block">
                                        <strong>Disabled option means that role was already exist!</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col has-feedback">
                                <label for="curr_password">Current Password</label>
                                <input id="curr_password" type="password" class="form-control" minlength="6"
                                       name="password" placeholder="Current Password" required>
                                <span class="glyphicon glyphicon-eye-open form-control-feedback right"
                                      aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col has-feedback">
                                <label for="as-password">New Password</label>
                                <input id="as-password" type="password" class="form-control" minlength="6"
                                       name="new_password" placeholder="New Password" required>
                                <span class="glyphicon glyphicon-eye-open form-control-feedback right"
                                      aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col has-feedback">
                                <label for="as-confirm">Password Confirmation</label>
                                <input id="as-confirm" type="password" class="form-control" minlength="6"
                                       name="password_confirmation" placeholder="Retype password" required
                                       onkeyup="return checkPassword($('#as-password').val(), $(this).val(), 'edit')">
                                <span class="glyphicon glyphicon-eye-open form-control-feedback right"
                                      aria-hidden="true"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="ep-form" method="post" action="{{route('update.profile.admins')}}"
                      enctype="multipart/form-data">
                    {{csrf_field()}}
                    {{method_field('PUT')}}
                    <div class="modal-body">
                        <input type="hidden" name="admin_id">
                        <div class="row">
                            <div class="col-4 text-center align-self-center">
                                <img class="img-thumbnail" id="ep-btn_img" style="cursor: pointer"
                                     data-toggle="tooltip" data-placement="bottom" alt="avatar" src="#"
                                     title="Allowed extension: jpg, jpeg, gif, png. Allowed size: < 2 MB">
                            </div>
                            <div class="col-8">
                                <div class="row form-group">
                                    <div class="col">
                                        <label class="control-label mb-0" for="ep-ava">Avatar
                                            <sub>(optional)</sub></label>
                                        <input type="file" name="ava" style="display: none;" accept="image/*"
                                               id="ep-ava">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-user"></i></span>
                                            </div>
                                            <input type="text" id="ep-txt_ava" class="browse_files form-control"
                                                   placeholder="Upload file here..." readonly style="cursor: pointer"
                                                   data-toggle="tooltip" data-placement="top"
                                                   title="Allowed extension: jpg, jpeg, gif, png. Allowed size: < 2 MB">
                                            <div class="input-group-append">
                                                <button class="browse_files btn btn-primary" type="button">
                                                    <i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col">
                                        <label class="control-label mb-0" for="ep-name">Full Name</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                            </div>
                                            <input id="ep-name" type="text" class="form-control" maxlength="191"
                                                   name="name"
                                                   placeholder="Full name" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
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
            var export_filename = 'Admins Table ({{now()->format('j F Y')}})';
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

        function createAdmin() {
            $(".fix-label-group .bootstrap-select").addClass('p-0');
            $(".fix-label-group .bootstrap-select button").css('border-color', '#e4e6fc');
            $("#createModal").modal('show');

            $(".browse_files").on('click', function () {
                $("#ava").trigger('click');
            });

            $("#ava").on('change', function () {
                var files = $(this).prop("files");
                var names = $.map(files, function (val) {
                    return val.name;
                });
                var txt = $("#txt_ava");
                txt.val(names);
                $("#txt_ava[data-toggle=tooltip]").attr('data-original-title', names).tooltip('show');
            });
        }

        $('#password + .glyphicon').on('click', function () {
            $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
            $('#password').togglePassword();
        });

        $('#confirm + .glyphicon').on('click', function () {
            $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
            $('#confirm').togglePassword();
        });

        function accountSettings(id, email, role) {
            $(".fix-label-group .bootstrap-select").addClass('p-0');
            $(".fix-label-group .bootstrap-select button").css('border-color', '#e4e6fc');

            if (role == 'root') {
                $(".fix-label-group").hide();
                $("#as-role").removeAttr('required').val('').selectpicker('refresh');
            } else {
                $(".fix-label-group").show();
                $("#as-role").attr('required', 'required').val(role).selectpicker('refresh');
            }

            $("#as-form input[name=admin_id]").val(id);
            $("#as-email").val(email);
            $("#settingsModal").modal("show");
        }

        $('#curr_password + .glyphicon').on('click', function () {
            $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
            $('#curr_password').togglePassword();
        });

        $('#as-password + .glyphicon').on('click', function () {
            $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
            $('#as-password').togglePassword();
        });

        $('#as-confirm + .glyphicon').on('click', function () {
            $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
            $('#as-confirm').togglePassword();
        });

        function checkPassword(password, confirm, check) {
            if (check == 'create') {
                if (password != confirm) {
                    $("#password, #confirm").addClass('is-invalid');
                    $("#password").parent().parent().addClass('has-danger');
                    $("#create-form button[type=submit]").attr('disabled', 'disabled');
                } else {
                    $("#password, #confirm").removeClass('is-invalid');
                    $("#password").parent().parent().removeClass('has-danger');
                    $("#create-form button[type=submit]").removeAttr('disabled');
                }
            } else {
                if (password != confirm) {
                    $("#as-password, #as-confirm").addClass('is-invalid');
                    $("#as-password").parent().parent().addClass('has-danger');
                    $("#as-form button[type=submit]").attr('disabled', 'disabled');
                } else {
                    $("#as-password, #as-confirm").removeClass('is-invalid');
                    $("#as-password").parent().parent().removeClass('has-danger');
                    $("#as-form button[type=submit]").removeAttr('disabled');
                }
            }
        }

        function editProfile(id, ava, name) {
            var $path = ava == "" ? '{{asset('images/avatar.png')}}' : '{{asset('storage/admins/ava/')}}/' + ava;

            $("#ep-name").val(name);
            $("#ep-form input[name=admin_id]").val(id);
            $("#profileModal").modal("show");

            $(".browse_files").on('click', function () {
                $("#ep-ava").trigger('click');
            });

            $("#ep-btn_img").attr('src', $path).on('click', function () {
                $("#ep-ava").trigger('click');
            });

            $("#ep-ava").on('change', function () {
                var files = $(this).prop("files");
                var names = $.map(files, function (val) {
                    return val.name;
                });
                var txt = $("#ep-txt_ava");
                txt.val(names);
                $("#ep-txt_ava[data-toggle=tooltip]").attr('data-original-title', names).tooltip('show');
            });
        }
    </script>
@endpush