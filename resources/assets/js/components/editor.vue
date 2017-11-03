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
            value: String,
        },
        mounted() {
            hljs.initHighlightingOnLoad();
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
                    renderingConfig: {
                        codeSyntaxHighlighting:true
                    },
                    autoDownloadFontAwesome: false,
                    toolbar: ["bold", "italic", "heading", "|",
                        "quote", "unordered-list", "ordered-list", "|",
                        "link", "image", "code", "|",
                        "preview", "side-by-side", "fullscreen", "guide"],
                };
                this.simplemde = new SimpleMDE(configs);

                this.simplemde.codemirror.on('change', () => {
                    this.$emit('input', this.simplemde.value());
                });
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
    @import '~github-markdown-css';
    @import "~font-awesome/css/font-awesome.min.css";
    @import '~highlight.js/styles/github-gist.css';
</style>