<template>
    <div class="container">
        <el-card>
            <div style="overflow:auto">
                <table class="table table-hover table-center table-striped" v-loading="loading"
                       element-loading-text="加载中╮(╯▽╰)╭">
                    <thead>
                    <tr>
                        <th width="7%">Rank</th>
                        <th width="17%">Nickname</th>
                        <th width="70%" style="min-width: 300px">Quote</th>
                        <th>Ratio(AC/Submit)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(u, i)  in ranks">
                        <td>{{ i + 1 + (curPage - 1) * 15}}</td>
                        <td><a :href="'/userinfo/' + u.name">{{ u.name }}</a></td>
                        <td>{{ u.motto }}</td>
                        <td>{{ u.submitted ? (parseFloat(u.accepted) / u.submitted * 100).toFixed(2) + '%' : '0.00%' }}
                            ({{ u.accepted }}/{{ u.submitted }})
                        </td>
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
                ranks: [],
                total: 0,
                loading: true,
            }
        },
        computed: {
            curPage() {
                return this.$route.query.page ? this.$route.query.page : 1;
            },
        },
        mounted() {
            this.setRanks();
        },
        methods: {
            changePageRoute(cp) {
                let que = {};
                if (cp != 1 || this.$route.query.page) {
                    que.page = cp;
                }
                this.$router.push({query: que});
                document.body.scrollTop = 0;
                document.documentElement.scrollTop = 0;
            },
            setRanks() {
                this.loading = true;
                axios.get('/api/rank?page=' + this.curPage).then((response) => {
                    this.loading = false;
                    this.ranks = response.data.content;
                    this.total = parseInt(response.data.total);
                });
            }
        },
        watch: {
            '$route.query'() {
                this.setRanks();
            },
        }
    }
</script>