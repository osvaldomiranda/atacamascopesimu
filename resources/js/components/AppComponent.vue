<template>
  <v-app id="inspire">
    <v-toolbar
      :clipped-left="$vuetify.breakpoint.lgAndUp"
      app
      fixed
    >
      <v-toolbar-title style="width: 600px" class="ml-0 pl-3">
        <span class="hidden-md-and-down">AtacamaScaope</span>
           <v-spacer></v-spacer>
      </v-toolbar-title>

      <v-spacer></v-spacer>
      <v-toolbar-items class="hidden-sm-and-down">
        <!-- <v-btn :to="'/dasboard'" flat>dashboard</v-btn> -->
        <v-btn flat @click="logout">logout</v-btn>
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