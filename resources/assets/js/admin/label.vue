<template>
<pre id="code" class="ace_editor" style="min-height:400px">
    <textarea class="ace_text-input"></textarea>
</pre>
</template>
<script>
    export default {
        mounted() {
            editor = ace.edit("code");
            editor.session.setMode("ace/mode/json");
        }
    }
</script>
