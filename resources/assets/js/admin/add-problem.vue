<template>
    <div style="padding-top: 10px">
        <el-card>
            <div slot="header" class="clearfix text-center">
                <span v-if="!this.id" style="font-size: 16px;color: #000">新增题目</span>
                <span v-else style="font-size: 16px;color: #000">修改题目</span>
            </div>
            <div>
                <div id="showError"></div>
                <el-form ref="form" :model="form" :rules="rules" label-width="150px">
                    <el-form-item label="标题" prop="title">
                        <el-input v-model="form.title" style="width: 60%" :maxlength="30"></el-input>
                    </el-form-item>
                    <el-form-item label="时间限制" prop="time">
                        <el-input v-model="form.time" style="width: 30%" :maxlength="5">
                            <template slot="append">MS</template>
                        </el-input>
                    </el-form-item>
                    <el-form-item label="内存限制" prop="memory">
                        <el-input v-model="form.memory" style="width: 30%" :maxlength="6">
                            <template slot="append">KB</template>
                        </el-input>
                        <i>最大不超过524288KB（512MB）</i>
                    </el-form-item>
                    <el-form-item label="公开">
                        <el-radio-group v-model="form.public">
                            <el-radio :label="1">是</el-radio>
                            <el-radio :label="0">否</el-radio>
                        </el-radio-group>
                    </el-form-item>
                    <editor :value="content" ref="contentEditor" style="width: 80%;margin: auto"></editor>
                    <el-form-item label="来源">
                        <el-input v-model="form.source" style="width: 60%" :maxlength="50"></el-input>
                    </el-form-item>
                    <el-form-item label="作者">
                        <el-input v-model="form.author" style="width: 60%" :maxlength="50"></el-input>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" @click="onSubmit">提交</el-button>
                    </el-form-item>
                </el-form>
            </div>
        </el-card>
    </div>
</template>

<script>
    export default {
        props: {
            'id': {
                type: String,
                default: "0",
            }
        },

        data() {
            return {
                form: {
                    title: '',
                    time: '1000',
                    memory: '32768',
                    public: 1,
                    content: '',
                    md: '',
                    source: '',
                    author: ''
                },
                rules: {
                    title: [{required: true, message: '请输入标题', trigger: 'blur'}],
                },
                content: '### Problem Description\n\n### Input\n\n### Output\n\n' +
                '### Sample Input\n\n### Sample Output\n\n### Hints\n',
            }
        },

        mounted() {
            this.form.author = this.user.name;
            this.$notify({
                title: '提示',
                dangerouslyUseHTMLString: true,
                message: '<a href="/admin/help/addProblem" target="view_window">点击查看添加题目帮助</a>',
                duration: 3000,
                type: 'warning'
            });
            if (this.id && this.id != '0') {
                const s = this;
                axios.get('/admin/getProblem/' + s.id).then((response) => {
                    if (response.data.failed === -1) {
                        this.$message.error(response.data.failed,);
                    } else {
                        this.content = response.data.pro.md;
                        this.form = response.data.pro;
                        this.form.public = response.data.pro.public;
                        this.form.time = this.form.time_limit;
                        this.form.memory = this.form.memory_limit;
                    }
                }).catch((error) => {
                    this.$message.error('获取题目失败');
                });
            }
        },

        methods: {
            onSubmit() {
                this.$refs['form'].validate((valid) => {
                    if (!valid) {
                        this.$message.error('表单填写错误，请检查');
                        return false;
                    }
                    this.form.content = this.$refs.contentEditor.getHtml();
                    this.form.md = this.$refs.contentEditor.getMD();
                    if (!this.form.content) {
                        this.$message.error('你想干嘛');
                        return false;
                    }
                    let t = this.form; //axios内部获取不到this
                    let url = '/admin/addProblem';
                    if (this.id != '0') {
                        url = '/admin/changeProblem';
                        t.id = this.id;
                    }
                    console.log(url);
                    axios.post(url, t).then((response) => {
                        if (response.data.result > 0) {
                            this.$message({
                                message: '提交成功',
                                duration: 1500,
                                type: 'success'
                            });
                            toTop();
                            this.$router.push('/problemOperation/' + response.data.result);
                        } else if (response.data.result === -1) {
                            this.$message.error('你没有添加题目的权限');
                        } else {
                            this.$message.error('提交失败');
                        }
                    }).catch((error) => {
                        if (error.response.status === 422) {
                            this.$message.error('表单填写错误，请查看控制台信息');
                            console.log(error.response.data.errors);
                        } else {
                            this.$message.error('提交失败' + error);
                        }
                    });
                });
            }
        },
        watch: {
            '$route' () {
                this.form = {
                    title: '',
                    time: '1000',
                    memory: '32768',
                    public: 1,
                    content: '',
                    md: '',
                    source: '',
                    author: ''
                };
                this.form.author = this.user.name;
                this.content = '### Problem Description\n\n### Input\n\n### Output\n\n' +
                    '### Sample Input\n\n### Sample Output\n\n### Hints\n';
                this.id = '0';
            }
        }
    }
</script>