<template>
    <div style="width: 500px;margin:auto">
        <show-code :code="code" :status="status"></show-code>
    </div>
</template>
<script>
    export default {
        props: {
            id: String
        },
        data() {
            return {
                code: '',
                status: {}
            }
        },
        mounted() {
            this.auth();
            const s = this;
            axios.get('/code/' + s.id).then((response) => {
                this.code = response.data.code;
                this.status = response.data.status
            });
        }
    }
</script>