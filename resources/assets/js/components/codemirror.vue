<template>
    <textarea></textarea>
</template>
<script>
    window.CodeMirror = require('codemirror');
    require('codemirror/lib/codemirror.css');
    //require('codemirror/theme/monokai.css');
    require('codemirror/mode/clike/clike');
    /**
     * 括号匹配
     */
    require('codemirror/addon/edit/matchbrackets');
    export default {
        props: {
            value: {
                type: [String, Number],
                default: ''
            },
            lang: {
                type: Number,
                default: 2
            },
            readOnly: {
                type: Boolean,
                default: false
            }
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
                readOnly: this.readOnly,
                matchBrackets: true,
                indentUnit: 4,
                lineWrapping: true,
                theme: "monokai"
            });
            this.setLang();
            this.editor.setValue(this.value);
        },
        methods: {
            getValue() {
                return this.editor.getValue();
            },
            setLang() {
                //http://codemirror.net/mode/index.html
                //text/x-csrc (C), text/x-c++src (C++), text/x-java text/x-python
                if (this.lang < 3) {
                    this.editor.setOption('mode', 'text/x-c++src');
                } else if (this.lang === 3) {
                    this.editor.setOption('mode', 'text/x-java');
                } else if (this.lang === 4) {
                    require('codemirror/mode/python/python');
                    this.editor.setOption('mode', 'text/x-python');
                } else if (this.lang === 10) {
                    require('codemirror/mode/javascript/javascript');
                    /**
                     * 代码提示
                     */
                    require('codemirror/addon/hint/show-hint.css');
                    require('codemirror/addon/hint/show-hint');
                    require('codemirror/addon/hint/javascript-hint');
                    this.editor.setOption('extraKeys', {"Ctrl":"autocomplete"});
                    this.editor.setOption('mode', 'text/javascript');
                }
            }
        },
        watch: {
            lang() {
                this.setLang();
            },
            value() {
                this.editor.setValue(this.value);
            }
        }
    }
</script>
<style>
    .CodeMirror {
        border: 1px solid #eee;
        height: auto;
        min-height: 300px;
    }
    .CodeMirror-scroll {
        /* Set scrolling behaviour here */
        overflow: auto;
        min-height: 300px;
    }
</style>
