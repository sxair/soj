<template>
    <div :class="{container: type != 'admin'}">
        <div v-if="problem.title" style="position: relative">
            <div class="col-md-9">
                <el-card>
                    <div class="pro-header">
                        <h3 class="text-center">{{ problem.title }}</h3>
                        <i>Time/Memory Limit: {{ problem.time_limit }} MS / {{ problem.memory_limit }} KB</i>
                        <i>Submitted: {{ problem.submitted }}&nbsp;&nbsp;&nbsp;Accepted: {{ problem.accepted }}</i>
                    </div>
                    <div class="pro-body" v-html="problem.content">
                        {{ problem.content }}
                    </div>
                </el-card>
            </div>
            <div class="col-md-3 media-hidden pro-subbar">
                <el-card>
                    <router-link :to="suburl + id" class="btn btn-primary" style="width:100%">提交</router-link>
                </el-card>
                <el-card style="margin-top: 8px">
                    <div slot="header" class="clearfix">
                        <h4>author</h4>
                    </div>
                    <a :href="'/problems?type=author&search='+problem.author" target="view_window">{{ problem.author
                        }}</a>
                </el-card>
                <el-card style="margin-top: 8px">
                    <div slot="header" class="clearfix">
                        <h4>source</h4>
                    </div>
                    <a :href="'/problems?type=source&search='+problem.source" target="view_window">{{ problem.source
                        }}</a>
                </el-card>
            </div>
            <div class="media-show bottom-right">
                <router-link :to="'/submit/'+id"><i class="el-icon-edit"></i></router-link>
            </div>
        </div>
        <div v-else-if="down">
            <el-card>
                <h1>您访问的题目不存在</h1>
            </el-card>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            id: [String, Number],
        },
        computed: {
            type() {
                if (window.location.pathname === '/admin') {
                    return 'admin';
                }
                return 'oj';
            },
            suburl() {
                return '/submit/';
            }
        },
        data() {
            return {
                down: false,
                problem: {}
            }
        },
        mounted() {
            this.setProblem();
        },
        methods: {
            setProblem() {
                let url = '/api/problem/' + this.id;
                if (this.type == 'admin') {
                    url = '/admin/getProblem/' + this.id;

                }
                axios.get(url)
                    .then((response) => {
                        this.problem = response.data;
                        this.down = true;
                    })
                    .catch((error) => {
                        this.down = true;
                    });
            }
        },
        watch: {
            '$route.query': 'setProblem'
        }
    }
</script>
<style>
    .pro-subbar .el-card__header {
        padding: 0 17px;
    }
</style>