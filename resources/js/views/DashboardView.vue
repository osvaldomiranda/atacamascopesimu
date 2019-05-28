<template>
  <v-layout row justify-center>

  <v-flex xs12>
    <v-card>

    <v-container fluid>
      <v-layout align-center row>
<!-- <passport-clients></passport-clients>
<passport-authorized-clients></passport-authorized-clients>
<passport-personal-access-tokens></passport-personal-access-tokens> -->
        </v-layout>
        <v-layout align-center row>
        <v-flex xs12>
            <v-container  fluid>
                    <v-layout >
                        <v-flex xs4 align-end flexbox>
                          <span class="headline"> Puntos Disponibles:{{ $store.getters.current_points }}</span>
                        </v-flex>
                        <v-flex xs8 align-end flexbox>
                            <div>
                                <points-component></points-component>
                                <reservation-component></reservation-component>
                                
                            </div>
                        </v-flex>

                    </v-layout>
                </v-container>
        </v-flex>
      </v-layout>
    </v-container>  

     <v-container fluid>

        <v-layout align-center row>

          <my-reservations></my-reservations>  
                  
        </v-layout>
    </v-container>    
  


     <v-container fluid>
        <v-layout align-center row>
        <v-flex xs12 style="overflow: auto">

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
    </v-container>


      </v-card>
    </v-flex>  

  </v-layout>
</template>

<script>
  import { mapState } from 'vuex';
  export default {
    computed: mapState(['astronomc_objects', 'current_points']),
    data () {
      return {
        search: '',
        points: 500,
        current_user:'',  

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
                equipment_image:'',
                equipment_name:'Equipo Principal',
                reservation_date:'01/05/2019',
                reservation_hour:'22:00',
                reservation_time:'2 Hours',
            }
        ],
        sessions:[
            {
                img: '',
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

        },

      openChat () {
          let app = this

            // Start pusher listener
          Pusher.logToConsole = true

          var pusher = new Pusher('e6e9d9fd854d385c5f5b', {
              cluster: 'us2',
              forceTLS: true
          })

          var channel = pusher.subscribe('newMessage-' + 1 + '-' + 2) // newMessage-[chatting-with-who]-[my-id]

          channel.bind('App\\Events\\MessageSent', function (data) {
              
              app.state = data.message['message'];

              if (app.state=="Imagen Recibida"){

                app.imageRefresh();
              }
              
          })
            // End pusher listener

          
       },


        filter(a){
          if(a=="Todos"){
            this.FilteredObjects = this.astronomic_objects
          } else {
            this.FilteredObjects = this.astronomic_objects.filter(it => it.catalog==a );  
          }
        },
        filterConstellation(a){
          if(a=="Todos"){
            this.FilteredObjects = this.astronomic_objects
          } else {
            this.FilteredObjects = this.astronomic_objects.filter(it => it.constellation==a );  
          }
        },
        move(){
          var $command = {'command': 'MONTURA', 'type': 'mount', 'status': 'PENDIENTE',
                          'ar': this.Ar, 'dec': this.Dec, 'user_id': 1, 'equipment_id': 1};

          alert(JSON.stringify($command));
          axios.post('/api/command/move', $command)
            .then(function (resp) {
                
            })
            .catch(function (resp) {
                console.log(resp);
                alert("Error move :" + resp);
            });

            this.currentRefresh();
        },
        shoot(){
          var $command = {'command': 'CAMARA', 'type': 'shoot', 'status': 'PENDIENTE',
                          'exptime': this.Exp, 'iso': this.Iso, 'ar': this.Ar_act, 'dec': this.Dec_act, 'user_id': 1, 'equipment_id': 1};

          this.imageUrl = '';
          axios.post('/api/command/shoot', $command)
            .then(function (resp) {    
            })
            .catch(function (resp) {
                console.log(resp);
                alert("Error shoot :" + resp);
            });

            this.currentRefresh();
            this.current_shot=this.current;
        },
        currentRefresh(){
        
          this.Ar_act = this.Ar;
          this.Dec_act= this.Dec;
          this.Iso_act= this.Iso;
          this.Exp_act= this.Exp;

          this.current = "Ar:" + this.Ar_act + ", Dec:"+ this.Dec_act + ", Iso:"+this.Iso_act+", Exp:"+this.Exp_act;
        },
        focus(){
          var $command = {'command': 'ENFOCADOR', 'type': 'focuser', 'status': 'PENDIENTE',
                          'ar': this.Ar, 'dec': this.Dec, 'user_id': 1, 'equipment_id': 1};

          alert(JSON.stringify($command));

          axios.post('/api/command/focus', $command)
            .then(function (resp) {
                
            })
            .catch(function (resp) {
                console.log(resp);
                alert("Error focus :" + resp);
            });
        },
        saveImage(){

        },

        imageRefresh(){
          let app = this;
          var $command = {'user_id':1}
          axios.get('/api/image/last', $command)
            .then(function (resp) {
              app.imageUrl = resp.data;                
            })
            .catch(function (resp) {
                console.log(resp);
                alert("Error shoot :" + resp);
            });
            app.getMyImages();
        },

        getMyImages(){
          let app = this;
          var $command = {'user_id':1}
          axios.get('/api/images', $command)
            .then(function (resp) {
              app.myImages = resp.data;               
            })
            .catch(function (resp) {
                console.log(resp);
                alert("Error shoot :" + resp);
            });
        }

    },
  }
</script>