<template>
    <div style="padding-top: 10px">
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
                    <th width="50%">title</th>
                    <th>author</th>
                    <th>public</th>
                    <th>operation</th>
                </tr>
                <tr v-for="problem in problems">
                    <td>{{ problem.problem_id }}</td>
                    <td>{{ problem.title }}</td>
                    <td>{{ problem.user_name }}</td>
                    <td>{{ problem.public ? 'yes' : 'no' }}</td>
                    <td>
                        <a href="#">修改</a>
                        <a v-if="problem.show" href="#">添加到oj</a>
                        <a href="#" v-else>已添加</a>
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
        created() {
            this.setProblems(this.$route.query.page);
        },
        methods: {
            setProblems(cp) {
                axios.get('/admin/problems?page=' + cp)
                    .then((response) => {
                        console.log(response.data);
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