<template>
    <div class="container">
        <div class="col-md-4">
            <div v-for="(i, index) in labels">
                <div class="label-header">
                    <a href="javascript:void(0)" @click="changLabel(index, -1)" class="label-item"
                       :class="[{'label-active': i.id < 0}, {'text-center': i.son === undefined}]">{{ i.name }}</a>
                </div>
                <ul class="label-group">
                    <li v-for="(s, sindex) in i.son">
                        <a href="javascript:void(0)" @click="changLabel(index, sindex)" class="label-item"
                           :class="{'label-active': s.id < 0}">{{ s.name }}</a>
                    </li>
                    <li v-if="i.id != 0">
                        <a href="javascript:void(0)" @click="addLabel(index)"><i
                                class="el-icon-circle-plus-outline"></i></a>
                    </li>
                </ul>
            </div>
            <a class="btn btn-default col-md-12" href="javascript:void(0)" @click="addLabel(0)"><i
                    class="el-icon-circle-plus-outline"></i></a>
        </div>
        <div class="col-md-5">
            <div v-if="op == 1">
                <el-form ref="form" :model="form" label-width="90px">
                    <div class="text-center">
                        <h3 v-if="name != ''">给 {{ name }} 添加子标签</h3>
                        <h3 v-else>添加新标签</h3>
                    </div>
                    <el-form-item label="标签名">
                        <el-input v-model="form.name"></el-input>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" @click="onAdd">确认添加</el-button>
                    </el-form-item>
                </el-form>
            </div>
            <div v-else-if="op == 2">
                <el-form ref="form" :model="form" label-width="90px">
                    <div class="text-center">
                        <h3>修改 {{ name }} 标签</h3>
                    </div>
                    <el-form-item label="标签名">
                        <el-input v-model="form.name"></el-input>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" @click="onChange">确认修改</el-button>
                    </el-form-item>
                </el-form>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                labels: [],
                op: 0,
                name: '',
                idx: 0,
                son: 0,
                form: {
                    name: ''
                }
            }
        },
        mounted() {
            this.setLabels();
        },
        methods: {
            setLabels() {
                axios.get('/api/label').then((response) => {
                    this.labels = JSON.parse(response.data.content);
                });
            },
            onSubmit() {
                if (confirm("确认更改标签？")) {
                    axios.post('/admin/cgLabel', val).then((response) => {
                        this.$message.success('更改成功');
                    }).catch((error) => {
                        this.$message.error('更改失败');
                    });
                }
            },
            onAdd() {
                if (confirm("确认新增标签？")) {
                    let val = {'index': this.idx, 'name': this.form.name};
                    axios.post('/admin/addLabel', val).then((response) => {
                        this.$message.success('添加成功');
                        this.setLabels();
                    }).catch((error) => {
                        this.$message.error('添加失败');
                    });
                }
            },
            onChange() {
                if (confirm("确认修改标签？")) {
                    let val = {'index': this.idx, 'son': this.son, 'name': this.form.name};
                    axios.post('/admin/changeLabel', val).then((response) => {
                        this.$message.success('修改成功');
                        this.setLabels();
                    }).catch((error) => {
                        this.$message.error('修改失败');
                    });
                }
            },
            changLabel(idx, son) {
                this.op = 2;
                this.idx = idx;
                this.son = son;
                if(son != -1)
                    this.name = this.labels[idx].son[son].name;
                else this.name = this.labels[idx].name;
            },
            addLabel(idx) {
                this.op = 1;
                this.idx = idx;
                if (idx)
                    this.name = this.labels[idx].name;
                else this.name = '';
            }
        }
    }
</script>
