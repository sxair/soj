/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');
import problemsRouter from './problemsRouter'
import contestsRouter from './contestsRouter'
import VueRouter from 'vue-router'
Vue.use(VueRouter);

import 'element-ui/lib/theme-chalk/pagination.css'
import 'element-ui/lib/theme-chalk/button.css'
import 'element-ui/lib/theme-chalk/input.css'
import 'element-ui/lib/theme-chalk/form.css'
import 'element-ui/lib/theme-chalk/form-item.css'
import 'element-ui/lib/theme-chalk/select.css'
import 'element-ui/lib/theme-chalk/option.css'
import 'element-ui/lib/theme-chalk/card.css'
import 'element-ui/lib/theme-chalk/loading.css'
import 'element-ui/lib/theme-chalk/message.css'
import {
    Pagination,
    Button,
    Input,
    Form,
    FormItem,
    Select,
    Option,
    Card,
    Icon,
    Loading,
    Message,
} from 'element-ui'

Vue.use(Pagination);
Vue.use(Button);
Vue.use(Input);
Vue.use(Select);
Vue.use(Option);
Vue.use(Form);
Vue.use(FormItem);
Vue.use(Card);
Vue.use(Icon);
//Vue.use(Message); 不能加
Vue.use(Loading);
Vue.prototype.$loading = Loading.service;
Vue.prototype.$message = Message;

/****************global****************/
Vue.component('navbar', require('./components/navbar.vue'));
Vue.component('to-html', require('./components/toHtml.vue'));
Vue.component('codemirror', require('./components/codemirror.vue'));
// Vue.component('show-code', resolve => require(['./components/showCode.vue'], resolve));
Vue.component('problems-table', require('./components/problemsTable.vue'));
Vue.component('problems-model', require('./problems/problemsModel.vue'));

let routes = [{path: '/', component: {template: '<div>foo</div>'}}];
routes = routes.concat(problemsRouter);
routes = routes.concat(contestsRouter);
let router = new VueRouter({
    mode: 'history',
    routes: routes
});

Vue.prototype.user = window.user;
Vue.prototype.auth = function() {
    if(window.user.id == 0) {
        window.location.href='/login?to='+window.location.href;
    }
};
window.app = new Vue({
    router,
    data: window.VueData,
}).$mount('#app');