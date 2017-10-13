<template>
    <div>
        <el-pagination
                layout="prev, pager, next"
                :total="50"
                :current-page="cp"
                @current-change="handleCurrentChange"
        >
        </el-pagination>
        <el-table
                :data="problems"
                style="width: 100%">
            <el-table-column
                    prop="id"
                    label="id">
            </el-table-column>
            <el-table-column
                    prop="title"
                    label="title">
            </el-table-column>
            <el-table-column
                    prop="ac-sub"
                    label="Accepted/Submitted">
            </el-table-column>
        </el-table>
    </div>
</template>

<script>
    export default {
        props:{
            'problems' : {
                type:Array,
                default() {
                    return []
                }
            },
            'cp' : {
                default() {
                    return 1;
                }
            },
        },
        methods:{
            handleCurrentChange:function(cp){
                this.$emit("page-change",cp);
            },
        }
    }
</script>