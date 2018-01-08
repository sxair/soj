@extends('layouts.app')
@push('js')
<style>
    .help .el-card__header {
        padding: 0;
    }
</style>
@endpush
@section('content')
    <nav class="s-navbar-media">
        <a class="s-navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'MNNUOJ') }}
        </a>
        <button class="slideout-btn">
            <i class="el-icon-menu" style="font-size: 26px;"></i>
        </button>
    </nav>
    <div class="container">
        <el-card class="help">
            <div slot="header" class="clearfix text-center">
                <h3>测试数据创建api文档</h3>
            </div>
        </el-card>
    </div>
@endsection