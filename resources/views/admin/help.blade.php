@extends('layouts.admin')
@section('content')
    <div class="container">
        <el-card>
            @if(is_null($content))
                <h1>暂无符合该标题的帮助文档</h1>
            @else
                {!! $content !!}
            @endif
        </el-card>
    </div>
@endsection