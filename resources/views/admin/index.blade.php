@extends('layouts.admin')
@section('content')
    <el-row>
        <el-col :sm="4" :offset="1">
                <el-menu>
                    <el-submenu index="1">
                        <template slot="title">
                            <i class="el-icon-menu"></i>
                            <span>题目库管理</span>
                        </template>
                        <el-menu-item-group>
                            <el-menu-item index="1-1">查看题目库</el-menu-item>
                            <el-menu-item index="1-2">新增题目</el-menu-item>
                        </el-menu-item-group>
                    </el-submenu>
                    <el-menu-item index="2">
                        <i class="el-icon-setting"></i>
                        <span slot="title">标签设置</span>
                    </el-menu-item>
                    <el-submenu index="3">
                        <template slot="title">
                            <i class="el-icon-menu"></i>
                            <span>比赛管理</span>
                        </template>
                        <el-menu-item-group>
                            <el-menu-item index="3-1">查看比赛</el-menu-item>
                            <el-menu-item index="3-2">新增比赛</el-menu-item>
                        </el-menu-item-group>
                    </el-submenu>
                    <el-menu-item index="4">
                        <i class="el-icon-document"></i>
                        <span slot="title">学生管理</span>
                    </el-menu-item>
                    <el-menu-item index="5">
                        <i class="el-icon-document"></i>
                        <span slot="title">重判题目</span>
                    </el-menu-item>
                    <el-menu-item index="6">
                        <i class="el-icon-setting"></i>
                        <span slot="title">模块开关</span>
                    </el-menu-item>
                </el-menu>
        </el-col>
    </el-row>
@endsection
@push('js')
<script>
    var app = new Vue({
        el: '#app'
    });
</script>
@endpush