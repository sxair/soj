<template>
    <div class="container">
        <el-col :md="19">
            <div style="margin-top: 10px">
                <el-card>
                    <el-pagination
                            layout="prev, pager, next"
                            :total="total"
                            :page-size="100"
                            :current-page="parseInt(curPage)"
                            @current-change="changePageRoute"
                    >
                    </el-pagination>
                    <problems-table :problems="problems"
                                    :search="noTitle"
                                    :loading="loading"
                                    :proUrl="/problem/"
                    ></problems-table>
                    <div>
                        <el-pagination
                                layout="prev, pager, next"
                                :total="total"
                                :page-size="100"
                                :current-page="parseInt(curPage)"
                                @current-change="changePageRoute"
                                style="float: right;margin-top:-18px"
                        >
                        </el-pagination>
                    </div>
                </el-card>
            </div>
        </el-col>
        <el-col :md="5">
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
                <div style="padding-top: 10px;">
                    <el-card>
                        <el-menu>
                            <el-submenu index="1">
                                <template slot="title">
                                    <i class="el-icon-location"></i>
                                    <span>导航一</span>
                                </template>
                                <el-menu-item-group>
                                    <el-menu-item index="1-1">选项1</el-menu-item>
                                    <el-menu-item index="1-2">选项2</el-menu-item>
                                </el-menu-item-group>
                            </el-submenu>
                        </el-menu>
                    </el-card>
                </div>
            </div>
        </el-col>
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
                    type: 'title'
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
            }
        },
        mounted() {
            this.setProblems();
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
            }
        },
        methods: {
            setProblems() {
                let cp = this.curPage;
                this.search.content = this.routeSearch;
                this.search.type = this.routeType;
                let getUrl = '/api/problems' + '?page=' + cp + '&search=' + this.search.content
                    + '&type=' + this.search.type;
                if (this.search.content && this.search.type != 'title') {
                    this.noTitle = true;
                } else this.noTitle = false;
                this.loading = true;
                axios.get(getUrl)
                    .then((response) => {
                        this.loading = false;
                        this.problems = response.data.problems;
                        this.total = parseInt(response.data.total);
                    })
                    .catch((error) => {
                        if (error.response.status == 429) {
                            this.$message.error('访问过快，请稍后刷新');
                        }
                        console.log(error);
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
                    if (this.emptySearch++ > 10) {
                        alert("老哥点那么多下干嘛？");
                    }
                    this.$message.error('请输入搜索内容');
                    return false;
                }
                let que = {page: 1};
                que.search = this.search.content;
                que.type = this.search.type;
                this.$router.push({query: que});
            },
        },
        watch: {
            '$route.query': function () {
                this.setProblems();
            }
        }
    }
</script>
<style>
    .el-form-item {
        margin-bottom: 10px;
    }

    .s-fix .el-card__body {
        padding: 10px 10px 0 10px;
    }

    .el-menu {
        border: 0;
    }
</style>