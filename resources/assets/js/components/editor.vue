<template>
    <div class="markdown-editor">
        <textarea></textarea>
    </div>
</template>

<script>
    import SimpleMDE from 'simplemde';
    export default {
        props: {
            value: String,
        },
        mounted() {
            this.initialize();
        },
        activated() {
            const editor = this.simplemde;
            if (!editor) return;
            const isActive = editor.isSideBySideActive() || editor.isPreviewActive();
            if (isActive) editor.toggleFullScreen();
        },
        methods: {
            initialize() {
                const configs = {
                    element: this.$el.firstElementChild,
                    initialValue: this.value,
                    renderingConfig: {},
                };
                this.simplemde = new SimpleMDE(configs);
            },
        },
        destroyed() {
            this.simplemde = null;
        },
        watch: {
            value(val) {
                if (val === this.simplemde.value()) return;
                this.simplemde.value(val);
            },
        },
    };
</script>
<style>
    @import '~simplemde/dist/simplemde.min.css';
</style>