<div class="card">
    <form class="form-horizontal" role="form" method="POST" id="form-ava" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ method_field('put') }}
        <div class="img-card image-upload">
            <label for="file-input">
                <img style="width: 100%" class="show_ava" alt="Avatar" src="{{$user->ava == "" ? asset('images/avatar.png') :
                asset('storage/users/ava/'.$user->ava)}}" data-placement="bottom" data-toggle="tooltip"
                     title="Klik disini untuk mengubah avatar Anda!">
            </label>
            <input id="file-input" name="ava" type="file" accept="image/*">
            <div id="progress-upload">
                <div class="progress-bar progress-bar-info progress-bar-striped active"
                     role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                     style="background-color: #592f83;z-index: 20">
                </div>
            </div>
        </div>
    </form>

    <form action="{{route('client.update.profile')}}" method="post">
        {{csrf_field()}}
        {{method_field('PUT')}}
        <input type="hidden" name="check_form" value="personal_data">
        <div class="card-content">
            <div class="card-title text-center">
                <a href="{{route('client.edit.profile')}}">
                    <h4 class="aj_name" style="color: #312855">{{$user->name}}</h4></a>
                <small style="color: #592f83;text-transform: lowercase">{{$user->email}}</small>
            </div>
            <div class="card-title">
                @if(\Illuminate\Support\Facades\Request::is('account/profile'))
                    <div id="show_personal_data_settings" class="row justify-content-center"
                         style="color: #592f83;cursor: pointer;font-size: 14px">
                        <div class="col text-right"><i class="fa fa-edit mr-2"></i>EDIT</div>
                    </div>
                @endif
                <table class="stats_personal_data" style="font-size: 15px;margin-top: 0">
                    <tr data-toggle="tooltip" data-placement="left" title="Jenis Kelamin">
                        <td><i class="fa fa-transgender"></i></td>
                        <td>&nbsp;</td>
                        <td>{{$user->jk != "" ? ucfirst($user->jk) : '(kosong)'}}</td>
                    </tr>
                    <tr data-toggle="tooltip" data-placement="left" title="Tanggal Lahir">
                        <td><i class="fa fa-birthday-cake"></i></td>
                        <td>&nbsp;</td>
                        <td>{{$user->tgl_lahir != "" ? \Carbon\Carbon::parse($user->tgl_lahir)->format('j F Y') : '(kosong)'}}</td>
                    </tr>
                    <tr data-toggle="tooltip" data-placement="left" title="Nomor Telepon">
                        <td><i class="fa fa-phone"></i></td>
                        <td>&nbsp;</td>
                        <td>{{$user->no_telp != "" ? $user->no_telp : '(kosong)'}}</td>
                    </tr>
                    <tr data-toggle="tooltip" data-placement="left" title="Alamat Lengkap">
                        <td><i class="fa fa-map-marked-alt"></i></td>
                        <td>&nbsp;</td>
                        <td>{{$user->alamat != "" ? $user->alamat : '(kosong)'}}</td>
                    </tr>
                </table>
                <hr class="stats_personal_data">
                <table class="stats_personal_data" style="font-size: 14px;margin-top: 0">
                    <tr>
                        <td><i class="fa fa-calendar-check"></i></td>
                        <td>&nbsp;Member Since</td>
                        <td>: {{$user->created_at->format('j F Y')}}</td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-clock"></i></td>
                        <td>&nbsp;Last Update</td>
                        <td>: {{$user->updated_at->diffForHumans()}}</td>
                    </tr>
                </table>
                <div id="personal_data_settings" style="display: none">
                    <small>Full Name</small>
                    <div class="row form-group">
                        <div class="col">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                </div>
                                <input placeholder="Name" maxlength="191" value="{{$user->name}}"
                                       type="text" class="form-control" name="name" required autofocus>
                            </div>
                        </div>
                    </div>

                    <small>Gender</small>
                    <div class="row form-group">
                        <div class="col">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-transgender"></i></span>
                                </div>
                                <select class="form-control" name="jk" required>
                                    <option value="" selected disabled>-- Choose --</option>
                                    <option value="male" {{$user->jk == "male" ? 'selected' : ''}}>Male</option>
                                    <option value="female" {{$user->jk == "female" ? 'selected' : ''}}>Female</option>
                                    <option value="other" {{$user->jk == "other" ? 'selected' : ''}}>Rather not say
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <small>Birthday</small>
                    <div class="row form-group">
                        <div class="col">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-birthday-cake"></i></span>
                                </div>
                                <input class="form-control datepicker" name="tgl_lahir" type="text" required
                                       placeholder="yyyy-mm-dd" value="{{$user->tgl_lahir}}" maxlength="10">
                            </div>
                        </div>
                    </div>

                    <small>Phone</small>
                    <div class="row form-group">
                        <div class="col">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                </div>
                                <input placeholder="08123xxxxxxx" type="text" maxlength="13" class="form-control"
                                       name="no_telp" onkeypress="return numberOnly(event, false)"
                                       value="{{$user->no_telp != "" ? $user->no_telp : ''}}" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(\Illuminate\Support\Facades\Request::is('account/profile'))
            <div class="card-footer p-0">
                <button class="btn btn-primary btn-block" id="btn_save_personal_data" disabled>
                    <i class="fa fa-user mr-2"></i>SAVE CHANGES
                </button>
            </div>
        @endif
    </form>
</div>