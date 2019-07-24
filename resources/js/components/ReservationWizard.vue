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

<template>
  <v-stepper v-model="e1">
    <v-stepper-header>
      <v-stepper-step :complete="e1 > 1" step="1">Elige tu Equipamiento</v-stepper-step>

      <v-divider></v-divider>

      <v-stepper-step :complete="e1 > 2" step="2">Elige Día de Observación</v-stepper-step>

      <v-divider></v-divider>

      <v-stepper-step step="3">Reserva tu Hora</v-stepper-step>
    </v-stepper-header>

    <v-stepper-items>
      <v-stepper-content step="1">
        <v-card
          class="mb-12"
          color="grey lighten-1"
          height="200px"
        >

            <v-layout row wrap>
                <v-flex xs1>
                </v-flex>
                <v-flex xs6>
                    <h1> Elige tu Equipamiento </h1>
                </v-flex>
            </v-layout>    

            <v-layout row wrap>
                <v-flex xs1>
                </v-flex>
                <v-flex xs6>
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
              <v-layout row wrap>
                <v-flex xs1>
                </v-flex>
                <v-flex xs4>
                  <h2>{{ equipment }}</h2>
                </v-flex>
                <v-flex xs1>
                </v-flex>
                <v-flex xs6>
                  <h2>{{ equipment_desc }}</h2>
                </v-flex>
            </v-layout>
        </v-card>

        <v-btn
          lass="mx-2" fab dark small color="primary"
          @click="e1 = 2"
        >
          <v-icon dark>arrow_forward</v-icon>
        </v-btn>


      </v-stepper-content>

      <v-stepper-content step="2">
        <v-card
          class="mb-12"
          color="grey lighten-1"
          height="600px"
        >
            

<!--             <v-layout row wrap>
                <v-flex xs1>
                </v-flex>
                <v-flex xs6>
                    <h1> Elige tu día de Observación </h1>
                </v-flex>
            </v-layout>   -->  

            <v-layout row wrap>
                
                <v-flex xs12>
                    <template>
                      <v-layout fill-height>
                        <v-flex>
                          <v-sheet height="64">
                            <v-toolbar flat color="white">
                              <v-btn outlined class="mr-4" @click="setToday">
                                Volver a Hoy
                              </v-btn>
                              <v-btn fab text small @click="prev">
                                <v-icon small>arrow_back_ios</v-icon>
                              </v-btn>
                              <v-btn fab text small @click="next">
                                <v-icon small>arrow_forward_ios</v-icon>
                              </v-btn>
                              <v-toolbar-title>Elige tu día de Observación</v-toolbar-title>
                              <v-spacer></v-spacer>
                              <!-- <v-menu bottom right>
                                <template v-slot:activator="{ on }">
                                  <v-btn
                                    outlined
                                    v-on="on"
                                  >
                                    <span>{{ typeToLabel[type] }}</span>
                                    <v-icon right>arrow_drop_down</v-icon>
                                  </v-btn>
                                </template>
                                <v-list>
                                  <v-list-item @click="type = 'day'">
                                    <v-list-item-title>Day</v-list-item-title>
                                  </v-list-item>
                                  <v-list-item @click="type = 'week'">
                                    <v-list-item-title>Week</v-list-item-title>
                                  </v-list-item>
                                  <v-list-item @click="type = 'month'">
                                    <v-list-item-title>Month</v-list-item-title>
                                  </v-list-item>
                                  <v-list-item @click="type = '4day'">
                                    <v-list-item-title>4 days</v-list-item-title>
                                  </v-list-item>
                                </v-list>
                              </v-menu> -->
                            </v-toolbar>
                          </v-sheet>
                          <v-sheet height="400">
                            <v-calendar
                              ref="calendar"
                              v-model="focus"
                              color="primary"
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
               

                            </v-calendar>
                            <v-menu
                              v-model="selectedOpen"
                              :close-on-content-click="false"
                              :activator="selectedElement"
                              full-width
                              offset-x
                            >
                              <v-card
                                color="grey lighten-4"
                                min-width="350px"
                                flat
                              >

                                <v-toolbar
                                  :color="selectedEvent.color"
                                  dark
                                >
                                  <v-btn icon>
                                    <v-icon>edit</v-icon>
                                  </v-btn>
                                  <v-toolbar-title v-html="selectedEvent.name"></v-toolbar-title>
                                  <v-spacer></v-spacer>
                                  <v-btn icon>
                                    <v-icon>favorite</v-icon>
                                  </v-btn>
                                  <v-btn icon>
                                    <v-icon>more_vert</v-icon>
                                  </v-btn>
                                </v-toolbar>

                                <v-card-text>
                                  <span v-html="selectedEvent.details"></span>
                                </v-card-text>
                                <v-card-actions>
                                  <v-btn
                                    text
                                    color="secondary"
                                    @click="selectedOpen = false"
                                  >
                                    Cancel
                                  </v-btn>
                                </v-card-actions>
                              </v-card>
                            </v-menu>
                          </v-sheet>
                        </v-flex>
                      </v-layout>
                    </template>






                </v-flex>
            </v-layout>    




        </v-card>


        <v-btn
          lass="mx-2" fab dark small color="primary"
          @click="e1 = 1"
        >
          <v-icon dark>arrow_back</v-icon>
        </v-btn>

        <v-btn
          lass="mx-2" fab dark small color="primary"
          @click="e1 = 3"
        >
          <v-icon dark>arrow_forward</v-icon>
        </v-btn>


      </v-stepper-content>

      <v-stepper-content step="3">
        <v-card
          class="mb-12"
          color="grey lighten-1"
          height="200px"
        ></v-card>


        <v-btn
          lass="mx-2" fab dark small color="primary"
          @click="e1 = 2"
        >
          <v-icon dark>arrow_back</v-icon>
        </v-btn>


      </v-stepper-content>
    </v-stepper-items>
  </v-stepper>
</template>

  </v-card>
  </v-dialog>
  </v-layout>


</template>



<style scoped>

</style>

<script>
  import SunCalc from 'suncalc';  
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
    e1: 0,
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
    equipment_desc: '',
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
      typeToLabel: {
        month: 'Month',
        week: 'Week',
        day: 'Day',
        '4day': '4 Days',
      },
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
      this.equipment_desc = a.description;
      this.equipment_image = a.image;
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
      let userId = document.head.querySelector('meta[name="userID"]');
      var reserv = {'user_id':4, 'equipment_id': this.equipment_id, 'date': this.start, 'hour': this.hourToReserv , 'points_out': this.telescope_points, 'current_points': this.$store.getters.current_points - this.telescope_points };


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


      
    },
    viewDay ({ date }) {
        this.focus = date
        this.type = 'day'
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




  },
  }
</script>