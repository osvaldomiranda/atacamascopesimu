
<template>
  <v-app id="inspire" dark >


    <!-- <v-content v-if="this.$store.getters.token != ''"> -->
    <v-navigation-drawer
      v-model="drawer"
      app
      width="110"
      
    >
  
      <v-list class="py-4">

        <v-list-tile ripple @click="toRoute('/dashboard')" class="py-2">
          <v-flex x12 class="ma-0 px-0 py-3 text-xs-center">
              <v-tooltip right>
                <template v-slot:activator="{ on }">
                  <v-icon x-large v-on="on">home</v-icon>
                </template>
                <span>Dashboard</span>
              </v-tooltip>
          </v-flex>
        </v-list-tile>

        <v-list-tile ripple @click="toRoute('/reservations')"  class="py-2">
          <v-flex x12 class="ma-0 px-0 py-3 text-xs-center">
              <v-tooltip right>
                <template v-slot:activator="{ on }">
                  <v-icon x-large v-on="on">alarm</v-icon>
                </template>
                <span>Reservas</span>
              </v-tooltip>
          </v-flex>
        </v-list-tile>

        <v-list-tile ripple @click="toRoute('/points')" class="py-2">
          <v-flex x12 class="ma-0 px-0 py-3 text-xs-center">
              <v-tooltip right>
                <template v-slot:activator="{ on }">
                  <v-icon x-large v-on="on">local_atm</v-icon>
                </template>
                <span>Puntos / Pagos</span>
              </v-tooltip>
          </v-flex>
        </v-list-tile>

        <v-list-tile ripple @click="toRoute('/publications')" class="py-2">
          <v-flex x12 class="ma-0 px-0 py-3 text-xs-center">
              <v-tooltip right>
                <template v-slot:activator="{ on }">
                  <v-icon x-large v-on="on">local_library</v-icon>
                </template>
                <span>Noticias</span>
              </v-tooltip>
          </v-flex>
        </v-list-tile>

        <v-list-tile ripple @click="toRoute('/gallery')" class="py-2">
          <v-flex x12 class="ma-0 px-0 py-3 text-xs-center">
              <v-tooltip right>
                <template v-slot:activator="{ on }">
                  <v-icon x-large v-on="on">insert_photo</v-icon>
                </template>
                <span>Galería</span>
              </v-tooltip>
          </v-flex>
        </v-list-tile>

        <v-list-tile ripple @click="toRoute('/weather')" class="py-2">
          <v-flex x12 class="ma-0 px-0 py-3 text-xs-center">
              <v-tooltip right>
                <template v-slot:activator="{ on }">
                  <v-icon x-large v-on="on">cloud</v-icon>
                </template>
                <span>Clima</span>
              </v-tooltip>
          </v-flex>
        </v-list-tile>

        <v-list-tile ripple @click="toRoute('/contacts')" class="py-2">
          <v-flex x12 class="ma-0 px-0 py-3 text-xs-center">
              <v-tooltip right>
                <template v-slot:activator="{ on }">
                  <v-icon x-large v-on="on">contact_mail</v-icon>
                </template>
                <span>Contacto</span>
              </v-tooltip>
          </v-flex>
        </v-list-tile> 

        <v-list-tile ripple @click="toRoute('/legal')" class="py-2">
          <v-flex x12 class="ma-0 px-0 py-3 text-xs-center">
              <v-tooltip right>
                <template v-slot:activator="{ on }">
                  <v-icon x-large v-on="on">gavel</v-icon>
                </template>
                <span>Legal</span>
              </v-tooltip>
          </v-flex>
        </v-list-tile>       


      </v-list>
    </v-navigation-drawer>

  <v-toolbar app dark color="#0e1820">
    <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
    <v-toolbar-title>
      Atacama Scope
    </v-toolbar-title>
    <v-spacer></v-spacer>
      <v-btn icon @click="toRoute('/myself')">
        <v-icon>account</v-icon>
      </v-btn>
  </v-toolbar>

    <v-content style="background: #0e1820">
            <router-view></router-view>
    </v-content>

<!--   </v-content>
  <v-content v-else>
    <h2>acá el otro componente {{this.$store.getters.token}}</h2>
  </v-content> -->


  </v-app>
</template>


 

<script>
  export default {
    data: () => ({
      dialog: false,
      drawer: null,
      step:"",
      points_in:0,
      points_out:0,
      userId:0,
      astronomic_objects: null, 
     
    }),
    props: {
      source: String
    },
    computed: {
      

    },
    created () {
      
    },
    mounted(){
      this.initialize()
    },
    methods: {
      initialize () {

        var app = this;

        axios.get('/api/currentuser')
            .then(function (resp) {    
                //alert(JSON.stringify(resp.data));
                app.$store.commit('changeUser',resp.data);
            })
            .catch(function (resp) {
                console.log(resp);
                alert("Error user :" + resp);
            });

        axios.get('/api/equipments')
            .then(function (resp) {    
                //alert(JSON.stringify(resp.data));
                app.$store.commit('changeEquipments',resp.data);
            })
            .catch(function (resp) {
                console.log(resp);
                alert("Error equipments :" + resp);
            });

        axios.get('/api/reservations')
            .then(function (resp) {    
                //alert(JSON.stringify(resp.data));
               app.$store.commit('changeReservations',resp.data);
            })
            .catch(function (resp) {
                console.log(resp);
                alert("Error reservations :" + resp);
            });


        axios.get('/api/points')
            .then(function (resp) {   
                for(var i in resp.data){
                     app.points_in += parseInt(resp.data[i].in,10);
                     app.points_out += parseInt(resp.data[i].out,10);
                 }
                 let c_points = (app.points_in || 0) - (app.points_out || 0);
                 app.$store.commit('changeCurrentPoints',c_points );
            })
            .catch(function (resp) {
                console.log(resp);
                alert("Error Points :" + resp);
            });

            this.$router.push('/dashboard');

      },

      toRoute(to){
         this.$router.push(to);
      },

      logout(){
            axios.post('/logout')
            .then(function (resp) {
                document.location.href = "/";
            })
            .catch(function (resp) {
                console.log(resp);
                alert("Error focus :" + resp);
            });
      }
    }
  }
</script>