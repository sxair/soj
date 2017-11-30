<template>
    <div style="overflow:auto">
        <table class="table table-hover table-center table-striped" v-loading="loading"
               element-loading-text="加载中╮(╯▽╰)╭"
               :class="problems.length > 13 ? 's-loading':''">
            <thead>
            <tr>
                <th width="10%">id</th>
                <th v-if="search" width="40%">title</th>
                <th width="70%" v-else>title</th>
                <th v-if="search">author</th>
                <th v-if="search">source</th>
                <th>Ac/Sub</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="pro in problems">
                <td>{{ pro.id }}</td>
                <td><router-link :to="proUrl + '/' + pro.id">{{ pro.title }}</router-link></td>
                <td v-if="search">{{ pro.author }}</td>
                <td v-if="search">{{ pro.source }}</td>
                <td>{{ pro.submitted ? (parseFloat(pro.accepted) / pro.submitted * 100).toFixed(2) + '%' : '0.00%' }}
                    ({{ pro.accepted }}/{{ pro.submitted }})
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: {
            'problems': {
                type: Array,
                default: []
            },
            'search': {
                type: Boolean,
                default: false
            },
            'loading': {
                type: Boolean,
                default: true,
            },
            'proUrl': String,
        },
    }
</script>
<style>
    .s-loading .el-loading-spinner {
        top: 180px;
    }
</style>