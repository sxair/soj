<template>
    <div class="container">
        <div class="col-md-4">
            <div v-for="(i, index) in labels">
                <div class="label-header" v-if="i.id != 0">
                    <a href="javascript:void(0)" @click="setProblemLabel(index, -1)" class="label-item"
                       :class="[{'text-center': i.son === undefined}]">{{ i.name }}</a>
                </div>
                <ul class="label-group">
                    <li v-for="(s, sindex) in i.son">
                        <a href="javascript:void(0)" @click="setProblemLabel(index, sindex)"
                           class="label-item">{{ s.name }}</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-5">
            <h3 class="text-center">{{ id }}:{{ title }}</h3>
            <el-card>
                <h3>已拥有的标签：</h3>
                <ul class="label-group">
                    <li v-for="i in proLabels">
                        <a href="javascript:void(0)" @click="checkedProblemLabel(i)"
                           class="label-item">{{ labelMap[i] }}</a>
                    </li>
                </ul>
            </el-card>
            <el-card v-if="op == 1">
                <div class="text-center">
                    <h3>新增 {{ title }} 标签</h3>
                </div>
                <div>
                    <h3>新标签名： {{ labelName }}</h3>
                </div>
                <el-button type="primary" @click="addProblemLabel">确认添加</el-button>
            </el-card>
            <el-card class="text-center" v-else-if="op == 2">
                <div>
                    <h3>删除 {{ labelMap[checked] }} 标签</h3>
                </div>
                <el-button type="primary" @click="delProblemLabel">删除</el-button>
            </el-card>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            id: {
                type: String,
                default: '0'
            }
        },
        computed: {
            labelName() {
                if (this.checked) {
                    if (this.checkedSon != -1) {
                        return this.labels[this.checked].son[this.checkedSon].name;
                    }
                    return this.labels[this.checked].name;
                }
                return '';
            }
        },
        data() {
            return {
                labels: [],
                labelMap: [],
                checked: 0,
                checkedSon: -1,
                op: 1,
                title: '',
                proLabels: []
            }
        },
        mounted() {
            this.setLabels();
            this.getProblem();
        },
        methods: {
            setLabels() {
                axios.get('/api/label').then((response) => {
                    this.labels = JSON.parse(response.data.content);
                    this.buildLabelMap();
                });
            },
            buildLabelMap() {
                for(let i in this.labels) {
                    let t = this.labels[i];
                    this.labelMap[t.id] = t.name;
                    for(let j in t.son) {
                        let tt = this.labels[i].son[j];
                        this.labelMap[tt.id] = tt.name;
                    }
                }
            },
            getProblem() {
                const id = this.id;
                axios.get('/admin/getProblemLabel/' + id).then((response) => {
                    this.title = response.data.title;
                    if(response.data.labels != '')
                    this.proLabels = JSON.parse(response.data.labels);
                });
            },
            setProblemLabel(id, son) {
                this.op = 1;
                this.checked = id;
                this.checkedSon = son;
            },
            getCheckedId() {
                let id = 0;
                if (this.checked) {
                    if (this.checkedSon != -1) {
                        id = this.labels[this.checked].son[this.checkedSon].id;
                    } else id = this.labels[this.checked].id;
                }
                return id;
            },
            addProblemLabel() {
                if (this.labelName == '') {
                    this.$message.error('请选择标签');
                } else {
                    let t = {'id': this.id,'label': this.getCheckedId()};
                    axios.post('/admin/addProblemLabel', t).then((response) => {
                        if(response.data.failed) {
                            this.$message.error(response.data.failed);
                        } else this.$message.success('添加成功');
                        this.getProblem();
                    }).catch((error) => {
                        this.$message.error('添加失败');
                    });
                }
            },
            checkedProblemLabel(id) {
                this.op=2;
                this.checked = id;
            },
            delProblemLabel() {
                if (this.checked == 0) {
                    this.$message.error('请选择标签');
                } else {
                    let t = {'id': this.id,'label': this.checked};
                    axios.post('/admin/delProblemLabel', t).then((response) => {
                        if(response.data.failed) {
                            this.$message.error(response.data.failed);
                        } else this.$message.success('删除成功');
                        this.getProblem();
                    }).catch((error) => {
                        this.$message.error('删除失败');
                    });
                }
            }
        }
    }
</script>