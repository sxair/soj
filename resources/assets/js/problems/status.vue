<template>
    <div class="container">
        <el-card>
            <el-form :inline="true" ref="search" :model="search" size="small" style="margin-left:10px">
                <el-form-item label="Author">
                    <el-input v-model="search.author" :maxlength="20"
                              style="width: 130px"
                              @keyup.enter.native="onSearch"></el-input>
                </el-form-item>
                <el-form-item label="Pro_id">
                    <el-input v-model.number="search.proId" :maxlength="5"
                              style="width: 80px"
                              @keyup.enter.native="onSearch"></el-input>
                </el-form-item>
                <el-form-item label="Result">
                    <el-select v-model="search.status" style="width:180px">
                        <el-option v-once
                                   v-for="item in results"
                                   :key="item.value"
                                   :label="item.label"
                                   :value="item.value">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="Language">
                    <el-select v-model="search.lang" style="width:120px">
                        <el-option v-once
                                   v-for="item in languages"
                                   :key="item.value"
                                   :label="item.label"
                                   :value="item.value">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="onSearch">查询</el-button>
                </el-form-item>
            </el-form>
            <div style="overflow:auto">
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
                        <td><a :href="'problem/' + sta.problem_id">{{ sta.problem_id }}</a></td>
                        <td>
                            <to-html :arg="sta.status" :type=1></to-html>
                        </td>
                        <td>
                            <to-html :arg="sta.lang" :type=0></to-html>
                        </td>
                        <td v-if="this.user.name != sta.user_name">{{ sta.code_len }}B</td>
                        <td v-else><a :href="'showcode/' + sta.id">{{ sta.code_len }}B</a></td>
                        <td>{{ sta.time }} MS</td>
                        <td>{{ sta.memory }} KB</td>
                        <td>{{ sta.created_at }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div>
                <el-pagination
                        layout="prev, pager, next"
                        :total="total"
                        :page-size="15"
                        :current-page="parseInt(curPage)"
                        @current-change="changePageRoute"
                        style="float: right;"
                >
                </el-pagination>
            </div>
        </el-card>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                status: {},
                loading: true,
                search: {
                    author: '',
                    proId: '',
                    status: 0,
                    lang: 0,
                },
                total: 0,
                results: [
                    {value: 0, label: 'All'},
                    {value: 2, label: 'Compilation error'},
                    {value: 3, label: 'Accepted'},
                    {value: 6, label: 'Wrong Answer'},
                    {value: 11, label: 'Runtime Error'},
                    {value: 9, label: 'Time Limit Exceeded'},
                    {value: 7, label: 'Memory Limit Exceeded'},
                    {value: 8, label: 'Output Limit Exceeded'},
                    {value: 10, label: 'Presentation Error'}
                ],
                languages: [
                    {value: 0, label: 'All'},
                    {value: 1, label: 'c'},
                    {value: 2, label: 'c++'},
                    {value: 3, label: 'java'},
                    {value: 4, label: 'python3'}
                ]
            }
        },
        computed: {
            'curPage'() {
                return this.$route.query.page ? this.$route.query.page : 1;
            },
        },
        mounted() {
            this.setStatus();
        },
        methods: {
            changePageRoute(cp) {
                /* fix this:
                 * status -> status?page = 3
                 * if back then will add a route ?page=1
                 */
                let use = false;
                for (let x in this.search) {
                    if (this.search[x]) use = true;
                }
                let que = {};
                if (use) que = JSON.parse(JSON.stringify(this.search));
                if (cp != 1 || this.$route.query.page) {
                    que.page = cp;
                }
                toTop();
                this.$router.push({query: que});
            },
            setStatus() {
                const query = this.$route.query;
                this.search.author = query.author ? query.author : '';
                this.search.proId = query.proId ? query.proId : '';
                this.search.status = query.status ? parseInt(query.status) : 0;
                this.search.lang = query.lang ? parseInt(query.lang) : 0;
                let getUrl = '/api/status' + '?page=' + this.curPage + '&author=' + this.search.author
                    + '&proId=' + this.search.proId + '&status=' + this.search.status
                    + '&lang=' + this.search.lang;
                this.loading = true;
                axios.get(getUrl).then((response) => {
                    this.loading = false;
                    this.status = response.data.content;
                    this.total = parseInt(response.data.total);
                });
            },
            onSearch() {
                let que = JSON.parse(JSON.stringify(this.search));
                que.page = 1;
                this.$router.push({query: que});
            },
        },
        watch: {
            '$route.query'() {
                this.setStatus();
            },
        }
    }
</script>