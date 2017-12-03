require('./bootstrap');
window.Vue = require('vue');
import VueRouter from 'vue-router'
Vue.use(VueRouter);

import 'element-ui/lib/theme-chalk/index.css'
import {
    Pagination,
    Button,
    Input,
    Form,
    FormItem,
    Select,
    Option,
    Menu,
    Submenu,
    MenuItem,
    MenuItemGroup,
    Card,
    Col,
    Radio,
    RadioGroup,
    RadioButton,
    Icon,
    Loading,
    Message,
    Notification,
} from 'element-ui'

Vue.use(Pagination);
Vue.use(Button);
Vue.use(Input);
Vue.use(Select);
Vue.use(Option);
Vue.use(Radio);
Vue.use(RadioGroup);
Vue.use(RadioButton);
Vue.use(Form);
Vue.use(FormItem);
Vue.use(Menu);
Vue.use(Submenu);
Vue.use(MenuItem);
Vue.use(MenuItemGroup);
Vue.use(Col);
Vue.use(Card);
Vue.use(Icon);
//Vue.use(Message); 不能加
Vue.use(Loading);
Vue.prototype.$loading = Loading.service;
Vue.prototype.$message = Message;
Vue.prototype.$notify = Notification;

Vue.component('navbar', require('./components/navbar.vue'));
Vue.component('admin-menu', require('./admin/admin-menu.vue'));
Vue.component('editor', resolve => require(['./components/editor.vue'], resolve));

const router = new VueRouter({
    routes: [
        {path: '/', component: {template: '<div>welcome</div>'}},
        {path: '/problems', component: require('./admin/problems.vue')},
        {path: '/addProblem', component: require('./admin/add-problem.vue')},
        {path: '/label', component: resolve => require(['./admin/label.vue'], resolve)},
        {path: '/problemData/:id', component: (resolve) => require(['./admin/problem-data.vue'], resolve)},
    ]
});

Vue.prototype.user = window.user;
window.app = new Vue({
    router,
}).$mount('#app');