<div class="col-10 col-md-8 d-none d-xl-block" data-aos="fade-down">
    <nav class="site-navigation position-relative text-right text-lg-center" role="navigation">
        <ul class="site-menu js-clone-nav mx-auto d-none d-lg-block">
            <li class="{{\Illuminate\Support\Facades\Request::is('/*') ? 'active' : ''}}">
                <a href="{{route('home')}}">Home</a></li>
            <li class="has-children {{\Illuminate\Support\Facades\Request::is('portfolios*') ? 'active' : ''}}">
                <a href="{{route('show.portfolio')}}">Portfolios</a>
                <ul class="dropdown">
                    @foreach(\App\Models\JenisPortofolio::orderBy('nama')->get() as $row)
                        <li><a href="{{route('show.portfolio')}}?q={{$row->id}}">
                                <i class="{{$row->icon}} mr-2"></i>{{$row->nama}}</a></li>
                    @endforeach
                </ul>
            </li>
            <li class="{{\Illuminate\Support\Facades\Request::is('services*') ? 'active' : ''}}">
                <a href="{{route('show.service')}}">Services</a></li>
            <li class="{{\Illuminate\Support\Facades\Request::is('how-it-works*') ? 'active' : ''}}">
                <a href="{{route('show.how-it-works')}}" target="_blank">How It Works</a></li>
            <li class="{{\Illuminate\Support\Facades\Request::is('feedback*') ? 'active' : ''}}">
                <a href="{{route('feedback')}}">Feedback</a></li>
            @if(Auth::check() || Auth::guard('admin')->check())
                <li class="has-children avatar">
                    <a href="javascript:void(0)" style="font-weight: 900;">
                        @if(Auth::check())
                            <img class="img-thumbnail show_ava" src="{{Auth::user()->ava != "" ?
                            asset('storage/users/ava/'.Auth::user()->ava) :
                            asset('images/avatar.png')}}">{{Auth::user()->name}}
                        @elseif(Auth::guard('admin')->check())
                            <img class="img-thumbnail show_ava" src="{{Auth::guard('admin')->user()->ava != "" ?
                            asset('storage/users/ava/'.Auth::guard('admin')->user()->ava) :
                            asset('images/avatar.png')}}">{{Auth::guard('admin')->user()->name}}
                        @endif
                    </a>
                    <ul class="dropdown">
                        <li><a href="{{Auth::guard('admin')->check() ? route('home-admin') :
                        route('client.dashboard')}}"><i class="fa fa-tachometer-alt mr-2"></i>Dashboard</a></li>
                        <li><a href="{{Auth::guard('admin')->check() ? route('admin.edit.profile') :
                        route('client.edit.profile')}}"><i class="fa fa-user-edit mr-2"></i>Edit Profile</a></li>
                        <li><a href="{{Auth::guard('admin')->check() ? route('admin.settings') :
                        route('client.settings')}}"><i class="fa fa-cogs mr-2"></i>Account Settings</a></li>
                        <li class="dropdown-divider"></li>
                        <li>
                            <a class="btn_signOut"><i class="fa fa-sign-out-alt mr-2"></i>Sign Out</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{csrf_field()}}
                            </form>
                        </li>
                    </ul>
                </li>
            @else
                <li><a href="javascript:void(0)" data-toggle="modal" onclick="openRegisterModal();"
                       style="font-weight: 900;">Sign Up/In</a></li>
            @endif
        </ul>
    </nav>
</div>