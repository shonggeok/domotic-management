<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('v100.fragments.head')
    </head>
    <body>
        @auth
        <div class="container">
            @include('v100.fragments.menu')
        </div>
        @endauth
        <div class="container">
            @yield('content')
        </div>
        @include('v100.fragments.scripts')
        @auth
            @include('v100.fragments.logout')
        @endauth
    </body>
</html>