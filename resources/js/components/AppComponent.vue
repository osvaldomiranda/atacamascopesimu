
<template>
  <v-app id="inspire" dark >





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


            this.$router.push('/controlsimple');

      },

      toRoute(to){
         this.$router.push(to);
      },


    }
  }
</script>