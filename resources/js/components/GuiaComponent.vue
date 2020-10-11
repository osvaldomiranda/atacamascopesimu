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
          <v-toolbar-title>Guia Simulador Interfaz de Control</v-toolbar-title>
          <v-spacer></v-spacer>
        </v-toolbar>


    <v-layout>
      <v-flex xs12 class="px-2 py-4">
        <h3>Las imagenes de este simulador han sido fotografiadas con los sistemas y equipos de Atacama Scope </h3>
        <p>Todos los derechos reservados</p>
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
        <h2>1.-</h2><h3>Busca y elige tu objeto astronómico </h3>
        <p>Selecciona la constelación de tu interes y el tipo de objeto astronómico, un algoritmo de validación te indicará si el objeto es visible por nuestro telescopio, y pasará las coordenadas para que puedas mover el telescópio.</p>
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
        <h2>2.-</h2><h3>Mueve el telescopio hasta las coordenadas del objeto</h3>
        <p>Cuando pinches en el botón mover, se enviará el comando de control al telescopio, para que este se mueva a la posición en la que se encuentra el objeto astronómico elejido</p>
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
        <h2>3.-</h2><h3>Obten tu fotografía</h3>
        <p>Selecciona la sensibilidad y el tiempo de exposición que deseas para tu fotografía y dispara.</p>
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
    }

    		 

      	
    
  }
</script>