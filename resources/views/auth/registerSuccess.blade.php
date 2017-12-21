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
    <div style="margin-bottom: 13px;"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <el-card>
                    <div slot="header" class="clearfix">
                        <span>confirm email</span>
                    </div>
                    我们已给您邮箱发送激活邮件。请等待查收邮件，并激活帐号。
                </el-card>
            </div>
        </div>
    </div>
@endsection
