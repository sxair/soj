<template>
    <div>

    </div>
</template>
<script>
    export default {
        props: {
            id: Number
        },
        data() {
            return {}
        },
        mounted() {
            const s = this;
            axios.get('code/' + s.id).then((response) => {
                this.loading = false;
                this.status = response.data.content;
                this.total = parseInt(response.data.total);
            });
        }
    }
</script>