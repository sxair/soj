webpackJsonp([2],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\"]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0&bustCache!./resources/assets/js/admin/add-problem.vue":
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

/* harmony default export */ __webpack_exports__["default"] = ({
    data: function data() {
        return {
            form: {
                title: '',
                time: '1000',
                memory: '32768',
                spj: '',
                content: ''
            }
        };
    },

    methods: {
        onSubmit: function onSubmit() {
            console.log('submit!');
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
      _c("el-card", { staticClass: "box-card" }, [
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
            _c(
              "el-form",
              {
                ref: "form",
                attrs: { model: _vm.form, "label-width": "150px" }
              },
              [
                _c(
                  "el-form-item",
                  { attrs: { label: "标题" } },
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
                  { attrs: { label: "时间/内存限制" } },
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
                    ),
                    _vm._v(" "),
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
                        _vm._v("\n                        <"),
                        _c(
                          "template",
                          { attrs: { slot: "append" }, slot: "append" },
                          [_vm._v("KB")]
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
                  { attrs: { label: "特殊判断" } },
                  [
                    _c(
                      "el-radio-group",
                      {
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
                        _c("el-radio", { attrs: { label: 1 } }, [_vm._v("开启")])
                      ],
                      1
                    )
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "el-form-item",
                  { attrs: { label: "题目描述" } },
                  [_c("editor")],
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
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\"]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0&bustCache!./resources/assets/js/admin/add-problem.vue")
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