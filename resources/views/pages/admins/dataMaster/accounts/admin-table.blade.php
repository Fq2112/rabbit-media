@extends('layouts.auth.mst_admin')
@section('title', 'The Rabbits: Admins Table | Rabbit Media – Digital Creative Service')
@push('styles')
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/datatables.min.css')}}">
    <link rel="stylesheet"
          href="{{asset('admins/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Buttons-1.5.6/css/buttons.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/bootstrap-social/bootstrap-social.css')}}">
    <style>
        #password + .glyphicon, #confirm + .glyphicon,
        #curr_password + .glyphicon, #as-password + .glyphicon, #as-confirm + .glyphicon {
            cursor: pointer;
            pointer-events: all;
        }

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
            <h1>Admins Table</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('home-admin')}}">Dashboard</a></div>
                <div class="breadcrumb-item">Data Master</div>
                <div class="breadcrumb-item">Accounts</div>
                <div class="breadcrumb-item">Admins</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        @if(Auth::guard('admin')->user()->isRoot())
                            <div class="card-header">
                                <div class="card-header-form">
                                    <button onclick="createAdmin()" class="btn btn-primary text-uppercase">
                                        <strong><i class="fas fa-plus mr-2"></i>Create</strong>
                                    </button>
                                </div>
                            </div>
                        @endif
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
                                        <th class="text-center">Position / Role</th>
                                        <th class="text-center">Created at</th>
                                        <th class="text-center">Last Update</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $no = 1; @endphp
                                    @foreach($admins as $admin)
                                        @php
                                            if($admin->isRoot()){
                                                $badge = 'primary';
                                            } elseif($admin->isAdmin()){
                                                $badge = 'info';
                                            } else{
                                                $badge = 'danger';
                                            }

                                            $created_at = \Carbon\Carbon::parse($admin->created_at)->format('j F Y');
                                            $updated_at = \Carbon\Carbon::parse($admin->updated_at)->diffForHumans();
                                            $orders = $admin->getOrderLog != null ? $admin->getOrderLog->count() : 0;
                                        @endphp
                                        <tr>
                                            <td style="vertical-align: middle" align="center">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" id="cb-{{$admin->id}}"
                                                           class="custom-control-input dt-checkboxes">
                                                    <label for="cb-{{$admin->id}}"
                                                           class="custom-control-label">{{$no++}}</label>
                                                </div>
                                            </td>
                                            <td style="vertical-align: middle" align="center">{{$admin->id}}</td>
                                            <td style="vertical-align: middle">
                                                <img class="img-thumbnail float-left mr-2" width="80" alt="avatar.png"
                                                     src="{{$admin->ava == "" ? asset('images/avatar.png') :
                                                     asset('storage/admins/ava/'.$admin->ava)}}">
                                                <strong>{{$admin->name}}</strong><br>
                                                <a href="mailto:{{$admin->email}}">{{$admin->email}}</a>
                                            </td>
                                            <td style="vertical-align: middle;text-transform: uppercase;"
                                                align="center"><span class="badge badge-{{$badge}}">
                                                    <strong>{{$admin->jabatan.' / '.$admin->role}}</strong></span>
                                            </td>
                                            <td style="vertical-align: middle" align="center">
                                                {{\Carbon\Carbon::parse($admin->created_at)->format('j F Y')}}</td>
                                            <td style="vertical-align: middle"
                                                align="center">{{$admin->updated_at->diffForHumans()}}</td>
                                            <td style="vertical-align: middle" align="center">
                                                @if(Auth::guard('admin')->user()->isRoot())
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-primary"
                                                                onclick="editProfile('{{$admin->id}}','{{$admin->ava}}',
                                                                        '{{$admin->name}}','{{$admin->jabatan}}')">
                                                            <strong><i class="fa fa-user-edit mr-2"></i>EDIT</strong>
                                                        </button>
                                                        <button id="option" type="button"
                                                                class="btn btn-primary dropdown-toggle"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false"></button>
                                                        <div class="dropdown-menu" aria-labelledby="option">
                                                            <a class="dropdown-item" href="javascript:void(0)"
                                                               onclick="openProfile('{{$admin->id}}','{{$admin->ava}}',
                                                                       '{{$admin->email}}','{{$admin->name}}',
                                                                       '{{$admin->jabatan}}','{{$admin->role}}',
                                                                       '{{$admin->deskripsi}}','{{$admin->facebook}}',
                                                                       '{{$admin->twitter}}','{{$admin->instagram}}',
                                                                       '{{$admin->whatsapp}}','{{$created_at}}',
                                                                       '{{$updated_at}}','{{$orders}}')">
                                                                <i class="fas fa-info-circle mr-2"></i>Details</a>
                                                            <a class="dropdown-item" href="javascript:void(0)"
                                                               onclick="accountSettings('{{$admin->id}}',
                                                                       '{{$admin->email}}','{{$admin->role}}')">
                                                                <i class="fa fa-user-cog mr-2"></i>Settings</a>
                                                            <a class="dropdown-item delete-data"
                                                               href="{{route('delete.admins',
                                                               ['id'=>encrypt($admin->id)])}}">
                                                                <i class="fa fa-trash-alt mr-2"></i>Delete</a>
                                                        </div>
                                                    </div>
                                                @else
                                                    <button class="btn btn-info" data-toggle="tooltip" title="Details"
                                                            data-placement="left" onclick="openProfile('{{$admin->id}}',
                                                            '{{$admin->ava}}','{{$admin->email}}','{{$admin->name}}',
                                                            '{{$admin->jabatan}}','{{$admin->role}}',
                                                            '{{$admin->deskripsi}}','{{$admin->facebook}}',
                                                            '{{$admin->twitter}}','{{$admin->instagram}}',
                                                            '{{$admin->whatsapp}}','{{$created_at}}','{{$updated_at}}',
                                                            '{{$orders}}')">
                                                        <i class="fas fa-info-circle"></i>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <form method="post" id="form-admin">
                                    {{csrf_field()}}
                                    <input type="hidden" name="admin_ids">
                                </form>
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
                                <label for="ava">Avatar <sub>(optional)</sub></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" name="ava" class="custom-file-input" id="ava"
                                               accept="image/*">
                                        <label class="custom-file-label" id="txt_ava">Choose File</label>
                                    </div>
                                </div>
                                <div class="form-text text-muted">
                                    Allowed extension: jpg, jpeg, gif, png. Allowed size: < 2 MB
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col">
                                <label for="name">Full Name</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                    </div>
                                    <input id="name" type="text" class="form-control" maxlength="191" name="name"
                                           placeholder="Full name" required>
                                </div>
                            </div>
                            <div class="col fix-label-group">
                                <label for="jabatan">Position</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fix-label-item" style="height: 2.25rem">
                                            <i class="fa fa-user-tie"></i></span>
                                    </div>
                                    <select id="jabatan" class="form-control selectpicker" title="-- Choose --"
                                            name="jabatan" data-live-search="true" required>
                                        <option value="ceo" data-subtext="Chief Executive Officer" {{\App\Admin::where
                                        ('jabatan', 'CEO')->count() > 0 ? 'disabled' : ''}}>CEO
                                        </option>
                                        <option value="cto" data-subtext="Chief Technology Officer" {{\App\Admin::where
                                        ('jabatan', 'CTO')->count() > 0 ? 'disabled' : ''}}>CTO
                                        </option>
                                        <option value="coo" data-subtext="Chief Operational Officer" {{\App\Admin::where
                                        ('jabatan', 'COO')->count() > 0 ? 'disabled' : ''}}>COO
                                        </option>
                                        <option value="Administrator">Administrator</option>
                                        <option value="photographer">Photographer</option>
                                        <option value="videographer">Videographer</option>
                                        <option value="designer">Designer</option>
                                    </select>
                                    <span class="invalid-feedback" style="display: block">
                                        <strong>Disabled option means that position was already exist!</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col">
                                <label for="email">Email</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                    </div>
                                    <input id="email" type="email" class="form-control" name="email" placeholder="Email"
                                           required>
                                </div>
                            </div>
                            <div class="col fix-label-group">
                                <label for="role">Role</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fix-label-item" style="height: 2.25rem">
                                            <i class="fa fa-user-shield"></i></span>
                                    </div>
                                    <select id="role" class="form-control selectpicker" title="-- Choose --"
                                            name="role" data-live-search="true" required>
                                        <option value="root">ROOT</option>
                                        <option value="admin">Admin</option>
                                        <option value="staff">Staff</option>
                                    </select>
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
                                <label for="as-email">Email</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                    </div>
                                    <input id="as-email" type="email" class="form-control" name="email"
                                           placeholder="Email" required>
                                </div>
                            </div>
                            <div class="col fix-label-group" id="as-role-div">
                                <label for="as-role">Role</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text fix-label-item" style="height: 2.25rem">
                                            <i class="fa fa-user-shield"></i></span>
                                    </div>
                                    <select id="as-role" class="form-control selectpicker" title="-- Choose --"
                                            name="role" data-live-search="true" required>
                                        <option value="root">ROOT</option>
                                        <option value="admin">Admin</option>
                                        <option value="staff">Staff</option>
                                    </select>
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
                                     title="Click here to change ava!">
                            </div>
                            <div class="col-8">
                                <div class="row form-group">
                                    <div class="col">
                                        <label for="ep-ava">Avatar <sub>(optional)</sub>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-user"></i></span>
                                            </div>
                                            <div class="custom-file">
                                                <input type="file" name="ava" class="custom-file-input" id="ep-ava"
                                                       accept="image/*">
                                                <label class="custom-file-label" id="ep-txt_ava">Choose File</label>
                                            </div>
                                        </div>
                                        <div class="form-text text-muted">
                                            Allowed extension: jpg, jpeg, gif, png. Allowed size: < 2 MB
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col">
                                        <label for="ep-name">Full Name</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                            </div>
                                            <input id="ep-name" type="text" class="form-control" maxlength="191"
                                                   name="name" placeholder="Full name" required>
                                        </div>
                                    </div>
                                    <div class="col fix-label-group">
                                        <label for="ep-jabatan">Position</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text fix-label-item" style="height: 2.25rem">
                                                    <i class="fa fa-user-tie"></i></span>
                                            </div>
                                            <select id="ep-jabatan" class="form-control selectpicker" required
                                                    title="-- Choose --" name="jabatan" data-live-search="true">
                                                <option value="ceo" data-subtext="Chief Executive Officer"
                                                        {{\App\Admin::where('jabatan', 'CEO')->count() > 0 ?
                                                        'disabled' : ''}}>CEO
                                                </option>
                                                <option value="cto" data-subtext="Chief Technology Officer"
                                                        {{\App\Admin::where('jabatan', 'CTO')->count() > 0 ?
                                                        'disabled' : ''}}>CTO
                                                </option>
                                                <option value="coo" data-subtext="Chief Operational Officer"
                                                        {{\App\Admin::where('jabatan', 'COO')->count() > 0 ?
                                                        'disabled' : ''}}>COO
                                                </option>
                                                <option value="Administrator">Administrator</option>
                                                <option value="photographer">Photographer</option>
                                                <option value="videographer">Videographer</option>
                                                <option value="designer">Designer</option>
                                            </select>
                                            <span class="invalid-feedback" style="display: block">
                                                <strong>Disabled option means that position was already exist!</strong>
                                            </span>
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
    <script>
        $(function () {
            var export_filename = 'Admins Table ({{now()->format('j F Y')}})', table = $("#dt-buttons").DataTable({
                dom: "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'B><'col-sm-12 col-md-4'f>>" +
                    "<'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                columnDefs: [
                    {"sortable": false, "targets": 6},
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
                        $("#form-admin input[name=admin_ids]").val(ids);
                        $("#form-admin").attr("action", "{{route('massDelete.admins')}}");

                        if (ids.length > 0) {
                            swal({
                                title: 'Delete Admins',
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
                                    $("#form-admin")[0].submit();
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

        function createAdmin() {
            $(".fix-label-group .bootstrap-select").addClass('p-0');
            $(".fix-label-group .bootstrap-select button").css('border-color', '#e4e6fc');
            $("#createModal").modal('show');

            $("#ava").on('change', function () {
                var files = $(this).prop("files"), names = $.map(files, function (val) {
                    return val.name;
                }), text = names[0];
                $("#txt_ava").text(text.length > 60 ? text.slice(0, 60) + "..." : text);
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
                $("#as-role-div").hide();
                $("#as-role").removeAttr('required').val('').selectpicker('refresh');
            } else {
                $("#as-role-div").show();
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

        function editProfile(id, ava, name, jabatan) {
            $(".fix-label-group .bootstrap-select").addClass('p-0');
            $(".fix-label-group .bootstrap-select button").css('border-color', '#e4e6fc');

            var $path = ava == "" ? '{{asset('images/avatar.png')}}' : '{{asset('storage/admins/ava/')}}/' + ava;

            $("#ep-name").val(name);
            $("#ep-jabatan").val(jabatan).selectpicker('refresh');
            $("#ep-form input[name=admin_id]").val(id);
            $("#profileModal").modal("show");

            $("#ep-txt_ava").text(ava != "" ? ava.slice(0, 60) + "..." : 'Choose File');
            $("#ep-btn_img").attr('src', $path).on('click', function () {
                $("#ep-ava").click();
            });

            $("#ep-ava").on('change', function () {
                var files = $(this).prop("files"), names = $.map(files, function (val) {
                    return val.name;
                }), text = names[0];
                $("#ep-txt_ava").text(text.length > 60 ? text.slice(0, 60) + "..." : text);
            });
        }

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