<template>
    <div style="margin: auto; width: 500px">
        <div v-for="(i, index) in test" v-if="i.used" style="border: 1px solid #e6ebf5;
            padding: 18px; box-shadow: 0 2px 12px 0 rgba(0,0,0,.1);margin-bottom: 13px">
            <i v-if="i.id != 1" class="el-icon-close pull-right" style="font-size: 18px;cursor:pointer" @click="delTest(index)"></i>
            <div style="padding-bottom: 13px">
                输入样例 {{ i.id }} : <input type="file" :id="'in' + i.id" style="display: inline-block">
            </div>
            输出样例 {{ i.id }} : <input type="file" :id="'out' + i.id" style="display: inline-block">
        </div>
        <el-button type="primary" @click="addTest">新增测试样例</el-button>
        <el-button v-if="!subing" @click="onSubmit">提交</el-button>
        <el-button v-else>提交中。。。</el-button>
    </div>
</template>
<script>
    export default {
        props: {
            id: String
        },
        data() {
            return {
                subing: false,
                cnt: 1,
                test: [{used: true, id: 1}]
            }
        },
        methods: {
            addTest() {
                this.test.push({used: true, id: ++this.cnt});
            },
            delTest(id) {
                this.test[id].used = false;
                for(let i = id + 1; i < this.test.length; i++) {
                    this.test[i].id --;
                }
                this.cnt --;
            },
            onSubmit() {
                if (!confirm("确定上传并覆盖测试数据？")) return;
                this.subing = true;
                let fd = new FormData();
                fd.append('id', this.id);
                for (let i in this.test) {
                    if (this.test[i].used) {
                        fd.append('input_file[]', this.$el.querySelector('#in' + this.test[i].id).files[0]);
                        fd.append('output_file[]', this.$el.querySelector('#out' + this.test[i].id).files[0]);
                    }
                }
                axios.post('admin/setProblemData', fd, {headers: {'Content-Type': 'multipart/form-data'}}).then((response) => {
                    this.subing = false;
                    console.log(response.data);
                    if(response.data.success) {
                        this.$message({
                            message: response.data.success,
                            duration: 5000,
                            type: 'success'
                        });
                    } else {
                        this.$message.error(response.data.failed);
                    }
                }).catch((error) => {
                    this.subing = false;
                    this.$message({
                        message: '提交失败，请重新提交',
                        duration: 3000,
                        type: 'error'
                    });
                });
            }
        }
    }
</script>
