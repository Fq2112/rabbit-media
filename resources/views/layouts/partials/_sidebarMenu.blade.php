<ul class="sidebar-menu">
    <li class="menu-header">General</li>
    <li class="dropdown {{\Illuminate\Support\Facades\Request::is('admin') ? 'active' : ''}}">
        <a href="{{route('home-admin')}}" class="nav-link">
            <i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
    <li class="dropdown {{\Illuminate\Support\Facades\Request::is('admin/inbox*') ? 'active' : ''}}">
        <a href="{{route('admin.inbox')}}" class="nav-link">
            <i class="fas fa-envelope"></i><span>Inbox</span></a></li>

    <li class="menu-header">Data Master</li>
    <li class="dropdown {{\Illuminate\Support\Facades\Request::is('admin/tables/accounts*') ? 'active' : ''}}">
        <a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
            <i class="fas fa-user-shield"></i><span>Accounts</span></a>
        <ul class="dropdown-menu">
            <li class="{{\Illuminate\Support\Facades\Request::is('admin/tables/accounts/admins*') ? 'active' : ''}}">
                <a href="{{route('table.admins')}}" class="nav-link">Admins</a></li>
            <li class="{{\Illuminate\Support\Facades\Request::is('admin/tables/accounts/users*') ? 'active' : ''}}">
                <a href="{{route('table.users')}}" class="nav-link">Users</a></li>
        </ul>
    </li>
    <li class="dropdown {{\Illuminate\Support\Facades\Request::is('admin/tables/company-profile*') ? 'active' : ''}}">
        <a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
            <i class="fas fa-building"></i><span>Company Profile</span></a>
        <ul class="dropdown-menu">
            <li class="{{\Illuminate\Support\Facades\Request::is('admin/tables/company-profile') ?
            'active' : ''}}"><a href="{{route('show.company.profile')}}" class="nav-link">About</a></li>
            <li class="{{\Illuminate\Support\Facades\Request::is('admin/tables/company-profile/faqs*') ?
            'active' : ''}}"><a href="{{route('table.faqs')}}" class="nav-link">FAQ</a></li>
            <li class="{{\Illuminate\Support\Facades\Request::is('admin/tables/company-profile/how-it-works*') ?
            'active' : ''}}"><a href="{{route('table.howItWorks')}}" class="nav-link">How It Works</a></li>
            <li class="{{\Illuminate\Support\Facades\Request::is('admin/tables/company-profile/portfolio-types*') ?
            'active' : ''}}"><a href="{{route('table.portfolio-types')}}" class="nav-link">Portfolio Types</a></li>
            <li class="{{\Illuminate\Support\Facades\Request::is('admin/tables/company-profile/portfolios*') ?
            'active' : ''}}"><a href="{{route('table.portfolios')}}" class="nav-link">Portfolios</a></li>
            <li class="{{\Illuminate\Support\Facades\Request::is('admin/tables/company-profile/portfolio-galleries*') ?
            'active' : ''}}"><a href="{{route('table.portfolio-galleries')}}" class="nav-link">Portfolio Galleries</a>
            </li>
        </ul>
    </li>
    <li class="dropdown {{\Illuminate\Support\Facades\Request::is('admin/tables/features*') ? 'active' : ''}}">
        <a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
            <i class="fas fa-hand-holding-usd"></i><span>Features</span></a>
        <ul class="dropdown-menu">
            <li class="{{\Illuminate\Support\Facades\Request::is('admin/tables/features/service-types*') ?
            'active' : ''}}"><a href="{{route('table.service-types')}}" class="nav-link">Service Types</a></li>
            <li class="{{\Illuminate\Support\Facades\Request::is('admin/tables/features/services*') ?
            'active' : ''}}"><a href="{{route('table.services')}}" class="nav-link">Services</a></li>
            <li class="{{\Illuminate\Support\Facades\Request::is('admin/tables/features/studio-types*') ?
            'active' : ''}}"><a href="{{route('table.studio-types')}}" class="nav-link">Studio Types</a></li>
            <li class="{{\Illuminate\Support\Facades\Request::is('admin/tables/features/studios*') ?
            'active' : ''}}"><a href="{{route('table.studios')}}" class="nav-link">Studios</a></li>
            <li class="{{\Illuminate\Support\Facades\Request::is('admin/tables/features/payment-categories*') ?
            'active' : ''}}"><a href="{{route('table.PaymentCategories')}}" class="nav-link">Payment Categories</a></li>
            <li class="{{\Illuminate\Support\Facades\Request::is('admin/tables/features/payment-methods*') ?
            'active' : ''}}"><a href="{{route('table.PaymentMethods')}}" class="nav-link">Payment Methods</a></li>
        </ul>
    </li>

    <li class="menu-header">Data Transaction</li>
    <li class="dropdown {{\Illuminate\Support\Facades\Request::is('admin/tables/clients/feedback*') ? 'active' : ''}}">
        <a href="{{route('table.feedback')}}" class="nav-link">
            <i class="fas fa-comment-dots"></i><span>Feedback</span></a></li>
    <li class="dropdown {{\Illuminate\Support\Facades\Request::is('admin/tables/clients/orders*') ? 'active' : ''}}">
        <a href="{{route('table.orders')}}" class="nav-link">
            <i class="fas fa-dollar-sign"></i><span>Orders</span></a></li>
</ul>

<div class="mt-4 mb-4 p-3 hide-sidebar-mini">
    <a href="{{route('home')}}" class="btn btn-primary btn-lg btn-block btn-icon-split">
        <i class="fas fa-rocket"></i> GO TO MAIN SITE</a>
</div>