<nav class="sidebar col-xs-12 col-sm-4 col-lg-3 col-xl-2">
    <h1 class="site-title"><a href="{{ Route('dashboard') }}"><em class="fa fa-rocket"></em> {{ env('APP_NAME') }}</a></h1>
    <a href="#menu-toggle" class="btn btn-default" id="menu-toggle"><em class="fa fa-bars"></em></a>
    <ul class="nav nav-pills flex-column sidebar-nav">
        <li class="nav-item">
            <a class="nav-link active" href="{{ Route('dashboard') }}"><em class="fa fa-dashboard"></em> Dashboard</a>
        </li>
    </ul>
</nav>