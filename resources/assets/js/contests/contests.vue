<template>
    <div class="container" style="overflow:auto">
        <el-card>
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
            }
        },
        computed: {
            'curPage'() {
                return this.$route.query.page ? this.$route.query.page : 1;
            }
        },
        created() {
            this.serContests();
        },
        methods: {
            serContests() {
                axios.get('/api/contests?page=' + this.curPage)
                    .then((response) => {
                        this.loading = false;
                        this.contests = response.data.content;
                        this.total = parseInt(response.data.total);
                    })
                    .catch((error) => {
                        if (error.response.status === 429) {
                            this.$message.error('访问过快，请稍后刷新');
                        }
                        console.log(error);
                    });
            },
            changePageRoute() {

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
    }
</script>