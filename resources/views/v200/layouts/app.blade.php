<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('v200.fragments.head')
@php
    $body_class = '';
    $main_class = 'col-xs-12 col-sm-8 col-lg-9 col-xl-10 pt-3 pl-4 ml-auto';

@endphp
@guest
    @php
        $body_class = 'login-page';
        $main_class = 'col-xs-10 col-sm-8 col-md-4 m-auto';
    @endphp
@endguest
<body class="{{ $body_class }}">
<div class="container-fluid" id="wrapper">
    <div class="row">
        @auth
            @include('v200.fragments.menu')
        @endauth
        <main class="{{ $main_class }}">
            @auth
                @include('v200.fragments.header')
            @endauth
            @yield('main_content')
            <section class="row">
                <div class="col-12 mt-1 mb-4">
                    <p>Template by <a href="https://medialoot.com/preview/bootstrap-4-dashboard-premium/index.html">Medialoot</a></p>
                </div>
            </section>
        </main>
    </div>
</div>

@include('v200.fragments.scripts')
@auth
    @include('v200.fragments.logout')
@endauth
</body>
</html>