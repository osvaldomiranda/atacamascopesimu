<template>
  <v-layout row justify-center>
    <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
      <template v-slot:activator="{ on }">
        <v-btn color="primary" dark v-on="on">Interfaz de Control</v-btn>
      </template>
      <v-card>
        <v-toolbar dark color="primary">
          <v-btn icon dark @click="dialog = false">
            <v-icon>close</v-icon>
          </v-btn>
          <v-toolbar-title>Interfaz de Control</v-toolbar-title>
          <v-spacer></v-spacer>
        </v-toolbar>


		 <v-container fluid>
		    <v-layout align-center row>
				<v-flex xs2>
					<v-layout align-center row>
						<v-flex xs12>	
					    	<v-card>
					      		<v-img
					      	  		src="https://cdn.vuetifyjs.com/images/cards/desert.jpg"
					      	  		aspect-ratio="1"
					      		></v-img>
					    	</v-card> 
					    </v-flex>
					</v-layout>   
					<v-layout align-center row>
						<v-flex xs12>
							<p>Iso: 1200, Exp: 2min, Objeto: M87</p> 	
						</v-flex>
					</v-layout>	
		      	</v-flex>

				<v-flex xs1>
				</v-flex>

				<v-flex xs8 style="overflow: auto">

					  <v-card>
					    <v-card-title>
					        <v-select
							    v-model="Catalog"
							    :items="Catalogs"
							    @input= "filter"
							    label="Catalogo"
							    single-line
						        hide-details
							    ></v-select>
					        <v-spacer></v-spacer>
						    <v-select
							    v-model="Constellation"
							    :items="Constellations"
							    label="Constelación"
							    single-line
						        hide-details
							    ></v-select>
							<v-spacer></v-spacer>    	
						      <v-text-field
						        v-model="search"
						        append-icon="search"
						        label="Buscar"
						        single-line
						        hide-details
						      ></v-text-field>
					    </v-card-title>
					    <v-data-table
					      :headers="headers"
					      :items="FilteredObjects"
					      :search="search"
					      v-model="selected"
					      :rows-per-page-items="rowsPerPageItems"
    					  :pagination.sync="pagination"
					    >
					      <template v-slot:items="props">
					      	<tr @click="showAlert(props.item)">
						        <td class="text-xs-right">{{ props.item.name }}</td>
						        <td class="text-xs-right">{{ props.item.catalog }}</td>
						        <td class="text-xs-right">{{ props.item.type_object }}</td>
						        <td class="text-xs-right">{{ props.item.constellation }}</td>
						        <td class="text-xs-right">{{ props.item.ra }}</td>
						        <td class="text-xs-right">{{ props.item.dec }}</td>
					    	</tr>
					      </template>
					      <v-alert v-slot:no-results :value="true" color="error" icon="warning">
					        Your search for "{{ search }}" found no results.
					      </v-alert>
					    </v-data-table>
					  </v-card>	
		      	</v-flex>
		    </v-layout>
		</v-container>    
		<v-container fluid>
		    <v-layout align-center row>
				<v-flex xs12>
					<v-card>
						<v-container  fluid>
				            <v-layout >
				              	<v-flex xs4 align-end flexbox>
				                	<span class="headline"> Objeto:{{ object }}</span>
				              	</v-flex>
				              	<v-flex xs4 align-end flexbox>
				                	<span class="headline"> Estado:{{ state }}</span>
				              	</v-flex>
				              	<v-flex xs4 align-end flexbox>
				              		<v-btn  small color="warning" @click="saveImage" >Guardar Imagen</v-btn>
				          		</v-flex>
				            </v-layout>
				        </v-container>
				    </v-card>
				</v-flex>
			</v-layout>
		</v-container>		        

		<v-container fluid>
		    <v-layout align-center row>
				<v-flex xs4>
					<v-card>
						<v-container fill-height fluid>
				            <v-layout fill-height>
				              <v-flex xs12 align-end flexbox>
				                <span class="headline">Montura</span>
				              </v-flex>
				            </v-layout>
				        </v-container>
						<v-layout align-center row>
							<v-flex align-center xs4>
								<v-text-field
								    v-model="Ar"
								        label="Asención Recta"
								    ></v-text-field>
		          			</v-flex>
							<v-flex align-center xs4>
								<v-text-field
								    v-model="Dec"
								        label="Declinación"
								    ></v-text-field>
		          			</v-flex>
		          		</v-layout>	

		          		<v-btn color="warning" @click="move()">Mover</v-btn>

 
			    	</v-card> 
				</v-flex>
				<v-flex xs4>
					<v-card>
						<v-container fill-height fluid>
				            <v-layout fill-height>
				              <v-flex xs12 align-end flexbox>
				                <span class="headline">Camara</span>
				              </v-flex>
				            </v-layout>
				        </v-container>

						<v-layout align-center row>
							<v-flex align-center xs4>
							
							    <v-select
							      v-model="Iso"
							      :items="Isos"
							      :rules="[v => !!v || 'Obligatorio']"
							      label="Sencibilidad"
							      required
							    ></v-select>

		          			</v-flex>


							<v-flex align-center xs4>


							    <v-select
							      v-model="Exp"
							      :items="Exps"
							      :rules="[v => !!v || 'Obligatorio']"
							      label="Tiempo Exposición"
							      required
							    ></v-select>


		          			</v-flex>
		          		</v-layout>	
		          		<v-btn color="warning" @click="shoot()">Disparar</v-btn>
			    	</v-card> 
				</v-flex>

				<v-flex xs4>
					<v-card>
						<v-container fill-height fluid>
				            <v-layout fill-height>
				              <v-flex xs12 align-end flexbox>
				                <span class="headline">Enfocador</span>
				              </v-flex>
				            </v-layout>
				        </v-container>

						<v-layout align-center row>
							<v-flex align-center xs4>
							
							    <v-select
							      v-model="Paso"
							      :items="Pasos"
							      :rules="[v => !!v || 'Obligatorio']"
							      label="Pasos"
							      required
							    ></v-select>

		          			</v-flex>


							<v-flex align-center xs4>


							    <v-select
							      v-model="Dir"
							      :items="Dirs"
							      :rules="[v => !!v || 'Obligatorio']"
							      label="Dirección"
							      required
							    ></v-select>


		          			</v-flex>
		          		</v-layout>	
		          		<v-btn color="warning" @click="focus">Enfocar</v-btn>
			    	</v-card> 
				</v-flex>

			</v-layout>
		</v-container>	



		 <v-container fluid>
		    <v-layout align-center row>
				<v-flex xs8 style="overflow: auto">

					  <v-card>
					    <v-card-title>
					      Mis fotos
					      <v-spacer></v-spacer>
					    </v-card-title>
					    <v-data-table
					      :headers="headers"
					      :items="desserts"
					      :search="search"
					    >
					      <template v-slot:items="props">
					        <td>
					        	<v-img
			      	  				src="https://cdn.vuetifyjs.com/images/cards/desert.jpg"
			      	  				aspect-ratio="1"
			      				></v-img>
					        </td>

					        <td class="text-xs-right">{{ props.item.calories }}</td>
	
					      </template>
					    </v-data-table>
					  </v-card>	
		      	</v-flex>

		    </v-layout>
		</v-container>


      </v-card>


    </v-dialog>
  </v-layout>
</template>

<script>
  import { mapState } from 'vuex';
  export default {
  	computed: mapState(['astronomc_objects']),
    data () {
      return {
        dialog: false,
        astronomic_objects:[],
        selected:[],
        search: '',

        Catalog:'Todos',
        Catalogs: ['Todos','SolarSistem','Messier','NGC', 'IC'],

        Constellation:'',
        Constellation: [],

        Ar: 1.92837,
        Dec: 1.92837,
        Iso: '100',
        Exp: '1',
        rowsPerPageItems: [3, 5, 10, 20],
		pagination: {
    		rowsPerPage: 3
		},	

		object:'Seleccione Objeto',
		state:'En espera',
		Paso:'100',
		Dir:'Adentro',
	    Pasos: [
	        '100',
	        '200',
	        '400',
	        '600',
	        '800',
	        '1000',
	        '2000',
	        '3000',
	    ],

	    Dirs: [
	        'Adentro',
	        'Afuera',
	    ],

	    Isos: [
	        '100',
	        '200',
	        '400',
	        '600',
	        '800',
	        '1000',
	        '2000',
	        '3000',
	    ],
	    Exps: [
	        '1s',
	        '2s',
	        '4s',
	        '6s',
	        '8s',
	        '1m',
	        '2m',
	        '3m',
	    ],

        headers: [
          { text: 'Nombre', value: 'name' },
          { text: 'Catalogo', value: 'catalog' },
          { text: 'Tipo', value: 'type_object' },
          { text: 'Constelación', value: 'constellation' },
          { text: 'AR', value: 'ra' },
          { text: 'DEC', value: 'dec' }
        ],
        desserts: [
          {
            name: 'Frozen Yogurt',
            calories: 159,
            fat: 6.0,
            carbs: 24,
            protein: 4.0,
            iron: '1%'
          },
          {
            name: 'Ice cream sandwich',
            calories: 237,
            fat: 9.0,
            carbs: 37,
            protein: 4.3,
            iron: '1%'
          },
        ]
      }
    },
    created () {
      	this.initialize();
    },
    methods: {
    	showAlert(a){
      	//	if (event.target.classList.contains('btn__content')) return;
      		this.Ar = a.coord_ar;
      		this.Dec = a.coord_dec;
      		this.object = a.name;
    	},
      	initialize () {
         	var app = this;
         	// app.astronomic_objects = this.$store.getters.astronomic_objects;

          axios.get('/api/astronomic_objects')
            .then(function (resp) {
              app.astronomic_objects = resp.data;
              app.filter('Todos');
              app.$store.commit('changeAstronomicObjects', app.astronomic_objects);
            })
            .catch(function (resp) {
                console.log(resp);
                alert("Error astronomic_objects :" + resp);
            });

            app.openChat();
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
        },
        shoot(){
        	var $command = {'command': 'CAMARA', 'type': 'shoot', 'status': 'PENDIENTE',
        	                'exptime': this.Exp, 'iso': this.Iso, 'user_id': 1, 'equipment_id': 1};

        	alert(JSON.stringify($command));

        	axios.post('/api/command/shoot', $command)
            .then(function (resp) {
                
            })
            .catch(function (resp) {
                console.log(resp);
                alert("Error shoot :" + resp);
            });
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

        }

    },
  }
</script>


