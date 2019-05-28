<template>
  <v-layout>
    <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
      <template v-slot:activator="{ on }">
        <v-btn color="warning" dark v-on="on">Reservar</v-btn>
      </template>
      <v-card>
        <v-toolbar dark color="primary">
          <v-btn icon dark @click="dialog = false">
            <v-icon>close</v-icon>
          </v-btn>
          <v-toolbar-title>Reservas</v-toolbar-title>
          <v-spacer></v-spacer>
        </v-toolbar>
 


        <v-container fluid>

            <v-card>
            <v-layout align-center row>
               
                   <v-flex xs1>
                   </v-flex>
                   <v-flex xs2>
                      <v-menu
                        ref="menu"
                        v-model="menu"
                        :close-on-content-click="false"
                        :nudge-right="40"
                        :return-value.sync="date"
                        lazy
                        transition="scale-transition"
                        offset-y
                        full-width
                        min-width="290px"
                      >
                        <template v-slot:activator="{ on }">
                          <v-text-field
                            v-model="today"
                            label="Fecha"
                            prepend-icon="event"
                            readonly
                            v-on="on"
                            v
                          ></v-text-field>
                        </template>
                        <v-date-picker v-model="today" no-title @input="change_date" scrollable>
                          <v-spacer></v-spacer>
                          <v-btn flat color="primary" @click="menu = false">Cancel</v-btn>
                          <v-btn flat color="primary" @click="$refs.menu.save(date)">OK</v-btn>
                        </v-date-picker>
                      </v-menu>
                    </v-flex>
                    <v-flex xs1>
                   </v-flex>
                    
                    <v-flex xs2>
                        <v-select
                          v-model="equipment"
                          :items="equipments"
                          item-text="name"
                          label="Telescopio"
                          v-validate="'required'"
                          return-object
                          :rules="blankRules"
                          required
                          @input= "changeTelescope"

                        ></v-select>
                    </v-flex>
                    <v-flex xs1>
                   </v-flex>

                    <v-flex xs4>
                        <span class="headline"> Puntos Disponibles:{{ $store.getters.current_points }}</span>
                    </v-flex>
            </v-layout> 

            <v-layout align-center row>
               
                   <v-flex xs8>
                   </v-flex>
                   <v-flex xs4>
                        <span>{{ moon_state }}</span>

                   </v-flex>
               </v-layout>
            </v-card>
            </v-container>




            <v-container fluid>
            <v-layout align-center row>
                <v-flex xs1>
                </v-flex>
                <v-flex xs4>
                
                <template>
                  <v-layout wrap>
                    <v-flex
                      xs12
                      class="mb-3"
                    >
                      <v-sheet height="500">
                        <v-calendar
                          ref="calendar"
                          v-model="start"
                          :type="type"
                          :end="end"
                          color="primary"
                        >
                                  <template v-slot:interval="{ hour }">
                                    <div
                                      class="text-xs-center"
                                    >
                                        <v-btn small v-if="reservationsArray.indexOf(hour)>-1" color="error">Reservado</v-btn>
                                        <v-btn small v-if="reservationsArray.indexOf(hour)<=-1" color="success" @click="confirmReserv(hour)">Disponible</v-btn>

                                    </div>
                                  </template>            
                        </v-calendar>
                      </v-sheet>
                    </v-flex>

                  </v-layout>
                </template>
        </v-flex>
        <v-flex xs7>
            <my-reservations></my-reservations>  
        </v-flex>
    </v-layout>

    </v-container>
    </v-card>


    <template>
      <v-dialog v-model="dialog2" max-width="500px">
        <v-card>
          <v-card-title>
            Confirmar Reserva
          </v-card-title>
          <v-card-text>
            {{ this.equipment }}
            {{ this.points_out }}
            {{ this.today }}
            {{ this.hourToReserv }}

          </v-card-text>
          <v-card-actions>
            <v-btn color="primary" flat @click="reserv">Reservar</v-btn>
            <v-btn color="primary" flat @click="dialog2=false">Close</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </template>



    </v-dialog>
  </v-layout>


</template>

<script>
  import { mapState } from 'vuex';
  export default {
    computed: mapState({
        equipments: state => state.equipments,
        reservations: state => state.reservations,
    }),

    data () {
      return {
        blankRules: [v => !!v || 'Campo requerido'],
        today: '2019-05-08',
        date: '2019-05-08',
        moon_state:"",
        current_points:0,
        points_in:0,
        points_out:0,
        hourToReserv:'',
        equipment: 'Equipo Principal',

        reservationsArray:[1,22,23],
        reservations:[],
        equipment_id: 1,

        dialog: false,
        dialog2: false,
   
        search: '',
   
        rowsPerPageItems: [3, 5, 10, 20],
        pagination: {
            rowsPerPage: 3
        },  

   
        headers: [
          { text: 'Nombre', value: 'name' },
          { text: 'Catalogo', value: 'catalog' },
          { text: 'Tipo', value: 'type_object' },
          { text: 'Constelación', value: 'constellation' },
          { text: 'AR', value: 'ra' },
          { text: 'DEC', value: 'dec' }
        ],

        type: 'day',
        start: '2019-05-17',
        end: '2019-05-20',
        typeOptions: [
            { text: 'Day', value: 'day' },
            { text: 'Week', value: 'week' },
        ]
    


      }
    },


    created () {
        this.initialize();
    },
    methods: {
        open (event) {
            alert(event.title)
        },



        initialize () {

            var app = this;
            var todayTime = new Date();
            var month = (todayTime.getMonth() + 1).toString();
            app.today = todayTime.getFullYear() + '-' + month.padStart(2,'00') + '-' + todayTime.getDate() ;
            app.start = app.today; 

            this.moon();

            this.points();
           
            this.reservatios_day();
        },


        moon (){
            var app = this;
            axios.get('/api/moon_state',{
                headers: { 
                    'moondate': app.start,
                }
            })
            .then(function (resp) { 
                 app.moon_state = resp.data;
            })
            .catch(function (resp) {
                console.log(resp);
                alert("Error moon :" + resp);
            });

        },

        confirmReserv (hour){
            this.hourToReserv = hour;
            this.dialog2 = true;
        },

        changeTelescope (a){
            this.equipment = a.name;
            this.equipment_id = a.id;
            this.points_out = a.points;
            this.reservatios_day();
        },

        change_date(a){
            this.start=a;
            this.end = a;
            this.moon();
            this.reservatios_day();
        },


        reservatios_day () {
            var app = this;
            axios.get('/api/reservations?equipment_id='+app.equipment_id+'&date='+app.start)
            .then(function (resp) {  
                app.reservationsArray=[];
                for(var i in resp.data){
                    app.reservationsArray.push(resp.data[i].hour);   
                }
            })
            .catch(function (resp) {
                console.log(resp);
                alert("Error reservations :" + resp);
            }); 
        },

        reserv (){
            var app = this
            let userId = document.head.querySelector('meta[name="userID"]');
            var reserv = {'user_id':userId.content, 'equipment_id': this.equipment_id, 'date': this.start, 'hour': this.hourToReserv , 'points_out': this.points_out, 'current_points': this.current_points - this.points_out };

            axios.post('/api/reservation/create', reserv)
            .then(function (resp) {  
                app.reservatios_day(); 
                app.points(); 
                app.my_reservations();
            })
            .catch(function (resp) {
                console.log(resp);
                alert("Error reservation create :" + resp);
            });

            app.dialog2=false;  
        },
        points (){
            let userId = document.head.querySelector('meta[name="userID"]');
            axios.get('/api/points',{
                headers: { 
                    'user': userId.content,
                }
            })
            .then(function (resp) {    
                for(var i in resp.data){
                     app.points_in += parseInt(resp.data[i].in,10);
                     app.points_out += parseInt(resp.data[i].out,10);
                 }

                 
                 app.current_points = app.points_in - app.points_out;
                 alert(app.current_points);

                 app.$store.commit('changeCurrentPoints',app.current_points );
            })
            .catch(function (resp) {
                console.log(resp);
                alert("Error Points Reserv :" + resp);
            });
        },
        my_reservations (){
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
        }
    },
  }
</script>

