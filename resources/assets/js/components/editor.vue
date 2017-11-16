<template>
    <div class="markdown-editor">
        <textarea></textarea>
    </div>
</template>

<script>
    import SimpleMDE from 'simplemde';
    import hljs from 'highlight.js';
    window.hljs = hljs;

    export default {
        props: {
            value: {
                type: String,
                default: ''
            },
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
                this.simplemde = new SimpleMDE({
                    element: this.$el.firstElementChild,
                    initialValue: this.value,
                    renderingConfig: {
                       // codeSyntaxHighlighting:true
                    },
                    autoDownloadFontAwesome: false,
                    toolbar: ["bold", "italic", "heading", "|",
                        "quote", "unordered-list", "ordered-list", "|",
                        "link", "image", "code", "|",
                        "preview", "side-by-side", "fullscreen", "guide"],
//                    previewRender: (plainText) => {
//
//                        return this.simplemde.markdown(plainText);
//                    }
                });
            },
            getValue() {
                return this.simplemde.markdown(this.simplemde.value());
            }
        },
        destroyed() {
            this.simplemde = null;
        },
        watch: {
            // 接收props
            value(val) {
                if (val === this.simplemde.value()) return;
                this.simplemde.value(val);
            },
        },
    };
</script>
<style>
    @import '~simplemde/dist/simplemde.min.css';
    @import "~font-awesome/css/font-awesome.min.css";
    @import '~highlight.js/styles/github-gist.css';
</style>