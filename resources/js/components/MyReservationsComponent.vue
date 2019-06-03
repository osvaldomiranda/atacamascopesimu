<template>
     <v-container fluid>

        <v-layout align-center row>
            <v-flex xs1>
            </v-flex>
  
        <v-flex xs10 style="overflow: auto">

            <v-card>
              <v-card-title>
                 <span class="headline">Mis Reservas</span>



              <v-spacer></v-spacer>     
                  <v-text-field
                    v-model="search"
                    append-icon="search"
                    label="Buscar"
                    single-line
                    hide-details
                  ></v-text-field>
              </v-card-title>
              <v-data-table
                :headers="headers"
                :items="my_reservations"
                :search="search"
                v-model="selected"
                :rows-per-page-items="rowsPerPageItems"
                :pagination.sync="pagination"
              >
                <template v-slot:items="props">
                  <tr @click="showAlert(props.item)">
                  <td class="text-xs-left">{{ props.item.equipment.name }}</td>
                  <td class="text-xs-left">{{ props.item.date }}</td>
                  <td class="text-xs-left">{{ props.item.hour }}</td>
                  <td class="text-xs-left">{{ props.item.points }}</td>
                  <td class="text-xs-left"> 
                    <v-btn color="warning" dark @click="onClick" >Interfaz de Control</v-btn> 
                  </td>
                </tr>
                </template>
                <v-alert v-slot:no-results :value="true" color="error" icon="warning">
                  Your search for "{{ search }}" found no results.
                </v-alert>
              </v-data-table>
            </v-card> 
            <v-flex xs1>
            </v-flex>
        </v-flex>
                
        </v-layout>
        <div ref="container">

        </div>
    </v-container>    

</template>



<script>
  import Vue from 'vue';
  import { mapState } from 'vuex';
  import ControlComponent     from './ControlComponent';
  
  export default {
    computed: mapState({
        my_reservations: state => state.my_reservations,
    }),

    data: () => ({
        // my_reservations:[],
        search:'',
        selected:3,
        rowsPerPageItems: [3, 5, 10, 20],
        pagination: {
            rowsPerPage: 3
        }, 

        headers: [
          { text: 'Equipo', value: '' },
          { text: 'Fecha', value: '' },
          { text: 'Hora', value: '' },
        ],
    }),
    mounted(){
      this.initialize()
    },
    methods: {
        initialize () {
            var app = this;
            let userId = document.head.querySelector('meta[name="userID"]');
            axios.get('/api/my_reservations',{
                    headers: { 
                        'user': userId.content,
                    }
                })
                .then(function (resp) {    
                    app.$store.commit('changeMyReservations',resp.data );
      
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Error my_reservations :" + resp);
                });
        },
        onClick (){
            var ComponentClass = Vue.extend(ControlComponent)
            var instance = new ComponentClass();
            // instance.$slots.default = ['Click me!']
            instance.$mount() // pass nothing
            this.$refs.container.appendChild(instance.$el)

        }
    }
}
</script>