require('./bootstrap');

window.Vue = require('vue');

import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import VueRouter from 'vue-router'

import Problems from './components/problems.vue'

Vue.use(ElementUI);
Vue.use(VueRouter);

Vue.component('nav-menu',require('./admin/nav-menu.vue'));

const router = new VueRouter({
    routes: [
        { path: '/',component:  {template: '<div>welcome</div>'}},
        { path: '/problems',component: Problems},
    ]
});

const app = new Vue({
    router,
}).$mount('#app');
