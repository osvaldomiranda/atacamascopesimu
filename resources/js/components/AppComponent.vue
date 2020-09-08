<template>




  
  <v-app id="inspire" dark style="
    background: #0e1820;

  ">
    <v-toolbar
      :clipped-left="$vuetify.breakpoint.lgAndUp"
      app
      fixed
    >
      <v-toolbar-title style="width: 600px" class="ml-0 pl-3">
        <span class="hidden-md-and-down">AtacamaScope</span>
           <v-spacer></v-spacer>
      </v-toolbar-title>

      <v-spacer></v-spacer>
      <v-toolbar-items class="hidden-sm-and-down">
        <v-btn :to="'/dashboard'" flat>DashBoard</v-btn> 
        <v-btn :to="'/equipment'" flat>Equipos</v-btn> 
        <v-btn :to="'/offers'" flat>Ofertas</v-btn> 
        <v-btn :to="'/publications'" flat>Publicaciones</v-btn>
        <!-- <v-btn :to="'/admincontrol'" flat>Control</v-btn> -->



        <v-btn v-if="$store.getters.user['role']==1" :to="'/statistics'" flat>Estadísticas</v-btn> 
        <v-btn v-if="$store.getters.user['role']==1" :to="'/users'" flat>Usuarios</v-btn>  

        <v-btn flat @click="logout">logout</v-btn>
      
      <v-spacer></v-spacer>
      <v-btn icon @click="toRoute('/myself')">
        <v-avatar  size="34px">
                <img
                    :src="$store.getters.user['avatar']"
                        alt="Avatar"
                >
        </v-avatar>
      </v-btn> 



      </v-toolbar-items>       
    </v-toolbar>


    <v-content>
      <v-container fluid>
       <!-- COntenido -->
        <div class="container">
            <router-view></router-view>
        </div>

      </v-container>
    </v-content>

  
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