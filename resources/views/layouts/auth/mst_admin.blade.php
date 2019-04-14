<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title')</title>
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{asset('admins/modules/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('fonts/fontawesome/css/all.css')}}">
    <!-- Page Specific CSS File -->
    <link rel="stylesheet" href="{{asset('admins/modules/bootstrap-select/dist/css/bootstrap-select.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/sweetalert/sweetalert2.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/izitoast/css/iziToast.min.css')}}">
@stack('styles')

<!-- Template CSS -->
    <link rel="stylesheet" href="{{asset('admins/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('admins/css/components.css')}}">

    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>
    <!-- /END GA -->
</head>
<body>
@php
    $contacts = \App\Models\Contact::where('created_at', '>=', today()->subDays('3')->toDateTimeString())
    ->orderByDesc('id')->get();

    $orders = \App\Models\Pemesanan::where('isPaid',false)->wherenotnull('payment_proof')
    ->whereDate('created_at', '>=', now()->subDay())->orderByDesc('id')->get();
@endphp
<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>
        <nav class="navbar navbar-expand-lg main-navbar">
            <ul class="navbar-nav mr-auto">
                <li><a href="javascript:void(0)" data-toggle="sidebar" class="nav-link nav-link-lg">
                        <i class="fas fa-bars"></i></a></li>
            </ul>
            <ul class="navbar-nav navbar-right">
                <li class="dropdown dropdown-list-toggle">
                    <a href="javascript:void(0)" data-toggle="dropdown"
                       class="nav-link nav-link-lg message-toggle {{count($contacts) > 0 ? 'beep' : ''}}">
                        <i class="far fa-envelope"></i></a>
                    <div class="dropdown-menu dropdown-list dropdown-menu-right">
                        <div class="dropdown-header">Messages</div>
                        <div class="dropdown-list-content dropdown-list-message">
                            @if(count($contacts) > 0)
                                @foreach($contacts as $row)
                                    @php $user = \App\User::where('email',$row->email); @endphp
                                    <a href="{{route('admin.inbox', ['id' => $row->id])}}" class="dropdown-item">
                                        <div class="dropdown-item-avatar">
                                            @if($user->count())
                                                @if($user->first()->ava == "")
                                                    <img src="{{asset('admins/img/avatar/avatar-'.rand(1,5).'.png')}}"
                                                         class="rounded-circle" alt="Avatar">
                                                @else
                                                    <img src="{{asset('storage/users/ava/'.$user->first()->ava)}}"
                                                         class="rounded-circle" alt="Avatar">
                                                @endif
                                            @else
                                                <img src="{{asset('admins/img/avatar/avatar-'.rand(1,5).'.png')}}"
                                                     class="rounded-circle" alt="Avatar">
                                            @endif
                                        </div>
                                        <div class="dropdown-item-desc">
                                            <b>{{$row->name}}</b>
                                            <p>{{$row->subject}}</p>
                                            <div class="time">{{\Carbon\Carbon::parse($row->created_at)->diffForHumans()}}</div>
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                <a class="dropdown-item">
                                    <div class="dropdown-item-avatar">
                                        <img src="{{asset('images/searchPlace.png')}}" class="img-fluid">
                                    </div>
                                    <div class="dropdown-item-desc">
                                        <p>There seems to be none of the feedback was found this 3 days&hellip;</p>
                                    </div>
                                </a>
                            @endif
                        </div>
                        <div class="dropdown-footer text-center">
                            <a href="{{route('admin.inbox')}}">More Messages<i class="fas fa-chevron-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </li>
                <li class="dropdown dropdown-list-toggle">
                    <a href="javascript:void(0)" data-toggle="dropdown"
                       class="nav-link notification-toggle nav-link-lg {{count($orders) > 0 ? 'beep' : ''}}">
                        <i class="far fa-bell"></i></a>
                    <div class="dropdown-menu dropdown-list dropdown-menu-right">
                        <div class="dropdown-header">Orders</div>
                        <div class="dropdown-list-content dropdown-list-message">
                            @if(count($orders) > 0)
                                @foreach($orders as $row)
                                    <a href="{{route('table.orders'.'?q='.$row->getUser->name)}}" class="dropdown-item">
                                        <div class="dropdown-item-avatar">
                                            <img src="{{asset('images/services/'.$row->getLayanan->getJenisLayanan->icon)}}"
                                                 class="rounded-circle" alt="Icon">
                                        </div>
                                        <div class="dropdown-item-desc">
                                            <b>{{$row->getLayanan}}</b>
                                            <p>{{$row->deskripsi}}</p>
                                            <div class="time">{{\Carbon\Carbon::parse($row->created_at)->diffForHumans()}}</div>
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                <a class="dropdown-item">
                                    <div class="dropdown-item-avatar">
                                        <img src="{{asset('images/searchPlace.png')}}" class="img-fluid">
                                    </div>
                                    <div class="dropdown-item-desc">
                                        <p>There seems to be none of the order was found this 3 days&hellip;</p>
                                    </div>
                                </a>
                            @endif
                        </div>
                        <div class="dropdown-footer text-center">
                            <a href="{{route('table.orders')}}">More Orders<i class="fas fa-chevron-right ml-2"></i></a>
                        </div>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0)" data-toggle="dropdown"
                       class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                        <img alt="image" src="{{asset('admins/img/avatar/avatar-1.png')}}" class="rounded-circle mr-1">
                        <div class="d-sm-none d-lg-inline-block">{{Auth::guard('admin')->user()->name}}</div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="{{route('admin.edit.profile')}}" class="dropdown-item has-icon">
                            <i class="fas fa-user-edit"></i> Edit Profile</a>
                        <a href="{{route('admin.settings')}}" class="dropdown-item has-icon">
                            <i class="fas fa-cogs"></i> Account Settings</a>
                        <div class="dropdown-divider"></div>
                        <a href="javascript:void(0)" class="dropdown-item has-icon text-danger btn_signOut">
                            <i class="fas fa-sign-out-alt"></i> Sign Out</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                              style="display: none;">{{csrf_field()}}
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        <div class="main-sidebar sidebar-style-2">
            <aside id="sidebar-wrapper">
                <div class="sidebar-brand">
                    <a href="{{route('home-admin')}}">The Rabbits</a>
                </div>
                <div class="sidebar-brand sidebar-brand-sm">
                    <a href="{{route('home-admin')}}"><img class="img-fluid" src="{{asset('images/loading.gif')}}"></a>
                </div>
                @include('layouts.partials._sidebarMenu')
            </aside>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            @yield('content')
        </div>
        <footer class="main-footer">
            <div class="footer-left">
                &copy;&nbsp;{{now()->format('Y')}} Rabbit Media – Digital Creative Service. All rights reserved.
            </div>
            <div class="footer-right">
                Designed & Developed by <a href="{{route('about')}}">Rabbit Media</a>
            </div>
        </footer>
    </div>
</div>
<div class="progress">
    <div class="bar"></div>
</div>

<!-- General JS Scripts -->
<script src="{{asset('admins/modules/jquery.min.js')}}"></script>
<script src="{{asset('admins/modules/popper.js')}}"></script>
<script src="{{asset('admins/modules/tooltip.js')}}"></script>
<script src="{{asset('admins/modules/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('admins/modules/nicescroll/jquery.nicescroll.min.js')}}"></script>
<script src="{{asset('admins/modules/moment.min.js')}}"></script>
<script src="{{asset('admins/js/stisla.js')}}"></script>

<!-- Page Specific JS File -->
<script src="{{asset('admins/modules/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
<script src="{{asset('admins/modules/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('admins/modules/izitoast/js/iziToast.min.js')}}"></script>
@stack('scripts')

<!-- Template JS File -->
<script src="{{asset('admins/js/scripts.js')}}"></script>
<script src="{{asset('admins/js/custom.js')}}"></script>
<script>
    @if(session('signed'))
    swal('Signed In!', 'Halo {{Auth::guard('admin')->user()->name}}! Anda telah masuk.', 'success');
    @endif
</script>
@include('layouts.partials._confirm')
@include('layouts.partials._toastnotify')
</body>
</html>