@extends('layouts.app')
@section('content')
    <nav class="s-subbar">
        <div class="s-subcon">
            <ul class="s-subnav">
                <li><a href="{{ url('problems') }}">Problems</a></li>
                <li><a href="{{ url('status') }}">Status</a></li>
                <li><a href="{{ url('ranks') }}">Ranks</a></li>
            </ul>
        </div>
    </nav>
    <div class="container" style="padding-top: 10px">
        <el-col :md="19">
            <el-card>
                <div class="pro-header">
                    <h3 class="text-center">{{ $pro->title }}</h3>
                    <i>Time/Memory Limit: {{ $pro->time_limit }} MS / {{ $pro->memory_limit }} MB</i>
                    <i>Submitted: {{ $pro->submitted }}&nbsp;&nbsp;&nbsp;Accepted: {{ $pro->accepted }}</i>
                </div>
                <div class="pro-body">
                    {!! $pro->content !!}
                </div>
            </el-card>
        </el-col>
        <el-col :md="5">
            <div style="width: 90%;margin: auto">
                <a class="btn btn-primary" href="{{ url('submit', $pro->id) }}" style="width: 100%;margin-bottom: 10px;" role="button">
                    提交</a>
                <el-card>
                    <div style="">
                        <h3 style="margin:2px 0 18px 0">信息</h3>
                        <dl class="dl-horizontal">
                            <dt style="width: 100px;text-align: left;font-weight:normal;">提交数</dt>
                            <dd style="margin-left:100px">{{ $pro->submitted }}</dd>
                            <dt style="width: 100px;text-align: left;font-weight:normal;">ac数</dt>
                            <dd style="margin-left:100px">{{ $pro->accepted }}</dd>
                        </dl>
                    </div>
                </el-card>
            </div>
        </el-col>
    </div>
@endsection