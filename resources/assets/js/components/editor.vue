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
            hljs.initHighlighting();
            this.initialize();
        },
        methods: {
            initialize() {
                this.simplemde = new SimpleMDE({
                    element: this.$el.firstElementChild,
                    initialValue: this.value,
                    renderingConfig: {
                        singleLineBreaks: false,
                        codeSyntaxHighlighting: true,
                    },
                    autoDownloadFontAwesome: false,
                    toolbar: ["bold", "italic", "heading", "|",
                        "quote", "unordered-list", "ordered-list", "|",
                        "link", "image", "code", "|",
                        "preview", "side-by-side", "fullscreen", "guide"],
                    previewRender: (plainText) => {
                        let val = this.simplemde.markdown(plainText);
                        return val.replace(/<code>/g, '<code class="hljs">');
                    }
                });
            },
            getHtml() {
                let val = this.simplemde.markdown(this.simplemde.value());
                return val.replace(/<code>/g, '<code class="hljs">');
            },
            getMD() {
                return this.simplemde.value();
            }
        },
        watch: {
            value() {
                this.simplemde.value(this.value);
            }
        },
        destroyed() {
            this.simplemde = null;
        }
    };
</script>
<style>
    @import '~simplemde/dist/simplemde.min.css';
    @import "~font-awesome/css/font-awesome.min.css";
</style>