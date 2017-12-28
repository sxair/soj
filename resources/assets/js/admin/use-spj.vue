<template>
    <div class="container">
        <div class="col-md-8 col-md-offset-2">
            <el-card>
                <el-form :inline="true" size="small" style="margin-left:10px">
                    <el-form-item label="Pro_id">
                        {{ id }}
                    </el-form-item>
                    <el-form-item label="Language">
                        C++
                    </el-form-item>
                    <el-form-item class="pull-right">
                        <button type="button" @click="close_spj" class="btn btn-danger">关闭spj</button>
                    </el-form-item>
                </el-form>
                <div style="margin: auto;width: 95%;">
                    <textarea v-model="code" style="min-height: 300px;width: 100%"></textarea>
                </div>
                <div style="text-align:left;float:left">
                    状态：
                    <to-html v-if="status != -1" :arg="status" :type=1></to-html>
                    <i v-if="status < 0">{{ statusLang[status] }}</i>
                </div>
                <div style="text-align:right;">
                    <button class="btn btn-primary" @click="onSubmit">提交</button>
                </div>
            </el-card>
            <el-card v-if="status == 2" style="margin-top:10px">
                {{ ce }}
            </el-card>
        </div>
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
                tmpCode: '',
                status: -1,
                statusLang: {'-1': '待提交', '-2': '待评测'},
                timeout: 0,
                ce: ''
            }
        },
        mounted() {
            this.check();
        },
        methods: {
            check() {
                if (this.timeout) clearTimeout(this.timeout);
            },
            setStatus(id) {
                axios.get('/admin/getStatus/' + id).then((response) => {
                    this.status = response.data.status;
                    if (this.status === 2) {
                        this.ce = response.data.ce;
                    }
                    if (this.status <= 1 || (this.status >= 50000 && this.status < 60000)) {
                        this.timeout = setTimeout(() => {
                            this.setStatus(id)
                        }, 1000);
                    }
                });
            },
            submit() {
                let t = {};
                t.id = this.id;
                t.code = this.tmpCode = this.code;
                if (this.code.length >= 65535) {
                    this.$message.error('代码过长');
                    return;
                }
                axios.post('/admin/compile', t).then((response) => {
                    if (response.data.success > 0) {
                        this.$message.success('提交成功');
                        this.status = -2;
                        this.timeout = setTimeout(() => {
                            this.setStatus(response.data.success)
                        }, 1000);
                    } else this.$message.error(response.data.failed);
                }).catch((error) => {
                    if (error.response.data.message) {
                        this.$message.error("提交失败," + JSON.parse(error.response.data.message));
                    } else {
                        this.$message.error('提交失败');
                    }
                });
            },
            onSubmit() {
                if (this.code.length < 50) {
                    this.$message.error('代码过短~');
                    return;
                }
                if (this.tmpCode == this.code) {
                    this.$message.error('请勿重复提交');
                    return;
                }
                this.submit();
            },
            close_spj() {
                let t = {'id': this.id};
                axios.post('/admin/closeSpj', t).then((response) => {
                    this.$message.success('已关闭spj判断');
                }).catch((error) => {
                    this.$message.error('关闭spj失败');
                });
            }
        },
        watch: {
            '$route.query': 'check'
        },
        beforeDestroy() {
            if (this.timeout) clearTimeout(this.timeout);
        }
    }
</script>