import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);


export default new Vuex.Store(
{
	state: {
	  user: '',
	  astronomic_objects:[],
	  equipments:[],
	  reservations:[],
	  myReservations:[],
	},
	mutations: {
		changeUser(state, user) {
		  	state.user = user;
		},
		changeEquipments(state, equipments) {
		  	state.equipments = equipments;
		},
		changeReservations(state, reservations) {
		  	state.reservations = reservations;
		},
		changeMyReservations(state, reservations) {
		  	state.reservations = reservations;
		},
		changeAstronomicObjects(state, astronomic_objects) {
		  	state.astronomic_objects = astronomic_objects;
		},
	},
	getters: {
		astronimic_objects: state => state.astronomic_objects,
		user: state=> state.user,
		equipments: state=> state.equipments,
		reservations: state=> state.reservations,
		myReservations: state=> state.myReservations,

	}
});