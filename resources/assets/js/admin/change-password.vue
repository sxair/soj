<template>
    <div class="col-md-8">
        <el-card>
            <div slot="header" class="clearfix">
                <span>更改密码</span>
            </div>
            <el-form ref="form" :model="form" label-width="90px">
                <el-form-item label="旧密码">
                    <el-input v-model="form.old_password" type="password"></el-input>
                </el-form-item>
                <el-form-item label="新密码">
                    <el-input v-model="form.password" type="password"></el-input>
                </el-form-item>
                <el-form-item label="重复新密码">
                    <el-input v-model="form.password_confirmation" type="password"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="onSubmit">更改</el-button>
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
                    password: '',
                    password_confirmation: ''
                }
            }
        },
        methods: {
            onSubmit() {
                const f = this.form;
                axios.post('admin/changePassword', f).then((response) => {
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
                    this.$message.error('更改失败');
                });
            }
        },
    }
</script>