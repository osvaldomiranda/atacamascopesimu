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
    <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
<!--       <template v-slot:activator="{ on }">
        <v-btn color="warning" dark v-on="on">Interfaz de Control</v-btn>
      </template> -->
      <v-card color="backgraundColor" >
        <v-toolbar dark color="rojo">
          <v-btn icon dark @click="returnToAtacamaScope()">
            <v-icon>close</v-icon>
          </v-btn>
          <v-toolbar-title>{{ $vuetify.t('$vuetify.control.title') }}</v-toolbar-title>
          <v-spacer></v-spacer>
        </v-toolbar>


		    <v-layout class="py-2">
				<v-flex xs8 class="px-2" style="overflow: auto">




					  <v-card class="py-4 px-2">
				        <v-layout>
				          <v-flex xs4 class="px-2">
				            <span v-if='object.name' class="headline">1.- {{ object.name }}</span>
				            <span v-else class="headline">1.- {{ $vuetify.t('$vuetify.control.Seleccione un Objeto') }}</span>
				          </v-flex>
				          	<v-flex xs8 class="px-2">
				            	<span class="headline"> {{ $vuetify.t('$vuetify.control.Estado Sistema') }}:{{ state }}</span>
				          	</v-flex>
				        </v-layout>
					    <v-card-title>
						    <v-select
							    v-model="Constellation"
							    :items="Constellations"
							    item-text='latin'
							    :label= this.constelacion
							    @input= "getAstrnomicObject"
							    return-object
						        hide-details
							    ></v-select>
							<v-spacer></v-spacer>
					        <v-select
							    v-model="type"
							    :items=types
							    @input= "getAstrnomicObject"
							    :label= this.tipo
						        hide-details
							    ></v-select>
					    </v-card-title>
					    <v-data-table
					      :headers="headers"
					      :items="FilteredObjects"
					      v-model="selected"
					      :rows-per-page-items="rowsPerPageItems"
    					  :pagination.sync="pagination"
					    >
					      <template v-slot:items="props">
					      	<tr @click="showAlert(props.item)">
					      		<td>
					      			<v-btn outline round color="amarillo">{{ $vuetify.t('$vuetify.control.Usar') }}</v-btn>
					      		</td>
						  
						        <td class="text-xs-left">{{ (props.item.colloquial_name || '') + ' ' + (props.item.nombre_coloquial || '')}}</td>
						        <td class="text-xs-left">{{ props.item.constellation }}</td>
						        <td class="text-xs-left">{{ props.item.type_object }}</td>
						        <td class="text-xs-left">{{ props.item.name }}</td>

					    	</tr>
					      </template>
					    </v-data-table>
					

					  </v-card>	

				</v-flex>
		      	<v-flex xs4 class="px-4">
					<v-layout align-center row>
						<v-flex xs12>	
					    	<v-card>
					    		<a  :href="imageUrl" target="_blank">
					      		<v-img
					      	  		v-bind:src="imageUrl"
					      	  		aspect-ratio="1"
					      		>
					      			<span class="my-span">{{ this.metadata }}</span>
					      		</v-img>
					      		</a>
					    	</v-card> 
					    </v-flex>
					</v-layout>   
		      	</v-flex>
		    </v-layout>
 

<!-- 		    <v-layout>
		    	<v-flex xs8 class="px-2">

		    	</v-flex>	

				<v-flex xs4 class="px-2">
					<v-card>
				        <v-layout >
				          	<v-flex xs4 align-end flexbox>
				            	<span > {{ object }}</span>
				          	</v-flex>
				          	<v-flex xs4 align-end flexbox>
				            	<span class="headline"> Estado:{{ state }}</span>
				          	</v-flex>
				          	<v-flex xs4 align-end flexbox>
				          		<p>Actual: {{current}}</p>
				       	</v-flex>
				        </v-layout>
				    </v-card>
				</v-flex>
			</v-layout> -->
	        

		    <v-layout>
				<v-flex xs6 class="px-2">
					<v-card class="py-2 px-2">
 
				        <v-layout>
				          <v-flex xs12>
				            <span class="headline">2.- {{ $vuetify.t('$vuetify.control.Mover Telescopio') }}</span>
				          </v-flex>
				        </v-layout>
						<v-layout>
							<v-flex xs6 class="px-2">
								<v-text-field
								    v-model="Ar_screen"
								    :label=this.asencionrecta
								    readonly=true
								    ></v-text-field>
		          			</v-flex>
							<v-flex xs4 class="px-2">
								<v-text-field
								    v-model="Dec_screen"
								    :label= this.declinacion
								    readonly=true
								    ></v-text-field>
		          			</v-flex>	          			
		          		</v-layout>	
		          		<v-btn round color="morado" @click="move()">{{ $vuetify.t('$vuetify.control.Mover') }}</v-btn>
			 		</v-card> 
				</v-flex>




				<v-flex xs6 class="px-2">
					<v-card class="py-2 px-2">
				        <v-layout>
				          <v-flex xs12>
				            <span class="headline">3.- {{ $vuetify.t('$vuetify.control.Sacar Foto') }}</span>
				          </v-flex>
				        </v-layout>


						<v-layout>
	
							<v-flex xs4 class="px-2">
							
							    <v-select
							      v-model="selectedIso"
							      :items="Isos"
							      item-text='iso'
							      return-object
							      :rules="[v => !!v || 'Obligatorio']"
							      :label= this.sensibilidad
							      @input= "selectIso"
							      required
							    ></v-select>

		          			</v-flex>
							<v-flex xs6 class="px-2">


							    <v-select
							      v-model="SelectedExp"
							      :items="Exps"
							      :rules="[v => !!v || 'Obligatorio']"
							      :label= this.tiempo_exp
							      @input= "selectExp"
							      required
							    ></v-select>


		          			</v-flex>

		          		</v-layout>
		          		<v-layout>
		          			<v-flex xs4>
		          				<v-btn round color="verde" @click="shoot()">{{ $vuetify.t('$vuetify.control.Disparar') }}</v-btn>	  
		          			</v-flex>
		          		    <v-flex xs6>
		          		    	
		          		    	
		          		    </v-flex>
		          		</v-layout>
			    	</v-card> 
				</v-flex>


			</v-layout>
		



		 
		    <v-layout>
				<v-flex xs12 class="px-2 py-2" style="overflow: auto">
					  <v-card class="px-4 py-4">
					    <v-card-title>
					      <span class="headline">{{ $vuetify.t('$vuetify.control.Mis fotos') }}</span>
					      <v-spacer></v-spacer>
					    </v-card-title>
					    <v-data-table
					      :headers="myImagesHeaders"
					      :items="myImages"
					      :search="search"
					    >


					      <template v-slot:items="props">
					        <td>
					        	<a class="px-2 py-2" :href="props.item.path" target="_blank">
						        	<v-img
				      	  				v-bind:src="props.item.path"
				      	  				aspect-ratio="1"
				      				></v-img>
			      				</a>
					        </td>

					        <td class="text-xs-left">{{ props.item.object_name }}</td>
					        <td class="text-xs-left">{{ props.item.iso_string }}</td>
					        <td class="text-xs-left">{{ props.item.exptime }}s</td>
					        <td class="text-xs-left">{{ props.item.ar_string }}</td>
					        <td class="text-xs-left">{{ props.item.dec_string }}</td>
					        <td class="text-xs-left">{{ props.item.created_at }}</td>
					      </template>
					      
					    </v-data-table>
					  </v-card>	
		      	</v-flex>
		    </v-layout>
		


      </v-card>

    <v-snackbar
      v-model="snackbar"
      :bottom="y === 'bottom'"
      :left="x === 'left'"
      :multi-line="mode === 'multi-line'"
      :right="x === 'right'"
      :timeout="timeout"
      :top="y === 'top'"
      :vertical="mode === 'vertical'"
    >
      {{ text }}
      <v-btn
        color="pink"
        flat
        @click="snackbar = false"
      >
        Close
      </v-btn>
    </v-snackbar>

    </v-dialog>
  </v-layout>



</template>

<script>
  import { mapState } from 'vuex';
  import Vue from 'vue';  
  import Loading from '../components/Loading.vue'
  import GuiaComponent from '../components/GuiaComponent.vue'
 


  export default {
    data () {
      return {

      	constelacion: this.$vuetify.t('$vuetify.control.Constelación') ,
      	tipo: this.$vuetify.t('$vuetify.control.Tipo objeto astronómico'),
      	sensibilidad: this.$vuetify.t('$vuetify.control.Sensibilidad'),
      	tiempo_exp: this.$vuetify.t('$vuetify.control.Tiempo Exposición(Segundos)'),
      	asencionrecta: this.$vuetify.t('$vuetify.control.Ascención Recta'),
      	declinacion: this.$vuetify.t('$vuetify.control.Declinación'),

        snackbar: false,
        y: 'top',
        x: null,
        mode: 'vertical',
        timeout: 6000,
        text: '',

      	tiempo: 0,
      	contando: true,
        tiempos: [],
        focuser_state: 0,
 		current_focus: 0,
        camera_state: 'Imagen Recibida',

        metadata: '',

        ninetyRule: [v => !!v || 'Campo requerido',
            v=> v <= 90 || 'Debe ser  menor o igual a 90',
            v=> v >= -90 || 'Debe ser mayor o igual a -90',
        ],

        sixtyRule: [v => !!v || 'Campo requerido',
            v=> v <= 59 || 'Debe ser menor a 60',
            v=> v >= 0 || 'Debe ser mayor a o igual 0',
        ],

        twentythreeRule: [v => !!v || 'Campo requerido',
            v=> v <= 23 || 'Debe ser menor o igual a 23',
            v=> v >= 0 || 'Debe ser mayor a o igual 0',
        ],

        blankRules: [v => !!v || 'Campo requerido'],

        dialog: true,
        dialog2: false,
        dialog3: false,
        slider: 0,
        astronomic_objects:[],
        selected:[],
        search: '',
        imageUrl: '',
        h_ra:0,
        m_ra:0,
        s_ra:0,

        h_dec:0,
        m_dec:0,
        s_dec:0,

        catalog:'SolarSistem',
        catalogs: ['SolarSistem','Messier','NGC', 'IC'],
        type:" ",
        name:null,
    


        Constellation:{name:' ',latin:' '},

        Constellations: [
            {name:'',latin:' '},

			{name:'And',latin:'Andromeda'},
			{name:'Cet',latin:'Cetus'},
			{name:'Cha',latin:'Chamaleon'},
			{name:'Sgr',latin:'Sagittarius'},
			{name:'Sco',latin:'Scorpius'},
			{name:'Cyg',latin:'Cygnus'},
			{name:'Hya',latin:'Hydra'},
			{name:'Car',latin:'Carina'},
			{name:'Dor',latin:'Dorado'},
			{name:'Cas',latin:'Cassiopeia'},
			{name:'Vir',latin:'Virgo'},
			{name:'Cap',latin:'Capricornus'},
			{name:'Vul',latin:'Vulpecula'},
			{name:'Pav',latin:'Pavo'},
			{name:'Aqr',latin:'Aquarius'},
			{name:'Oph',latin:'Ophiuchus'},
			{name:'Ara',latin:'Ara'},
			{name:'Cen',latin:'Centaurus'},
			{name:'Ant',latin:'Antlia'},
			{name:'TrA',latin:'Triangulum Australe'},
			{name:'Cru',latin:'Crux'},
			{name:'Tuc',latin:'Tucana'},
			{name:'Lyr',latin:'Lyra'},
			{name:'Scl',latin:'Sculptor'},
			{name:'Men',latin:'Mensa'},
        ],
        FilteredObjects: [],

        Ar: 0,
        Dec: 0,
        Ar_screen:'',
        Dec_screen:'',
        Iso: '100',
        Exp: '1',

        Ar_act:0,
        Dec_act:0,
        Iso_act:0,
        Exp_act:0,
        current:'',
        current_shot:'',	

        rowsPerPageItems: [4, 6, 10, 20],
		pagination: {
    		rowsPerPage: 4
		},	

		object:'',
		state: this.$vuetify.t('$vuetify.control.Enespera'),
		selectedTic:'100',
		selectedDir:'Adentro',
		tic:100,
		dir:1,
	    Tics: [
	        '100',
	        '500',
	        '1000',
	        '2500',
	        '5000',
	        '10000',
	    ],

	    Dirs: [
	        'Adentro',
	        'Afuera',
	    ],

	    selectedIso:'',
	    Isos: [
			{choice: 1, iso: 100},
			{choice: 2, iso: 125},
			{choice: 3, iso: 160},
			{choice: 4, iso: 200},
			{choice: 5, iso: 250},
			{choice: 6, iso: 320},
			{choice: 7, iso: 400},
			{choice: 8, iso: 500},
			{choice: 9, iso: 640},
			{choice: 10, iso: 800},
			{choice: 11, iso: 1000},
			{choice: 12, iso: 1250},
			{choice: 13, iso: 1600},
			{choice: 14, iso: 2000},
			{choice: 15, iso: 2500},
			{choice: 16, iso: 3200},
			{choice: 17, iso: 4000},
			{choice: 18, iso: 5000},
			{choice: 19, iso: 6400},
			{choice: 20, iso: 8000},
			{choice: 21, iso: 10000},
			{choice: 22, iso: 12800},
			{choice: 23, iso: 16000},
			{choice: 24, iso: 20000},
			{choice: 25, iso: 25600},
			],




	    Exps: [
	        '1',
	        '2',
	        '4',
	        '6',
	        '8',
	        '10',
	        '20',
	        '30',
	        '40',
	        '60',
	        '120',
	        '240',
	        '300',

	    ],

        myImages: [],

      }
    },
    computed:{

    	types(){

    		if(this.$vuetify.lang.current=='es'){
    		return[
    		    ' ',
        		'Cúmulo Globular',
        		'Cúmulo abierto',
        		'Galaxia',       		
                'Asterismo o Cúmulo Abierto',
				'Estrella',
				'Estrella doble',
				'Galaxias en Interacción',
				'Nebulosa',
				'Nebulosa de emisión Hidrógeno',
				'Nebulosa de Reflexión',
				'Nebulosa Extragaláctica',
				'Nebulosa Planetaria',
				'Nebulosa y Cúmulo',
				'Nova',
				'Otro',
				'Planet',
				'Par de Galaxias',
				'Remanente de Supernova',
				'Trío de Galaxias',
    		]}
    		else {
    			return[
    		    ' ',
        		'Globular cluster',
        		'Open Cluster',
        		'Galaxy',       		
                'Asterism or Open Cluster',
				'Star',
				'Double star',
				'Galaxies in Interactionn',
				'Nebula',
				'Emission Nebula Hydrogen',
				'Reflection Nebula',
				'Extragalactic Nebula',
				'Planetary nebula',
				'Nebula and Cluster',
				'Nova',
				'Other',
				'Planet',
				'Pair of Galaxies',
				'Supernova remnant',
				'Trio of Galaxies',
    		]
    		}
    	},


        astronomc_objects(){
          return this.$store.state.astronomc_objects
        },
        headers(){
          return [

          { text: this.$vuetify.t('$vuetify.control.Usar'), value: 'name' },
          { text: this.$vuetify.t('$vuetify.control.Descripción'), value: 'colloquial_name' },
          { text: this.$vuetify.t('$vuetify.control.Constelación'), value: 'constellation' },
          { text: this.$vuetify.t('$vuetify.control.Tipo'), value: 'type_object' },
          { text: this.$vuetify.t('$vuetify.control.Nombre'), value: 'name' },

          ]
        },

        myImagesHeaders(){
        	return[
        		  { text: this.$vuetify.t('$vuetify.dashboard.Foto'), value: 'img' },
                  { text: this.$vuetify.t('$vuetify.dashboard.Nombre'), value: 'name' },
                  { text: this.$vuetify.t('$vuetify.dashboard.ISO'), value: 'iso' },
                  { text: this.$vuetify.t('$vuetify.dashboard.TiempoExp'), value: 'exptime' },

                  { text: this.$vuetify.t('$vuetify.control.Coord AR'), value: 'ar' },
		          { text: this.$vuetify.t('$vuetify.control.Coord DEC'), value: 'dec' },
		          { text: this.$vuetify.t('$vuetify.control.Fecha'), value: 'created_at' }
        	]
        }

    },
    created () {
      	//this.initialize();
    },
    mounted (){
    	this.initialize();

    },
    components: {
          Loading,
    },

    methods: {


    	async showAlert(a){
      	//	if (event.target.classList.contains('btn__content')) return;
      		var app = this;
 
      		this.object = a;

      		this.$refs.Loading.show("Calculando si el objeto es visible, un momento por favor") 

      			            		app.Ar_screen = app.object.ra;
      					app.Dec_screen = app.object.dec;
      					app.coords(app.Ar_screen, app.Dec_screen); 



	        this.$refs.Loading.hide()      		 

      				
    	},
      	initialize () {

      		
      		


      		this.imageRefresh();
            this.openChat();
            this.getMyImages();
            this.getAstrnomicObject();

            this.guiaClick();

            
        },


        getAstrnomicObject(){
        	var app=this;

        	var constellation = app.Constellation ?  app.Constellation.name : "Cru"

        	//
        	////alert("getAstrnomicObject")
        	axios.get('/api/astronomic_objects?constellation=' + constellation +'&type='+app.type)
            .then(function (resp) {
              	app.FilteredObjects = resp.data;
            })
            .catch(function (resp) {
                alert("Error astronomic_objects name :" + resp);
            });
        },

        getAstrnomicObjectName(){
        	var app=this;

        	axios.get('/api/astronomic_objects?name=' + app.search)
            .then(function (resp) {
              	app.FilteredObjects = resp.data;
            })
            .catch(function (resp) {
                alert("Error astronomic_objects constellation :" + resp);
            });
        },

	    openChat () {
	        let app = this

	        // Start pusher listener
	        Pusher.logToConsole = true


	        //production
			// app_id = "764758"
			// key = "6a09b6dc7cbc0cce55a3"
			// secret = "3821c2b9107f68e63aba"
			// cluster = "us2"

	        var pusher = new Pusher('6a09b6dc7cbc0cce55a3', {
	            cluster: 'us2',
	            forceTLS: true
	        });

	        var channel = pusher.subscribe('newMessage-1-2'); // newMessage-[chatting-with-who]-[my-id]

	        channel.bind('App\\Events\\MessageSent', function (data) {
	            
	            // app.state = data.message['message'];
	           // alert(JSON.stringify(data.message));

	           //Estado:Pos.Actual :18825.0
	           if(data.message['message']!='NaN'){  
		           var posactual = data.message['message'].substring(0, 3);
		           var imageMsg = data.message['message'].indexOf("Imagen");

		           	if(posactual=="Pos"){
	               		var n = data.message['message'].indexOf(":");
	               		var position = data.message['message'].substring(n+1,n+10);
	               		app.focuser_state = parseInt(position,10) - app.$store.getters.current_focus;
	               		app.state = app.focuser_state;
	           		} else {
	           			app.state = messageToEn(data.message['message']);
	           		}



		            if (imageMsg>=0){
		            	app.camera_state = messageToEn(app.state);	
		            }

		            if (app.state==messageToEn("Imagen Recibida")){
		            //	app.pulsa();
		            	app.imageRefresh();
		            }
	        	}
	            
	        })
	          // End pusher listener
	     },





        move(){
        	// alert('Enviando Comando');
        	this.state = 'Enviando Comando';
        	if(this.Ar_screen){
	        	var $command = {'command': 'MONTURA', 'type': 'mount', 'status': 'PENDIENTE',
	        	                'ar': this.Ar, 'dec': this.Dec, 'user_id': 1, 'equipment_id': 1};

	        	//alert(JSON.stringify($command));
	        	axios.post('/api/command/move', $command)
	            .then(function (resp) {
	                
	            })
	            .catch(function (resp) {
	                console.log(resp);
	                alert("Error move :" + resp);
	            });

	            this.currentRefresh();
        	}
        },
        shoot(){
        	this.state = 'Enviando Comando';

        	


        	var command = {'command': 'CAMARA', 'type': 'shoot', 'status': 'PENDIENTE',
        	                'exptime': this.Exp, 'iso': this.Iso, 'iso_string': this.selectedIso.iso,'ar': this.Ar_screen, 'dec': this.Dec_screen, 'user_id': 1, 'equipment_id': 1, 'object_id':this.object.id, 'object_name': this.object.name, 'path': this.object.path};



        	this.imageUrl = '';
        	axios.post('/api/command/shoot', command)
            .then(function (resp) {    
            })
            .catch(function (resp) {
                console.log(resp);
                alert("Error create reservation :" + resp);
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

        	if(!this.Tic){
        		this.Tic = 100;
        	}

        	if(!this.Dir){
        		this.Dir = 0;
        	}

        	this.state = 'Enviando Comando';
        	var $command = {'command': 'ENFOCADOR', 'type': 'focuser', 'status': 'PENDIENTE',
        	                'steps': this.Tic, 'direction': this.Dir, 'user_id': this.$store.getters.user['id'], 'equipment_id': 1};

        	//alert(JSON.stringify($command));



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
        	axios.get('/api/image/last')
            .then(function (resp) {
            	app.imageUrl = resp.data;                
            })
            .catch(function (resp) {
                console.log(resp);
                alert("Error imageRefresh :" + resp);
            });
            app.getMyImages();
        },

        getMyImages(){
        	let app = this;
        	axios.get('/api/images')
            .then(function (resp) {
            	app.myImages = resp.data;               
            })
            .catch(function (resp) {
                console.log(resp);
                alert("Error getMyImages :" + resp);
            });
        },

        coords (ra, dec){
        
        	var res = ra.replace(/h/g, " ")
        	res = res.replace(/m/g, " ")
        	res = res.replace(/s/g, " ")
        	this.h_ra = parseFloat(res.split(" ")[0]);
       		this.m_ra = parseFloat(res.split(" ")[1]); 
       		this.s_ra = parseFloat(res.split(" ")[2]);
	    	var ra_selected  = (this.h_ra + (this.m_ra/60) + (this.s_ra/3600));
        	this.Ar = ra_selected;


        	res = dec.replace(/°/g, " ")
        	res = res.replace(/m/g, " ")
        	res = res.replace(/s/g, " ")
        	this.h_dec = parseFloat(res.split(" ")[0]);
       		this.m_dec = parseFloat(res.split(" ")[1]); 
       		this.s_dec = parseFloat(res.split(" ")[2]);
       		var dec_selected  = 0;
       		var h_dec_loc = this.h_dec;
       		if(h_dec_loc<0){
       			h_dec_loc = h_dec_loc * -1;
       			dec_selected  = -(h_dec_loc + (this.m_dec/60) + (this.s_dec/3600));
       		} else{
       			dec_selected  = (h_dec_loc + (this.m_dec/60) + (this.s_dec/3600));
       		}
       		
      		this.Dec = dec_selected;
      		
        },

        inc_s_ra () {
      		if(this.s_ra<60){
      			this.s_ra = parseInt(this.s_ra,10) + 1
      		}
    	},
    	dec_s_ra () {
      		
      		if(this.s_ra>0){
      			this.s_ra = parseInt(this.s_ra,10) - 1
      		}
    	},
        inc_m_ra () {
      		if(this.m_ra<60){
      			this.m_ra = parseInt(this.m_ra,10) + 1
      		}
    	},
    	dec_m_ra () {
      		
      		if(this.m_ra>0){
      			this.m_ra = parseInt(this.m_ra,10) - 1
      		}
    	},

        inc_s_dec () {
      		if(this.s_dec<60){
      			this.s_dec = parseInt(this.s_dec,10) + 1
      		}
    	},
    	dec_s_dec () {
      		
      		if(this.s_dec>0){
      			this.s_dec = parseInt(this.s_dec,10) - 1
      		}
    	},
        inc_m_dec () {
      		if(this.m_dec<60){
      			this.m_dec = parseInt(this.m_dec,10) + 1
      		}
    	},
    	dec_m_dec () {
      		
      		if(this.m_dec>0){
      			this.m_dec = parseInt(this.m_dec,10) - 1
      		}
    	},

    	savefine (){
    		this.Ar_screen = this.h_ra+'h'+this.m_ra+'m'+this.s_ra+'s';
    		this.Dec_screen = this.h_dec+'°'+this.m_dec+'m'+this.s_dec+'s';

    		this.coords(this.Ar_screen, this.Dec_screen);
    		this.dialog2 = false;

    	},
    	savecoords (){
    		this.Ar_screen = this.h_ra+'h'+this.m_ra+'m'+this.s_ra+'s';
    		this.Dec_screen = this.h_dec+'°'+this.m_dec+'m'+this.s_dec+'s';

    		this.coords(this.Ar_screen, this.Dec_screen);
    		this.dialog3 = false;

    	},

    	selectIso(a){
       		this.selectedIso = a;
    		this.Iso = a.choice;
    	},

    	selectExp(a){
    		this.selectedExp = a;
    		this.Exp = a;
    	},


    	selectTic(a){
    		this.selectedTic = a;
    		this.Tic = a;
    	},

    	selectDir(a){
    		this.selectedDir = a;
    		if(a=="Afuera") {
    			this.Dir = 1;
    		} else {
    			this.Dir = 0;
    		}
    		
    	},

        pad(num, tam) {
            var s = num + '';
            while (s.length < tam) {
                s = '0' + s;
            }
            return s;
        },
        tiempoFormateado: function() {
            return formateaTiempo(this.tiempo);
        },
        actualizaTiempo: function() {
            if(this.contando) {
                this.tiempo++;
                this.state='  '+this.tiempo + ' Seg';
            }
        },
        pulsa: function() {
        	this.reinicia();
            this.contando = !this.contando;
        },
        reinicia: function() {
            this.tiempo = 0;
        },
        agregaTiempo: function() {
            this.tiempos.push(this.tiempo);
            this.tiempo = 0;
            this.$store.commit('tiempos', this.tiempos);
        },
        borrarTiempos: function() {
            this.tiempos.splice(0, this.tiempos.length);
            this.$store.commit('tiempos', this.tiempos);
        },
        totalTiempos: function() {
            var total = 0;
            for(var i = 0; i < this.tiempos.length; i++) {
                total += this.tiempos[i];
            }
            return total;
        },
	    guiaClick (){
	    	// alert('guiaClick');
	    	
	        var ComponentGuia = Vue.extend(GuiaComponent)
	        var instance = new ComponentGuia({store: this.$store});
	        instance.$mount();
	        this.$refs.container.appendChild(instance.$el);
	    },

	    returnToAtacamaScope(){
	    	window.location.href = "http://atacamascope.cl";
	    },

	    messageToEn(message){

	    	var es = [
		    	'Imagen Recibida',
		    	'En espera',
		    	'Enviando comando',
		    	'Comando Recibido',
		    	'Moviendo Telescopio',
		    	'Telescopio en posicion',
		    	'Imagen Recibida',
		    	'Comando Imagen recibido',
		    	'Obteniendo Imagen',
		    	'Subiendo Imagen',
	    	]

	    	var en = [
				'Image Received',
				'On hold',
				'Sending command',
				'Command Received',
				'Moving Telescope',
				'Telescope in position',
				'Image Received',
				'Image command received',
				'Getting Image',
				'Uploading Image',
	    	]

	    	var i = es.indexOf(message)

	    	return en[i]
	    }


    },
    filters: {
        formateaTiempo: function(t) {
            var horas = parseInt(t / 3600);
            var minutos = parseInt(t / 60) % 60;
            var segundos = t % 60;
            var s = this.pad(horas, 2) + ':' + this.pad(minutos, 2) + ':' + this.pad(segundos, 2);
            return s;
        }
    },







    
  }
</script>
