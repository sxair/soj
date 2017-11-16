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
    <link href="{{ asset('css/soj.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="s-navbar" id="menu">
        <navbar title="{{ config('app.name', 'MNNUOJ') }}"></navbar>
    </nav>
    <div id="panel">
        <nav class="s-navbar-btn">
            <div class="s-container">
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
        @yield('content')
        <footer class="text-center" style="padding:30px 50px">
            <div>
                Copyright © 2017 sair. All rights reserved.
            </div>
        </footer>
    </div>
</div>
<!-- Scripts -->
@if(Auth::user())
    <script>
        window.user = {
            id: '{{ Auth::id() }}',
            name: '{{ Auth::user()->name }}',
            control: '{{ Auth::user()->control }}'
        };
    </script>
    @else
    <script>
        window.user = {
            id: 0,
            name: '',
            control: 0
        };
    </script>
@endif
<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ mix('js/soj.js') }}"></script>
@stack('js')
</body>
</html>
