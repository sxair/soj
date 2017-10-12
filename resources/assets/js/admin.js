require('./bootstrap');

window.Vue = require('vue');

import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'

Vue.use(ElementUI);

Vue.component('navbar', require('./admin/navbar.vue'));