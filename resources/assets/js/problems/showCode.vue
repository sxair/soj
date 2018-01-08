<template>
    <div style="width: 500px;margin:auto" class="cm-auto">
        <codemirror :readOnly=true :value="code" :lang="status.lang"></codemirror>
    </div>
</template>
<script>
    export default {
        props: {
            id: String
        },
        data() {
            return {
                code: '',
                status: {}
            }
        },
        mounted() {
            this.setCode();
        },
        methods: {
            setCode() {
                this.auth();
                const s = this;
                axios.get('/code/' + s.id).then((response) => {
                    this.code = response.data.code;
                    this.status = response.data.status
                }).catch((error) => {
                    this.$message.error('代码查看失败');
                });
            }
        },
        watch: {
            '$route.query': 'setCode'
        }
    }
</script>