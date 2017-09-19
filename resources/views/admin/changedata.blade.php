@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="col-md-offset-3 col-md-6 text-center bg">
            @if(count($errors))
                <h1>{{ $errors->first() }}</h1>
            @else
                <div>
                    @if(session('success'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{ session('success') }}
                        </div>
                    @elseif(session('failed'))
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{ session('failed') }}
                        </div>
                    @elseif(session('warning'))
                        <div class="alert alert-warning">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{ session('warning') }}
                        </div>
                    @endif
                </div>
                <h1>题目{{ $id }}测试数据</h1>
                <form class="form-horizontal" method="POST" action="{{ url('changedata') }}"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="text" name="id" value="{{ $id }}" style="display: none"/>
                    <div class="test">
                        <div class="panel panel-default">
                            <div class="panel-heading">测试1</div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="control-label col-md-3">输入</label>
                                    <div class="col-md-7">
                                        <input type="file" name="input_file[]"/>
                                    </div>
                                    <label class="control-label col-md-3">输出</label>
                                    <div class="col-md-7">
                                        <input type="file" name="output_file[]"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="col-md-6 col-md-offset-3 btn btn-primary" type="button" onclick="addtest()">新增测试
                    </button>
                    <br>
                    <button type="submit" class="col-md-6 col-md-offset-3 btn btn-primary">提交</button>
                </form>
            @endif
        </div>
    </div>
    @push('js')
    <script>
        var testnum = 2;
        function addtest() {
            $('.test').append('<div class="panel panel-default"><div class="panel-heading">测试' + testnum +
                '</div><div class="panel-body">\
                <div class="form-group">\
                <label class="control-label col-md-3">输入</label>\
                <div class="col-md-7">\
                <input type="file" name="input_file[]"/>\
                </div>\
                <label class="control-label col-md-3">输出</label>\
                <div class="col-md-7">\
                <input type="file" name="output_file[]"/>\
                </div>\
                </div>\
                </div>\
                </div>');
            testnum++;
        }

    </script>
    @endpush
@endsection