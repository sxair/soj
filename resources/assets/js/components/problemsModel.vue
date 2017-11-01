<template>
    <el-row class="container">
        <el-col :md="19">
            <div style="margin-top: 10px">
                <el-card>
                    <el-pagination
                            layout="prev, pager, next"
                            :total="total"
                            :page-size="100"
                            :current-page="parseInt($route.query.page)"
                            @current-change="handleCurrentChange"
                    >
                    </el-pagination>
                    <problems-table :problems="problems" :search="noTitle"
                                    :loading="loading"></problems-table>
                    <div>
                        <el-pagination
                                layout="prev, pager, next"
                                :total="total"
                                :page-size="100"
                                :current-page="parseInt($route.query.page)"
                                @current-change="changeRouter"
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
                            <el-input v-model="search.content"></el-input>
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
    </el-row>
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
                }
                ],
                emptySearch: 0,
                noTitle: false,
            }
        },
        mounted() {
            this.setProblems(this.$route.query.page);
        },
        methods: {
            setProblems(cp) {
                const getUrl = '/api/problems' + '?page=' + cp + '&search=' + this.search.content
                    + '&type=' + this.search.type;
                this.loading = true;
                axios.get(getUrl)
                    .then((response) => {
                        this.loading = false;
                        this.problems = response.data.problems;
                        this.total = parseInt(response.data.total);
                    })
                    .catch((error) => {
                        if(error.response.status == 429) {
                            this.$message.error('访问过快，请稍后刷新');
                        }
                        console.log(error);
                    });
            },
            handleCurrentChange: function (cp) {
                this.changeRouter(cp);
                this.setProblems(cp);
            },
            changeRouter: function (cp) {
                let que = {page: cp};
                if (this.search.content) {
                    que.search = this.search.content;
                    if((que.type = this.search.type) != 'title') {
                        this.noTitle = true;
                    } else {
                        this.noTitle = false;
                    }
                } else this.noTitle = false;
                this.$router.push({query: que});
            },
            onSearch: function () {
                if(this.search.content === '') {
                    if(this.emptySearch++ > 10) {
                        alert("老哥点那么多下干嘛？");
                    }
                    return false;
                }
                this.handleCurrentChange(this.$route.query.page);
            },
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