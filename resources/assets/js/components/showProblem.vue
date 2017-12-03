<template>
<div class="container">
    <div v-if="problem.title" style="position: relative">
        <div class="col-md-9">
            <el-card>
                <div class="pro-header">
                    <h3 class="text-center">{{ problem.title }}</h3>
                    <i>Time/Memory Limit: {{ problem.time_limit }} MS / {{ problem.memory_limit }} MB</i>
                    <i>Submitted: {{ problem.submitted }}&nbsp;&nbsp;&nbsp;Accepted: {{ problem.accepted }}</i>
                </div>
                <div class="pro-body" v-html="problem.content">
                    {{ problem.content }}
                </div>
            </el-card>
        </div>
        <div class="col-md-3 media-hidden">
            <el-card>
                <router-link :to="'/submit/'+id" class="btn btn-primary" style="width:100%">提交</router-link>
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
        id: String,
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
            axios.get('/api/problem/' + this.id)
                .then((response) => {
                    this.problem = response.data;
                    this.down = true;
                })
                .catch((error) => {
                    if (error.response.status == 429) {
                        this.$message.error('访问过快，请稍后刷新');
                    }
                    this.down = true;
                    console.log(error);
                });
        }
    }
}
</script>