
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

import AppComponent             from './components/AppComponent'
// import ControlComponent      from './components/ControlComponent'
// import PointsComponent       from './components/PointsComponent'
// import ReservationComponent  from './components/ReservationComponent'
import MyReservationsComponent  from './components/MyReservationsComponent'
import UploadAvatar             from './components/UploadAvatarComponent'
import UploadEquipmentImage     from './components/UploadEquipmentImage'
import NewEquipment             from './components/NewEquipment'





Vue.use(Vuex);
Vue.use(VueRouter);


window.axios = require('axios');

window._ = require('lodash')
window.Popper = require('popper.js').default
// Pusher
window.Pusher = require('pusher-js')


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
// Vue.component('control-component', ControlComponent);
// Vue.component('points-component', PointsComponent);
// Vue.component('reservation-component', ReservationComponent);
Vue.component('my-reservations', MyReservationsComponent);
Vue.component('upload-avatar', UploadAvatar);
Vue.component('upload-equipment-image', UploadEquipmentImage);
Vue.component('new-equipment', NewEquipment);



//AppComponent


const app = new Vue({
    el: '#App',
    render: h => h(AppComponent),
    store,
    router: router,
   created () {
        this.initialize()
    },
    methods: {
        initialize () {
            let token_vu = document.head.querySelector('meta[name="token"]');
            
            if (token_vu.content){
                window.axios.defaults.headers.common['Authorization'] = 'Bearer '+token_vu.content;
                this.$store.commit('changeToken',token_vu.content)
            }else{
                window.axios.defaults.headers.common['Authorization'] = 'Bearer '+ this.$store.getters.token;
            }
        }
    }

});