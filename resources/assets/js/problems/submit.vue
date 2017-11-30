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
                    <el-form-item label="Result">
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
                    <textarea v-model="code" style="min-height: 300px;width: 100%"></textarea>
                </div>
                <div style="text-align:right">
                    <button class="btn btn-primary" @click="onSubmit">提交</button>
                </div>
            </el-card>
        </div>
    </div>
</template>
<script>
    export default {
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
                    {value: 4, label: 'python3'}
                ],
                code: '',
                tmpCode: '',
            }
        },
        methods: {
            onSubmit() {
                if (this.code.length < 50) {
                    this.$message.error('代码过短~');
                    return;
                }
                if (this.tmpCode == this.code) {
                    this.$message.error('请勿重复提交');
                    return;
                }
                let t = {};
                t.problem_id = this.search.proId;
                t.lang = this.search.lang;
                t.code = this.tmpCode = this.code;
                axios.post('/submit', t).then((response) => {
                    console.log(response.data);
                    if (response.data.success === true) {
                        this.$message({
                            message: '提交成功',
                            duration: 1500,
                            type: 'success'
                        });
                        this.$router.push({path: '/status'});
                    } else this.$message.error(response.data.failed);
                }).catch((error) => {
                    if (error.response.data.errors.problem_id) {
                        this.$message.error('题目不存在');
                    } else {
                        this.$message.error('代码过长');
                    }
                });
            }
        },
    }
</script>