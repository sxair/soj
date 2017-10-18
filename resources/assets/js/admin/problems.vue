<template>
    <div>

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
                    <td>{{ problem.id }}</td>
                    <td>{{ problem.title }}</td>
                    <td>{{ problem.author }}</td>
                    <td>{{ problem.public?'yes':'no' }}</td>
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
                :total="tl"
                :current-page="parseInt($route.query.page)"
                @current-change="handleCurrentChange"
        >
        </el-pagination>
    </div>
</template>

<script>
    export default {
        props: {
            'tl': {
                type: Number,
                default() {
                    return 30
                }
            },
            'search': {
                type: Boolean,
                default() {
                    return false
                }
            },
            'problems': {
                type: Object,
                default() {
                    return null;
                }
            }
        },
        created() {
            this.setProblems(this.$route.query.page);
        },
        methods: {
            setProblems(cp) {
                axios.get('/api/problems')
                    .then((response) => {
                        this.problems = response.data;
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