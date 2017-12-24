<template>
    <div>
        <el-card>
            <table class="table table-hover table-center">
                <tbody>
                <tr>
                    <th width="10%">用户名</th>
                    <th width="10%">推荐者</th>
                    <th width="60%">备注</th>
                    <th>操作</th>
                </tr>
                <tr v-for="(a, index) in admins">
                    <td>{{ a.name }}</td>
                    <td>{{ a.presenter_name }}</td>
                    <td>{{ a.remark }}</td>
                    <td>
                        <el-button size="mini" type="primary" @click="change(a.id)">修改</el-button>
                        <el-button size="mini" type="danger" @click="delAdmin(a.id, a.name)">删除</el-button>
                    </td>
                </tr>
                </tbody>
            </table>
            <el-pagination
                    layout="prev, pager, next"
                    :total="total"
                    :page-size="50"
                    :current-page="parseInt(curPage)"
                    @current-change="changePageRoute"
                    style="float: right"
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
                'admins': [],
            }
        },
        mounted() {
            this.setAdmins();
        },
        computed: {
            'curPage'() {
                return this.$route.query.page ? this.$route.query.page : 1;
            },
        },
        methods: {
            setAdmins() {
                let cp = this.curPage;
                toTop();
                axios.get('/admin/admins?page=' + cp)
                    .then((response) => {
                        this.admins = response.data.content;
                        this.total = parseInt(response.data.total);
                    });
            },
            changePageRoute(cp) {
                if (cp != 1 || this.$route.query.page) {
                    this.$router.push({query: {page: cp}});
                }
            },
            delAdmin(id, name) {
                if (confirm("确认取消" + name + "管理员资格?")) {
                    axios.post('/admin/delAdmin', {'id': id})
                        .then((response) => {
                            if(response.data.success) {
                                this.$message({
                                    message: response.data.success,
                                    type: 'success'
                                });
                            } else {
                                this.$message.error(response.data.failed);
                            }
                        }).catch((error) => {this.$message.error('删除失败');});
                }
            }
        },
        watch: {
            '$route.query.page': function () {
                this.setAdmins();
            }
        }
    }
</script>