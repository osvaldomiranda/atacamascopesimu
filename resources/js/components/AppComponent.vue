<template>
  <v-app id="inspire">
    <v-toolbar
      :clipped-left="$vuetify.breakpoint.lgAndUp"
      app
      fixed
    >
      <v-toolbar-title style="width: 600px" class="ml-0 pl-3">
        <!-- <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon> -->
        <span class="hidden-md-and-down">Registro de Fuentes y Procesos</span>
           <v-spacer></v-spacer>
      </v-toolbar-title>

        <!-- <p>Empresa: {{$store.getters.company.name}}</p> -->
      <v-spacer></v-spacer>
      <v-toolbar-items class="hidden-sm-and-down">
        <v-btn :to="'/dasboard'" flat>Login</v-btn>
        <v-btn flat>Register</v-btn>
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
      astronomic_objects: null,      
    }),
    props: {
      source: String
    },
    computed: {
      token() {
        let token = document.head.querySelector('meta[name="csrf-token"]');
        return token.content
      }
    },
    created () {
      this.initialize()
    },
    methods: {
      initialize () {
         var app = this;
      },
    }
  }
</script>