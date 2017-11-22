@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="col-md-10 col-md-offset-1" style="margin-top: 20px">
            <el-card>
                <div slot="header" class="clearfix">
                    <span>信息更改</span>
                </div>
                <form class="form-horizontal">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="name" class="col-md-3 control-label"><span style="color: red">*</span>Name</label>
                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" value="{{ $user->name }}" required autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">E-Mail Address</label>
                        <div class="col-md-6">
                            {{ $user->email }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="old" class="col-md-3 control-label">Old Password</label>
                        <div class="col-md-6">
                            <input id="old" type="password" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-md-3 control-label">New Password</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password-confirm" class="col-md-3 control-label">Confirm Password</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="school" class="col-md-3 control-label">School</label>

                        <div class="col-md-6">
                            <input id="school" type="text" class="form-control"
                                   name="school" value="{{ $info->school }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="school" class="col-md-3 control-label">Quote</label>
                        <div class="col-md-8">
                            <editor ref="editor" :value="motto"></editor>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-3">
                            <button type="button" class="btn btn-primary" onclick="changeUserInfo()">
                                更改
                            </button>
                        </div>
                    </div>
                </form>
            </el-card>
        </div>
    </div>
@endsection
@push('setData')
    window.VueData.motto = "{{ $info->motto }}";
@endpush