@extends('layouts.admin')
@section('content')
    <style>
        .editor-box{
            min-height: 260px;
            min-width: 600px;
        }
    </style>
    <div class="container">
        <div>
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ $error }}
                </div>
            @endforeach
            <div class="panel panel-default">
                <div class="panel-heading" style="text-align: center;padding: 0 0 2px 0;"><h2 style="">更改题目</h2></div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('updateproblem') }}" id="proform" onsubmit="return subadd()">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $pro->id }}">
                        <div class="form-group">
                            <label for="title" class="control-label col-md-3">标题</label>
                            <div class="col-md-7">
                                <input id="title" class="form-control" name="title" value="{{ $pro->title }}" required="required" autofocus="autofocus"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="time_limit" class="col-md-3 control-label">时间限制</label>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input id="time_limit" class="form-control" value="{{ $pro->time_limit }}" name="time_limit" maxlength="5" required="required">
                                    <div class="input-group-addon">MS</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="memory_limit" class="control-label col-md-3">内存限制</label>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input id="memory_limit" class="form-control" value="{{ $pro->memory_limit }}" name="memory_limit" maxlength="6" required="required">
                                    <div class="input-group-addon">KB</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="spj" class="control-label col-md-3">spj</label>
                            <div class="col-md-9">
                                <div class="col-md-3" style="margin-right: -18px;">
                                    <label class="radio-inline">
                                        <input type="radio"  name="spj" id="spj0" value="0" {!! $pro->spj?:'checked="checked"' !!}/> 否
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio"  name="spj" id="spj1" value="2" {!! $pro->spj==2?'checked="checked"':''!!}/> 精度限制
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="content" class="control-label col-md-3">题目描述</label>
                            <div class="col-md-8">
                                <div id="e_content" class="editor-box"></div>
                                <textarea id="content" name="content" class="hidden">{!! $pro->content !!}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input" class="control-label col-md-3">输入</label>
                            <div class="col-md-8">
                                <div id="e_input" class="editor-box"></div>
                                <textarea id="input" name="input" class="hidden">{!! $pro->input !!}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="output" class="control-label col-md-3">输出</label>
                            <div class="col-md-8">
                                <div id="e_output" class="editor-box"></div>
                                <textarea id="output" name="output" class="hidden">{!! $pro->output !!}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sample_input" class="control-label col-md-3">输入测试</label>
                            <div class="col-md-8">
                                <textarea id="sample_input" class="editor-box" name="sample_input" required="required">{{ $pro->sample_input }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sample_output" class="control-label col-md-3">输出测试</label>
                            <div class="col-md-8">
                                <textarea id="sample_output" class="editor-box" name="sample_output" required="required">{{ $pro->sample_output }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="hint" class="control-label col-md-3">hint（样例解释）</label>
                            <div class="col-md-8">
                                <div id="e_hint" class="editor-box"></div>
                                <textarea id="hint" name="hint" class="hidden">{{ $pro->hint }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="author" class="control-label col-md-3">作者</label>
                            <div class="col-md-7">
                                <input id="author" class="form-control" value="{{ $pro->author }}" name="author" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="source" class="control-label col-md-3">来源</label>
                            <div class="col-md-7">
                                <input id="source" class="form-control" value="{{ $pro->source }}" name="source" />
                            </div>
                        </div>
                        <button id="addproblem" type="submit" class="btn btn-primary col-md-offset-6">提交</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <link href="{{ asset('umeditor1.2.3/themes/default/css/umeditor.css') }}" type="text/css" rel="stylesheet">
    @push('js')
    <script src="{{ asset('umeditor1.2.3/third-party/template.min.js') }}"></script>
    <script src="{{ asset('umeditor1.2.3/umeditor.config.js') }}"></script>
    <script src="{{ asset('umeditor1.2.3/umeditor.js') }}"></script>
    <script>
        var cont = UM.getEditor('e_content');
        var inp = UM.getEditor('e_input');
        var oup = UM.getEditor('e_output');
        var hi = UM.getEditor('e_hint');
        var submitted = true;
        function subadd() {
            $("#content").val(cont.getContent());
            $("#input").val(inp.getContent());
            $("#output").val(oup.getContent());
            $("#hint").val(hi.getContent());
            var t = submitted;
            submitted = false;
            return t;
        }
        cont.addListener("ready", function () {
            cont.setContent($("#content").val());
        });
        inp.addListener("ready", function () {
            inp.setContent($("#input").val());
        });
        oup.addListener("ready", function () {
            oup.setContent($("#output").val());
        });
        hi.ready(function () {
            hi.setContent($("#hint").val());
        });
    </script>
    @endpush
@endsection