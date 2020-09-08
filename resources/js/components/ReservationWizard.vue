<template>
  <v-layout>
  <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
<!--       <template v-slot:activator="{ on }">
    <v-btn color="warning" dark v-on="on">Reservar</v-btn>
    </template> -->
    <v-card>
    <v-toolbar dark color="morado">
      <v-btn icon dark @click="dialog = false">
      <v-icon>close</v-icon>
      </v-btn>
      <v-toolbar-title>Reservas</v-toolbar-title>
      <v-spacer></v-spacer>
    </v-toolbar>

<template>
  <v-stepper dark color="morado" v-model="e1">
    <v-stepper-header>
      <v-stepper-step color="morado"  :complete="e1 > 1" step="1">Elige tu Equipamiento</v-stepper-step>

      <v-divider></v-divider>

      <v-stepper-step color="morado"  :complete="e1 > 2" step="2">Elige Día de Observación </v-stepper-step>

      <v-divider></v-divider>

      <v-stepper-step color="morado"  step="3">Reserva tu Hora</v-stepper-step>
    </v-stepper-header>

    <v-stepper-items>
      <v-stepper-content step="1">
        <v-card
          class="px-4 py-4 xs-6"
          height="450px"
        >

            <v-layout>
                <v-flex xs6 class="px-4">
                    <h1> Elige tu Equipamiento </h1>
                </v-flex>
            </v-layout>    

            <v-layout>
                <v-flex xs6 class="px-4">
                    <v-select
                      v-model="equipment"
                      :items="equipments"
                      item-text="name"
                      label="Equipamiento"
                      return-object
                      
                      required
                      @input= "changeTelescope"

                    ></v-select>
                </v-flex>

              </v-layout>



              <v-layout>
                <v-flex xs2 class="px-4 py-4">                  
                  <v-card>
                      <v-img
                          v-bind:src= "img" 
                          aspect-ratio="1"
                      ></v-img>  
                  </v-card> 
                </v-flex>
                <v-flex xs8 class="px-4 py-4">
                  <h2>{{ equipment }}</h2>
                  <h4>{{ equipment_desc }}</h4>
                </v-flex>
            </v-layout>
        </v-card>

        <v-btn
          lass="mx-2" fab dark small color="morado"
          @click="e1 = 2"
        >
          <v-icon dark>arrow_forward</v-icon>
        </v-btn>


      </v-stepper-content>

      <v-stepper-content step="2">
        <v-card
          class="mb-12"
          flat
          color="transparent"
          height="630px"
        >
            

<!--             <v-layout row wrap>
                <v-flex xs1>
                </v-flex>
                <v-flex xs6>
                    <h1> Elige tu día de Observación </h1>
                </v-flex>
            </v-layout>   -->  

            <v-layout row wrap>
                <v-flex xs1>
                </v-flex>
                <v-flex xs10>
                    <template>
                      <v-layout fill-height>
                        <v-flex>
                          <v-sheet height="64">
                            <v-toolbar flat color="morado">
                              <v-btn outline round color="white" @click="setToday">
                                Volver a Hoy
                              </v-btn>
                              <v-btn fab text small @click="prev">
                                <v-icon small>arrow_back_ios</v-icon>
                              </v-btn>
                              <v-btn fab text small @click="next">
                                <v-icon small>arrow_forward_ios</v-icon>
                              </v-btn>


                              <v-select
                                v-model="type"
                                :items="typeToLabel"
                                label="Tipo"
                                required
                              ></v-select>

                              <v-toolbar-title>Elige tu día de Observación {{ focus }}</v-toolbar-title>
                              <v-spacer></v-spacer>
      
                            </v-toolbar>
                          </v-sheet>
                          <v-sheet  height="540">
                            <v-calendar
                              ref="calendar"
                              v-model="focus"
                              color="bacgraundColor"
                              :events="events"
                              :event-color="getEventColor"
                              :event-margin-bottom="3"
                              :now="today"
                              :type="type"
                              @click:event="showEvent"
                              @click:more="viewDay"
                              @click:date="viewDay"
                              @change="updateRange"
                            >
               

                             <template v-slot:day="{ date }">

                                <template>

                                    <v-layout @click="viewDay({ date })">
                                        <v-flex xs4 class="px-2"> 
                                            <v-card flat color="transparent">
                                                <v-img
                                                    v-bind:src= "moonImages(date)" 
                                                    aspect-ratio="1"
                                                    max-width="45"
                                                    max-height="45"
                                                ></v-img>   
                                            </v-card> 
                                        </v-flex>


                                        <v-flex xs4 class="px-1">                                           
                                            <v-flex xs12>
                                              <p>{{ moonRise(date) }}</p>
                                            </v-flex>
                                            <v-flex xs12 class="px-1">
                                              <p>{{ moonSet(date) }}</p>
                                            </v-flex>                            
                                        </v-flex>
                                    </v-layout>    


                                </template>

                                <template v-for="event in eventsMap[date]">
                                  <v-menu
                                    :key="event.title"
                                    v-model="event.open"
                                    full-width
                                    offset-x
                                  >
                                    <template v-slot:activator="{ on }">
                                      <div
                                        v-if="!event.time"
                                        v-ripple
                                        class="my-event"
                                        v-on="on"
                                        v-html="event.title"
                                      ></div>
                                    </template>
                                    <v-card
                                      color="grey lighten-4"
                                      min-width="350px"
                                      flat
                                    >
                                      <v-toolbar
                                        color="primary"
                                        dark
                                      >
                                      <!--   <v-btn icon>
                                          <v-icon>edit</v-icon>
                                        </v-btn> -->
                                        <v-toolbar-title v-html="event.title"></v-toolbar-title>
                                        <v-spacer></v-spacer>
<!--                                         <v-btn icon>
                                          <v-icon>favorite</v-icon>
                                        </v-btn>
                                        <v-btn icon>
                                          <v-icon>more_vert</v-icon>
                                        </v-btn> -->
                                      </v-toolbar>
                                      <v-card-title primary-title>
                                        <span v-html="event.details"></span>
                                      </v-card-title>
                                      <v-card-actions>
                                        <v-btn
                                          flat
                                          color="secondary"
                                        >
                                          Cancel
                                        </v-btn>
                                      </v-card-actions>
                                    </v-card>
                                  </v-menu>
                                </template>
                              </template>




                            </v-calendar>

                          </v-sheet>
                        </v-flex>
                      </v-layout>
                    </template>

                </v-flex>
            </v-layout>    




        </v-card>


        <v-btn
          lass="mx-2" fab dark small color="morado"
          @click="e1 = 1"
        >
          <v-icon dark>arrow_back</v-icon>
        </v-btn>

        <v-btn
          lass="mx-2" fab dark small color="morado"
          @click="e1 = 3"
        >
          <v-icon dark>arrow_forward</v-icon>
        </v-btn>


      </v-stepper-content>

      <v-stepper-content step="3">
        <v-card
          class="mb-12"
          flat
          color="transparent"
          height="450px"
        >
          

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
                      <v-sheet height="400">
                      <v-calendar
                        ref="calendar"
                        v-model="focus"
                        type="day"
                        :end="end"
                        color="primary"
                      >
                            <template v-slot:interval="{ hour }">
                            <div
                              class="text-xs-center"
                            >
                              <v-btn round small v-if="reservationsArray.indexOf(hour)>-1" color="error">Reservado</v-btn>
                              <v-btn round small v-if="reservationsArray.indexOf(hour)<=-1" color="success" @click="confirmReserv(hour)">Disponible</v-btn>

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

        </v-card>
        <br>

        <v-btn
          lass="mx-2" fab dark small color="morado"
          @click="e1 = 2"
        >
          <v-icon dark>arrow_back</v-icon>
        </v-btn>


      </v-stepper-content>
    </v-stepper-items>
  </v-stepper>
</template>

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
        <div class="title font-weight-light">Fecha:  {{ this.reserv_date }}</div>
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



<style scoped>

</style>

<script>
  import SunCalc from 'suncalc';  
  import lune from 'lune';  
  import { mapState } from 'vuex';

  var actualDate = new Date().toISOString().substr(0, 10)

  export default {
  computed: mapState({
    //equipments: state => state.equipments,
    reservations: state => state.reservations,

  }),

    computed: {
      title () {
        const { start, end } = this
        if (!start || !end) {
          return ''
        }

        const startMonth = this.monthFormatter(start)
        const endMonth = this.monthFormatter(end)
        const suffixMonth = startMonth === endMonth ? '' : endMonth

        const startYear = start.year
        const endYear = end.year
        const suffixYear = startYear === endYear ? '' : endYear

        const startDay = start.day + this.nth(start.day)
        const endDay = end.day + this.nth(end.day)

        switch (this.type) {
          case 'month':
            return `${startMonth} ${startYear}`
          case 'week':
          case '4day':
            return `${startMonth} ${startDay} ${startYear} - ${suffixMonth} ${endDay} ${suffixYear}`
          case 'day':
            return `${startMonth} ${startDay} ${startYear}`
        }
        return ''
      },
      monthFormatter () {
        return this.$refs.calendar.getFormatter({
          timeZone: 'UTC', month: 'long',
        })
      },
    },


  data () {
    return {
    img: "http://www.celestron.es/wp-content/uploads/2017/05/12077_-CGX-L_EdgeHD_14_Kit_01.jpeg",

    e1: 0,
    generalRuleDate: [v => !!v || 'Campo requerido',
      v=> v >= actualDate || 'Debe ser fecha mayor a la actual',
    ],

    blankRules: [v => !!v || 'Campo requerido'],
    today: '2019-05-08',
    reserv_date: '2019-05-08',
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
    equipment_desc: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
    equipment_image: '',

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


      
      focus: '2019-01-08',
      type: 'month',
      typeToLabel: [
        'month',
        'week',
        'day',
        '4 days',
      ],
      start: null,
      end: null,
      selectedEvent: {},
      selectedElement: null,
      selectedOpen: false,
      events: [
        {
          name: 'event 7',
          start: '2019-07-07 9:00',
          end: '2019-07-07 10:00',
          color: '#4285F4',
        },
      ],



    }


  },



  created () {
    this.initialize();
  },

   computed: {
      // convert the list of events into a map of lists keyed by date
      eventsMap () {
        const map = {}
        this.events.forEach(e => (map[e.date] = map[e.date] || []).push(e))
        return map
      }
    },

  methods: {
    open (event) {
      alert(event.title)
    },

    


    initialize () {

      

      var app = this;
      app.today = actualDate;
      app.start = app.today; 
      app.focus = app.today; 

      // -22.96, 68.24

      
      app.suntimes = SunCalc.getTimes(new Date(), 33.0000, -70.3326);
      // format sunrise time from the Date object
      app.sunset = app.suntimes.sunset;
      app.sunrise = app.suntimes.sunrise;

      

      app.moon_times = SunCalc.getMoonTimes(new Date(), 33.0000, -70.3326);
       // alert(JSON.stringify(app.moon_times));
      app.moonset = app.moon_times["set"];
      app.moonrise = app.moon_times["rise"];


          axios.get('/api/equipments')
            .then(function (resp) {    
                //alert(JSON.stringify(resp.data));
                //app.$store.commit('changeEquipments',resp.data);
                app.equipments = resp.data;
            })
            .catch(function (resp) {
                console.log(resp);
                alert("Error equipments :" + resp);
            });

      this.moon();
      
      this.reservatios_day();
    },


    moon (){
      // var app = this;
      // axios.get('/api/moon_state',{
      //   headers: { 
      //     'moondate': app.start,
      //   }
      // })
      // .then(function (resp) { 
      //    app.moon_state = resp.data;
      //    app.moonImage();
      // })
      // .catch(function (resp) {
      //   console.log(resp);
      //   alert("Error moon :" + resp);
      // });
    },

    confirmReserv (hour){
      this.hourToReserv = hour;
      this.dialog2 = true;
    },

    changeTelescope (a){
      this.equipment = a.name;
      this.equipment_id = a.id;
      this.equipment_desc = a.description;
      this.equipment_image = a.image;
      this.telescope_points = a.points;
      this.reservatios_day();
    },

    change_date(a){
      alert(a);
      this.start=a;
      this.end = a;
      this.moon_times = SunCalc.getMoonTimes(new Date(a), -22.96, 68.24);
      this.moonset = this.moon_times["set"];
      this.moonrise = this.moon_times["rise"];
      this.moon();
      this.reservatios_day();
    },


    reservatios_day () {
      var app = this;
      axios.get('/api/reservations?equipment_id='+app.equipment_id+'&date='+app.reserv_date)
      .then(function (resp) {  
        app.reservationsArray=[];
        app.events=[];
        for(var i in resp.data){
          // alert(JSON.stringify(resp.data[i]));
          app.reservationsArray.push(resp.data[i].hour); 


           app.events.push( {title: 'Reservado a las ' + resp.data[i].hour + 'Hrs',
                          details: 'Reservado',
                          date: resp.data[i].date,
                            open: false } )   
        }

      })
      .catch(function (resp) {
        console.log(resp);
        alert("Error reservations :" + resp);
      }); 
    },

    reserv (){
      var app = this

      // alert(JSON.stringify(this.reserv_date));


      var reserv = {'user_id':4, 'equipment_id': this.equipment_id, 'date': this.reserv_date, 'hour': this.hourToReserv , 'points_out': this.telescope_points, 'current_points': this.$store.getters.current_points - this.telescope_points };


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
      app.dialog=false;  
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


    viewDay ({ date }) {
        //validar que la fecha a reservar sea mayor o igual a hoy

        // alert(JSON.stringify(date));
        if(date<this.today){
          
        } else {

            this.reserv_date = date;
            this.focus = date;
            this.start = this.focus;
            this.reservatios_day();
            this.e1 = 3;
        }
    },

      getEventColor (event) {
        return event.color
      },
      setToday () {
        this.focus = this.today
      },
      prev () {
        this.$refs.calendar.prev()
      },
      next () {
        this.$refs.calendar.next()
      },
      showEvent ({ nativeEvent, event }) {
        const open = () => {
          this.selectedEvent = event
          this.selectedElement = nativeEvent.target
          setTimeout(() => this.selectedOpen = true, 10)
        }

        if (this.selectedOpen) {
          this.selectedOpen = false
          setTimeout(open, 10)
        } else {
          open()
        }

        nativeEvent.stopPropagation()
      },
      updateRange ({ start, end }) {
        // You could load events from an outside source (like database) now that we have the start and end dates on the calendar
        this.start = start
        this.end = end
      },
      nth (d) {
        return d > 3 && d < 21
          ? 'th'
          : ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'][d % 10]
      },



      moonRise(a){

        var moon_times = SunCalc.getMoonTimes(new Date(a + 'T00:00'), -22.96, 68.24);
       // alert(JSON.stringify(app.moon_times));
        var moonset = moon_times["rise"];
        var monset_time =''
        if(moonset){
          monset_time = 'Rise:' + moonset.toLocaleTimeString();
        } 
        
        return monset_time;

      },

      moonSet(a){

        var moon_times = SunCalc.getMoonTimes(new Date(a + 'T00:00'), -22.96, 68.24);
        var moonset = moon_times["set"];
        var monset_time =''
        if(moonset){
          monset_time = 'Set:' + moonset.toLocaleTimeString();
        } 
        
        return monset_time;

      },

      moonImages(a){

        var imageUrl='';
        
        var some_date = new Date(a + 'T00:00')
        var some_date_phase = lune.phase(some_date)

        var age = some_date_phase['age'];
 
        var age = parseInt(some_date_phase['age']); 
        switch (age) {
        case 1:
          imageUrl = require('./../../assets/images/Luna01.png');
          break;
        case 2:
          imageUrl = require('./../../assets/images/Luna02.png');
          break;
        case 3:
          imageUrl = require('./../../assets/images/Luna03.png');
          break;
        case 4:
          imageUrl = require('./../../assets/images/Luna04.png');
          break;
        case 5:
          imageUrl = require('./../../assets/images/Luna05.png');
          break;
        case 6:
          imageUrl = require('./../../assets/images/Luna06.png');
          break;
        case 7:
          imageUrl = require('./../../assets/images/Luna07.png');
          break;
        case 8:
          imageUrl = require('./../../assets/images/Luna08.png');
          break;
        case 9:
          imageUrl = require('./../../assets/images/Luna09.png');
          break;
        case 10:
          imageUrl = require('./../../assets/images/Luna10.png');
          break;
        case 11:
          imageUrl = require('./../../assets/images/Luna11.png');
          break;
        case 12:
          imageUrl = require('./../../assets/images/Luna12.png');
          break;
        case 13:
          imageUrl = require('./../../assets/images/Luna13.png');
          break;
        case 14:
          imageUrl = require('./../../assets/images/Luna14.png');
          break;
        case 15:
          imageUrl = require('./../../assets/images/Luna15.png');
          break;
        case 16:
          imageUrl = require('./../../assets/images/Luna16.png');
          break;
        case 17:
          imageUrl= require('./../../assets/images/Luna17.png');
          break;
        case 18:
          imageUrl = require('./../../assets/images/Luna18.png');
          break;
        case 19:
          imageUrl = require('./../../assets/images/Luna19.png');
          break;
        case 20:
          imageUrl = require('./../../assets/images/Luna20.png');
          break;
        case 21:
          imageUrl = require('./../../assets/images/Luna21.png');
          break;
        case 22:
          imageUrl = require('./../../assets/images/Luna22.png');
          break;
        case 23:
          imageUrl = require('./../../assets/images/Luna23.png');
          break;
        case 24:
          imageUrl = require('./../../assets/images/Luna24.png');
          break;
        case 25:
          imageUrl= require('./../../assets/images/Luna25.png');
          break;
        case 26:
          imageUrl = require('./../../assets/images/Luna26.png');
          break;
        case 27:
          imageUrl = require('./../../assets/images/Luna27.png');
          break;
        case 28:
          imageUrl = require('./../../assets/images/Luna28.png');
          break;
        case 29:
          imageUrl = require('./../../assets/images/Luna29.png');
          break;
        }


        return imageUrl;
      }


  },
  }
</script>