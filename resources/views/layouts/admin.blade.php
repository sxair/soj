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
<div id="app">
    <navbar title="{{ config('app.name', 'MNNUOJ') }}"></navbar>
    <div id="panel">
        <nav class="s-navbar-media">
            <a class="s-navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'MNNUOJ') }}
            </a>
            <button class="slideout-btn">
                <i class="el-icon-menu" style="font-size: 26px;"></i>
            </button>
        </nav>
        @yield('content')
        <footer class="text-center" style="padding:30px 50px">
            <div>
                Copyright © 2017 sair. All rights reserved.
            </div>
        </footer>
    </div>
</div>
<script>
    window.user = @if(Auth::user()){!! Auth::user() !!}
        @else {
        id: 0, name: ''
    }; @endif
</script>
<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/admin.js') }}"></script>
<script src="{{ mix('js/soj.js') }}"></script>
@stack('js')
</body>
</html>
