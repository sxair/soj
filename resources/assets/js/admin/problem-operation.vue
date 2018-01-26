<template>
    <div style="width: 500px;margin: auto">
        <h3>题目 {{ id }}，您有以下选择:</h3>
        <div style="margin: 18px">
            <ul class="list-unstyled">
                <li>
                    <router-link :to="'/changeProblem/' + id">修改题目内容</router-link>
                </li>
                <li>
                    <router-link :to="'/problemData/' + id">修改测试数据</router-link>
                </li>
                <li>
                    <router-link :to="'/useSpj/' + id">修改答案判断方式</router-link>
                </li>
                <li>
                    <router-link :to="'/codeModel/' + id">程序填空</router-link>
                </li>
                <li>
                    <router-link :to="'/setProblemLabel/' + id">修改标签</router-link>
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