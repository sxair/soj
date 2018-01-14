<template>
    <div class="container">
        <div class="col-md-8 col-md-offset-2">
            <el-card>
                <el-form :inline="true" ref="search" :model="search" size="small" style="margin-left:10px">
                    <el-form-item label="Pro_id">
                        <el-input v-model.number="search.proId" :maxlength="5"
                                  style="width: 80px"
                                  @keyup.enter.native="onSearch"></el-input>
                    </el-form-item>
                    <el-form-item label="Language">
                        <el-select v-model="search.lang" style="width:180px">
                            <el-option v-once
                                       v-for="item in lang"
                                       :key="item.value"
                                       :label="item.label"
                                       :value="item.value">
                            </el-option>
                        </el-select>
                    </el-form-item>
                </el-form>
                <div style="margin: auto;width: 95%;">
                    <codemirror :value="code" ref="editor"></codemirror>
                </div>
                <div style="text-align:left;float:left" v-if="type == 'admin'">
                    状态(请勿刷新)： <to-html v-if="status != -1" :arg="status" :type=1></to-html> <i v-if="status < 0">{{ statusLang[status] }}</i>
                    &nbsp;&nbsp;time: {{ statusData.time }}MS
                    &nbsp;&nbsp;memory: {{ statusData.memory }}KB
                </div>
                <div style="text-align:right;">
                    <button class="btn btn-primary" @click="onSubmit">提交</button>
                </div>
            </el-card>
            <el-card v-if="status == 2" style="margin-top:10px">
                <pre>{{ statusData.ce }}</pre>
            </el-card>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            id:String
        },
        data() {
            return {
                search: {
                    proId: 1000,
                    lang: 2,
                },
                lang: [
                    {value: 1, label: 'c'},
                    {value: 2, label: 'c++'},
                    {value: 3, label: 'java'},
                    {value: 4, label: 'python2'},
                    {value: 5, label: 'python3'}
                ],
                code: '',
                tmpCode: '',
                status: -1,
                statusLang: {'-1': '待提交', '-2': '待评测'},
                timeout: 0,
                statusData: {},
            }
        },
        mounted() {
            this.check();
        },
        computed: {
            type() {
                if(window.location.pathname === '/admin') {
                    return 'admin';
                }
                return 'oj';
            },
            suburl() {
                return '/submit/';
            }
        },
        methods: {
            check() {
                if(this.timeout) clearTimeout(this.timeout);
                this.auth();
                this.search.proId = parseInt(this.id);
            },
            setStatus(id) {
                axios.get('/admin/getStatus/' + id).then((response) => {
                    this.status = response.data.status;
                    this.statusData = response.data;
                    if(this.status <= 1 || (this.status >= 50000 && this.status < 60000)) {
                        this.timeout = setTimeout(()=>{this.setStatus(id)}, 1000);
                    }
                });
            },
            submit() {
                if(this.timeout) clearTimeout(this.timeout);
                let t = {};
                t.problem_id = this.search.proId;
                t.lang = this.search.lang;
                t.code = this.code;
                let url = '/submit';
                if(this.type == 'admin') {
                    url = '/admin/submit';
                }
                axios.post(url, t).then((response) => {
                    if (response.data.success > 0) {
                        this.$message({
                            message: '提交成功',
                            duration: 1500,
                            type: 'success'
                        });
                        if(this.type == 'admin') {
                            this.status = -2;
                            this.timeout = setTimeout(()=>{this.setStatus(response.data.success)}, 1000);
                        } else {
                            this.$router.push({path: '/status'});
                        }
                    } else this.$message.error(response.data.failed);
                }).catch((error) => {
                    if (error.response.data.errors && error.response.data.errors.problem_id) {
                        this.$message.error('题目不存在');
                    } else {
                        this.$message.error('提交失败');
                    }
                });
            },
            onSubmit() {
                this.code = this.$refs.editor.getValue();
                if (this.code.length < 30) {
                    this.$message.error('代码过短~');
                    return;
                }
                if(this.code.length >= 65535) {
                    this.$message.error('代码过长');
                    return ;
                }
                if (this.tmpCode == this.code) {
                    this.$message.error('请勿重复提交');
                    return;
                }
                this.tmpCode = this.code;
                this.submit();
                //setInterval(()=>{this.submit()}, 100);
            }
        },
        watch: {
            '$route.query': 'check'
        },
        beforeDestroy() {
            if(this.timeout) clearTimeout(this.timeout);
        }
    }
</script>