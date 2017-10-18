webpackJsonp([1],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\"]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0&bustCache!./resources/assets/js/admin/problems.vue":
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

/* harmony default export */ __webpack_exports__["default"] = ({
    props: {
        'tl': {
            type: Number,
            default: function _default() {
                return 30;
            }
        },
        'search': {
            type: Boolean,
            default: function _default() {
                return false;
            }
        },
        'problems': {
            type: Object,
            default: function _default() {
                return null;
            }
        }
    },
    created: function created() {
        this.setProblems(this.$route.query.page);
    },

    methods: {
        setProblems: function setProblems(cp) {
            var _this = this;

            axios.get('/api/problems').then(function (response) {
                _this.problems = response.data;
            }).catch(function (error) {
                console.log(error);
            });
        },

        handleCurrentChange: function handleCurrentChange(cp) {
            this.$router.push({ query: { page: cp } });
            this.setProblems(cp);
        }
    }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-5571f9c7\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0&bustCache!./resources/assets/js/admin/problems.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c("table", { staticClass: "table table-hover table-center" }, [
        _c(
          "tbody",
          [
            _vm._m(0),
            _vm._v(" "),
            _vm._l(_vm.problems, function(problem) {
              return _c("tr", [
                _c("td", [_vm._v(_vm._s(problem.id))]),
                _vm._v(" "),
                _c("td", [_vm._v(_vm._s(problem.title))]),
                _vm._v(" "),
                _c("td", [_vm._v(_vm._s(problem.author))]),
                _vm._v(" "),
                _c("td", [_vm._v(_vm._s(problem.public ? "yes" : "no"))]),
                _vm._v(" "),
                _c("td", [
                  _c("a", { attrs: { href: "#" } }, [_vm._v("修改")]),
                  _vm._v(" "),
                  problem.show
                    ? _c("a", { attrs: { href: "#" } }, [_vm._v("添加到oj")])
                    : _c("a", { attrs: { href: "#" } }, [_vm._v("已添加")])
                ])
              ])
            })
          ],
          2
        )
      ]),
      _vm._v(" "),
      _c("el-pagination", {
        attrs: {
          layout: "prev, pager, next",
          total: _vm.tl,
          "current-page": parseInt(_vm.$route.query.page)
        },
        on: { "current-change": _vm.handleCurrentChange }
      })
    ],
    1
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c("th", { attrs: { width: "10%" } }, [_vm._v("id")]),
      _vm._v(" "),
      _c("th", { attrs: { width: "50%" } }, [_vm._v("title")]),
      _vm._v(" "),
      _c("th", [_vm._v("author")]),
      _vm._v(" "),
      _c("th", [_vm._v("public")]),
      _vm._v(" "),
      _c("th", [_vm._v("operation")])
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-5571f9c7", module.exports)
  }
}

/***/ }),

/***/ "./resources/assets/js/admin/problems.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\"]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0&bustCache!./resources/assets/js/admin/problems.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-5571f9c7\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0&bustCache!./resources/assets/js/admin/problems.vue")
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
Component.options.__file = "resources\\assets\\js\\admin\\problems.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {  return key !== "default" && key.substr(0, 2) !== "__"})) {  console.error("named exports are not supported in *.vue files.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-5571f9c7", Component.options)
  } else {
    hotAPI.reload("data-v-5571f9c7", Component.options)
' + '  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});