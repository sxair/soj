/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router'

import 'element-ui/lib/theme-chalk/pagination.css'
import 'element-ui/lib/theme-chalk/button.css'
import 'element-ui/lib/theme-chalk/input.css'
import 'element-ui/lib/theme-chalk/form.css'
import 'element-ui/lib/theme-chalk/form-item.css'
import 'element-ui/lib/theme-chalk/select.css'
import 'element-ui/lib/theme-chalk/option.css'
import 'element-ui/lib/theme-chalk/card.css'
import 'element-ui/lib/theme-chalk/col.css'
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
    Col,
    Loading,
    Message,
} from 'element-ui'

Vue.use(VueRouter);
Vue.use(Pagination);
Vue.use(Button);
Vue.use(Input);
Vue.use(Select);
Vue.use(Option);
Vue.use(Form);
Vue.use(FormItem);
Vue.use(Card);
Vue.use(Col);
//Vue.use(Message); 不能加
Vue.use(Loading);
Vue.prototype.$loading = Loading.service;
Vue.prototype.$message = Message;

Vue.component('navbar', require('./components/navbar.vue'));
Vue.component('to-html', require('./components/toHtml.vue'));
Vue.component('problems-table', require('./components/problemsTable.vue'));
Vue.component('problems-model', require('./components/problemsModel.vue'));
Vue.component('status', require('./components/status.vue'));

const router = new VueRouter({
    mode: 'history',
});

if(typeof window.user ==="undefined") {
    window.user = {
        id: 0,
        name: '',
        control: 0
    }
    alert("?");
}
Vue.prototype.user = window.user;

window.app = new Vue({
    router
}).$mount('#app');

// import {
//     Pagination,
//     Dialog,
//     Autocomplete,
//     Dropdown,
//     DropdownMenu,
//     DropdownItem,
//     Menu,
//     Submenu,
//     MenuItem,
//     MenuItemGroup,
//     Input,
//     InputNumber,
//     Radio,
//     RadioGroup,
//     RadioButton,
//     Checkbox,
//     CheckboxButton,
//     CheckboxGroup,
//     Switch,
//     Select,
//     Option,
//     OptionGroup,
//     Button,
//     ButtonGroup,
//     Table,
//     TableColumn,
//     DatePicker,
//     TimeSelect,
//     TimePicker,
//     Popover,
//     Tooltip,
//     Breadcrumb,
//     BreadcrumbItem,
//     Form,
//     FormItem,
//     Tabs,
//     TabPane,
//     Tag,
//     Tree,
//     Alert,
//     Slider,
//     Icon,
//     Row,
//     Col,
//     Upload,
//     Progress,
//     Badge,
//     Card,
//     Rate,
//     Steps,
//     Step,
//     Carousel,
//     CarouselItem,
//     Collapse,
//     CollapseItem,
//     Cascader,
//     ColorPicker,
//     Transfer,
//     Container,
//     Header,
//     Aside,
//     Main,
//     Footer,
//     Loading,
//     MessageBox,
//     Message,
//     Notification
// } from 'element-ui