<template>       

<v-container>

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

  <v-layout row>

            <v-flex xs6 class="px-1 py-4">
                <v-card >
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
                    <br>
                    <br>
                    <br>
                </v-card>
            </v-flex>

            <v-flex xs6 class="px-1 py-4">
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
   
    <v-layout row>
    <v-flex xs12 class="px-2 py-4">
                      <v-card>
                        <v-card-title>
                          <span class="headline">Mis fotos</span>
                        </v-card-title>
                        <v-data-table
                          :headers="myImagesHeaders"
                          :items="myImages"
                        >
                          <template v-slot:items="props">
                            <td>
                                <a class="px-2 py-2" :href="props.item.path" target="_blank">
                                    <v-img
                                        v-bind:src="props.item.path"
                                        aspect-ratio="1"
                                    ></v-img>
                                </a>
                            </td>
                            <td class="text-xs-left">{{ props.item.object_name }}</td>
                            <td class="text-xs-left">{{ props.item.iso_string }}</td>
                            <td class="text-xs-left">{{ props.item.exptime }}s</td>
                            <td class="text-xs-left">{{ props.item.ar_string }}</td>
                            <td class="text-xs-left">{{ props.item.dec_string }}</td>
                            <td class="text-xs-left">{{ props.item.created_at }}</td>
                            <td>
                                <v-btn round color="morado" small class="white--text"  @click="download">
                                  <v-icon>cloud_download</v-icon>
                                  Imagen Raw
                                </v-btn>
                            </td>
                          </template>
                          
                        </v-data-table>
                      </v-card> 
    </v-flex>
    </v-layout>



    <div ref="container">
    </div>

  </v-container>
</template>

<script>
  import { mapState } from 'vuex';  
  import Vue from 'vue';  
  import PointsComponent      from './../components/PointsComponent';
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
        myImagesHeaders: [
          { text: 'Foto', value: 'img' },
          { text: 'Nombre', value: 'name' },
          { text: 'ISO', value: 'iso' },
          { text: 'TiempoExp', value: 'exptime' },
          { text: 'Coord AR', value: 'ar' },
          { text: 'Coord DEC', value: 'dec' },
          { text: 'Fecha', value: 'created_at' }
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

            this.getMyImages();

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
        },

        getMyImages(){
            let app = this;
            axios.get('/api/images')
            .then(function (resp) {
                app.myImages = resp.data;               
            })
            .catch(function (resp) {
                console.log(resp);
                alert("Error shoot :" + resp);
            });
        },

        download(){
            alert('Estamos subiendo la imagen al servidor, estará disponible dentro de las proximas horas');
        }

    },
  }
</script>