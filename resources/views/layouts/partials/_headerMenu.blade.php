<div class="col-10 col-md-8 d-none d-xl-block" data-aos="fade-down">
    <nav class="site-navigation position-relative text-right text-lg-center" role="navigation">
        <ul class="site-menu js-clone-nav mx-auto d-none d-lg-block">
            <li class="active"><a href="{{route('home')}}">Home</a></li>
            <li class="has-children">
                <a href="single.html">Portfolios</a>
                <ul class="dropdown">
                    @foreach(\App\Models\JenisPortofolio::orderBy('nama')->get() as $row)
                        <li><a href="#"><i class="fa {{$row->icon}}" style="margin-right: 8px"></i>{{$row->nama}}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
            <li class="has-children">
                <a href="services.html">Services</a>
                <ul class="dropdown">
                    @foreach(\App\Models\JenisLayanan::orderBy('nama')->get() as $row)
                        <li><a href="#"><i class="fa {{$row->icon}}" style="margin-right: 8px"></i>{{$row->nama}}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
            <li><a href="about.html">Feedback</a></li>
            <li><a href="contact.html">About Us</a></li>
            @if(Auth::check() || Auth::guard('admin')->check())
                <li class="has-children avatar">
                    <a href="#" style="font-weight: 900;">
                        @if(Auth::check())
                            <img class="img-thumbnail" src="{{Auth::user()->ava != "" ?
                            asset('storage/users/ava/'.Auth::user()->ava) :
                            asset('images/avatar.png')}}">{{Auth::user()->name}}
                        @elseif(Auth::guard('admin')->check())
                            <img class="img-thumbnail" src="{{Auth::guard('admin')->user()->ava != "" ?
                            asset('storage/users/ava/'.Auth::guard('admin')->user()->ava) :
                            asset('images/avatar.png')}}">{{Auth::guard('admin')->user()->name}}
                        @endif
                    </a>
                    <ul class="dropdown">
                        <li><a href="#"><i class="fa fa-user-edit" style="margin-right: 8px"></i>Edit Profile</a></li>
                        <li><a href="#"><i class="fa fa-cogs" style="margin-right: 8px"></i>Account Settings</a></li>
                        <li>
                            <a class="btn_signOut"><i class="fa fa-sign-out-alt" style="margin-right: 8px"></i>Sign Out</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
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