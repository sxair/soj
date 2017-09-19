@extends('layouts.admin')
@section('content')
    <style>
        .editor-box {
            min-height: 260px;
            min-width: 600px;
        }
    </style>
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
            <div class="panel-heading" style="text-align: center;padding: 0 0 2px 0;"><h2 style="">新增题目</h2></div>
            <div class="panel-body">
                <form class="form-horizontal" method="POST" action="{{ url('addproblem') }}" id="proform"
                      onsubmit="return subadd()">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="title" class="control-label col-md-3">标题</label>
                        <div class="col-md-7">
                            <input id="title" class="form-control" name="title" value="{{ old('title') }}"
                                   required="required" autofocus="autofocus"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="time_limit" class="col-md-3 control-label">时间限制</label>
                        <div class="col-md-3">
                            <div class="input-group">
                                <input id="time_limit" class="form-control"
                                       value="{{ old('time_limit')?old('time_limit'):1000 }}" name="time_limit"
                                       maxlength="5" required="required">
                                <div class="input-group-addon">MS</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="memory_limit" class="control-label col-md-3">内存限制</label>
                        <div class="col-md-3">
                            <div class="input-group">
                                <input id="memory_limit" class="form-control"
                                       value="{{ old('memory_limit')?old('memory_limit'):32768 }}" name="memory_limit"
                                       maxlength="6" required="required">
                                <div class="input-group-addon">KB</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="spj" class="control-label col-md-3">spj</label>
                        <div class="col-md-9">
                            <div class="col-md-3" style="margin-right: -18px;">
                                <label class="radio-inline">
                                    <input type="radio" name="spj" id="spj0"
                                           value="0" {!! old('spj')?:'checked="checked"' !!}/> 否
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="spj" id="spj1"
                                           value="2" {!! old('spj')==2?'checked="checked"':''!!}/> 精度限制
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="content" class="control-label col-md-3">题目描述</label>
                        <div class="col-md-8">
                            <div id="content" class="editor-box"></div>
                            <input type="text" name="content" class="hidden"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input" class="control-label col-md-3">输入</label>
                        <div class="col-md-8">
                            <div id="input" class="editor-box"></div>
                            <input type="text" name="input" class="hidden"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="output" class="control-label col-md-3">输出</label>
                        <div class="col-md-8">
                            <div id="output" class="editor-box"></div>
                            <input type="text" name="output" class="hidden"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sample_input" class="control-label col-md-3">输入测试</label>
                        <div class="col-md-8">
                            <textarea id="sample_input" class="editor-box" name="sample_input"
                                      required="required">{{ old('sample_input') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sample_output" class="control-label col-md-3">输出测试</label>
                        <div class="col-md-8">
                            <textarea id="sample_output" class="editor-box" name="sample_output"
                                      required="required">{{ old('sample_output') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hint" class="control-label col-md-3">hint（样例解释）</label>
                        <div class="col-md-8">
                            <div id="hint" class="editor-box"></div>
                            <input type="text" name="hint" class="hidden"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="author" class="control-label col-md-3">作者</label>
                        <div class="col-md-7">
                            <input id="author" class="form-control" value="{{ old('author') }}" name="author"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="source" class="control-label col-md-3">来源</label>
                        <div class="col-md-7">
                            <input id="source" class="form-control" value="{{ old('source') }}" name="source"/>
                        </div>
                    </div>
                    <button id="addproblem" type="submit" class="btn btn-primary col-md-offset-6">提交</button>
                </form>
            </div>
        </div>
    </div>
    <link href="{{ asset('umeditor1.2.3/themes/default/css/umeditor.css') }}" type="text/css" rel="stylesheet">
    @push('js')
    <script src="{{ asset('umeditor1.2.3/third-party/template.min.js') }}"></script>
    <script src="{{ asset('umeditor1.2.3/umeditor.config.js') }}"></script>
    <script src="{{ asset('umeditor1.2.3/umeditor.min.js') }}"></script>
    <script>
        var cont = UM.getEditor('content');
        var inp = UM.getEditor('input');
        var oup = UM.getEditor('output');
        var hi = UM.getEditor('hint');
        function subadd() {
            $("input[name='content']").val(cont.getContent());
            $("input[name='input']").val(inp.getContent());
            $("input[name='output']").val(oup.getContent());
            $("input[name='hint']").val(hi.getContent());
            return twice();
        }
        cont.addListener("ready", function () {
            cont.setContent("<?php echo old('content'); ?>");
        });
        inp.addListener("ready", function () {
            inp.setContent("<?php echo old('input'); ?>");
        });
        oup.addListener("ready", function () {
            oup.setContent("<?php echo old('output'); ?>");
        });
        hi.addListener("ready", function () {
            hi.setContent("<?php echo old('hint'); ?>");
        });
    </script>
    @endpush
@endsection