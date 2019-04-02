<nav class="sidebar col-xs-12 col-sm-4 col-lg-3 col-xl-2">
    <h1 class="site-title"><a href="{{ Route('dashboard') }}"><em class="fa fa-rocket"></em> {{ env('APP_NAME') }}</a></h1>
    <a href="#menu-toggle" class="btn btn-default" id="menu-toggle"><em class="fa fa-bars"></em></a>
    <ul class="nav nav-pills flex-column sidebar-nav">
        <li class="nav-item">
            <a class="nav-link active" href="{{ Route('dashboard') }}"><em class="fa fa-dashboard"></em> Dashboard</a>
        </li>

        <li class="parent nav-item">
            <a class="nav-link" data-toggle="collapse" href="#sub-item-1" aria-expanded="true">
                <em class="fa fa-cog">&nbsp;</em> {{ __('common.settings') }}
                <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right" aria-expanded="true">
                    <i class="fa fa-plus fa-minus"></i>
                </span>
            </a>
            <ul class="children collapse" id="sub-item-1">
                <li class="nav-item">
                    <a class="nav-link" href="{{ Route('password_show') }}">{{ __('common.change') }} password</a>
                    <a class="nav-link" href="{{ Route('settings_user') }}">{{ __('common.settings') }} {{ __('common.user') }}</a>
                </li>
            </ul>
        </li>

    </ul>
</nav>