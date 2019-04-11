<ul class="sidebar-menu">
    <li class="menu-header">General</li>
    <li class="dropdown active">
        <a href="{{route('home-admin')}}" class="nav-link"><i
                    class="fa fa-tachometer-alt"></i><span>Dashboard</span></a>
    </li>
    <li class="menu-header">Data Master</li>
    <li class="dropdown">
        <a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
            <i class="fa fa-user-shield"></i><span>Accounts</span></a>
        <ul class="dropdown-menu">
            <li><a href="#" class="nav-link">Admins</a></li>
            <li><a href="#" class="nav-link">Users</a></li>
        </ul>
    </li>
    <li class="dropdown">
        <a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
            <i class="fa fa-building"></i><span>Company Profile</span></a>
        <ul class="dropdown-menu">
            <li><a href="#" class="nav-link">About</a></li>
            <li><a href="#" class="nav-link">FAQ</a></li>
            <li><a href="#" class="nav-link">Portfolio Types</a></li>
            <li><a href="#" class="nav-link">Portfolios</a></li>
            <li><a href="#" class="nav-link">Portfolio Galleries</a></li>
        </ul>
    </li>
    <li class="dropdown">
        <a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
            <i class="fa fa-hand-holding-usd"></i><span>Features</span></a>
        <ul class="dropdown-menu">
            <li><a href="#" class="nav-link">Service Types</a></li>
            <li><a href="#" class="nav-link">Service Pricing</a></li>
            <li><a href="#" class="nav-link">Payment Categories</a></li>
            <li><a href="#" class="nav-link">Payment Methods</a></li>
        </ul>
    </li>
    <li class="menu-header">Data Transaction</li>
    <li><a href="#" class="nav-link"><i class="fa fa-comment-dots"></i><span>Feedback</span></a></li>
    <li><a href="#" class="nav-link"><i class="fa fa-file-invoice-dollar"></i><span>Orders</span></a></li>
</ul>

<div class="mt-4 mb-4 p-3 hide-sidebar-mini">
    <a href="{{route('home')}}" class="btn btn-primary btn-lg btn-block btn-icon-split">
        <i class="fas fa-rocket"></i> GO TO MAIN SITE
    </a>
</div>