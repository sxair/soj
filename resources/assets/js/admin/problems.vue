<template>
    <div>
        <el-card>
            <el-pagination
                    layout="prev, pager, next"
                    :total="total"
                    :page-size="50"
                    :current-page="parseInt(curPage)"
                    @current-change="changePageRoute"
            >
            </el-pagination>
            <table class="table table-hover">
                <tbody>
                <tr>
                    <th width="7%">id</th>
                    <th width="60%">title</th>
                    <th>author</th>
                    <th>public</th>
                    <th>operation</th>
                </tr>
                <tr v-for="(pro, index) in problems">
                    <td>{{ pro.problem_id }}</td>
                    <td>
                        <router-link :to="'/problem/' + pro.problem_id">
                            {{ pro.title }}
                        </router-link>
                        <div class="label-group" style="float: right">
                            <el-tag v-for="i in pro.labels" :key="i" style="margin-right: 5px">{{ labelMap[i] }}
                            </el-tag>
                        </div>
                    </td>
                    <td>{{ pro.user_name }}</td>
                    <td>{{ pro.public ? 'yes' : 'no' }}</td>
                    <td>
                        <el-button size="mini" v-if="!pro.oj_id" type="primary" @click="addToOj(pro.problem_id,index)">
                            添加
                        </el-button>
                        <el-button size="mini" v-else type="danger">oj{{ pro.oj_id }}</el-button>
                        <el-button size="mini" type="warning" @click="toOperation(pro.problem_id)">操作</el-button>
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
                'problems': [],
                'labels': [],
                'labelMap': [],
            }
        },
        mounted() {
            this.setLabels();
            this.setProblems();
        },
        computed: {
            'curPage'() {
                return this.$route.query.page ? this.$route.query.page : 1;
            },
        },
        methods: {
            setLabels() {
                axios.get('/api/label').then((response) => {
                    this.labels = JSON.parse(response.data.content);
                    this.buildLabelMap();
                });
            },
            buildLabelMap() {
                for (let i in this.labels) {
                    let t = this.labels[i];
                    this.labelMap[t.id] = t.name;
                    for (let j in t.son) {
                        let tt = this.labels[i].son[j];
                        this.labelMap[tt.id] = tt.name;
                    }
                }
            },
            setProblems() {
                let cp = this.curPage;
                toTop();
                axios.get('/admin/problems?page=' + cp)
                    .then((response) => {
                        this.problems = response.data.problems;
                        this.total = parseInt(response.data.total);
                        for (let i in this.problems) {
                            if (this.problems[i].labels != '')
                                this.problems[i].labels = JSON.parse(this.problems[i].labels);
                        }
                    });
            },
            changePageRoute(cp) {
                if (cp != 1 || this.$route.query.page) {
                    this.$router.push({query: {page: cp}});
                }
            },
            addToOj(id, index) {
                if (confirm("确定添加到oj题目库？")) {
                    const s = this;
                    axios.get('/admin/addToOj/' + id).then((response) => {
                        if (response.data.success) {
                            s.problems[index].oj_id = response.data.success;
                            this.$message({
                                message: '成功添加至oj，编号为' + response.data.success,
                                type: 'success'
                            })
                        } else {
                            this.$message.error(response.data.failed ? response.data.failed : '添加失败');
                        }
                    }).catch((error) => {
                        this.$message.error('添加失败');
                    });
                }
            },
//            delFormOj(id, index) {
//                if(confirm("确定从oj题目库移除？")) {
//                    const s = this;
//                    axios.get('/admin/delFromOj/'+id)
//                        .then((response) => {
//                            if(response.data.success) {
//                                s.problems[index].oj_id = 0;
//                                this.$message({
//                                    message: '删除成功',
//                                    type: 'success'
//                                })
//                            } else {
//                                this.$message.error(response.data.failed ? response.data.failed : '添加失败');
//                            }
//                        });
//                }
//            },
            toOperation(id) {
                toTop();
                this.$router.push('/problemOperation/' + id);
            }
        },
        watch: {
            '$route.query.page': function () {
                this.setProblems();
            }
        }
    }
</script>