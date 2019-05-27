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
	  my_reservations:[],
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

		changeAstronomicObjects(state, astronomic_objects) {
		  	state.astronomic_objects = astronomic_objects;
		},
		changeMyReservations(state, my_reservations) {
		  	state.my_reservatiosn = my_reservations;
		},
	},
	getters: {
		astronimic_objects: state => state.astronomic_objects,
		user: state=> state.user,
		equipments: state=> state.equipments,
		reservations: state=> state.reservations,
		my_reservations: state=> state.my_reservations,

	}
});