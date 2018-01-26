require('./bootstrap');
window.Vue = require('vue');
import VueRouter from 'vue-router'
import VueI18n from 'vue-i18n'
import I18nMessage from './i18n'
Vue.use(VueI18n);
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
    Alert,
    Radio,
    RadioGroup,
    RadioButton,
    Icon,
    Tag,
    Loading,
    Message,
    MessageBox,
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
Vue.use(Tag);
Vue.use(Alert);
//Vue.use(Message); 不能加
Vue.use(Loading);
Vue.prototype.$loading = Loading.service;
Vue.prototype.$message = Message;
Vue.prototype.$msgbox = MessageBox;
Vue.prototype.$alert = MessageBox.alert;
Vue.prototype.$notify = Notification;

Vue.component('codemirror', resolve => require(['./components/codemirror.vue'], resolve));
Vue.component('navbar', require('./components/navbar.vue'));
Vue.component('soj-footer', require('./components/footer.vue'));
Vue.component('admin-menu', require('./admin/admin-menu.vue'));
Vue.component('editor', resolve => require(['./components/editor.vue'], resolve));
Vue.component('to-html', require('./components/toHtml.vue'));

const router = new VueRouter({
    routes: [
        {path: '/', component: {template: '<div>welcome</div>'}},
        {path: '/addProblem', component: require('./admin/add-problem.vue')},
        {path: '/changeProblem/:id', component: require('./admin/add-problem.vue'), props:true},
        {path: '/changePassword', component: require('./admin/change-password.vue')},
        {path: '/label', component:require('./admin/label.vue')},
        {path: '/problems', component: require('./admin/problems.vue')},
        {path: '/ojProblems', component: require('./admin/oj-problems.vue')},
        {path: '/problemData/:id', component: require('./admin/problem-data.vue'), props: true},
        {path: '/problemOperation/:id', component: require('./admin/problem-operation.vue'), props: true},
        {path: '/changePassword', component: require('./admin/change-password.vue')},
        {path: '/showAdmins', component: require('./admin/show-admins.vue')},
        {path: '/addAdmin', component: require('./admin/add-admin.vue')},
        {path: '/useSpj/:id', component: require('./admin/use-spj.vue'), props: true},
        {path: '/setProblemLabel/:id', component: require('./admin/set-problem-label.vue'), props: true},
        {path: '/problem/:id', component: require('./components/showProblem.vue'), props: true},
        {path: '/submit/:id', component: require('./components/submit.vue'), props: true},
        {path: '/codeModel/:id', component: require('./admin/code-model.vue'), props: true},
    ]
});

Vue.prototype.user = window.user;
Vue.prototype.auth = function() {
    if(window.user.id == 0) {
        window.location.href='/login?to='+window.location.href;
    }
};
const i18n = new VueI18n(I18nMessage);
window.app = new Vue({
    router,
    i18n,
}).$mount('#app');