<template>
    <div style="overflow:auto">
        <el-form :inline="true" ref="search" :model="search">
            <el-form-item label="Author">
                <el-input v-model="search.author"  @keyup.enter.native="onSearch"></el-input>
            </el-form-item>
            <el-form-item label="pro_id">
                <el-input v-model="search.proId"
                          :rules="[{ type: 'number', message: 'id必须为数字值'}]"
                          @keyup.enter.native="onSearch"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="onSearch">查询</el-button>
            </el-form-item>
        </el-form>
        <table class="table table-hover table-center table-striped" v-loading="loading"
               element-loading-text="加载中╮(╯▽╰)╭">
            <thead>
            <tr>
                <th>id</th>
                <th>user</th>
                <th>pro.id</th>
                <th>status</th>
                <th>language</th>
                <th>code len</th>
                <th>time</th>
                <th>memory</th>
                <th>submit time</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="sta in status">
                <td>{{ sta.id }}</td>
                <td><a href="#">{{ sta.user_name }}</a></td>
                <td><a href="#">{{ sta.problem_id }}</a></td>
                <td style="text-align: center">{{ ($sta.status) }}</td>
                <td>{{ sta.lang }}</td>
                <td>{{ sta.code_len }}</td>
                <td>{{ sta.time }}</td>
                <td>{{ sta.memory }}</td>
                <td>{{ sta.created_at }}</td>
            </tr>
            </tbody>
        </table>
        <div>
            <el-pagination
                    layout="prev, pager, next"
                    :total="total"
                    :page-size="10"
                    :current-page="parseInt(curPage)"
                    @current-change="changePageRoute"
                    style="float: right;margin-top:-18px"
            >
            </el-pagination>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            'user': {
                type: Object,
                default: {
                    'name': '',
                    'id': 0
                }
            }
        },
        data() {
            return {
                'status': {},
                'loading': false,
                'search' : {
                    'author' : '',
                    'proId' : ''
                }
            }
        },
        methods: {
            changePageRoute: function (cp) {
                let que = {};
                /* fix this:
                 * problems -> problems?page = 3
                 * if back then will add a route ?page=1
                 */
                if (cp != 1 || this.$rouet.query.page) {
                    que.page = cp;
                }
                if (this.$route.query.search) {
                    que.search = this.$route.query.search;
                    que.type = this.$route.query.type;
                }
                this.$router.push({query: que});
            },
        },
    }
</script>
<style>
    .el-form-item {
        margin-bottom:10px;
    }
</style>