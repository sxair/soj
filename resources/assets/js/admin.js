require('./bootstrap');

import 'element-ui/lib/theme-chalk/index.css'
import ElementUI from 'element-ui'
import VueRouter from 'vue-router'

window.Vue = require('vue');
Vue.use(ElementUI);
Vue.use(VueRouter);

Vue.component('admin-menu',require('./admin/admin-menu.vue'));
Vue.component('editor', resolve => require(['./components/editor.vue'], resolve));

const router = new VueRouter({
    routes: [
        { path: '/',component:  {template: '<div>welcome</div>'}},
        { path: '/problems',component: resolve => require(['./admin/problems.vue'], resolve)},
        { path: '/addProblem',component: resolve => require(['./admin/add-problem.vue'],resolve)},
    ]
});

const app = new Vue({
    router,
}).$mount('#app');


