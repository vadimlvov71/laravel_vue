/*
* First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');
window.axios = require("axios")
import Vue from 'vue/dist/vue'
window.Vue = require('vue');
import App from './components/App.vue';
import VueAxios from 'vue-axios';
import VueRouter from 'vue-router';
import axios from 'axios';
import { routes } from './components/routes';
import pagination from 'laravel-vue-pagination';
import FlashMessage from '@smartweb/vue-flash-message';
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
import Vuelidate from 'vuelidate'
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
var config = {
    time: 10000,
    icon: true,
	position: 'bottom left',
}
Vue.use(FlashMessage, config);
Vue.use(VueRouter);
Vue.use(VueAxios, axios);
Vue.use(Vuelidate)

Vue.component('example-component', require('./components/AllPosts.vue'));
//Pagination laravel-vue-pagination
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('v-select', vSelect)

window.Laravel = {
  "csrfToken": "foo",
  "baseUrl": "http:\/\/localhost\/laravel8\/new3\/"
}
 
const router = new VueRouter({
	base: '/laravel8/new3/',
    mode: 'history',
    routes: routes
});
 //console.log(router);
const app = new Vue({
    el: '#app',
    baseUrl: Laravel.baseUrl,
    router: router,
    render: h => h(App),
});
