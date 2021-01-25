<style>
	.my-span {
	  	background-color: transparent;
	  	color: white;
	    position: absolute;
	    width: 100%;
	    bottom: 0;
	    text-align: center;
	}
</style>
<template>
  <v-layout>
  	<loading ref="Loading"></loading> 
    <v-dialog v-model="dialog"  hide-overlay transition="dialog-bottom-transition">
<!--       <template v-slot:activator="{ on }">
        <v-btn color="warning" dark v-on="on">Interfaz de Control</v-btn>
      </template> -->
      <v-card color="backgraundColor" >
        <v-toolbar dark color="morado">
          <v-btn icon dark @click="dialog = false">
            <v-icon>close</v-icon>
          </v-btn>
          <v-toolbar-title>{{ $vuetify.t('$vuetify.guide.title') }}</v-toolbar-title>
          <v-spacer></v-spacer>
        </v-toolbar>


            <v-card class="py-4 px-2">
                <v-layout>
                  <v-flex xs1 class="px-2">
                  <v-img src="http://atacamascope.cl/images/english.png" 
                  aspect-ratio="1.4"  
                  max-height="22"
                                max-width="33"
                                v-on:click="changeLocaleEn" 
                  ></v-img>
              </v-flex>
                  <v-flex xs1 class="px-2">
                 <v-img src="http://atacamascope.cl/images/spanish.png" 
                 aspect-ratio="1.4"  
                   max-height="22"
                                 max-width="33"
                                 v-on:click="changeLocaleEs" 
                  ></v-img>
              </v-flex>
            </v-layout>
          </v-card>

    <v-layout>
      <v-flex xs12 class="px-2 py-4">
        <h3>{{ $vuetify.t('$vuetify.guide.derechos1') }} </h3>
        <p>{{ $vuetify.t('$vuetify.guide.derechos2') }} </p>
      </v-flex>

    </v-layout>

		<v-layout>
			<v-flex xs4 class="px-2 py-4">
        <v-img
          lazy-src="https://drive.google.com/uc?id=1cEjqlX3u_eb7v0cE2LHNEdwa0bHbpwT2&export=download"
          max-height="300"
          max-width="300"
          src="https://drive.google.com/uc?id=1cEjqlX3u_eb7v0cE2LHNEdwa0bHbpwT2&export=download"
        ></v-img>
			</v-flex>
      <v-flex xs4 class="px-2 py-4">
        <h2>1.-</h2><h3>{{ $vuetify.t('$vuetify.guide.busca1') }}  </h3>
        <p>{{ $vuetify.t('$vuetify.guide.busca2') }} </p>
      </v-flex>

		</v-layout>
    <v-layout>
      <v-flex xs4 class="px-2 py-4">
        <v-img
    
          lazy-src="https://drive.google.com/uc?id=1dDIm9YZz-z5Di8g3UgT1fLYuCSBP767J&export=download"
          max-height="300"
          max-width="300"
          src="https://drive.google.com/uc?id=1dDIm9YZz-z5Di8g3UgT1fLYuCSBP767J&export=download"
        ></v-img>
      </v-flex>
      <v-flex xs4 class="px-2 py-4">
        <h2>2.-</h2><h3>{{ $vuetify.t('$vuetify.guide.mueve1') }} </h3>
        <p>{{ $vuetify.t('$vuetify.guide.mueve2') }} </p>
      </v-flex>

    </v-layout>


    <v-layout>
      <v-flex xs4 class="px-2 py-4">
        <v-img
          lazy-src="https://drive.google.com/uc?id=1WCc6lE93c8nK-yeWkr7PkyCFzcCCRh9N&export=download"
          max-height="300"
          max-width="300"
          src="https://drive.google.com/uc?id=1WCc6lE93c8nK-yeWkr7PkyCFzcCCRh9N&export=download"
        ></v-img>
      </v-flex>
      <v-flex xs4 class="px-2 py-4">
        <h2>3.-</h2><h3>{{ $vuetify.t('$vuetify.guide.obten1') }} </h3>
        <p>{{ $vuetify.t('$vuetify.guide.obten2') }} </p>
      </v-flex>

    </v-layout>


	  </v-card>
	</v-dialog>
</v-layout>



</template>

<script>
  import { mapState } from 'vuex';
  import Vue from 'vue';  


  export default {
    data () {
      return {

        dialog: true,
      }
    },
    created () {
      	
    },
    mounted (){
    	

    },

    methods: {
      changeLocaleEn () {
            this.$vuetify.lang.current = 'en'         
      },

      changeLocaleEs () {
          this.$vuetify.lang.current = 'es'         
      }
    }

    		 

      	
    
  }
</script>