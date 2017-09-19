@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ asset('codemirror/lib/codemirror.css') }}">
    <style type="text/css">
        .CodeMirror {
            height: auto;
            border: 1px solid #ccc;
            font-size: 15px;
        }</style>
    <link rel="stylesheet" href="{{ asset('codemirror/theme/monokai.css') }}">
    <script src="{{ asset('codemirror/lib/codemirror.js') }}"></script>
    <script src="{{ asset('codemirror/mode/clike/clike.js') }}"></script>
    <div class="container">
        <div class="row col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 style="margin: 5px 3px; text-align: center">Show Code</h3></div>
                <div class="panel-body">
                        <div style="font-size: 15px; text-align: center">
                            <p>
                                <strong>author : </strong><a href="{{ url('userinfo', $status->user_id) }}">{{ $status->user_name }}</a>
                                &nbsp;&nbsp;&nbsp;
                                <strong>problem id : </strong><a href="{{ url('problem', $status->problem_id) }}">{{ $status->problem_id }}</a>
                            </p>
                            <p><strong>status id : </strong>{{ $status->id }}
                                &nbsp;&nbsp;&nbsp;
                                <strong>status : </strong>{!! status_html($status->status) !!}
                            </p>
                            <p>
                                <strong>Language : </strong>{{ lang_html($status->lang) }}
                                &nbsp;&nbsp;&nbsp;
                                <strong>time : </strong>{{ $status->time }}MS
                                &nbsp;&nbsp;&nbsp;
                                <strong>memory : </strong>{{ $status->memory }}KB
                            </p>
                        </div>
                    <textarea id="code">{{ $code->code }}</textarea>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
            lineNumbers: true,
            @if($status->lang <= 2)
            mode: 'text/x-c++src',
            @elseif($status->lang == 3)
            mode: 'text/x-java',
            @endif
            theme: 'monokai',
            readOnly : true,
            viewportMargin: Infinity,
        });
    </script>
@endsection