
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue'
import Vuetify from 'vuetify'
import Vuex from 'vuex'
import VueRouter from 'vue-router'
import store from './store';
import router from './routes'




import AppComponent         from './components/AppComponent'
import ControlComponent         from './components/ControlComponent'




Vue.use(Vuex)
Vue.use(VueRouter)


window.axios = require('axios');
axios.defaults.headers.common = {
    // 'X-CSRF-TOKEN': window.Laravel.csrfToken,
    'Content-Type': 'application/json',
    'X-Requested-With': 'XMLHttpRequest'
};
Vue.prototype.$http = window.axios




Vue.use(Vuetify, {
    theme: {

        primary: '#1976D2',
        secondary: '#424242',
        accent: '#82B1FF',
        error: '#FF5252',
        info: '#2196F3',
        success: '#4CAF50',
        warning: '#FFC107'
    }
});


Vue.component('app', require('./views/App.vue'));
Vue.component('control-component', ControlComponent);



const app = new Vue({
    el: '#App',
    render: h => h(AppComponent),
    store,
    router: router,
    
});