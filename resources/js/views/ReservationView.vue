<template>

      <v-card>
        <v-toolbar dark color="morado">
          <v-toolbar-title>Reservas</v-toolbar-title>
        </v-toolbar>

         <v-layout row>
          <v-flex xs12 class="px-2">
              <v-card class="py-4">
                      <v-layout>
                      <v-flex xs1>
                      </v-flex>
                      
                      <v-flex xs6>
                          <v-btn round color="morado"  dark @click="reservClick" >Reserva tu hora de telescopio Aquí</v-btn> 
                      </v-flex>

                  </v-layout>   
                  <my-reservations></my-reservations>
              </v-card>
          </v-flex>  
        </v-layout>

         <v-container fluid>
            <v-layout row>
                <v-flex xs1>
                </v-flex>
                <v-flex xs4>
                    <span class="headline"> Historial de reservas</span>
                </v-flex>    
            </v-layout>

            <v-layout align-center row>

                <v-flex xs1>
                </v-flex>

                <v-flex xs10 style="overflow: auto">

                      <v-card>
  
                        <v-data-table
                          :headers="headers"
                          :items="purchases"
                          :search="search"
                          v-model="selected"
                          :rows-per-page-items="rowsPerPageItems"
                          :pagination.sync="pagination"
                        >
                          <template v-slot:items="props">
                            <tr @click="showAlert(props.item)">
                                <td class="text-xs-right">{{ props.item.created_at }}</td>
                                <td class="text-xs-right">{{ props.item.in }}</td>
                                <td class="text-xs-right">{{ props.item.out }}</td>
                                <td class="text-xs-right">{{ props.item.current_points }}</td>
                                <td class="text-xs-right">{{ props.item.transaction_id }}</td>
                                <td class="text-xs-right">{{ props.item.reservation_id }}</td>
                            </tr>
                          </template>
                          <v-alert v-slot:no-results :value="true" color="error" icon="warning">
                            Your search for "{{ search }}" found no results.
                          </v-alert>
                        </v-data-table>
                      </v-card> 

                </v-flex>
                        
            </v-layout>
        </v-container>    
            


      </v-card>


  
</template>
<script>
  import { mapState } from 'vuex';
  export default {
    computed: mapState(['current_points']),
    data () {
      return {
        dialog: true,
        points_out:0,
        points_in:0,
        points: 0,
        price: 0,
        search:'',
        userId: 0,
        selected: '100',
       
        rowsPerPageItems: [3, 5, 10, 20],
        pagination: {
            rowsPerPage: 3
        },  

        purchases:[],

        points_items: [
            '100',
            '200',
            '400',
            '600',
            '800',
            '1000',
            '2000',
            '3000',
        ],

        headers: [
          { text: 'Fecha', value: 'created_at' },
          { text: 'Puntos Comprados', value: 'in' },
          { text: 'Puntos usados', value: 'out' },
          { text: 'Puntos disponibles', value: 'current_points' },
          { text: 'Nro.Transacción', value: 'transaction_id' },
          { text: 'Nro.Reserva', value: 'reservation_id' },
        ],
     
      }
    },
    created () {
        this.initialize();
    },
    methods: {
        showAlert(a){
        },
        initialize () {
            var app = this;
            axios.get('/api/points')
            .then(function (resp) {   
                app.purchases = resp.data; 
            })
            .catch(function (resp) {
                console.log(resp);
                alert("Error Points :" + resp);
            });
        },

        pay(){

            let app = this;
            let fecha = this.GetFormattedDate();

            var pay_points = {'created_at':fecha,'in': this.points, 'out': 0, 'current_points': this.$store.getters.current_points + parseInt(this.points), 'reservation_id': '', 'transaction_id': '876238746', 'a': this.$store.getters.user};

            axios.post('/api/points/pay', pay_points)
            .then(function (resp) {
                app.purchases.push(pay_points);
                let c_points=app.$store.getters.current_points + parseInt(app.points);
                app.$store.commit('changeCurrentPoints',c_points );
            })
            .catch(function (resp) {
                console.log(resp);
                alert("Error AddPoints :" + resp);
            });

        },

        cost(a){
            //alert(a);
            this.price = a;
            this.points = a;
        },


        GetFormattedDate() {
            var todayTime = new Date();
            var month = (todayTime.getMonth() + 1);
            var day = (todayTime.getDate());
            var year = (todayTime.getFullYear());
            return  day+ "/" + month + "/" + year;
        }



    },
  }
</script>