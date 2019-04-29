<template>
  <v-layout>
    <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
      <template v-slot:activator="{ on }">
        <v-btn color="warning" dark v-on="on">Comprar Puntos</v-btn>
      </template>
      <v-card>
        <v-toolbar dark color="primary">
          <v-btn icon dark @click="dialog = false">
            <v-icon>close</v-icon>
          </v-btn>
          <v-toolbar-title>Puntos</v-toolbar-title>
          <v-spacer></v-spacer>
        </v-toolbar>

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
				              		<p>Actual: {{current}}</p>
				          		</v-flex>
				            </v-layout>
				        </v-container>
				    </v-card>
				</v-flex>
			</v-layout>
		</v-container>	

		 <v-container fluid>

		    <v-layout align-center row>

				<v-flex xs1>
				</v-flex>

				<v-flex xs7 style="overflow: auto">

					  <v-card>
					    <v-card-title>
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
        imageUrl: '',

        Catalog:'Todos',
        Catalogs: ['Todos','SolarSistem','Messier','NGC', 'IC'],

        Constellation:'',
        Constellations: [],
        FilteredObjects: [],

        Ar: 1.92837,
        Dec: 1.92837,
        Iso: '100',
        Exp: '1',

        Ar_act:0,
        Dec_act:0,
        Iso_act:0,
        Exp_act:0,
        current:'',
        current_shot:'',	

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
	        '1',
	        '2',
	        '4',
	        '6',
	        '8',
	        '1',
	        '2',
	        '3',
	    ],

        headers: [
          { text: 'Nombre', value: 'name' },
          { text: 'Catalogo', value: 'catalog' },
          { text: 'Tipo', value: 'type_object' },
          { text: 'Constelación', value: 'constellation' },
          { text: 'AR', value: 'ra' },
          { text: 'DEC', value: 'dec' }
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
      }
    },
    created () {
      	this.initialize();
    },
    methods: {
    	showAlert(a){
      	//	if (event.target.classList.contains('btn__content')) return;
      		var app = this;
      		this.Ar = a.coord_ar;
      		this.Dec = a.coord_dec;
      		this.object = a.name;
      		if(a.catalog=='SolarSistem'){
	      		axios.get('/api/astronomic_objects/solarsistem?object=' + a.name)
	            .then(function (resp) {    
	            	//alert(JSON.stringify(resp.data));
	            	app.Ar = resp.data["ar"];
	            	app.Dec = resp.data["dec"];
	            })
	            .catch(function (resp) {
	                console.log(resp);
	                alert("Error shoot :" + resp);
	            });
      		}      		
    	},
      	initialize () {
         	var app = this;
         	// app.astronomic_objects = this.$store.getters.astronomic_objects;


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