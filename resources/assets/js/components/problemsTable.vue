<template>
    <div style="overflow:auto">
        <table class="table table-hover table-center table-striped" v-loading="loading"
               element-loading-text="加载中╮(╯▽╰)╭"
               :class="problems.length > 13 ? 's-loading':''">
            <thead>
            <tr>
                <th width="10%">id</th>
                <th v-if="search" :href="proUrl">title</th>
                <th width="70%" v-else :href="proUrl">title</th>
                <th v-if="search">author</th>
                <th v-if="search">source</th>
                <th>Ac/Sub</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="problem in problems">
                <td>{{ problem.id }}</td>
                <td><a :href="prourl(problem.id)">{{ problem.title }}</a></td>
                <td v-if="search">{{ problem.author }}</td>
                <td v-if="search">{{ problem.source }}</td>
                <td>{{ problem.submitted ? (parseFloat(problem.accepted) / problem.submitted * 100).toFixed(2) + '%' : '0.00%' }}
                    ({{ problem.accepted }}/{{ problem.submitted }})
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
            'proUrl': {
                typt: String,
                default: '#'
            }
        },
        methods: {
            prourl(id) {
                return this.proUrl + id;
            }
        }
    }
</script>
<style>
    .s-loading .el-loading-spinner {
        top: 180px;
    }
</style>