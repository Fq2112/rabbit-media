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
    <link rel="stylesheet" href="{{asset('css/glyphicons.css')}}">
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
<body class="use-nicescroll">
@php
    $role = Auth::guard('admin')->user();
    $contacts = \App\Models\Contact::where('created_at', '>=', today()->subDays('3')->toDateTimeString())
    ->orderByDesc('id')->get();

    if($role->isRoot()){
        $orders = \App\Models\Pemesanan::where('isAccept',false)->where('isReject', false)->orderByDesc('id')->get();
        $notif = count($orders);

    } elseif($role->isAdmin()){
        $pays = \App\Models\Pemesanan::where('isAccept',true)->where('isReject',false)
        ->where('start', '>', now()->addDays(2))->whereNotNull('payment_id')->whereNotNull('payment_proof')
        ->where('status_payment' ,'<=', 1)->orderByDesc('id')->get();

        $outcomes = \App\Models\Pemesanan::where('status_payment', 2)->orderByDesc('id')->get();
        $notif = count($pays) + count($outcomes);

    } else{
        $logs = \App\Models\Pemesanan::where('status_payment','>=',1)->doesntHave('getOrderLog')->orderByDesc('id')->get();

        $revisions = \App\Models\OrderLogs::has('getOrderRevision')->where('isReady', false)->where('isComplete', false)
        ->orderByDesc('id')->get();

        $notif = count($logs) + count($revisions);
    }
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
                @if($role->isRoot() || $role->isAdmin())
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
                                                    <img src="{{ $user->first()->ava == "" ? asset
                                                    ('admins/img/avatar/avatar-'.rand(1,5).'.png') :
                                                    asset('storage/users/ava/'.$user->first()->ava)}}"
                                                         class="rounded-circle" alt="Avatar">
                                                @else
                                                    <img src="{{asset('admins/img/avatar/avatar-'.rand(1,5).'.png')}}"
                                                         class="rounded-circle" alt="Avatar">
                                                @endif
                                            </div>
                                            <div class="dropdown-item-desc">
                                                <b>{{$row->name}}</b>
                                                <p>{{$row->subject}}</p>
                                                <div class="time">{{\Carbon\Carbon::parse($row->created_at)
                                                ->diffForHumans()}}</div>
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
                                <a href="{{route('admin.inbox')}}">More Messages<i
                                            class="fas fa-chevron-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                    </li>
                @endif

                <li class="dropdown dropdown-list-toggle">
                    <a class="nav-link notification-toggle nav-link-lg {{$notif > 0 ? 'beep' : ''}}"
                       href="javascript:void(0)" data-toggle="dropdown"><i class="far fa-bell"></i></a>
                    <div class="dropdown-menu dropdown-list dropdown-menu-right">
                        <div class="dropdown-header">Notifications</div>
                        <div class="dropdown-list-content dropdown-list-icons">
                            @if($notif > 0)
                                @if($role->isRoot())
                                    @if(count($orders) > 0)
                                        <a href="javascript:void(0)" class="dropdown-item" style="cursor: default">
                                            <div class="dropdown-item-avatar text-uppercase text-muted">
                                                <i class="fa fa-dollar-sign mr-2"></i>Order Confirmation
                                            </div>
                                        </a>
                                        @foreach($orders as $row)
                                            @php
                                                $romanDate = \App\Support\RomanConverter::numberToRoman($row->created_at
                                                ->format('y')).'/'.\App\Support\RomanConverter::numberToRoman($row->created_at
                                                ->format('m'));
                                                $invoice = 'INV/'.$row->created_at->format('Ymd').'/'.$romanDate.'/'.$row->id;
                                            @endphp
                                            <a href="{{route('table.orders').'?q='.$invoice}}" class="dropdown-item">
                                                <div class="dropdown-item-avatar">
                                                    <img class="img-fluid" alt="Icon" src="{{asset('images/services/'.
                                                $row->getLayanan->getJenisLayanan->icon)}}">
                                                </div>
                                                <div class="dropdown-item-desc">
                                                    <b>{{$invoice}}</b>
                                                    <p>This order ({{$row->judul}}) hasn't been confirmed yet!</p>
                                                    <div class="time">
                                                        {{\Carbon\Carbon::parse($row->created_at)->diffForHumans()}}</div>
                                                </div>
                                            </a>
                                        @endforeach
                                    @endif

                                @elseif($role->isAdmin())
                                    @if(count($pays) > 0)
                                        <a href="javascript:void(0)" class="dropdown-item" style="cursor: default">
                                            <div class="dropdown-item-avatar text-uppercase text-muted">
                                                <i class="fa fa-dollar-sign mr-2"></i>Order Verification
                                            </div>
                                        </a>
                                        @foreach($pays as $row)
                                            @php
                                                $romanDate = \App\Support\RomanConverter::numberToRoman
                                                ($row->created_at->format('y')).'/'.
                                                \App\Support\RomanConverter::numberToRoman($row->created_at->format('m'));
                                                $invoice = 'INV/'.$row->created_at->format('Ymd').'/'.
                                                $romanDate.'/'.$row->id;
                                            @endphp
                                            <a href="{{route('table.orders').'?q='.$invoice}}" class="dropdown-item">
                                                <div class="dropdown-item-avatar">
                                                    <img class="img-fluid" alt="Icon" src="{{asset('images/services/'.
                                                    $row->getLayanan->getJenisLayanan->icon)}}">
                                                </div>
                                                <div class="dropdown-item-desc">
                                                    <b>{{$invoice}}</b>
                                                    <p>Payment for this order ({{$row->judul}}) hasn't been verified
                                                        yet!</p>
                                                    <div class="time">
                                                        {{\Carbon\Carbon::parse($row->created_at)->diffForHumans()}}
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    @endif
                                    <hr class="mt-0"
                                        style="display: {{count($pays) > 0 && count($outcomes) > 0 ? '' : 'none'}}">
                                    @if(count($outcomes) > 0)
                                        <a href="javascript:void(0)" class="dropdown-item" style="cursor: default">
                                            <div class="dropdown-item-avatar text-uppercase text-muted">
                                                <i class="fa fa-funnel-dollar mr-2"></i>Order Outcome
                                            </div>
                                        </a>
                                        @foreach($outcomes as $row)
                                            @php
                                                $romanDate = \App\Support\RomanConverter::numberToRoman
                                                ($row->created_at->format('y')).'/'.
                                                \App\Support\RomanConverter::numberToRoman($row->created_at->format('m'));
                                                $invoice = 'INV/'.$row->created_at->format('Ymd').'/'.
                                                $romanDate.'/'.$row->id;
                                            @endphp
                                            <a href="{{route('table.order-outcomes').'?q='.$invoice.'&id='.$row->id}}"
                                               class="dropdown-item">
                                                <div class="dropdown-item-avatar">
                                                    <img class="img-fluid" alt="Icon" src="{{asset('images/services/'.
                                                    $row->getLayanan->getJenisLayanan->icon)}}">
                                                </div>
                                                <div class="dropdown-item-desc">
                                                    <b>{{$invoice}}</b>
                                                    <p>Outcome for this order ({{$row->judul}}) hasn't been noted
                                                        yet!</p>
                                                    <div class="time">
                                                        {{\Carbon\Carbon::parse($row->created_at)->diffForHumans()}}
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    @endif
                                @else
                                    @if(count($logs) > 0)
                                        <a href="javascript:void(0)" class="dropdown-item" style="cursor: default">
                                            <div class="dropdown-item-avatar text-uppercase text-muted">
                                                <i class="fa fa-tasks mr-2"></i>Order Log
                                            </div>
                                        </a>
                                        @foreach($logs as $row)
                                            @php
                                                $romanDate = \App\Support\RomanConverter::numberToRoman
                                                ($row->created_at->format('y')).'/'.
                                                \App\Support\RomanConverter::numberToRoman($row->created_at->format('m'));
                                                $invoice = 'INV/'.$row->created_at->format('Ymd').'/'.
                                                $romanDate.'/'.$row->id;
                                            @endphp
                                            <a href="{{route('table.order-logs').'?q='.$invoice.'&id='.$row->id.'&check=setup'}}"
                                               class="dropdown-item">
                                                <div class="dropdown-item-avatar">
                                                    <img class="img-fluid" alt="Icon" src="{{asset('images/services/'.
                                                    $row->getLayanan->getJenisLayanan->icon)}}">
                                                </div>
                                                <div class="dropdown-item-desc">
                                                    <b>{{$invoice}}</b>
                                                    <p>Progress/log for this order ({{$row->judul}}) hasn't been set
                                                        yet!</p>
                                                    <div class="time">
                                                        {{\Carbon\Carbon::parse($row->created_at)->diffForHumans()}}
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    @endif
                                    <hr class="mt-0"
                                        style="display: {{count($logs) > 0 && count($revisions) > 0 ? '' : 'none'}}">
                                    @if(count($revisions) > 0)
                                        <a href="javascript:void(0)" class="dropdown-item" style="cursor: default">
                                            <div class="dropdown-item-avatar text-uppercase text-muted">
                                                <i class="fa fa-edit mr-2"></i>Order Revision
                                            </div>
                                        </a>
                                        @foreach($revisions as $row)
                                            @php
                                                $order = $row->getPemesanan;
                                                $romanDate = \App\Support\RomanConverter::numberToRoman
                                                ($order->created_at->format('y')).'/'.
                                                \App\Support\RomanConverter::numberToRoman($order->created_at->format('m'));
                                                $invoice = 'INV/'.$order->created_at->format('Ymd').'/'.
                                                $romanDate.'/'.$order->id;
                                            @endphp
                                            <a href="{{route('table.order-logs').'?q='.$invoice.'&id='.$order->id.'&check=rev'}}"
                                               class="dropdown-item">
                                                <div class="dropdown-item-avatar">
                                                    <img class="img-fluid" alt="Icon" src="{{asset('images/services/'.
                                                    $order->getLayanan->getJenisLayanan->icon)}}">
                                                </div>
                                                <div class="dropdown-item-desc">
                                                    <b>{{$invoice}}</b>
                                                    <p>Revision for this order ({{$order->judul}}) hasn't been completed
                                                        yet!</p>
                                                    <div class="time">
                                                        {{\Carbon\Carbon::parse($order->created_at)->diffForHumans()}}
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    @endif
                                @endif
                            @else
                                <a class="dropdown-item">
                                    <div class="dropdown-item-avatar">
                                        <img src="{{asset('images/searchPlace.png')}}" class="img-fluid">
                                    </div>
                                    <div class="dropdown-item-desc">
                                        <p>There seems to be none of the notification was found&hellip;</p>
                                    </div>
                                </a>
                            @endif
                        </div>
                    </div>
                </li>

                <li class="dropdown">
                    <a href="javascript:void(0)" data-toggle="dropdown"
                       class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                        <img alt="image" src="{{$role->ava != "" ? asset('storage/admins/ava/'.$role->ava) :
                        asset('admins/img/avatar/avatar-'.rand(1,5).'.png')}}" class="rounded-circle mr-1">
                        <div class="d-sm-none d-lg-inline-block">{{$role->name}}</div>
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
                    <a href="{{$role->isRoot() || $role->isAdmin() ? route('home-admin') : route('show.schedules')}}">
                        The Rabbits</a>
                </div>
                <div class="sidebar-brand sidebar-brand-sm">
                    <a href="{{$role->isRoot() || $role->isAdmin() ? route('home-admin') : route('show.schedules')}}">
                        <img class="img-fluid" src="{{asset('images/loading.gif')}}"></a>
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
<script src="{{asset('admins/modules/nicescroll/jquery.nicescroll.js')}}"></script>
<script src="{{asset('admins/modules/moment.min.js')}}"></script>
<script src="{{asset('admins/js/stisla.js')}}"></script>
<script src="{{asset('js/hideShowPassword.min.js')}}"></script>

<!-- Page Specific JS File -->
<script src="{{asset('admins/modules/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
<script src="{{asset('admins/modules/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('admins/modules/izitoast/js/iziToast.min.js')}}"></script>
<script src="{{asset('admins/modules/checkMobileDevice.js')}}"></script>
@stack('scripts')

<!-- Template JS File -->
<script src="{{asset('admins/js/scripts.js')}}"></script>
<script src="{{asset('admins/js/custom.js')}}"></script>
<script>
    @if(session('signed'))
    swal('Signed In!', 'Halo {{$role->name}}! Anda telah masuk.', 'success');
            @endif

            @if(!\Illuminate\Support\Facades\Request::is('admin/tables*'))
    var title = document.getElementsByTagName("title")[0].innerHTML;
    (function titleScroller(text) {
        document.title = text;
        setTimeout(function () {
            titleScroller(text.substr(1) + text.substr(0, 1));
        }, 500);
    }(title + " ~ "));
    @endif
</script>
@include('layouts.partials._confirm')
@include('layouts.partials._toastnotify')
</body>
</html>