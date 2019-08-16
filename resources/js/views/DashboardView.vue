<template>
  <v-layout row>
    <v-flex xs8 class="px-2">
        <v-card class="py-4">
            <my-reservations></my-reservations>
            <v-layout>
                <v-flex xs1>
                </v-flex>
                <v-flex xs6>
                    <v-btn round color="morado"  dark @click="reservClick" >Reservar</v-btn> 
                </v-flex>
            </v-layout>            
        </v-card>
    </v-flex>  

    <v-flex xs4>
        <v-layout class="px-1">
            <v-flex xs12 class="px-1">
                <v-card>
                    <v-layout>
                        <v-flex xs1>
                        </v-flex>
                        <v-flex xs8 class="py-2">
                            <span class="subheading">Clima Actual</span>
                        </v-flex>
                    </v-layout>     
                    <v-layout>
                            <v-flex xs1 align-end flexbox>

                            </v-flex>
                            <v-flex xs4 align-end flexbox>
                                <v-img :src= "weather_image" ></v-img>
                            </v-flex>
                            <v-flex xs4 align-end flexbox>
                              <span style="color:#0BD8B5" class="subheading"> {{ weather["WeatherText"] }} {{weather["Temperature"]["Metric"]["Value"]}} º{{weather["Temperature"]["Metric"]["Unit"]}}</span>
                            </v-flex>
                      </v-layout>
                      <v-layout align-center row>
                            <v-flex xs5 align-end flexbox>
                            </v-flex>
                            <v-flex xs4 align-end flexbox>
                                <v-btn round color="verde"  href="https://www.accuweather.com/es/cl/san-pedro-de-atacama/57225/daily-weather-forecast/57225?day=0"  target="_blank">
                                    Ver Pronóstico    
                                </v-btn>
                            </v-flex>
                      </v-layout>   
                      <br>               
                </v-card>
            </v-flex>
        </v-layout>
        <br>
        <v-layout class="px-1">
            <v-flex xs12 class="px-1">
                <v-card class="py-1">
                    <v-layout>
                        <v-flex xs1 >
                        </v-flex>
                        <v-flex xs8 class="px-1">
                            <span class="subheading">Puntos</span>
                        </v-flex>
                    </v-layout>   
                    <v-layout class="px-1">
                        <v-flex xs4>
                        </v-flex>                  
                        <v-flex xs4 align-end flexbox>
                          <span style="color:#FFCC00"  class="display-3">{{ $store.getters.current_points }}</span>
                        </v-flex>
                    </v-layout>    
                    <v-layout class="px-1">
                        <v-flex xs5>
                        </v-flex> 
                        <v-flex xs4 align-end flexbox>
                            <div>
                                <v-btn round color="amarillo"  dark @click="pointsClick" >Comprar Puntos</v-btn>      
                            </div>
                        </v-flex>                      
                    </v-layout>
                    <br>
                </v-card>
            </v-flex>
        </v-layout>
    </v-flex>

    <v-flex xs12 class="px-2">
        <br>
        <v-card>
            <v-layout row wrap>
                <v-flex xs1>
                </v-flex>    
                <v-flex xs2>
                    <v-layout align-center row>
                        <v-flex align-center xs12 class="py-2">
                            <v-avatar
                                size="150px"
                            >
                                <img
                                  :src="$store.getters.user['avatar']"
                                  alt="Avatar"
                                >
                            </v-avatar>
                        </v-flex>
                    </v-layout>
                    <v-layout align-center row>
                        <v-flex xs1>
                        </v-flex> 
                    </v-layout>  
                    <v-layout align-center row>
                        <v-flex align-center xs1>
                            <upload-avatar></upload-avatar>
                        </v-flex>    
                        <v-flex align-center xs1>
                        </v-flex>
                        <v-flex align-center xs10>
                            <span class="body-2">{{ $store.getters.user['email'] }}</span>
                        </v-flex>  
                    </v-layout> 
                </v-flex>
                <v-flex xs1>
                  
                </v-flex>
                <v-flex xs7>
                    <v-card>
                        <v-card-title>
                            <span class="headline">Mis Sesiones</span>
                            <v-spacer></v-spacer>
                        </v-card-title>
                        <v-data-table
                            :headers="mySessionsHeaders"
                            :items="sessions"
                            :search="search"
                        >
                            <template v-slot:items="props">
                                <td>
                                    <v-img
                                        v-bind:src="props.item.img"
                                        aspect-ratio="1"
                                    ></v-img>
                                </td>

                                <td class="text-xs-left">{{ props.item.session_date }}</td>
                                <td class="text-xs-left">{{ props.item.session_hour }}</td>
                                <td class="text-xs-left">{{ props.item.img_count }}</td>
                                <td class="text-xs-left">{{ props.item.equipment_name }}</td>
                                <td class="text-xs-left"></td>
                            </template>
                        </v-data-table>
                    </v-card> 
                </v-flex>
            </v-layout>              
        </v-card>  
    </v-flex>
  
    <div ref="container">
    </div>
  </v-layout>
</template>

<script>
  import { mapState } from 'vuex';  
  import Vue from 'vue';  
  import PointsComponent      from './../components/PointsComponent';
  //import ReservationComponent from './../components/ReservationComponent';
  import ReservationComponent from './../components/ReservationWizard';


  export default {
    computed: mapState(['astronomc_objects', 'current_points', 'user']),
    data () {
      return {
        search: '',
        points: 500,
        current_user:'', 
        weather: '', 
        weather_image: '', 

        rowsPerPageItems: [3, 5, 10, 20],
        pagination: {
            rowsPerPage: 3
        },  

        headers: [
          { text: 'Equipo', value: 'equipment_image' },
          { text: 'Nombre', value: 'equipment_name' },
          { text: 'Fecha', value: 'reservation_date' },
          { text: 'Hora', value: 'reservation_hour' },
          { text: 'Tiempo Reservado', value: 'reservation_time' },
          { text: '', value:''}

        ],
        myImages: [],
        mySessionsHeaders: [
          { text: 'Foto', value: 'img' },
          { text: 'Fecha', value: 'session_date' },
          { text: 'Hora', value: 'session_hour' },
          { text: 'cantidad de fotos', value: 'img_count' },
          { text: 'Equipo', value: 'equipment_name' },
        ],
        reservations:[
            {
                equipment_image: require('./../../assets/images/sanpeter2.jpg'),
                equipment_name:'Equipo Principal',
                reservation_date:'01/05/2019',
                reservation_hour:'22:00',
                reservation_time:'2 Hours',
            }
        ],
        sessions:[
            {
                img: "https://cdn.shopify.com/s/files/1/1935/4371/products/12046_Advanced_VX_9_25_SCT_1_570x380@2x.jpg?v=1554219678",
                session_date: '26/04/2019',
                session_hour: '22:00',
                img_count: 10,
                equipment_name: 'Equipo Principal',
            }

        ]
      }
    },
    created () {
        this.initialize();
    },
    methods: {
        showAlert(a){
            //  if (event.target.classList.contains('btn__content')) return;
            var app = this;
            this.Ar = a.coord_ar;
            this.Dec = a.coord_dec;
            this.object = a.name;        
        },
        initialize () {
            var app= this;

            axios.get('/api/weather')
            .then(function (resp) {    
                app.weather =  resp.data[0]; 
                app.weather_image = "https://developer.accuweather.com/sites/default/files/0"+app.weather["WeatherIcon"]+"-s.png" ;              
            })
            .catch(function (resp) {
                console.log(resp);
                alert("Error accuweather :" + resp);
            });

        },
        pointsClick (){
            var ComponentPoints = Vue.extend(PointsComponent)
            var instance = new ComponentPoints({store: this.$store});
            instance.$mount();
            this.$refs.container.appendChild(instance.$el);
        },
        reservClick (){
            var ComponentReserv = Vue.extend(ReservationComponent)
            var instance = new ComponentReserv({store: this.$store});
            instance.$mount();
            this.$refs.container.appendChild(instance.$el);
        }

    },
  }
</script>