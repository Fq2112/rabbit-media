@extends('layouts.mst_user')
@push('styles')
    <link href="{{asset('css/card.css')}}" rel="stylesheet">
    <link href="{{asset('css/myDashboard.css')}}" rel="stylesheet">
    <link href="{{asset('css/myTree-Sidenav.css')}}" rel="stylesheet">
    <link href="{{asset('css/myMaps.css')}}" rel="stylesheet">
    <link href="{{asset('css/myTags.css')}}" rel="stylesheet">
    <link href="{{asset('css/myAccordion.css')}}" rel="stylesheet">
    <link href="{{asset('css/fileUploader.css')}}" rel="stylesheet">
    <link href="{{asset('admins/modules/summernote/summernote-bs4.css')}}" rel="stylesheet">
    <style>
        .site-wrapper_left-col .logo:before {
            content: '{{substr($user->name,0,1)}}';
        }
    </style>
@endpush
@section('content')
    @php
        $order = \App\Models\Pemesanan::where('user_id', $user->id)->count();
    @endphp
    <div class="wrapper">
        <div class="wrapper_container">
            <div class="site-wrapper active" id="target">
                <div class="site-wrapper_left-col" data-aos="fade-right">
                    <a href="{{route('client.edit.profile')}}" class="logo">
                        {{\Illuminate\Support\Str::words($user->name,2,"")}}</a>
                    <div class="left-nav">
                        <div class="well" id="sidebar-menu">
                            <ul class="nav nav-list nav-menu-list-style">
                                <li class="nav-menu-header">
                                    <label class="nav-header glyphicon-icon-rpad">
                                        <span class="fa fa-tachometer-alt mr-3"></span>Dashboard
                                        <span class="menu-collapsible-icon glyphicon glyphicon-chevron-down"></span>
                                    </label>
                                    <ul class="nav nav-list tree bullets">
                                        <li style="list-style: none"><a href="{{route('client.dashboard')}}">Order
                                                Status
                                                <span class="badge">{{$order > 999 ? '999+' : $order}}</span></a></li>
                                    </ul>
                                </li>
                                <li class="nav-menu-header">
                                    <label class="nav-header glyphicon-icon-rpad">
                                        <span class="fa fa-user-edit mr-3"></span>Account Settings
                                        <span class="menu-collapsible-icon glyphicon glyphicon-chevron-down"></span>
                                    </label>
                                    <ul class="nav nav-list tree bullets">
                                        <li style="list-style: none"><a href="{{route('client.edit.profile')}}">Edit
                                                Profile</a></li>
                                        <li style="list-style: none"><a href="{{route('client.settings')}}">Change
                                                Password</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="site-wrapper_top-bar" data-aos="fade-left">
                    <a href="javascript:void(0)" id="toggle"><i class="fa fa-bars"></i></a>
                </div>

                @yield('inner-content')

            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{asset('admins/modules/summernote/summernote-bs4.js')}}"></script>
    <script>
        var CURRENT_URL = window.location.href.split('#')[0].split('?')[0],
            $SIDEBAR_MENU = $('#sidebar-menu'), $TREE_TOGGLE = $('.nav-header');

        function init_sidebar() {
            $SIDEBAR_MENU.find('a[href="' + CURRENT_URL + '"]').addClass('current-page')
                .parents('.nav-menu-header').children('label').addClass('active')
                .parent().children('ul.tree').slideDown().find('a').css('border-right', '5px solid #592f83');

            $TREE_TOGGLE.on('click', function () {
                var $this = $(this);

                $TREE_TOGGLE.removeClass('active');
                $this.addClass('active');

                if ($this.next().hasClass('show')) {
                    $this.next().slideUp().find('a').css('border-right', 'none');

                } else {
                    $this.parent().parent().find('.tree').slideUp();
                    $this.next().slideDown().find('a').css('border-right', '5px solid #592f83');
                }
            });
        }

        function init_toggleMenu() {
            $("#toggle").on('click', function () {
                $(".logo").text(function (i, text) {
                    return text === "{{\Illuminate\Support\Str::words($user->name,1,"")}}" ?
                        "{{\Illuminate\Support\Str::words($user->name, 2,"")}}" :
                        "{{\Illuminate\Support\Str::words($user->name,1,"")}}";
                });

                $('.nav-header:not(.active)').find('.tree').slideUp();

                $(".site-wrapper").toggleClass('active');
            });
        }

        $(function () {
            init_sidebar();
            init_toggleMenu();
        });

        $(window).resize(function () {
            if ($(window).width() < 1200) {
                $("#toggle").click();
            }
        });
    </script>
@endpush
