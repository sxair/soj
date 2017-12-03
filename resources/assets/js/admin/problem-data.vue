<template>
    <el-card>
        <div class="container">
            <form action="">
                <div>
                    <input type="file" name="text[]">
                </div>
            </form>
            <button class="btn btn-default">新增测试样例</button>
        </div>
    </el-card>
</template>
<script>
    export default {
        props: {
            id: String
        },
        data() {
            return {
                cnt: 0
            }
        },
        methods: {
            
        }
    }
</script>
