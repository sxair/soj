<template>
    <div class="container">
        <el-card>
            <el-form :inline="true" ref="search" :model="search" size="small" style="margin-left:10px">
                <el-form-item label="Search Contest:">
                    <el-input v-model="search.content" :maxlength="20"
                              style="width: 180px"
                              @keyup.enter.native="onSearch"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-select v-model="search.type" style="width:100px">
                        <el-option v-once
                                   v-for="it in searchType"
                                   :key="it.value"
                                   :label="it.label"
                                   :value="it.value">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item>
                    <el-select v-model="search.time" style="width:100px">
                        <el-option v-once
                                   v-for="it in searchTime"
                                   :key="it.value"
                                   :label="it.label"
                                   :value="it.value">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="onSearch">查询</el-button>
                </el-form-item>
            </el-form>
            <div style="overflow: auto">
                <table class="table table-hover table-center table-striped" v-loading="loading"
                       element-loading-text="加载中╮(╯▽╰)╭"
                >
                    <thead>
                    <tr>
                        <th width="8%">ID</th>
                        <th width="40%">Title</th>
                        <th>Begin Time</th>
                        <th>Length</th>
                        <th>Writers</th>
                        <th>Type</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="con in contests">
                        <td>{{ con.id }}</td>
                        <td><a :href="'/contest/' + con.id">{{ con.title }}</a></td>
                        <td>{{ con.start_time }}</td>
                        <td>{{ diffData(con.start_time, con.end_time) }}</td>
                        <td>{{ con.user_name }}</td>
                        <td v-html="getType(con.password)">{{ getType(con.password) }}</td>
                        <td v-html="getStatus(con.start_time, con.end_time)">{{ getStatus(con.start_time, con.end_time)
                            }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
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
                total: 0,
                loading: true,
                contests: [],
                search: {
                    content: '',
                    type: 0,
                    time: 0,
                },
                searchType: [
                    {value: 0, label: 'Title'},
                    {value: 1, label: 'Writer'}
                ],
                searchTime: [
                    {value: 0, label: 'All'},
                    {value: 1, label: 'Current'},
                    {value: 2, label: 'Pasted'},
                    {value: 3, label: 'Scheduled'}
                ]
            }
        },
        computed: {
            'curPage'() {
                return this.$route.query.page ? this.$route.query.page : 1;
            }
        },
        created() {
            this.setContests();
        },
        methods: {
            changePageRoute(cp) {
                let use = false;
                for (let x in this.search) {
                    if (this.search[x]) use = true;
                }
                let que = {};
                if (use) que = JSON.parse(JSON.stringify(this.search));
                if (cp != 1 || this.$route.query.page) {
                    que.page = cp;
                }
                this.$router.push({query: que});
                document.body.scrollTop = 0;
                document.documentElement.scrollTop = 0;
            },
            setContests() {
                const query = this.$route.query;
                this.search.type = query.type ? parseInt(query.type) : 0;
                this.search.time = query.time ? parseInt(query.time) : 0;
                this.search.content = query.content ? query.content : '';
                let getUrl = '/api/contests' + '?page=' + this.curPage + '&type=' + this.search.type
                    + '&time=' + this.search.time + '&content=' + this.search.content;
                this.loading = true;
                axios.get(getUrl).then((response) => {
                    this.loading = false;
                    this.contests = response.data.content;
                    this.total = parseInt(response.data.total);
                });
            },
            onSearch() {
                let que = JSON.parse(JSON.stringify(this.search));
                que.page = 1;
                this.$router.push({query: que});
            },
            diffData(s, e) {
                var twoInt = function (n) {
                    if (n < 10) return '0' + n;
                    return n;
                };
                var st = new Date(s).getTime(), et = new Date(e).getTime();
                var min = parseInt((et - st) / 60000);
                var day = parseInt(min / 1440);
                min %= 1440;
                return day + 'days ' + twoInt(parseInt(min / 60)) + ':' + twoInt(min % 60);
            },
            getType(p) {
                if (p) {
                    return '<span style="color:red">Public</span>'
                }
                return '<span style="color: green">Private</span>'
            },
            getStatus(s, e) {
                if (new Date(s).getTime() > new Date().getTime()) {
                    return '<span style="color: blue">Scheduled</span>';
                }
                if (new Date(e).getTime() < new Date().getTime()) {
                    return '<span style="color: green">Ended</span>';
                }
                return '<span style="color: red;">Running</span>';
            },
        },
        watch: {
            '$route.query'() {
                this.setContests();
            },
        }
    }
</script>