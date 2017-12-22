<template>
    <div class="col-md-8">
        <el-card>
            <div slot="header" class="clearfix">
                <span>新增管理员</span>
            </div>
            <el-form ref="form" :model="form" label-width="90px">
                <el-form-item label="用户名">
                    <el-input v-model="form.name" type="name"></el-input>
                </el-form-item>
                <el-form-item label="邮箱">
                    <el-input v-model="form.email" type="email"></el-input>
                </el-form-item>
                <el-form-item label="类型">
                    <el-radio-group v-model="form.type">
                        <el-radio :label="3">学生管理员</el-radio>
                        <el-radio :label="2">教师</el-radio>
                        <el-radio :label="1">管理员</el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item label="备注">
                    <el-input v-model="form.remark" type="remark"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="onSubmit">确认添加</el-button>
                </el-form-item>
            </el-form>
        </el-card>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                form: {
                    name: '',
                    email: '',
                    remark: '',
                    type: 3
                }
            }
        },
        methods: {
            onSubmit() {
                const f = this.form;
                axios.post('admin/addAdmin', f).then((response) => {
                    if(response.data.success) {
                        this.$message({
                            message: response.data.success,
                            type: 'success'
                        });
                    } else {
                        this.$message.error(response.data.failed);
                    }
                }).catch((error) => {
                    this.subing = false;
                    this.$message.error('添加失败');
                });
            }
        },
    }
</script>