<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/soj.css') }}" rel="stylesheet">
</head>
<body>
<nav class="s-navbar" id="menu">
    <div class="container">
        <a class="s-navbar-brand s-mhidden" href="{{ url('/') }}">
            {{ config('app.name', 'MNNUOJ') }}
        </a>
        <ul class="s-nav">
            <li><a href="{{ url('problems') }}">Problems</a></li>
            <li><a href="#">Contests</a></li>
        </ul>
        <ul class="s-nav s-nav-right">
            @guest
            <li><a href="{{ route('login') }}">Login</a></li>
            <li><a href="{{ route('register') }}">Register</a></li>
            @else
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ url('userinfo', Auth::user()->name) }}">个人信息</a>
                            <a href="{{ url('change') }}">修改资料</a>
                            @can('control')
                                <a href="{{ url('control') }}">功能管理</a>
                            @endcan
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
                @endguest
        </ul>
    </div>
</nav>
<div id="panel">
    <nav class="s-navbar-btn">
        <div class="container">
            <a class="s-navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'MNNUOJ') }}
            </a>
            <button class="slideout-btn">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
    </nav>
    <div id="app">
        @yield('content')
    </div>
</div>
<footer class="text-center" style="padding:30px 50px">
    <div>
        Copyright © 2017 sair. All rights reserved.
    </div>
</footer>
<!-- Scripts -->
<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ mix('js/soj.js') }}"></script>
@stack('js')
</body>
</html>
