<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}">

    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300i,400,700" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('fonts/icomoon/style.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('fonts/fontawesome/css/all.css')}}">

    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{asset('css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/owl.theme.default.min.css')}}">

    <link rel="stylesheet" href="{{asset('css/lightgallery.min.css')}}">

    <link rel="stylesheet" href="{{asset('css/bootstrap-datepicker.css')}}">

    <link rel="stylesheet" href="{{asset('fonts/flaticon/font/flaticon.css')}}">

    <link rel="stylesheet" href="{{asset('css/swiper.css')}}">

    <link rel="stylesheet" href="{{asset('css/aos.css')}}">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{asset('sweetalert2/sweetalert2.min.css')}}">
    <script src="{{asset('sweetalert2/sweetalert2.min.js')}}"></script>
    <!-- Modal -->
    <script src="{{ asset('js/modal.js') }}"></script>
    <link rel="stylesheet" href="{{asset('css/modal.css')}}">
    <!-- loading.io -->
    <link rel="stylesheet" href="{{asset('css/loading.css')}}">
    <!-- scroll to top -->
    <link rel="stylesheet" href="{{asset('css/scroll-to-top.css')}}">

    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <style>
        .logotype{
            -webkit-transition: all .3s ease-in-out;
            -moz-transition: all .3s ease-in-out;
            transition: all .3s ease-in-out;
        }

        .logotype:hover{
            -webkit-transition: all .3s ease-in-out;
            -moz-transition: all .3s ease-in-out;
            transition: all .3s ease-in-out;
        }

        .progress {
            position: fixed;
            margin-bottom: 0;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 5px;
            border-radius: 0;
            z-index: 20;
        }

        .progress .bar {
            height: 100%;
            width: 10%;
            background: #592f83;
            transition: background 0.15s ease;
        }
    </style>
    @stack('styles')

    <script src='https://www.google.com/recaptcha/api.js?onload=recaptchaCallback&render=explicit' async defer></script>
</head>
<body>
<a href="#" onclick="scrollToTop()" title="Go to top"><strong class="to-top" style="color: #fff">TOP</strong></a>

<div class="site-wrap">
    <div class="site-mobile-menu">
        <div class="site-mobile-menu-header">
            <div class="site-mobile-menu-close mt-3">
                <span class="icon-close2 js-menu-toggle"></span>
            </div>
        </div>
        <div class="site-mobile-menu-body"></div>
    </div>

    <header class="site-navbar py-3" role="banner">

        <div class="container-fluid">
            <div class="row align-items-center">

                <div class="col-6 col-xl-2" data-aos="fade-down">
                    <h1 class="mb-0">
                        <a href="{{route('home')}}" class="text-black h2 mb-0">
                            <img src="{{asset('images/logo_black.png')}}" class="logotype" width="200"
                                 onmouseover="this.src='{{asset('images/logo_purple.png')}}'"
                                 onmouseout="this.src='{{asset('images/logo_black.png')}}'">
                        </a>
                    </h1>
                </div>
                <div class="col-10 col-md-8 d-none d-xl-block" data-aos="fade-down">
                    <nav class="site-navigation position-relative text-right text-lg-center" role="navigation">

                        <ul class="site-menu js-clone-nav mx-auto d-none d-lg-block">
                            <li class="active"><a href="{{route('home')}}">Home</a></li>
                            <li class="has-children">
                                <a href="single.html">Portfolios</a>
                                <ul class="dropdown">
                                    @foreach(\App\Models\JenisPortofolio::orderBy('nama')->get() as $row)
                                        <li><a href="#">{{$row->nama}}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="has-children">
                                <a href="services.html">Services</a>
                                <ul class="dropdown">
                                    @foreach(\App\Models\JenisLayanan::orderBy('nama')->get() as $row)
                                        <li><a href="#">{{$row->nama}}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            <li><a href="about.html">Feedback</a></li>
                            <li><a href="contact.html">About Us</a></li>
                            <li><a href="javascript:void(0)" data-toggle="modal"
                                   onclick="openRegisterModal();" style="font-weight: 900;">Sign Up/In</a></li>
                        </ul>
                    </nav>
                </div>

                <div class="col-6 col-xl-2 text-right" data-aos="fade-down">
                    <div class="d-none d-xl-inline-block">
                        <ul class="site-menu js-clone-nav ml-auto list-unstyled d-flex text-right mb-0"
                            data-class="social">
                            <li><a href="https://fb.com/RabbitMedia" class="pl-0 pr-3"
                                   target="_blank"><span class="icon-facebook"></span></a></li>
                            <li><a href="https://twitter.com/RabbitMediaID" class="pl-3 pr-3"
                                   target="_blank"><span class="icon-twitter"></span></a></li>
                            <li><a href="https://instagram.com/rabbit.media" class="pl-3 pr-3"
                                   target="_blank"><span class="icon-instagram"></span></a></li>
                            <li><a href="https://www.youtube.com/channel/UCjKrYWn5JL6dR48nvXKUibw" class="pl-3 pr-3"
                                   target="_blank"><span class="icon-youtube-play"></span></a></li>
                        </ul>
                    </div>

                    <div class="d-inline-block d-xl-none ml-md-0 mr-auto py-3" style="position: relative; top: 3px;"><a
                                href="#" class="site-menu-toggle js-menu-toggle text-black"><span
                                    class="icon-menu h3"></span></a></div>

                </div>

            </div>
        </div>
    </header>

    @yield('content')

    <div class="footer py-4">
        <div class="container-fluid">
            <p>
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                &copy; {{now()->format('Y')}} <a href="http://rabbit-media.net" target="_blank">Rabbit Media</a>. All
                rights reserved. Designed by <a href="http://rabbit-media.net" target="_blank">Rabbit Media</a><br>This
                template is made by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            </p>
        </div>
    </div>


</div>

<!-- modal sign up -->
<div class="modal fade login" id="loginModal">
    <div class="modal-dialog login animated">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Login with</h4>
            </div>
            <div class="modal-body">
                <!-- Sign in form -->
                <div class="box">
                    <div class="content">
                        @if(!\Illuminate\Support\Facades\Request::is('agency'))
                            <div class="social">
                                <a class="circle github" href="{{route('redirect', ['provider' => 'github'])}}"
                                   data-toggle="tooltip" data-title="Github" data-placement="left">
                                    <i class="fab fa-github fa-fw"></i>
                                </a>
                                {{--<a id="facebook_login" class="circle facebook"
                                   href="{{route('redirect', ['provider' => 'facebook'])}}"
                                   data-toggle="tooltip" data-title="Facebook" data-placement="top">
                                    <i class="fab fa-facebook-f fa-fw"></i>
                                </a>--}}
                                <a id="linkedin_login" class="circle linkedin"
                                   href="{{route('redirect', ['provider' => 'linkedin'])}}"
                                   data-toggle="tooltip" data-title="Linkedin" data-placement="top">
                                    <i class="fab fa-linkedin-in fa-fw"></i>
                                </a>
                                <a class="circle twitter" href="{{route('redirect', ['provider' => 'twitter'])}}"
                                   data-toggle="tooltip" data-title="Twitter" data-placement="bottom">
                                    <i class="fab fa-twitter fa-fw"></i>
                                </a>
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
                        @endif
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
                                    <div class="col-lg-12">
                                        <input class="form-control" type="email" placeholder="Email"
                                               name="email" value="{{ old('email') }}" required>
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                    </div>
                                </div>
                                <div class="row has-feedback">
                                    <div class="col-lg-12">
                                        <input id="log_password" class="form-control" type="password"
                                               placeholder="Password" name="password" minlength="6" required>
                                        <span class="glyphicon glyphicon-eye-open form-control-feedback"></span>
                                        <span class="help-block">
                                            @if(session('error'))
                                                <strong>{{ $errors->first('password') }}</strong>
                                            @endif
                                                <a href="javascript:openEmailModal()" style="text-decoration: none">Forgot password?</a>
                                        </span>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="checkbox col-lg-12">
                                        <label>
                                            <input type="checkbox"
                                                   name="remember" {{ old('remember') ? 'checked' : '' }}
                                                   style="position: relative"> Remember me
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12" id="recaptcha-login"></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input id="btn_login" class="btn btn-default btn-login" type="submit"
                                               value="SIGN IN" style="background: #FA5555;border-color: #FA5555"
                                               disabled>
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
                                <input type="hidden" name="role" value="{{\Illuminate\Support\Facades\Request::is
                                ('agency*') ? 'agency' : 'seeker'}}">
                                <div class="row has-feedback">
                                    <div class="col-lg-12">
                                        <input id="reg_name" type="text" placeholder="Full name"
                                               class="form-control" name="name" required>
                                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                    </div>
                                </div>
                                <div class="row has-feedback">
                                    <div class="col-lg-12">
                                        <input id="reg_email" class="form-control" type="email"
                                               placeholder="Email" name="email" required>
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                    </div>
                                </div>
                                <div class="row has-feedback">
                                    <div class="col-lg-12">
                                        <input class="form-control" type="password" placeholder="Password"
                                               id="reg_password" name="password" minlength="6" required>
                                        <span class="glyphicon glyphicon-eye-open form-control-feedback"></span>
                                    </div>
                                </div>
                                <div class="row has-feedback">
                                    <div class="col-lg-12">
                                        <input class="form-control" type="password" placeholder="Retype password"
                                               id="reg_password_confirm" name="password_confirmation"
                                               minlength="6" required>
                                        <span class="glyphicon glyphicon-eye-open form-control-feedback"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12" style="font-size: 14px;text-align: justify">
                                        <small>
                                            By continuing this, you acknowledge that you accept on SISKA
                                            <a href="#privacy-policy" target="_blank"
                                               style="text-decoration: none">Privacy Policies</a> and
                                            <a href="#terms-conditions" target="_blank"
                                               style="text-decoration: none">Terms & Conditions</a>.
                                        </small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12" id="recaptcha-register"></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input id="btn_register" class="btn btn-default btn-register" type="submit"
                                               value="CREATE ACCOUNT" style="background: #00ADB5;border-color: #00ADB5"
                                               disabled>
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
                                    <div class="col-lg-12">
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
                                    <div class="col-lg-12">
                                        <input class="btn btn-default btn-login" type="submit"
                                               value="send password reset link"
                                               style="background: #FA5555;border-color: #FA5555">
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
                                    <div class="col-lg-12">
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
                                    <div class="col-lg-12">
                                        <input id="forg_password" class="form-control" type="password"
                                               placeholder="New Password" name="password" minlength="6" required>
                                        <span class="glyphicon glyphicon-eye-open form-control-feedback"></span>
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row {{ $errors->has('password_confirmation') ? ' has-error' : '' }} has-feedback">
                                    <div class="col-lg-12">
                                        <input id="forg_password_confirm" class="form-control" type="password"
                                               placeholder="Retype password" name="password_confirmation"
                                               minlength="6" onkeyup="return checkForgotPassword()" required>
                                        <span class="glyphicon glyphicon-eye-open form-control-feedback"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input class="btn btn-default btn-login btn-password" type="submit"
                                               value="reset password" style="background: #FA5555;border-color: #FA5555">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Partnership -->
                <div class="box">
                    <div class="content partnershipBox" style="display: none">
                        <div class="form">
                            <form method="post" accept-charset="UTF-8" class="form-horizontal" id="form-partnership">
                                {{ csrf_field() }}
                                <div class="row has-feedback">
                                    <div class="col-lg-12">
                                        <input id="partnership_name" type="text"
                                               placeholder="University/institution/instance name"
                                               class="form-control" name="name" required>
                                        <span class="glyphicon glyphicon-education form-control-feedback"></span>
                                    </div>
                                </div>
                                <div class="row has-feedback">
                                    <div class="col-lg-12">
                                        <input id="partnership_email" class="form-control" type="email"
                                               placeholder="Email address" name="email" required>
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                    </div>
                                </div>
                                <div class="row has-feedback">
                                    <div class="col-lg-12">
                                        <input id="partnership_phone" placeholder="Phone number" type="text"
                                               maxlength="13" class="form-control" name="phone"
                                               onkeypress="return numberOnly(event, false)" required>
                                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                                    </div>
                                </div>
                                <div class="row has-feedback">
                                    <div class="col-lg-12">
                                        <input id="partnership_uri" placeholder="SiskaLTE base URI: http://&hellip;"
                                               type="text" class="form-control" name="uri" required>
                                        <span class="glyphicon glyphicon-globe form-control-feedback"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12" id="recaptcha-partnership"></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input id="btn_partnership" class="btn btn-default btn-login" type="submit"
                                               value="SUBMIT"
                                               style="background: linear-gradient(#eb4b4b, #732f2f), #4b2222;;border-color: transparent"
                                               disabled>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="forgot login-footer">
                    <span>Looking to <a href="javascript:showRegisterForm()"
                                        style="color: #00ADB5;">create an account</a>?</span>
                </div>
                <div class="forgot register-footer" style="display:none">
                    <span>Already have an account? <a href="javascript:showLoginForm()"
                                                      style="color: #FA5555">Sign In</a></span>
                </div>
                <div class="forgot partnership-footer" style="display:none">
                    <span style="font-size: 17px">Looking for <a href="https://github.com/Fq2124/siska-lte"
                                                                 target="_blank"
                                                                 style="color: #fa5555;">SiskaLTE</a> installation guide?</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="progress">
    <div class="bar"></div>
</div>
<script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('js/hideShowPassword.min.js')}}"></script>
<script src="{{asset('js/jquery-migrate-3.0.1.min.js')}}"></script>
<script src="{{asset('js/jquery-ui.js')}}"></script>
<script src="{{asset('js/popper.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/owl.carousel.min.js')}}"></script>
<script src="{{asset('js/jquery.stellar.min.js')}}"></script>
<script src="{{asset('js/jquery.countdown.min.js')}}"></script>
<script src="{{asset('js/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('js/swiper.min.js')}}"></script>
<script src="{{asset('js/aos.js')}}"></script>

<script src="{{asset('js/picturefill.min.js')}}"></script>
<script src="{{asset('js/lightgallery-all.min.js')}}"></script>
<script src="{{asset('js/jquery.mousewheel.min.js')}}"></script>

<script src="{{asset('js/main.js')}}"></script>

@include('layouts.partials._scripts')
@include('layouts.partials._alert')
@stack('scripts')
</body>
</html>