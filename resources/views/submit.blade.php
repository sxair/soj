@extends('layouts.app')
@section('content')
    <div class="container" style="padding-top: 10px;">
        <div class="col-md-8 col-md-offset-2">
            <el-card>
                <form class="form-inline" action="{{ url('submit') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="proid">Problem Id</label>
                        <input type="text" class="form-control" id="proid" value="{{ $id }}"
                               style="width: 70px"
                               maxlength="5"
                               required
                        >
                    </div>
                    <div class="form-group">
                        <label>Language</label>
                        <select class="form-control">
                            <option>c</option>
                            <option>c++</option>
                            <option>3</option>
                        </select>
                    </div>
                    <pre id="code" class="center-block"
                         style="min-height: 300px;min-width: 60%;"><textarea></textarea></pre>
                    <input type="text" name="problem_id" value="{{ $id }}" style="display: none"/>
                    <button type="button" class="btn btn-info" style="float: right;margin-bottom: 10px">提交</button>
                </form>
            </el-card>
        </div>
    </div>
@endsection
@push('js')
<script src="{{ asset('ace-builds/src-min/ace.js') }}"></script>
<script src="{{ asset('ace-builds/src-min/ext-language_tools.js') }}"></script><script>
    var editor = ace.edit("code");
    editor.setFontSize(18);
    editor.session.setMode("ace/mode/c_cpp");
</script>
@endpush
