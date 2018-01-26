@extends('layouts.app')
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
        <div class="col-md-6">
            <div>
                <h4 style="display: inline-block">随机序列长度：</h4>
                <input type="text" id="list" style="width: 50px">
                最小值
                <input type="text" id="list_min" style="width: 50px">
                最大值
                <input type="text" id="list_max" style="width: 50px">
                <el-button size="mini" type="primary" onclick="runList()">生成</el-button>
            </div>
            <div>
                <h4 style="display: inline-block">随机字符串长度：</h4>
                <input type="text" id="string" style="width: 100px">
                <el-button size="mini" type="primary" onclick="runString()">生成</el-button>
            </div>
            <h3>编写生成测试数据js代码(<a href="{{ url('help', 'createTest') }}" target="view_window">api文档</a>)</h3>
            <codemirror ref="editor" :lang=10 :value="code"></codemirror>
            <div class="text-right">
                <button class="btn btn-primary" style="margin-top: 10px;width: 30%" onclick="run()">生成</button>
            </div>
        </div>
        <div class="col-md-6">
            <h3>测试数据：</h3>
            <codemirror ref="test" :value="test"></codemirror>
        </div>
    </div>
@endsection
@push('setData')
    window.VueData = {code: 'var n = 10;\n\
pln(n);\n\
list(n);\n', test: ''}
@endpush
@push('js')
<style>
    .CodeMirror {
        height: 390px;
    }
</style>
<script src="{{ asset('js/create-test.js') }}"></script>
@endpush