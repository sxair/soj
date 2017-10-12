
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import {
    Table,
    TableColumn,
    Card,
} from 'element-ui'

Vue.use(Table);
Vue.use(TableColumn);
Vue.use(Card);

Vue.component('Problems', require('./components/Problems.vue'));