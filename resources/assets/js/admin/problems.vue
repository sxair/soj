<template>
    <div>
        <el-card>
            <el-pagination
                    layout="prev, pager, next"
                    :total="total"
                    :page-size="50"
                    :current-page="parseInt($route.query.page)"
                    @current-change="handleCurrentChange"
            >
            </el-pagination>
            <table class="table table-hover table-center">
                <tbody>
                <tr>
                    <th width="10%">id</th>
                    <th width="45%">title</th>
                    <th>author</th>
                    <th>public</th>
                    <th>operation</th>
                </tr>
                <tr v-for="problem in problems">
                    <td>{{ problem.problem_id }}</td>
                    <td><a href="">{{ problem.title }}</a></td>
                    <td>{{ problem.user_name }}</td>
                    <td>{{ problem.public ? 'yes' : 'no' }}</td>
                    <td>
                        <el-button size="mini" type="info"
                                @click="">编辑</el-button>
                        <el-button size="mini" v-if="problem.show" type="primary">加至oj</el-button>
                        <el-button size="mini" v-else type="success">已添加</el-button>
                        <router-link :to="'/problemData/' + problem.problem_id"><el-button size="mini" type="warning">修改数据</el-button></router-link>
                    </td>
                </tr>
                </tbody>
            </table>
            <el-pagination
                    layout="prev, pager, next"
                    :total="total"
                    :page-size="50"
                    :current-page="parseInt($route.query.page)"
                    @current-change="handleCurrentChange"
            >
            </el-pagination>
        </el-card>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                'total': 0,
                'problems': [],
            }
        },
        mounted() {
            this.setProblems(this.$route.query.page);
        },
        methods: {
            setProblems(cp) {
                axios.get('/admin/problems?page=' + cp)
                    .then((response) => {
                        this.problems = response.data.problems;
                        this.total = parseInt(response.data.total);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            handleCurrentChange: function (cp) {
                this.$router.push({query: {page: cp}});
                this.setProblems(cp);
            },
        }
    }
</script>