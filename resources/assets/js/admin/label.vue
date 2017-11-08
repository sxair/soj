<template>
<div style="padding-top: 10px" v-loading="loading"
     element-loading-text="提交中...">
    <pre id="code" class="ace_editor" style="min-height:400px">
    <textarea class="ace_text-input"></textarea>
    </pre>
    <el-button type="primary" style="float: right" @click="onSubmit">更改</el-button>
</div>
</template>
<script>
    export default {
        data() {
            return {
                loading: false,
                editor: {}
            }
        },
        mounted() {
            this.editor = ace.edit("code");
            this.editor.session.setMode("ace/mode/json");
            axios.get('/api/label')
                .then((response) => {
                    console.log(response.data);
                    this.editor.setValue(response.data.content);
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        methods: {
            onSubmit() {
                const val = {"label": this.editor.getValue()};
                console.log('label');
                if(confirm("确认更改标签？")) {
                    axios.post('/admin/cgLabel', val).then((response) => {
                        this.loading = false;
                        this.$message({
                            message: '提交成功',
                            duration: 1500,
                            type: 'success'
                        });
                    }).catch((error) => {
                        this.$message({
                            showClose: true,
                            message: '提交失败' + error,
                            type: 'error',
                            duration: 0
                        });
                    });
                }
            }
        }
    }
</script>
