<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}">

    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300i,400,700" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('fonts/icomoon/style.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('fonts/fontawesome/css/all.css')}}">

    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{asset('css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/owl.theme.default.min.css')}}">

    <link rel="stylesheet" href="{{asset('css/lightgallery.min.css')}}">

    <!-- Bootstrap  -->
    <link rel="stylesheet" href="{{asset('css/bootstrap-datepicker.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-datetimepicker.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-select.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-toggle.css')}}">
    <link rel="stylesheet" href="{{asset('css/daterangepicker.css')}}">

    <link rel="stylesheet" href="{{asset('fonts/flaticon/font/flaticon.css')}}">

    <link rel="stylesheet" href="{{asset('css/swiper.css')}}">

    <link rel="stylesheet" href="{{asset('css/aos.css')}}">

    <link rel="stylesheet" href="{{asset('css/style.css')}}">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{asset('vendors/sweetalert2/sweetalert2.min.css')}}">
    <script src="{{asset('vendors/sweetalert2/sweetalert2.min.js')}}"></script>
    <!-- Modal -->
    <script src="{{ asset('js/modal.js') }}"></script>
    <link rel="stylesheet" href="{{asset('css/modal.css')}}">
    <!-- loading.io -->
    <link rel="stylesheet" href="{{asset('css/loading.css')}}">
    <!-- scroll to top -->
    <link rel="stylesheet" href="{{asset('css/scroll-to-top.css')}}">
    <!-- download card -->
    <link rel="stylesheet" href="{{asset('css/downloadCard-gridList.css')}}">
    <style>
        @if(\Illuminate\Support\Facades\Request::is('/*'))
        .to-top {
            left: 1%;
        }

        @else
        .to-top {
            right: 1%;
        }
        @endif
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

    <header class="site-navbar py-3 {{\Illuminate\Support\Facades\Request::is('/*') ? '' : 'border-bottom'}}"
            role="banner">
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

                @include('layouts.partials._headerMenu')

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

                    <div class="d-inline-block d-xl-none ml-md-0 mr-auto py-3" style="position: relative; top: 3px;">
                        <a href="#" class="site-menu-toggle js-menu-toggle text-black"><span
                                    class="icon-menu h3"></span></a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    @yield('content')

    <div class="footer py-4">
        <div class="container-fluid {{\Illuminate\Support\Facades\Request::is('/*') ? '' : 'text-center'}}">
            <p>
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                &copy;&nbsp;{{now()->format('Y')}} Rabbit Media – Digital Creative Service. All rights reserved.<br>
                Designed by <a href="{{route('home')}}" target="_blank">Rabbit Media</a>. This template is made by
                <a href="https://colorlib.com" target="_blank">Colorlib</a>.<br>
                <a href="{{route('info')}}#privacy-policy" target="_blank">Privacy Policy</a><strong> &middot; </strong>
                <a href="{{route('info')}}#terms-conditions" target="_blank">Terms & Conditions</a><strong>
                    &middot; </strong>
                <a href="{{route('info')}}#team" target="_blank">Get in Touch</a><strong> &middot; </strong>
                <a href="{{route('info')}}#faqs" target="_blank">FAQ</a>
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            </p>
        </div>
    </div>

</div>

@include('layouts.partials._signUpIn')

<div class="progress">
    <div class="bar"></div>
</div>
<script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('js/hideShowPassword.min.js')}}"></script>
<script src="{{asset('js/jquery-migrate-3.0.1.min.js')}}"></script>
<script src="{{asset('js/jquery-ui.js')}}"></script>
<script src="{{asset('js/popper.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/moment.js')}}"></script>
<script src="{{asset('js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('js/owl.carousel.min.js')}}"></script>
<script src="{{asset('js/jquery.stellar.min.js')}}"></script>
<script src="{{asset('js/jquery.countdown.min.js')}}"></script>
<script src="{{asset('js/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('js/swiper.min.js')}}"></script>
<script src="{{asset('js/aos.js')}}"></script>

<script src="{{asset('js/picturefill.min.js')}}"></script>
<script src="{{asset('js/lightgallery-all.min.js')}}"></script>
<script src="{{asset('js/lg-video.min.js')}}"></script>
<script src="{{asset('js/jquery.mousewheel.min.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{asset('js/bootstrap-select.js')}}"></script>
<script src="{{asset('js/bootstrap-toggle.js')}}"></script>
<script src="{{asset('js/daterangepicker.js')}}"></script>
<!-- Masonry Responsive Grid -->
<script src="{{asset('js/masonry.pkgd.min.js')}}"></script>
<script src="{{asset('js/imagesloaded.pkgd.min.js')}}"></script>
<!-- Smooth scroll -->
<script src="{{asset('js/smooth-scrollbar.min.js')}}"></script>
<!-- TinyMCE -->
<script src="{{asset('vendors/tinymce/tinymce.min.js')}}"></script>

@include('layouts.partials._scripts')
@include('layouts.partials._alert')
@include('layouts.partials._confirm')
@stack('scripts')
</body>
</html>