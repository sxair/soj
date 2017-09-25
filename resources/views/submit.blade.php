@extends('layouts.app')
@section('content')
    <div class="container">
        <ul class="col-md-12 list-inline">
            <li class="onclick"><a href="{{ url('problems') }}">Problems</a></li>
            <li><a href="{{ url('status') }}">Status</a></li>
            <li><a href="{{ url('rank') }}">Rank</a></li>
        </ul>
        <div class="row">
            <div class="panel panel-default col-md-8 col-md-offset-2">
                <div class="panel-body">
                    <form action="{{ url('submit') }}" id="subpro" method="post" onsubmit="return twice()">
                        {{ csrf_field() }}
                        <div>
                            <p>Time/Memory Limit:<i id="time">{{ $time }}</i>MS/
                                <i id="momory">{{ $memory }}</i>KB
                            </p>
                            <select name="lang" id="lang" onchange="cglang()">
                                {{ lang_option() }}
                            </select>
                        </div>
                        <textarea name="code" id="code" class="center-block" style="min-height: 300px;min-width: 60%;"></textarea>
                        <input type="text" name="problem_id" value="{{ $id }}" style="display: none"/>
                        <button type="submit">提交</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('js')
    <script>
        var time = '{{ $time }}', memory = '{{ $memory }}';
        cglang();
    </script>
    @endpush
@endsection
