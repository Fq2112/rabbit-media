@section('title', ''.$user->name.'\'s Account Settings: Change Password | Rabbit Media – Digital Creative Service')
@extends('layouts.auth.mst_client')
@section('inner-content')
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 text-center" data-aos="fade-right">
            @include('layouts.partials.auth._form_ava-client')
        </div>
        <div class="col-xl-8 col-lg-8 col-md-6 col-sm-12" data-aos="fade-left">
            <div class="card">
                <form class="form-horizontal" role="form" method="POST" id="form-password">
                    {{ csrf_field() }}
                    {{ method_field('put') }}
                    <div class="card-content">
                        <div class="card-title">
                            <small style="font-weight: 600">Account Settings</small>
                            <hr class="mt-0">
                            <small>Primary E-mail (verified)</small>
                            <div class="row form-group has-feedback">
                                <div class="col">
                                    <input type="email" class="form-control" value="{{$user->email}}" disabled>
                                    <span class="glyphicon glyphicon-check form-control-feedback"></span>
                                </div>
                            </div>

                            <small style="cursor: pointer; color: #592f83" id="show_password_settings">Change Password
                                ?
                            </small>
                            <div id="password_settings" style="display: none">
                                <div id="error_curr_pass" class="row form-group has-feedback">
                                    <div class="col">
                                        <input placeholder="Current password" id="check_password" type="password"
                                               class="form-control" name="password" minlength="6" required autofocus>
                                        <span class="glyphicon glyphicon-eye-open form-control-feedback"
                                              style="pointer-events: all;cursor: pointer"></span>
                                        <span class="invalid-feedback">
                                            <strong class="aj_pass" style="text-transform: none"></strong>
                                        </span>
                                    </div>
                                </div>

                                <div id="error_new_pass" class="row form-group has-feedback">
                                    <div class="col">
                                        <input placeholder="New password" id="password" type="password"
                                               class="form-control" name="new_password" minlength="6" required>
                                        <span class="glyphicon glyphicon-eye-open form-control-feedback"
                                              style="pointer-events: all;cursor: pointer"></span>
                                        @if ($errors->has('new_password'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('new_password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col">
                                        <input placeholder="Retype password" id="password-confirm" type="password"
                                               class="form-control" name="password_confirmation" minlength="6" required
                                               onkeyup="return checkPassword()">
                                        <span class="glyphicon glyphicon-eye-open form-control-feedback"
                                              style="pointer-events: all;cursor: pointer"></span>
                                        <span class="invalid-feedback">
                                            <strong class="aj_new_pass" style="text-transform: none"></strong>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer p-0">
                        <button id="btn_save_password" class="btn btn-primary btn-block" disabled>
                            <i class="fa fa-lock mr-2"></i>SAVE CHANGES
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push("scripts")
    <script>
        $("#show_password_settings").click(function () {
            $(this).text(function (i, v) {
                return v === "PASSWORD SETTINGS" ? "Change Password ?" : "PASSWORD SETTINGS";
            });
            if ($(this).text() === 'Change Password ?') {
                this.style.color = "#592f83";
            } else {
                this.style.color = "#7f7f7f";
            }

            $("#password_settings").toggle(300);
            if ($("#btn_save_password").attr('disabled')) {
                $("#btn_save_password").removeAttr('disabled');
            } else {
                $("#btn_save_password").attr('disabled', 'disabled');
            }
        });

        $('#check_password + .glyphicon').on('click', function () {
            $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
            $('#check_password').togglePassword();
        });

        $('#password + .glyphicon').on('click', function () {
            $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
            $('#password').togglePassword();
        });

        $('#password-confirm + .glyphicon').on('click', function () {
            $(this).toggleClass('glyphicon-eye-open glyphicon-eye-close');
            $('#password-confirm').togglePassword();
        });

        function checkPassword() {
            var new_pas = $("#password").val(),
                re_pas = $("#password-confirm").val();
            if (new_pas != re_pas) {
                $("#password, #password-confirm").addClass('is-invalid');
                $("#error_new_pass").addClass('has-danger');
                $(".aj_new_pass").text("Konfirmasi password harus sama dengan password baru Anda!").parent().show();
                $("#btn_save_password").attr('disabled', 'disabled');
            } else {
                $("#password, #password-confirm").removeClass('is-invalid');
                $("#error_new_pass").removeClass('has-danger');
                $(".aj_new_pass").text("").parent().hide();
                $("#btn_save_password").removeAttr('disabled');
            }
        }
    </script>
    @include('layouts.partials.auth._scripts_ajax-client')
@endpush
