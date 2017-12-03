<template>
    <textarea></textarea>
</template>
<script>
    window.CodeMirror = require('codemirror');
    require('codemirror/lib/codemirror.css');
    require('codemirror/theme/monokai.css');
    require('codemirror/mode/clike/clike');
    export default {
        props: {
            code: String,
            status: Object
        },
        data() {
            return {
                editor: {}
            }
        },
        mounted() {
            this.editor = CodeMirror.fromTextArea(this.$el, {
                mode: "text/x-c++src",
                lineNumbers: true,
                readOnly: true,
                theme: "monokai",
            });
        },
        watch: {
            code() {
                //http://codemirror.net/mode/index.html
                //text/x-csrc (C), text/x-c++src (C++), text/x-java text/x-python
                if(this.status.lang < 3) {
                    this.editor.setOption('mode', 'text/x-c++src');
                } else if(this.status.lang == 3) {
                    this.editor.setOption('mode', 'text/x-java');
                } else {
                    require('codemirror/mode/python/python');
                    this.editor.setOption('mode', 'text/x-python');
                }
                this.editor.setValue(this.code);
            }
        }
    }
</script>