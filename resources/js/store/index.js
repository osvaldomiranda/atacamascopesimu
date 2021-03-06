import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);


export default new Vuex.Store(
{
	state: {
	  user: '',

	  equipments:[],
	  reservations:[],
	  my_reservations:[],
	  current_points:0,
	  current_focus:26000,
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


		changeMyReservations(state, my_reservations) {
		  	state.my_reservations = my_reservations;
		},
		changeCurrentPoints(state, current_points) {
		  	state.current_points = current_points;
		},
		changeCurrentFocus(state, current_focus) {
		  	state.current_focus = current_focus;
		},
	},
	getters: {
		user: state=> state.user,
		equipments: state=> state.equipments,
		reservations: state=> state.reservations,
		my_reservations: state=> state.my_reservations,
		current_points: state=> state.current_points,
		current_focus: state=> state.current_focus,

	}
});