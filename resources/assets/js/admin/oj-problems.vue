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
                    <td>
                        <el-button size="mini" type="info" @click="delFormOj(pro.id, index)">移除oj{{ pro.id }}</el-button>
                        <el-button size="mini" type="danger" @click="toOperation(pro.problem_id)">修改</el-button>
                        <a :href="'/admin/download/test/' + pro.problem_id" style="margin-left:8px"><el-button size="mini">下载测试数据</el-button></a>
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
                axios.get('/admin/ojProblems?page=' + cp)
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
            delFormOj(id, index) {
                if(confirm("确定从oj题目库移除？")) {
                    const s = this;
                    axios.get('/admin/delFromOj/'+id)
                        .then((response) => {
                            if(response.data.success) {
                                s.problems[index].oj_id = 0;
                                this.$message({
                                    message: '删除成功',
                                    type: 'success'
                                })
                                this.setProblems();
                            } else {
                                this.$message.error(response.data.failed ? response.data.failed : '删除失败');
                            }
                        });
                }
            },
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