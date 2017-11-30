<template>
    <div class="container">
        <div class="col-md-9">
            <el-card>
                <el-pagination
                        layout="prev, pager, next"
                        :total="total"
                        :page-size="50"
                        :current-page="parseInt(curPage)"
                        @current-change="changePageRoute"
                >
                </el-pagination>
                <problems-table :problems="problems"
                                :search="noTitle"
                                :loading="loading"
                                proUrl="/problem"
                ></problems-table>
                <div>
                    <el-pagination
                            layout="prev, pager, next"
                            :total="total"
                            :page-size="50"
                            :current-page="parseInt(curPage)"
                            @current-change="changePageRoute"
                            style="float: right"
                    >
                    </el-pagination>
                </div>
            </el-card>
        </div>
        <div class="col-md-3">
            <div class="s-fix">
                <el-card>
                    <el-form ref="search" :model="search">
                        <el-form-item>
                            <el-input v-model="search.content" @keyup.enter.native="onSearch"></el-input>
                        </el-form-item>
                        <el-form-item>
                            <el-select v-model="search.type" style="width:120px">
                                <el-option
                                        v-for="item in options"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                </el-option>
                            </el-select>
                            <el-button type="primary" @click="onSearch">查询</el-button>
                        </el-form-item>
                    </el-form>
                </el-card>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                problems: [],
                total: 0,
                search: {
                    content: '',
                    type: 'title',
                    label: 0
                },
                loading: true,
                options: [{
                    value: 'title',
                    label: 'title'
                }, {
                    value: 'author',
                    label: 'author'
                }, {
                    value: 'source',
                    label: 'source'
                }],
                emptySearch: 0,
                noTitle: false,
                label: [{
                    name: '所有问题',
                    id: 0
                }]
            }
        },
        created() {
            this.setProblems();
            this.setLabel();
        },
        computed: {
            'curPage'() {
                return this.$route.query.page ? this.$route.query.page : 1;
            },
            'routeSearch'() {
                return this.$route.query.search ? this.$route.query.search : '';
            },
            'routeType'() {
                return this.$route.query.type ? this.$route.query.type : 'title';
            },
            'routeLabel'() {
                return this.$route.query.label ? this.$route.query.label : 0;
            }
        },
        methods: {
            setLabel() {
                axios.get("api/label")
                    .then((response) => {
                        this.label = eval(response.data.content);
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            setProblems() {
                let cp = this.curPage;
                if ((this.search.content = this.routeSearch) != '')
                    this.emptySearch = -1;
                this.search.type = this.routeType;
                this.search.label = this.routeLabel;
                let getUrl = '/api/problems' + '?page=' + cp + '&search=' + this.search.content
                    + '&type=' + this.search.type;
                if (this.search.content && this.search.type != 'title') {
                    this.noTitle = true;
                } else this.noTitle = false;
                this.loading = true;
                document.body.scrollTop = 0;
                document.documentElement.scrollTop = 0;
                axios.get(getUrl).then((response) => {
                    this.loading = false;
                    this.problems = response.data.content;
                    this.total = parseInt(response.data.total);
                });
            },
            changePageRoute(cp) {
                let que = {};
                /* fix this:
                 * problems -> problems?page = 3
                 * if back then will add a route ?page=1
                 */
                if (cp != 1 || this.$route.query.page) {
                    que.page = cp;
                }
                if (this.$route.query.search) {
                    que.search = this.$route.query.search;
                    que.type = this.$route.query.type;
                }
                this.$router.push({query: que});
            },
            onSearch() {
                if (this.search.content === '') {
                    if (this.emptySearch == -1) {
                        this.emptySearch = 0;
                        this.$router.push({query: {}});
                        return;
                    }
                    this.$message.error('请输入搜索内容');
                    return;
                }
                let que = {page: 1};
                que.search = this.search.content;
                que.type = this.search.type;
                if (this.search.label) {
                    que.label = this.search.label;
                }
                this.$router.push({query: que});
            },
            onLabelSearch(lid) {
                this.search.label = parseInt(lid);
                if (this.search.content === '') {
                    this.$router.push({query: {label: this.search.label}});
                } else this.onSearch();
            }
        },
        watch: {
            '$route.query': function () {
                this.setProblems();
            }
        }
    }
</script>