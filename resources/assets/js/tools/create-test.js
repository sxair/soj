function run() {
    console.log("?");
    app.code = app.$refs.editor.getValue();
    app.test = eval(app.code);
}
