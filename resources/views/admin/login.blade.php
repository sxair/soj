@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <el-card>
                    <div slot="header" class="clearfix">
                        <span>Login</span>
                    </div>
                        <form class="form-horizontal" method="post" action="{{ url('admin/login') }}">
                            {{ csrf_field() }}
                            @if(session('failed'))
                                <el-alert
                                        title="{{ session('failed') }}"
                                        type="error"
                                        style="margin-bottom: 17px"
                                >
                                </el-alert>
                            @endif
                            <div class="form-group">
                                <label for="password" class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Login
                                    </button>
                                </div>
                            </div>
                        </form>
                </el-card>
            </div>
        </div>
    </div>
@endsection