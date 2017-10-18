require('./bootstrap');

window.Vue = require('vue');

import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import VueRouter from 'vue-router'

Vue.use(ElementUI);
Vue.use(VueRouter);

Vue.component('nav-menu',require('./admin/nav-menu.vue'));

const editor = resolve => require(['./components/editor.vue'], resolve);
Vue.component('editor', editor);

const router = new VueRouter({
    routes: [
        { path: '/',component:  {template: '<div>welcome</div>'}},
        { path: '/problems',component: resolve => require(['./admin/problems.vue'],resolve)},
        { path: '/addproblem',component: resolve => require(['./admin/add-problem.vue'],resolve)},
    ]
});

const app = new Vue({
    router,
}).$mount('#app');


