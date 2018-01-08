<template>
    <div style="width: 500px;margin: auto">
        <h3>问题 {{ id }}，您有以下选择:</h3>
        <div style="margin: 18px">
            <ul class="list-unstyled">
                <li>
                    <router-link :to="'/changeProblem/' + id">修改题目内容</router-link>
                </li>
                <li>
                    <router-link :to="'/problemData/' + id">修改测试数据</router-link>
                </li>
                <li>
                    <router-link :to="'/useSpj/' + id">使用特殊判断</router-link>
                </li>
                <li>
                    <router-link :to="'/setProblemLabel/' + id">添加标签</router-link>
                </li>
                <li>
                    <a :href="'/admin/download/test/' + id">下载测试数据</a>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            id: String
        },

    }
</script>
<style>
    .list-unstyled li {
        padding-bottom: 8px;
    }
</style>