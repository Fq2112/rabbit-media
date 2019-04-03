<div class="modal fade login" id="loginModal">
    <div class="modal-dialog login animated">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Login with</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <!-- Sign in form -->
                <div class="box">
                    <div class="content">
                        <div class="social">
                            <a class="circle github" href="{{route('redirect', ['provider' => 'github'])}}"
                               data-toggle="tooltip" data-title="Github" data-placement="left">
                                <i class="fab fa-github fa-fw"></i>
                            </a>
                            <a id="facebook_login" class="circle facebook"
                               href="{{route('redirect', ['provider' => 'facebook'])}}"
                               data-toggle="tooltip" data-title="Facebook" data-placement="top">
                                <i class="fab fa-facebook-f fa-fw"></i>
                            </a>
                            <a id="linkedin_login" class="circle linkedin"
                               href="{{route('redirect', ['provider' => 'linkedin'])}}"
                               data-toggle="tooltip" data-title="Linkedin" data-placement="bottom">
                                <i class="fab fa-linkedin-in fa-fw"></i>
                            </a>
                            {{--<a id="twitter_login" class="circle twitter"
                               href="{{route('redirect', ['provider' => 'twitter'])}}"
                               data-toggle="tooltip" data-title="Twitter" data-placement="bottom">
                                <i class="fab fa-twitter fa-fw"></i>
                            </a>--}}
                            <a id="google_login" class="circle google"
                               href="{{route('redirect', ['provider' => 'google'])}}"
                               data-toggle="tooltip" data-title="Google+" data-placement="right">
                                <i class="fab fa-google-plus-g fa-fw"></i>
                            </a>
                        </div>
                        <div class="division">
                            <div class="line l"></div>
                            <span>or</span>
                            <div class="line r"></div>
                        </div>
                        <div class="error"></div>
                        <div class="form loginBox">
                            @if(session('success') || session('recovered'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                                    </button>
                                    <h4><i class="icon fa fa-check"></i> Alert!</h4>
                                    {{session('success') ? session('success') : session('recovered')}}
                                </div>
                            @elseif(session('error') || session('inactive'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                                    </button>
                                    <h4><i class="icon fa fa-times"></i> Alert!</h4>
                                    {{session('error') ? session('error') : session('inactive')}}
                                </div>
                            @endif
                            <form method="post" accept-charset="UTF-8" class="form-horizontal"
                                  action="{{ route('login') }}" id="form-login">
                                {{ csrf_field() }}

                                <div class="row has-feedback">
                                    <div class="col-12">
                                        <input class="form-control" type="email" placeholder="Email"
                                               name="email" value="{{ old('email') }}" required>
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                    </div>
                                </div>
                                <div class="row has-feedback">
                                    <div class="col-12">
                                        <input id="log_password" class="form-control" type="password"
                                               placeholder="Password" name="password" minlength="6" required>
                                        <span class="glyphicon glyphicon-eye-open form-control-feedback"
                                              style="pointer-events: all;cursor: pointer"></span>
                                        <span class="help-block">
                                            @if(session('error'))
                                                <strong>{{ $errors->first('password') }}</strong>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 checkbox">
                                        <label>
                                            <input type="checkbox" name="remember" {{old('remember') ? 'checked' : ''}}
                                            style="position: relative"> Remember me
                                        </label>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a href="javascript:openEmailModal()">Forgot password?</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12" id="recaptcha-login"></div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <input id="btn_login" class="btn btn-primary py-3 px-4 text-white btn-login"
                                               type="submit" value="SIGN IN" disabled>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Sign up form -->
                <div class="box">
                    <div class="content registerBox" style="display:none;">
                        <div class="form">
                            @if ($errors->has('email'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                                    </button>
                                    <h4><i class="icon fa fa-times"></i> Alert!</h4>
                                    {{ $errors->first('email') }}
                                </div>
                            @elseif($errors->has('password') || $errors->has('name'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                                    </button>
                                    <h4><i class="icon fa fa-times"></i> Alert!</h4>
                                    {{ $errors->has('password') ? $errors->first('password') : $errors->first('name') }}
                                </div>
                            @endif
                            <div id="reg_errorAlert"></div>
                            <form method="post" accept-charset="UTF-8" class="form-horizontal"
                                  action="{{ route('register') }}" id="form-register">
                                {{ csrf_field() }}
                                <div class="row has-feedback">
                                    <div class="col-12">
                                        <input id="reg_name" type="text" placeholder="Full name"
                                               class="form-control" name="name" required>
                                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                    </div>
                                </div>
                                <div class="row has-feedback">
                                    <div class="col-12">
                                        <input id="reg_email" class="form-control" type="email"
                                               placeholder="Email" name="email" required>
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                    </div>
                                </div>
                                <div class="row has-feedback">
                                    <div class="col-12">
                                        <input class="form-control" type="password" placeholder="Password"
                                               id="reg_password" name="password" minlength="6" required>
                                        <span class="glyphicon glyphicon-eye-open form-control-feedback"
                                              style="pointer-events: all;cursor: pointer"></span>
                                    </div>
                                </div>
                                <div class="row has-feedback">
                                    <div class="col-12">
                                        <input class="form-control" type="password" placeholder="Retype password"
                                               id="reg_password_confirm" name="password_confirmation"
                                               minlength="6" required>
                                        <span class="glyphicon glyphicon-eye-open form-control-feedback"
                                              style="pointer-events: all;cursor: pointer"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12" style="font-size: 15px;text-align: justify">
                                        <small>
                                            By continuing this, you acknowledge that you accept on Rabbit's
                                            <a href="{{route('info')}}" target="_blank">Privacy Policy</a> and
                                            <a href="{{route('info')}}" target="_blank">Terms & Conditions</a>.
                                        </small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12" id="recaptcha-register"></div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <input id="btn_register"
                                               class="btn btn-primary py-3 px-4 text-white btn-register"
                                               type="submit" value="CREATE ACCOUNT" disabled>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Reset password form -->
                <div class="box">
                    <div class="content emailBox" style="display:none;">
                        <div class="form">
                            @if(session('resetLink') || session('resetLink_failed'))
                                <div class="alert alert-{{session('resetLink') ? 'success' : 'danger'}} alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                                    </button>
                                    <h4><i class="icon fa fa-{{session('resetLink') ? 'check' : 'times'}}"></i> Alert!
                                    </h4>
                                    {{session('resetLink') ? session('resetLink') : session('resetLink_failed')}}
                                </div>
                            @endif
                            <form method="post" accept-charset="UTF-8" class="form-horizontal"
                                  action="{{ route('password.email') }}">
                                {{ csrf_field() }}

                                <div class="row {{ $errors->has('Email') ? ' has-error' : '' }} has-feedback">
                                    <div class="col-12">
                                        <input class="form-control" type="email" placeholder="Email" name="email"
                                               value="{{ old('email') }}" required>
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <input class="btn btn-primary py-2 px-4 text-white btn-login" type="submit"
                                               value="send password reset link">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Recovery password form -->
                <div class="box">
                    @if(session('recover_failed'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                            </button>
                            <h4><i class="icon fa fa-times"></i> Alert!</h4>
                            {{ session('recover_failed') }}
                        </div>
                    @endif
                    <div class="content passwordBox" style="display:none;">
                        <div id="forg_errorAlert"></div>
                        <div class="form">
                            <form id="form-recovery" method="post" accept-charset="UTF-8" class="form-horizontal"
                                  action="{{route('password.request',
                                  ['token' => session('reset') ? session('reset')['token'] : old('token')])}}">
                                {{ csrf_field() }}
                                <div class="row {{ $errors->has('Email') ? ' has-error' : '' }} has-feedback">
                                    <div class="col-12">
                                        <input class="form-control" type="email" placeholder="Email" name="email"
                                               value="{{ old('email') }}" required>
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row {{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
                                    <div class="col-12">
                                        <input id="forg_password" class="form-control" type="password"
                                               placeholder="New Password" name="password" minlength="6" required>
                                        <span class="glyphicon glyphicon-eye-open form-control-feedback"
                                              style="pointer-events: all;cursor: pointer"></span>
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row {{ $errors->has('password_confirmation') ? ' has-error' : '' }} has-feedback">
                                    <div class="col-12">
                                        <input id="forg_password_confirm" class="form-control" type="password"
                                               placeholder="Retype password" name="password_confirmation"
                                               minlength="6" onkeyup="return checkForgotPassword()" required>
                                        <span class="glyphicon glyphicon-eye-open form-control-feedback"
                                              style="pointer-events: all;cursor: pointer"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <input class="btn btn-primary py-2 px-4 text-white btn-login btn-password"
                                               type="submit" value="reset password">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="forgot login-footer">
                    <span>Looking to <a href="javascript:showRegisterForm()">create an account</a>?</span>
                </div>
                <div class="forgot register-footer" style="display:none">
                    <span>Already have an account? <a href="javascript:showLoginForm()">Sign In</a></span>
                </div>
            </div>
        </div>
    </div>
</div>