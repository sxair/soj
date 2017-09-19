@extends('layouts.app')
@section('content')
    <div class="container">
        <ul class="col-md-12 list-inline">
            <li class="onclick"><a href="{{ url('problems') }}">Problems</a></li>
            <li><a href="{{ url('status') }}">Status</a></li>
            <li><a href="{{ url('rank') }}">Rank</a></li>
        </ul>
        <div></div>
    </div>
    <div style="margin: auto;text-align: center">
        <form action="{{ url('submit') }}" id="subpro" method="post" onsubmit="return twice()">
            {{ csrf_field() }}
            <div>
                Time/Memory Limit:<i id="timlim">{{ $time }}</i>MS/
                <i id="memlim">{{ $memory }}</i>K
                <select name="lang" id="lang" onchange="cglang()">
                    <option value="2">{{ lang_html(2) }}</option>
                    <option value="1">{{ lang_html(1) }}</option>
                    <option value="3">{{ lang_html(3) }}</option>
                </select>
            </div>
            <textarea name="code" id="code" style="min-height: 300px;min-width: 60%;"></textarea>
            <input type="text" name="problem_id" value="{{ $id }}" style="display: none"/>
            <button type="submit">提交</button>
        </form>
    </div>
    @push('js')
    <script>
        var time = '{{ $time }}', memory = '{{ $memory }}';
        cglang();
    </script>
    @endpush
@endsection
