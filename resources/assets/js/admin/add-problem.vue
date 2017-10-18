<template>
    <div style="padding-top: 10px">
        <el-card class="box-card">
            <div slot="header" class="clearfix text-center">
                <span style="font-size: 16px;color: #000">新增题目</span>
            </div>
            <div>
                <el-form ref="form" :model="form" label-width="150px">
                    <el-form-item label="标题">
                        <el-input v-model="form.title" style="width: 60%" :maxlength="30"></el-input>
                    </el-form-item>
                    <el-form-item label="时间/内存限制">
                        <el-input v-model="form.time" style="width: 30%" :maxlength="5">
                            <template slot="append">MS</template>
                        </el-input>
                        <el-input v-model="form.memory" style="width: 30%" :maxlength="6">
                            <<template slot="append">KB</template>
                        </el-input>
                    </el-form-item>
                    <el-form-item label="特殊判断">
                        <el-radio-group v-model="form.spj">
                            <el-radio :label="0">关闭</el-radio>
                            <el-radio :label="1">开启</el-radio>
                        </el-radio-group>
                    </el-form-item>
                    <el-form-item label="题目描述">
                        <editor></editor>
                    </el-form-item>
                </el-form>
            </div>
        </el-card>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form: {
                    title: '',
                    time: '1000',
                    memory: '32768',
                    spj: '',
                    content: ''
                }
            }
        },
        methods: {
            onSubmit() {
                console.log('submit!');
            }
        }
    }
</script>