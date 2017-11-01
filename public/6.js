webpackJsonp([6],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}],[\"es2015\",{\"modules\":false}]],\"plugins\":[\"transform-object-rest-spread\",[\"component\",[{\"libraryName\":\"element-ui\",\"styleLibraryName\":\"theme-chalk\"}]]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0&bustCache!./resources/assets/js/admin/add-problem.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    data: function data() {
        return {
            form: {
                title: '',
                time: '1000',
                memory: '32768',
                spj: 0,
                judge: '',
                content: '',
                source: '',
                author: ''
            },
            rules: {
                title: [{ required: true, message: '请输入标题', trigger: 'blur' }],
                time: [{ required: true, message: '自己看着办把', trigger: 'blur' }],
                memory: [{ required: true, message: '自己看着办把', trigger: 'blur' }]
            },
            content: '### Problem Description\n\n### Input\n\n### Output\n\n' + '### Sample Input\n\n### Sample Output\n\n### Hints\n',
            useSpj: false
        };
    },
    mounted: function mounted() {
        this.$notify({
            title: '提示',
            dangerouslyUseHTMLString: true,
            message: '<a href="#" target="view_window">点击查看添加题目帮助</a>',
            duration: 5600,
            type: 'warning'
        });
    },


    methods: {
        onSubmit: function onSubmit() {
            var _this = this;

            this.$refs['form'].validate(function (valid) {
                if (!valid) {
                    _this.$message.error('表单填写错误，请检查');
                    return false;
                }
                _this.form.content = _this.$refs.contentEditor.simplemde.value();
                _this.form.content = _this.$refs.contentEditor.simplemde.markdown(_this.form.content);
                if (!_this.form.content) {
                    _this.$message.error('你想干嘛');
                    return false;
                }
                var t = _this.form; //axios内部获取不到this
                axios.post('/admin/addProblem', {
                    data: t
                }).then(function (response) {
                    console.log(response.data);
                    if (response.data === true) {
                        _this.$message({
                            message: '提交成功',
                            duration: 1500,
                            type: 'success'
                        });
                    } else {
                        _this.$message({
                            message: '我也不知为什么失败了。。',
                            duration: 1500,
                            type: 'success'
                        });
                    }
                }).catch(function (error) {
                    console.log(error.response.data);
                    if (error.response.status === 422) {
                        _this.$message.error('表单填写错误，请联系管理员');
                        console.log(error.response.data.errors);
                    } else {
                        _this.$message({
                            showClose: true,
                            message: '提交失败' + error,
                            type: 'error',
                            duration: 0
                        });
                    }
                });
            });
        },
        onChange: function onChange(val) {
            if (val === 3) {
                this.useSpj = true;
            } else this.useSpj = false;
        }
    }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-d5a0eda0\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0&bustCache!./resources/assets/js/admin/add-problem.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticStyle: { "padding-top": "10px" } },
    [
      _c("el-card", [
        _c(
          "div",
          {
            staticClass: "clearfix text-center",
            attrs: { slot: "header" },
            slot: "header"
          },
          [
            _c(
              "span",
              { staticStyle: { "font-size": "16px", color: "#000" } },
              [_vm._v("新增题目")]
            )
          ]
        ),
        _vm._v(" "),
        _c(
          "div",
          [
            _c("div", { attrs: { id: "showError" } }),
            _vm._v(" "),
            _c(
              "el-form",
              {
                ref: "form",
                attrs: {
                  model: _vm.form,
                  rules: _vm.rules,
                  "label-width": "150px"
                }
              },
              [
                _c(
                  "el-form-item",
                  { attrs: { label: "标题", prop: "title" } },
                  [
                    _c("el-input", {
                      staticStyle: { width: "60%" },
                      attrs: { maxlength: 30 },
                      model: {
                        value: _vm.form.title,
                        callback: function($$v) {
                          _vm.$set(_vm.form, "title", $$v)
                        },
                        expression: "form.title"
                      }
                    })
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "el-form-item",
                  { attrs: { label: "时间限制", prop: "time" } },
                  [
                    _c(
                      "el-input",
                      {
                        staticStyle: { width: "30%" },
                        attrs: { maxlength: 5 },
                        model: {
                          value: _vm.form.time,
                          callback: function($$v) {
                            _vm.$set(_vm.form, "time", $$v)
                          },
                          expression: "form.time"
                        }
                      },
                      [
                        _c(
                          "template",
                          { attrs: { slot: "append" }, slot: "append" },
                          [_vm._v("MS")]
                        )
                      ],
                      2
                    )
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "el-form-item",
                  { attrs: { label: "内存限制", prop: "memory" } },
                  [
                    _c(
                      "el-input",
                      {
                        staticStyle: { width: "30%" },
                        attrs: { maxlength: 6 },
                        model: {
                          value: _vm.form.memory,
                          callback: function($$v) {
                            _vm.$set(_vm.form, "memory", $$v)
                          },
                          expression: "form.memory"
                        }
                      },
                      [
                        _c(
                          "template",
                          { attrs: { slot: "append" }, slot: "append" },
                          [_vm._v("KB")]
                        )
                      ],
                      2
                    ),
                    _vm._v(" "),
                    _c("i", [_vm._v("推荐最大不超过524288KB（512MB）")])
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "el-form-item",
                  { attrs: { label: "特殊判断" } },
                  [
                    _c(
                      "el-radio-group",
                      {
                        on: { change: _vm.onChange },
                        model: {
                          value: _vm.form.spj,
                          callback: function($$v) {
                            _vm.$set(_vm.form, "spj", $$v)
                          },
                          expression: "form.spj"
                        }
                      },
                      [
                        _c("el-radio", { attrs: { label: 0 } }, [_vm._v("关闭")]),
                        _vm._v(" "),
                        _c("el-radio", { attrs: { label: 1 } }, [
                          _vm._v("精度3位")
                        ]),
                        _vm._v(" "),
                        _c("el-radio", { attrs: { label: 2 } }, [
                          _vm._v("精度6位")
                        ]),
                        _vm._v(" "),
                        _c("el-radio", { attrs: { label: 3 } }, [_vm._v("自定义")])
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _vm.useSpj
                      ? _c("el-input", {
                          staticStyle: { width: "60%" },
                          attrs: {
                            type: "textarea",
                            autosize: { minRows: 5, maxRows: 10 },
                            placeholder: "请输入判断代码"
                          },
                          model: {
                            value: _vm.form.judge,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "judge", $$v)
                            },
                            expression: "form.judge"
                          }
                        })
                      : _vm._e()
                  ],
                  1
                ),
                _vm._v(" "),
                _c("editor", {
                  ref: "contentEditor",
                  staticStyle: { width: "80%", margin: "auto" },
                  attrs: { value: _vm.content }
                }),
                _vm._v(" "),
                _c(
                  "el-form-item",
                  { attrs: { label: "来源" } },
                  [
                    _c("el-input", {
                      staticStyle: { width: "60%" },
                      attrs: { maxlength: 50 },
                      model: {
                        value: _vm.form.source,
                        callback: function($$v) {
                          _vm.$set(_vm.form, "source", $$v)
                        },
                        expression: "form.source"
                      }
                    })
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "el-form-item",
                  { attrs: { label: "作者" } },
                  [
                    _c("el-input", {
                      staticStyle: { width: "60%" },
                      attrs: { maxlength: 50 },
                      model: {
                        value: _vm.form.author,
                        callback: function($$v) {
                          _vm.$set(_vm.form, "author", $$v)
                        },
                        expression: "form.author"
                      }
                    })
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "el-form-item",
                  [
                    _c(
                      "el-button",
                      {
                        attrs: { type: "primary" },
                        on: { click: _vm.onSubmit }
                      },
                      [_vm._v("提交")]
                    )
                  ],
                  1
                )
              ],
              1
            )
          ],
          1
        )
      ])
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-d5a0eda0", module.exports)
  }
}

/***/ }),

/***/ "./resources/assets/js/admin/add-problem.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}],[\"es2015\",{\"modules\":false}]],\"plugins\":[\"transform-object-rest-spread\",[\"component\",[{\"libraryName\":\"element-ui\",\"styleLibraryName\":\"theme-chalk\"}]]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0&bustCache!./resources/assets/js/admin/add-problem.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-d5a0eda0\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0&bustCache!./resources/assets/js/admin/add-problem.vue")
/* template functional */
  var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources\\assets\\js\\admin\\add-problem.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {  return key !== "default" && key.substr(0, 2) !== "__"})) {  console.error("named exports are not supported in *.vue files.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-d5a0eda0", Component.options)
  } else {
    hotAPI.reload("data-v-d5a0eda0", Component.options)
' + '  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});