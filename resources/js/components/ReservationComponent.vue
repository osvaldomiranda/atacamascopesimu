<template>
  <v-layout>
    <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
<!--       <template v-slot:activator="{ on }">
        <v-btn color="warning" dark v-on="on">Reservar</v-btn>
      </template> -->
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
                            :rules='generalRuleDate'
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
        <v-flex xs1>
        </v-flex>
        <v-flex xs1>
          <v-layout align-center row>
            <v-flex xs12> 
                <v-card>
                    <v-img
                        v-bind:src= "moonUrl" 
                        aspect-ratio="1"
                    ></v-img>
                </v-card> 
              </v-flex>
          </v-layout>   
          </v-flex>
        <v-flex xs1>
        </v-flex>  
        <v-flex xs8>
          <v-layout align-center row>
                   <v-flex xs1>
                   </v-flex> 
                   <v-flex xs12>
                      <div class="title font-weight-light">{{ moon_state }}</div>

                   </v-flex>
            </v-layout>       
            <v-layout align-center row>
                    <v-flex xs1>
                   </v-flex> 
                   <v-flex xs12>
                        <div class="title font-weight-light">MoonSet: {{ moonset }}</div>
                   </v-flex>
            </v-layout>   
            <v-layout align-center row>
                    <v-flex xs1>
                   </v-flex>     
                   <v-flex xs12>
                      <div class="title font-weight-light">MoonRise: {{ moonrise }}</div>
                   </v-flex>
            </v-layout>
            <v-layout align-center row>
                    <v-flex xs1>
                   </v-flex>     
                   <v-flex xs12>
                      <div class="title font-weight-light">SunRise: {{ sunrise }}</div>
                   </v-flex>
            </v-layout>
            <v-layout align-center row>
                    <v-flex xs1>
                   </v-flex>     
                   <v-flex xs12>
                      <div class="title font-weight-light">SunSet: {{ sunset }}</div>
                   </v-flex>
            </v-layout>
        </v-flex>  
        

        </v-layout>
          <v-layout align-center row>
        <v-flex xs1>
          <br>
        </v-flex>
      </v-layout>
            <!-- {{ url('images/Luna1.jpg') }} -->
            
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
      
          <v-card-title
            class="headline grey lighten-2"
            primary-title
          >
            Confirmar Reserva
          </v-card-title>
          <v-card-text>
            <v-container grid-list-md>
            <v-layout wrap row>
              <v-flex xs12>
                <div class="title font-weight-light">Equipo: {{ this.equipment }}</div>
              </v-flex>
            </v-layout>
            <v-layout wrap row>
              <v-flex xs12>
                <div class="title font-weight-light">Puntos de esta reserva: {{ this.telescope_points }}</div>
              </v-flex>
            </v-layout>  
            <v-layout wrap row>
              <v-flex xs12>
                <div class="title font-weight-light">Fecha:  {{ this.today }}</div>
              </v-flex>
            </v-layout>
            <v-layout wrap row>
              <v-flex xs12>
                <div class="title font-weight-light">A las: {{ this.hourToReserv }} Horas</div>
              </v-flex>
            </v-layout>
            
          </v-container>
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
  import SunCalc from 'suncalc';  
  import { mapState } from 'vuex';

  var actualDate = new Date().toISOString().substr(0, 10)

  export default {
    computed: mapState({
        equipments: state => state.equipments,
        reservations: state => state.reservations,
    }),

    data () {
      return {
        generalRuleDate: [v => !!v || 'Campo requerido',
            v=> v >= actualDate || 'Debe ser fecha mayor a la actual',
        ],

        blankRules: [v => !!v || 'Campo requerido'],
        today: '2019-05-08',
        date: '2019-05-08',
        moon_state:"",
        moon_times:"",
        moonset:"",
        moonrise:"",
        suntimes:"",
        sunrise:"",
        sunset:"",
        moonUrl:'',
        menu:false,
        telescope_points:200,
        current_points:0,
        points_in:0,
        points_out:0,
        hourToReserv:'',
        equipment: 'Equipo Principal',

        reservationsArray:[],
        equipment_id: 1,

        dialog: true,
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
            app.today = actualDate;
            app.start = app.today; 

            
            app.suntimes = SunCalc.getTimes(new Date(), 33.0000, -70.3326);
            // format sunrise time from the Date object
            app.sunset = app.suntimes.sunset;
            app.sunrise = app.suntimes.sunrise;

            

            app.moon_times = SunCalc.getMoonTimes(new Date(), 33.0000, -70.3326);
           // alert(JSON.stringify(app.moon_times));
            app.moonset = app.moon_times["set"];
            app.moonrise = app.moon_times["rise"];

            this.moon();
            
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
                 app.moonImage();
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
            this.telescope_points = a.points;
            this.reservatios_day();
        },

        change_date(a){
            alert(a);
            this.start=a;
            this.end = a;
            this.moon_times = SunCalc.getMoonTimes(new Date(a), 33.0000, -70.3326);
            this.moonset = this.moon_times["set"];
            this.moonrise = this.moon_times["rise"];
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
            var reserv = {'user_id':userId.content, 'equipment_id': this.equipment_id, 'date': this.start, 'hour': this.hourToReserv , 'points_out': this.telescope_points, 'current_points': this.$store.getters.current_points - this.telescope_points };


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
            let c_points = this.$store.getters.current_points - this.telescope_points;
            this.$store.commit('changeCurrentPoints',c_points );
        },
        my_reservations (){
            var app = this;
          
            axios.get('/api/my_reservations')
                .then(function (resp) {    
                    app.$store.commit('changeMyReservations',resp.data );
      
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Error reservation my_reservations :" + resp);
                });
        },

        moonImage (){



          var app = this;
          var splitted = app.moon_state.split(':');
          var age = parseInt(splitted[3]); 
          switch (age) {
            case 1:
              app.moonUrl = require('./../../assets/images/Luna01.jpg');
              break;
            case 2:
              app.moonUrl = require('./../../assets/images/Luna02.jpg');
              break;
            case 3:
              app.moonUrl = require('./../../assets/images/Luna03.jpg');
              break;
            case 4:
              app.moonUrl = require('./../../assets/images/Luna04.jpg');
              break;
            case 5:
              app.moonUrl = require('./../../assets/images/Luna05.jpg');
              break;
            case 6:
              app.moonUrl = require('./../../assets/images/Luna06.jpg');
              break;
            case 7:
              app.moonUrl = require('./../../assets/images/Luna07.jpg');
              break;
            case 8:
              app.moonUrl = require('./../../assets/images/Luna08.jpg');
              break;
            case 9:
              app.moonUrl = require('./../../assets/images/Luna09.jpg');
              break;
            case 10:
              app.moonUrl = require('./../../assets/images/Luna10.jpg');
              break;
            case 11:
              app.moonUrl = require('./../../assets/images/Luna11.jpg');
              break;
            case 12:
              app.moonUrl = require('./../../assets/images/Luna12.jpg');
              break;
            case 13:
              app.moonUrl = require('./../../assets/images/Luna13.jpg');
              break;
            case 14:
              app.moonUrl = require('./../../assets/images/Luna14.jpg');
              break;
            case 15:
              app.moonUrl = require('./../../assets/images/Luna15.jpg');
              break;
            case 16:
              app.moonUrl = require('./../../assets/images/Luna16.jpg');
              break;
            case 17:
              app.moonUrl = require('./../../assets/images/Luna17.jpg');
              break;
            case 18:
              app.moonUrl = require('./../../assets/images/Luna18.jpg');
              break;
            case 19:
              app.moonUrl = require('./../../assets/images/Luna19.jpg');
              break;
            case 20:
              app.moonUrl = require('./../../assets/images/Luna20.jpg');
              break;
            case 21:
              app.moonUrl = require('./../../assets/images/Luna21.jpg');
              break;
            case 22:
              app.moonUrl = require('./../../assets/images/Luna22.jpg');
              break;
            case 23:
              app.moonUrl = require('./../../assets/images/Luna23.jpg');
              break;
            case 24:
              app.moonUrl = require('./../../assets/images/Luna24.jpg');
              break;
            case 25:
              app.moonUrl = require('./../../assets/images/Luna25.jpg');
              break;
            case 26:
              app.moonUrl = require('./../../assets/images/Luna26.jpg');
              break;
            case 27:
              app.moonUrl = require('./../../assets/images/Luna27.jpg');
              break;
            case 28:
              app.moonUrl = require('./../../assets/images/Luna28.jpg');
              break;
            case 29:
              app.moonUrl = require('./../../assets/images/Luna29.jpg');
              break;
          }

          //alert(app.moonUrl);
          
        }
    },
  }
</script>

