<template>
    <div>
        <el-card style="width: 50%;margin: auto">
            <div slot="header" class="clearfix">
                <span>Compile Error Information</span>
            </div>
            <div v-if="down && ce != ''">
                <pre>{{ ce }}</pre>
            </div>
            <div v-else-if="down">
                <h3>暂无相应信息</h3>
            </div>
            <div v-else>
                <h3>加载中</h3>
            </div>
        </el-card>
    </div>
</template>
<script>
    export default {
        props: {
            id: [String, Number]
        },
        data() {
            return {
                ce: '',
                down: false
            }
        },
        mounted() {
            this.setCeInfo();
        },
        methods: {
            setCeInfo() {
                let url = '/api/ceinfo/' + this.id;
                axios.get(url).then((response) => {
                    this.ce = response.data;
                    this.down = true;
                }).catch((error) => {
                    this.down = true;
                });
            }
        },
        watch: {
            id() {
                this.setCeInfo();
            }
        }
    }
</script>