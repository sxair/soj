<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ mix('css/soj.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <navbar title="{{ config('app.name', 'MNNUOJ') }}"></navbar>
    <div id="panel">
        @yield('content')
        <soj-footer></soj-footer>
    </div>
</div>
<script>
    window.VueData = {};
    @stack('setData')
    window.user = @if(Auth::user()){!! Auth::user() !!}
        @else {
        id: 0, name: ''
    }; @endif
</script>
<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ mix('js/soj.js') }}"></script>
@stack('js')
</body>
</html>
