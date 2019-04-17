import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);


export default new Vuex.Store(
{
	state: {
	  user: '',
	  astronomic_objects:[],
	},
	mutations: {
		changeUser(state, user) {
		  	state.user = user
		},
		changeAstronomicObjects(state, astronomic_objects) {
		  	state.astronomic_objects = astronomic_objects;
		},
	},
	getters: {
		astronimic_objects: state => state.astronomic_objects,
	}
});