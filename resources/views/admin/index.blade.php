@extends('layouts.admin')
@section('content')
    <div>
        <el-col :md="4">
            <admin-menu></admin-menu>
        </el-col>
        <el-col :md="20">
            <div class="s-fix">
                <router-view></router-view>
            </div>
        </el-col>
    </div>
@endsection