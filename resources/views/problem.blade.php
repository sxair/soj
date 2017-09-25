@extends('layouts.app')
@section('content')
    <div class="container">
        <ul class="col-md-12 list-inline">
            <li class="onclick"><a href="{{ url('problems') }}">Problems</a></li>
            <li><a href="{{ url('status') }}">Status</a></li>
            <li><a href="{{ url('rank') }}">Rank</a></li>
        </ul>
        <div class="row">
            <div class="col-md-9 panel panel-default">
                <div class="panel-heading" style="text-align: center;">
                    <h2 style="margin: auto">{{ $pro->id }}: {{ $pro->title }}</h2>
                </div>
                <div class="panel-body">
                    <div class="text-center">
                        <p style="margin-top: -10px">time limit per test {{ $pro->time_limit }} ms<br/>
                        memory limit per test {{ $pro->memory_limit }} KB</p>
                    </div>
                    <div class="probox">{!! $pro->content !!}</div>
                    <h4>Input</h4>
                    <div class="probox">{!! $pro->input !!}</div>
                    <h4>output</h4>
                    <div class="probox">{!! $pro->output !!}</div>
                    <h4>Sample Input</h4>
                    <pre><div class="probox">{{ $pro->sample_input}}</div></pre>
                    <h4>Sample output</h4>
                    <pre><div class="probox">{{ $pro->sample_output }}</div></pre>
                    <h4>hint</h4>
                    <div class="probox">{!! $pro->hint !!}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-md-6" style="border-bottom: solid 1px #d4d4d4;border-right: solid 1px #d4d4d4">
                            <a href="{{ url('proinfo', $pro->id) }}"><h4>提交：{{ $pro->submitted }}</h4></a>
                        </div>
                        <div class="col-md-6" style="border-bottom: solid 1px #d4d4d4">
                            <a href="{{ url('proinfo', $pro->id) }}"><h4>ac：{{ $pro->accepted }}</h4></a>
                        </div>
                        <a class="btn btn-primary" href="#" style="width:100%;margin-top: 10px">题解</a>
                        <a class="btn btn-primary" href="{{ url('submit', [$pro->id, $pro->time_limit, $pro->memory_limit]) }}" style="width:100%;margin-top: 10px">提交</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">source</div>
                    <div class="panel-body">
                        <a href="{{ url('problems') }}?search={{ $pro->source }}&type=2">{{ $pro->source }}</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">author</div>
                    <div class="panel-body">
                        <a href="">{{ $pro->author }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
