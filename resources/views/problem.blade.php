@extends('layouts.app')
@section('content')
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
            <el-button type="primary" plain>提交</el-button>
        </el-col>
    </div>
@endsection