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
          <v-btn icon dark @click="dialog = false">
            <v-icon>close</v-icon>
          </v-btn>
          <v-toolbar-title>Interfaz de Control</v-toolbar-title>
          <v-spacer></v-spacer>
        </v-toolbar>


		    <v-layout class="py-2">
				<v-flex xs8 class="px-2" style="overflow: auto">

					  <v-card class="py-4 px-2">
				        <v-layout>
				          <v-flex xs4 class="px-2">
				            <span v-if='object.name' class="headline">1.- {{ object.name }}</span>
				            <span v-else class="headline">1.- Seleccione un Objeto</span>
				          </v-flex>
				          	<v-flex xs8 class="px-2">
				            	<span class="headline"> Estado Sistema:{{ state }}</span>
				          	</v-flex>
				        </v-layout>
					    <v-card-title>
						    <v-select
							    v-model="Constellation"
							    :items="Constellations"
							    item-text='latin'
							    label="Constelación"
							    @input= "getAstrnomicObject"
							    return-object
							    single-line
						        hide-details
							    ></v-select>
							<v-spacer></v-spacer>
					        <v-select
							    v-model="type"
							    :items="types"
							    @input= "getAstrnomicObject"
							    label="Tipo"
							    single-line
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
					      			<v-btn outline round color="amarillo">Usar</v-btn>
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
				            <span class="headline">2.- Mover Telescopio</span>
				          </v-flex>
				        </v-layout>
						<v-layout>
							<v-flex xs6 class="px-2">
								<v-text-field
								    v-model="Ar_screen"
								    label="Asención Recta"
								    readonly=true
								    ></v-text-field>
		          			</v-flex>
							<v-flex xs4 class="px-2">
								<v-text-field
								    v-model="Dec_screen"
								    label="Declinación"
								    readonly=true
								    ></v-text-field>
		          			</v-flex>	          			
		          		</v-layout>	
		          		<v-btn round color="morado" @click="move()">Mover</v-btn>
			 		</v-card> 
				</v-flex>




				<v-flex xs6 class="px-2">
					<v-card class="py-2 px-2">
				        <v-layout>
				          <v-flex xs12>
				            <span class="headline">3.- Sacar Foto</span>
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
							      label="Sensibilidad"
							      @input= "selectIso"
							      required
							    ></v-select>

		          			</v-flex>
							<v-flex xs6 class="px-2">


							    <v-select
							      v-model="SelectedExp"
							      :items="Exps"
							      :rules="[v => !!v || 'Obligatorio']"
							      label="Tiempo Exposición(Segundos)"
							      @input= "selectExp"
							      required
							    ></v-select>


		          			</v-flex>

		          		</v-layout>
		          		<v-layout>
		          			<v-flex xs4>
		          				<v-btn round color="verde" @click="shoot()">Disparar</v-btn>	  
		          			</v-flex>
		          		    <v-flex xs6>
		          		    	<span class="headline">{{ this.camera_state }}</span>
		          		    	
		          		    </v-flex>
		          		</v-layout>
			    	</v-card> 
				</v-flex>


			</v-layout>
		



		 
		    <v-layout>
				<v-flex xs12 class="px-2 py-2" style="overflow: auto">
					  <v-card class="px-4 py-4">
					    <v-card-title>
					      <span class="headline">Mis fotos</span>
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

  export default {
  	computed: mapState(['astronomc_objects']),
    data () {
      return {

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
        type:"Cúmulo abierto",
        name:null,
        types:[	' ',
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
				'Trío de Galaxias',],
        Constellation:{name:'Cru',latin:'Crux'},
        Constellations: [
            {name:'',latin:' '},
        	{name:'And',latin:'Andromeda'},
			{name:'Ant',latin:'Antlia'},
			{name:'Aps',latin:'Apus'},
			{name:'Aql',latin:'Aquila'},
			{name:'Aqr',latin:'Aquarius'},
			{name:'Ara',latin:'Ara'},
			{name:'Ari',latin:'Aries'},
			{name:'Aur',latin:'Auriga'},
			{name:'Boo',latin:'Bootes'},
			{name:'Cae',latin:'Caelum'},
			{name:'Cam',latin:'Camelopardalis'},
			{name:'Cap',latin:'Capricornus'},
			{name:'Car',latin:'Carina'},
			{name:'Cas',latin:'Cassiopeia'},
			{name:'Cen',latin:'Centaurus'},
			{name:'Cep',latin:'Cepheus'},
			{name:'Cet',latin:'Cetus'},
			{name:'Cha',latin:'Chamaleon'},
			{name:'Cir',latin:'Circinus'},
			{name:'CMa',latin:'Canis Major'},
			{name:'CMi',latin:'Canis Minor'},
			{name:'Cnc',latin:'Cancer'},
			{name:'Col',latin:'Columba'},
			{name:'Com',latin:'Coma Berenices'},
			{name:'CrA',latin:'Corona Australis'},
			{name:'CrB',latin:'Corona Borealis'},
			{name:'Crt',latin:'Crater'},
			{name:'Cru',latin:'Crux'},
			{name:'Crv',latin:'Corvus'},
			{name:'CVn',latin:'Canes Venatici'},
			{name:'Cyg',latin:'Cygnus'},
			{name:'Del',latin:'Delphinus'},
			{name:'Dor',latin:'Dorado'},
			{name:'Dra',latin:'Draco'},
			{name:'Equ',latin:'Equuleus'},
			{name:'Eri',latin:'Eridanus'},
			{name:'For',latin:'Fornax'},
			{name:'Gem',latin:'Gemini'},
			{name:'Gru',latin:'Grus'},
			{name:'Her',latin:'Hercules'},
			{name:'Hor',latin:'Horologium'},
			{name:'Hya',latin:'Hydra'},
			{name:'Hyi',latin:'Hydrus'},
			{name:'Ind',latin:'Indus'},
			{name:'Lac',latin:'Lacerta'},
			{name:'Leo',latin:'Leo'},
			{name:'Lep',latin:'Lepus'},
			{name:'Lib',latin:'Libra'},
			{name:'LMi',latin:'Leo Minor'},
			{name:'Lup',latin:'Lupus'},
			{name:'Lyn',latin:'Lynx'},
			{name:'Lyr',latin:'Lyra'},
			{name:'Men',latin:'Mensa'},
			{name:'Mic',latin:'Microscopium'},
			{name:'Mon',latin:'Monoceros'},
			{name:'Mus',latin:'Musca'},
			{name:'Nor',latin:'Norma'},
			{name:'Oct',latin:'Octans'},
			{name:'Oph',latin:'Ophiuchus'},
			{name:'Ori',latin:'Orion'},
			{name:'Pav',latin:'Pavo'},
			{name:'Peg',latin:'Pegasus'},
			{name:'Per',latin:'Perseus'},
			{name:'Phe',latin:'Phoenix'},
			{name:'Pic',latin:'Pictor'},
			{name:'PsA',latin:'Piscis Austrinus'},
			{name:'Psc',latin:'Pisces'},
			{name:'Pup',latin:'Puppis'},
			{name:'Pyx',latin:'Pyxis'},
			{name:'Ret',latin:'Reticulum'},
			{name:'Scl',latin:'Sculptor'},
			{name:'Sco',latin:'Scorpius'},
			{name:'Sct',latin:'Scutum'},
			{name:'Ser',latin:'Serpens'},
			{name:'Sex',latin:'Sextans'},
			{name:'Sge',latin:'Sagitta'},
			{name:'Sgr',latin:'Sagittarius'},
			{name:'Tau',latin:'Taurus'},
			{name:'Tel',latin:'Telescopium'},
			{name:'TrA',latin:'Triangulum Australe'},
			{name:'Tri',latin:'Triangulum'},
			{name:'Tuc',latin:'Tucana'},
			{name:'UMa',latin:'Ursa Major'},
			{name:'UMi',latin:'Ursa Minor'},
			{name:'Vel',latin:'Vela'},
			{name:'Vir',latin:'Virgo'},
			{name:'Vol',latin:'Volans'},
			{name:'Vul',latin:'Vulpecula'},
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
		state:'En espera',
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

        headers: [
          { text: 'Usar', value: 'name' },
          { text: 'Descripción', value: 'colloquial_name' },
          { text: 'Constelación', value: 'constellation' },
          { text: 'Tipo', value: 'type_object' },
          { text: 'Nombre', value: 'name' },

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

	      	await axios.get('/api/astronomic_objects/horizon?object=' + a.name)
	            .then(function (resp) {    

	            	
	            	if(resp.data<=5){
	            	
        				app.Ar = 0;
				        app.Dec = 0;
				        app.Ar_screen = '';
				        app.Dec_screen = '';

				        app.text = "Objeto NO VISIBLE,altura Alt/Az BAJO el HORIZONTE: " + JSON.stringify(resp.data) +'º';

				        app.snackbar = true;
	

	            	} else {

	            		app.Ar_screen = app.object.ra;
      					app.Dec_screen = app.object.dec;
      					app.coords(app.Ar_screen, app.Dec_screen); 
	            	}
	            })
	            .catch(function (resp) {
	                console.log(resp);
	                alert("Error shoot :" + resp);
	            }); 

	        this.$refs.Loading.hide()      		 

      				
    	},
      	initialize () {

      		//alert('initialize');
      		this.imageRefresh();
            this.openChat();
            this.getMyImages();
            this.getAstrnomicObject();
        },


        getAstrnomicObject(){
        	var app=this;

        	var constellation = app.Constellation ?  app.Constellation.name : "Cru"

        	//
        	alert("getAstrnomicObject")
        	axios.get('/api/astronomic_objects?constellation=' + constellation +'&type='+app.type)
            .then(function (resp) {
              	app.FilteredObjects = resp.data;
            })
            .catch(function (resp) {
                alert("Error astronomic_objects :" + resp);
            });
        },

        getAstrnomicObjectName(){
        	var app=this;

        	axios.get('/api/astronomic_objects?name=' + app.search)
            .then(function (resp) {
              	app.FilteredObjects = resp.data;
            })
            .catch(function (resp) {
                alert("Error astronomic_objects :" + resp);
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
	           			app.state = data.message['message'];
	           		}



		            if (imageMsg>=0){
		            	app.camera_state = app.state;	
		            }

		            if (app.state=="Imagen Recibida"){
		            //	app.pulsa();
		            	app.imageRefresh();
		            }
	        	}
	            
	        })
	          // End pusher listener
	     },





        move(){
        	alert('Enviando Comando');
        	this.state = 'Enviando Comando';
        	if(this.Ar_screen){
	        	var $command = {'command': 'MONTURA', 'type': 'mount', 'status': 'PENDIENTE',
	        	                'ar': this.Ar, 'dec': this.Dec, 'user_id': this.$store.getters.user['id'], 'equipment_id': 1};

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
        	                'exptime': this.Exp, 'iso': this.Iso, 'iso_string': this.selectedIso.iso,'ar': this.Ar_screen, 'dec': this.Dec_screen, 'user_id': this.$store.getters.user['id'], 'equipment_id': 1, 'object_id':this.object.id, 'object_name': this.object.name};



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
                alert("Error shoot :" + resp);
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
                alert("Error shoot :" + resp);
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
    }
    
  }
</script>
