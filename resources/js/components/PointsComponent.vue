<template>
  <v-layout>
    <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
      <template v-slot:activator="{ on }">
        <v-btn color="warning" dark v-on="on">Comprar Puntos</v-btn>
      </template>
      <v-card>
        <v-toolbar dark color="primary">
          <v-btn icon dark @click="dialog = false">
            <v-icon>close</v-icon>
          </v-btn>
          <v-toolbar-title>Puntos</v-toolbar-title>
          <v-spacer></v-spacer>
        </v-toolbar>

        <v-container fluid>
            <v-layout align-center row>
                <v-flex xs12>
                    <v-card>
                        <v-container  fluid>

                            <v-layout row>
                                <v-flex xs1>
                                </v-flex>
                                <v-flex xs4>
                                    <span class="headline"> Puntos Disponibles:{{ current_points }}</span>
                                </v-flex>
                                
                            </v-layout>
                            </br>
                            <v-layout row>
                                <v-flex xs1>
                                </v-flex>
                                <v-flex xs3 align-end flexbox>
                                    <v-select
                                        :items="points_items"
                                        label="Puntos"
                                        outline
                                        @input= "cost"
                                    ></v-select>
                                </v-flex>
                                <v-flex xs1>
                                </v-flex>
                                <v-flex xs3 align-end flexbox>
                                    <span class="headline"> US$:{{ price }}</span>
                                </v-flex>

                                <v-flex xs3 align-end flexbox>
                                    <v-btn @click="pay()" color="success">Proceso de Pago</v-btn>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>  

         <v-container fluid>
            <v-layout row>
                <v-flex xs1>
                </v-flex>
                <v-flex xs4>
                    <span class="headline"> Historial de compras</span>
                </v-flex>    
            </v-layout>

            <v-layout align-center row>

                <v-flex xs1>
                </v-flex>

                <v-flex xs7 style="overflow: auto">

                      <v-card>
                        <v-card-title>
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


    </v-dialog>
  </v-layout>
</template>

<script>

  export default {
    data () {
      return {
        dialog: false,

        current_points: 0,
        points: 0,
        price: 0,
       
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
        //  if (event.target.classList.contains('btn__content')) return;
            var app = this;
          
        },
        initialize () {
            var app = this;

            axios.get('/api/points')
            .then(function (resp) {    
                //alert(JSON.stringify(resp.data));
               // app.purchases = resp.data;
            })
            .catch(function (resp) {
                console.log(resp);
                alert("Error Points :" + resp);
            });

        },

        // openChat () {
        //     let app = this

        //       // Start pusher listener
        //     Pusher.logToConsole = true

        //     var pusher = new Pusher('e6e9d9fd854d385c5f5b', {
        //         cluster: 'us2',
        //         forceTLS: true
        //     })

        //     var channel = pusher.subscribe('newMessage-' + 1 + '-' + 2) // newMessage-[chatting-with-who]-[my-id]

        //     channel.bind('App\\Events\\MessageSent', function (data) {
                
        //         app.state = data.message['message'];

        //         if (app.state=="Imagen Recibida"){

        //             app.imageRefresh();
        //         }
                
        //     })
        //       // End pusher listener

            
        //  },

        pay(){

            let app = this;

            let fecha = this.GetFormattedDate();

            var pay_points = {'created_at':fecha,'in': this.points, 'out': 0, 'current_points': parseInt(this.current_points) + parseInt(this.points), 'reservation_id': '', 'transaction_id': '876238746'};

            this.purchases.push(pay_points);

            this.current_points = parseInt(this.current_points) + parseInt(this.points);
            axios.post('/api/points/addpoints', pay_points)
            .then(function (resp) {
               
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