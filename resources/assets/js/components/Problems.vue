<template>
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
</template>

<script>
    export default {
        props:{
            'problems' : {
                type:Array,
                default() {
                    return []
                }
            }
        },
    }
</script>