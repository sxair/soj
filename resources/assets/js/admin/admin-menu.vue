<template>
    <el-menu
            :router=true
            :default-active="$route.path"
            :unique-opened=true
    >
        <el-submenu index="1">
            <template slot="title">
                <i class="el-icon-tickets"></i>
                <span>题目库管理</span>
            </template>
            <el-menu-item-group>
                <el-menu-item index="/problems">修改管理员题目库</el-menu-item>
                <el-menu-item index="/ojProblems">修改oj题目库</el-menu-item>
                <el-menu-item index="/addProblem">新增题目</el-menu-item>
                <!--<el-menu-item index="1-3">查看选择题</el-menu-item>-->
                <!--<el-menu-item index="1-4">新增选择题</el-menu-item>-->
            </el-menu-item-group>
        </el-submenu>
        <el-menu-item index="/label">
            <i class="el-icon-star-on"></i>
            <span slot="title">标签设置</span>
        </el-menu-item>
        <!--<el-submenu index="3">-->
            <!--<template slot="title">-->
                <!--<i class="el-icon-menu"></i>-->
                <!--<span>比赛管理</span>-->
            <!--</template>-->
            <!--<el-menu-item-group>-->
                <!--<el-menu-item index="3-1">查看比赛</el-menu-item>-->
                <!--<el-menu-item index="3-2">新增比赛</el-menu-item>-->
            <!--</el-menu-item-group>-->
        <!--</el-submenu>-->
        <el-submenu index="4">
            <template slot="title">
                <i class="el-icon-star-off"></i>
                <span>管理员管理</span>
            </template>
            <el-menu-item-group>
                <el-menu-item index="/changePassword">修改管理密码</el-menu-item>
                <el-menu-item index="/showAdmins">修改管理员</el-menu-item>
                <el-menu-item index="/addAdmin">新增管理员</el-menu-item>
            </el-menu-item-group>
        </el-submenu>
        <!--<el-menu-item index="4">-->
            <!--<i class="el-icon-document"></i>-->
            <!--<span slot="title">学生管理</span>-->
        <!--</el-menu-item>-->
        <!--<el-menu-item index="5">-->
            <!--<i class="el-icon-refresh"></i>-->
            <!--<span slot="title">重判题目</span>-->
        <!--</el-menu-item>-->
        <!--<el-menu-item index="6">-->
            <!--<i class="el-icon-setting"></i>-->
            <!--<span slot="title">模块开关</span>-->
        <!--</el-menu-item>-->
        <el-menu-item index="logout">
            <i class="el-icon-news"></i>
            <span slot="title">退出管理</span>
        </el-menu-item>
    </el-menu>
</template>

<script>
    export default {

    }
</script>