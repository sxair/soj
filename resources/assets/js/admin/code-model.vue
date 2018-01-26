<template>
    <div class="col-md-8 col-md-offset-2">
        <el-card>
            <div style="text-align:right">
                <button type="button" @click="close" class="btn btn-danger">关闭程序填空</button>
            </div>
            <div style="margin: auto;width: 95%">
                <codemirror :value="code" ref="editor"></codemirror>
            </div>
            <div style="text-align:right">
                <button class="btn btn-primary" @click="change">翻译模板</button>
                <button class="btn btn-primary" @click="submit">使用程序填空</button>
            </div>
        </el-card>
        <el-card>
            <pre style="word-wrap:break-word">

            </pre>
        </el-card>
    </div>
</template>
<script>
    export default {
        props: {
            id: String
        },
        data() {
            return {
                code: ''
            }
        },
        mounted() {
            this.$notify({
                title: '提示',
                dangerouslyUseHTMLString: true,
                message: '<a href="/admin/help/addProblem" target="_blank">点击查看程序填空帮助</a>',
                duration: 3000,
                type: 'warning'
            });
            this.$nextTick(() => {this.setCode()});
        },
        methods: {
            setCode() {
                let id = this.id;
                axios.get('/admin/getCodeModel/' + id).then((response) => {
                    this.code = response.data;
                }).catch((error) => {
                    console.log(error);
                    this.$message.error('获取源码失败');
                });
            },
            close() {
                let id = this.id;
                axios.get('/admin/closeCodeModel/' + id).then((response) => {
                    this.$message.error('关闭成功');
                }).catch((error) => {
                    this.$message.error('关闭失败');
                });
            },
            change() {

            },
            submit() {
                this.code = this.$refs.editor.getValue();
                let t = {'id': this.id, 'code': this.code};
                axios.get('/admin/addCodeModel', t).then((response) => {
                    this.$message.error('添加成功');
                }).catch((error) => {
                    this.$message.error('添加失败');
                });
            }
        },
        watch: {
            '$route.query': function () {
                this.setCode();
            }
        }
    }
</script>