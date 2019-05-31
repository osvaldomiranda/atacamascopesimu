<template>
  <v-layout>
    <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
      <template v-slot:activator="{ on }">
        <v-btn color="warning" dark v-on="on">Interfaz de Control</v-btn>
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
		    	<v-flex xs1>
				</v-flex>
				<v-flex xs2>
					<v-layout align-center row>
						<v-flex xs12>	
					    	<v-card>
					      		<v-img
					      	  		v-bind:src="imageUrl"
					      	  		aspect-ratio="1"
					      		></v-img>
					    	</v-card> 
					    </v-flex>
					</v-layout>   
					<v-layout align-center row>
						<v-flex xs12>
							<p>{{current_shot}}</p> 	
						</v-flex>
					</v-layout>	
		      	</v-flex>

				<v-flex xs1>
				</v-flex>

				<v-flex xs7 style="overflow: auto">

					  <v-card>
					    <v-card-title>
					        <v-select
							    v-model="type"
							    :items="types"
							    @input= "filterType"
							    label="Tipo"
							    single-line
						        hide-details
							    ></v-select>
					        <v-spacer></v-spacer>
						    <v-select
							    v-model="Constellation"
							    :items="Constellations"
							    label="Constelación"
							    @input= "filterConstellation"
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
							<v-flex align-center xs1>
							</v-flex>	
							<v-flex align-center xs4>
								<v-text-field
								    v-model="Ar_screen"
								        label="Asención Recta"
								    ></v-text-field>
		          			</v-flex>
							<v-flex align-center xs1>
							</v-flex>
							<v-flex align-center xs4>
								<v-text-field
								    v-model="Dec_screen"
								        label="Declinación"
								    ></v-text-field>
		          			</v-flex>
							<v-flex align-center xs1>
							</v-flex>		          			
		          		</v-layout>	



		          		<v-btn color="warning" @click="move()">Mover</v-btn>
<template>



    <v-dialog v-model="dialog2" persistent max-width="800px">
      <template v-slot:activator="{ on }">
        <v-btn color="warning" dark v-on="on">Mov.Fino</v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline">Movimiento Fino</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
          				<v-layout align-center row>
          					<span class="title">Ascención Recta</span>
          				</v-layout>
						<v-layout align-center row>
							<v-flex align-center xs1>
							</v-flex>	
							<v-flex align-center xs3>
								<v-text-field
								    v-model="h_ra"
								        label="AR Horas"
								    ></v-text-field>
		          			</v-flex>
							<v-flex align-center xs1>
							</v-flex>
							<v-flex align-center xs3>
								<v-text-field 
									v-model="m_ra" 
									type="number" 
									label="AR Minutos" 
									append-outer-icon="add" @click:append-outer="inc_m_ra" 
									prepend-icon="remove" @click:prepend="dec_m_ra">
								</v-text-field>
		          			</v-flex>
							<v-flex align-center xs1>
							</v-flex>	
							<v-flex align-center xs3>

								<v-text-field 
									v-model="s_ra" 
									type="number" 
									label="AR Segundos" 
									append-outer-icon="add" @click:append-outer="inc_s_ra" 
									prepend-icon="remove" @click:prepend="dec_s_ra">
								</v-text-field>
		          			</v-flex>
							<v-flex align-center xs1>
							</v-flex>		          			
		          		</v-layout>	
          				<v-layout align-center row>
          					<span class="title">Declinación</span>
          				</v-layout>

						<v-layout align-center row>

							<v-flex align-center xs1>
							</v-flex>	
							<v-flex align-center xs3>
								<v-text-field
								    v-model="h_dec"
								        label="DEC Grados"
								    ></v-text-field>
		          			</v-flex>
							<v-flex align-center xs1>
							</v-flex>
							<v-flex align-center xs3>
								<v-text-field 
									v-model="m_dec" 
									type="number" 
									label="DEC Minutos" 
									append-outer-icon="add" @click:append-outer="inc_m_dec" 
									prepend-icon="remove" @click:prepend="dec_m_dec">
								</v-text-field>
		          			</v-flex>
							<v-flex align-center xs1>
							</v-flex>	
							<v-flex align-center xs3>
								<v-text-field 
									v-model="s_dec" 
									type="number" 
									label="DEC Segundos" 
									append-outer-icon="add" @click:append-outer="inc_s_dec" 
									prepend-icon="remove" @click:prepend="dec_s_dec">
								</v-text-field>
		          			</v-flex>
							<v-flex align-center xs1>
							</v-flex>		          			
		          		</v-layout>	
          </v-container>
         
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" flat @click="dialog2 = false">Cerrar</v-btn>
          <v-btn color="blue darken-1" flat @click="savefine">Guardar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

</template>

<template>

    <v-dialog v-model="dialog3" persistent max-width="600px">
      <template v-slot:activator="{ on }">
        <v-btn color="warning" dark v-on="on">Mis Coords.</v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline">Coordenadas especificas</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
          	          	<v-layout align-center row>
          				<span class="title">Ascención Recta</span>
          				</v-layout>
						<v-layout align-center row>
							<v-flex align-center xs1>
							</v-flex>	
							<v-flex align-center xs3>
								<v-text-field
								    v-model="h_ra"
								    min:0
								    max:60
								    label="AR Horas"
								    ></v-text-field>
		          			</v-flex>
							<v-flex align-center xs1>
							</v-flex>
							<v-flex align-center xs3>
								<v-text-field
								    v-model="m_ra"
								        label="AR Minutos"
								    ></v-text-field>
		          			</v-flex>
							<v-flex align-center xs1>
							</v-flex>	
							<v-flex align-center xs3>
								<v-text-field
								    v-model="s_ra"
								        label="AR Segundos"
								    ></v-text-field>
		          			</v-flex>
							<v-flex align-center xs1>
							</v-flex>		          			
		          		</v-layout>	
		          		<v-layout align-center row>
          					<span class="title">Declinación</span>
          				</v-layout>
						<v-layout align-center row>
							<v-flex align-center xs1>
							</v-flex>	
							<v-flex align-center xs3>
								<v-text-field
								    v-model="h_dec"
								        label="DEC Grados"
								    ></v-text-field>
		          			</v-flex>
							<v-flex align-center xs1>
							</v-flex>
							<v-flex align-center xs3>
								<v-text-field
								    v-model="m_dec"
								        label="DEC Minutos"
								    ></v-text-field>
		          			</v-flex>
							<v-flex align-center xs1>
							</v-flex>	
							<v-flex align-center xs3>
								<v-text-field
								    v-model="s_dec"
								        label="DEC Segundos"
								    ></v-text-field>
		          			</v-flex>
							<v-flex align-center xs1>
							</v-flex>		          			
		          		</v-layout>	
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" flat @click="dialog3 = false">Cerrar</v-btn>
          <v-btn color="blue darken-1" flat @click="savecoords">Guardar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

</template>
 
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
							<v-flex align-center xs1>
							</v-flex>	
							<v-flex align-center xs4>
							
							    <v-select
							      v-model="Iso"
							      :items="Isos"
							      :rules="[v => !!v || 'Obligatorio']"
							      label="Sencibilidad"
							      required
							    ></v-select>

		          			</v-flex>
							<v-flex align-center xs1>
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
							<v-flex align-center xs1>
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
							<v-flex align-center xs1>
							</v-flex>	
							<v-flex align-center xs4>
							
							    <v-select
							      v-model="Paso"
							      :items="Pasos"
							      :rules="[v => !!v || 'Obligatorio']"
							      label="Pasos"
							      required
							    ></v-select>

		          			</v-flex>
							<v-flex align-center xs1>
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
							<v-flex align-center xs1>
							</v-flex>	
		          		</v-layout>	
		          		<v-btn color="warning" @click="focus">Enfocar</v-btn>
			    	</v-card> 
				</v-flex>

			</v-layout>
		</v-container>	



		 <v-container fluid>
		    <v-layout align-center row>
				<v-flex xs12 style="overflow: auto">

					  <v-card>
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
					        	<a href="props.item.path">
						        	<v-img
				      	  				v-bind:src="props.item.path"
				      	  				aspect-ratio="1"
				      				></v-img>
			      				</a>
					        </td>

					        <td class="text-xs-right">{{ props.item.name }}</td>
					        <td class="text-xs-right">{{ props.item.iso }}</td>
					        <td class="text-xs-right">{{ props.item.exptime }}</td>
					        <td class="text-xs-right">{{ props.item.ar }}</td>
					        <td class="text-xs-right">{{ props.item.dec }}</td>
					        <td class="text-xs-right">{{ props.item.created_at }}</td>
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
        dialog2: false,
        dialog3: false,
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
        type:'Planet',
        types:[	'Planet',
        		'Asterismo o Cúmulo Abierto',
				'Cúmulo abierto',
				'Cúmulo Globular',
				'Estrella',
				'Estrella doble',
				'Galaxia',
				'Galaxias en Interacción',
				'Nebulosa',
				'Nebulosa de emisión Hidrógeno',
				'Nebulosa de Reflexión',
				'Nebulosa Extragaláctica',
				'Nebulosa Planetaria',
				'Nebulosa y Cúmulo',
				'Nova',
				'Otro',
				'Par de Galaxias',
				'Remanente de Supernova',
				'Trío de Galaxias',],
        Constellation:'',
        Constellations: [],
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
      	
    },
    mounted (){
    	this.initialize();
    },
    methods: {
    	showAlert(a){
      	//	if (event.target.classList.contains('btn__content')) return;
      		var app = this;
 
      		this.object = a.name;
      		this.Ar_screen = a.ra;
      		this.Dec_screen = a.dec;


      		if(a.catalog=='SolarSistem'){
	      		axios.get('/api/astronomic_objects/solarsistem?object=' + a.name)
	            .then(function (resp) {    
	            	//alert(JSON.stringify(resp.data));
	            	app.Ar = resp.data["ar"];
	            	app.Dec = resp.data["dec"];
	            	app.Ar_screen = resp.data["ar"];
	            	app.Dec_screen = resp.data["dec"];
	            })
	            .catch(function (resp) {
	                console.log(resp);
	                alert("Error shoot :" + resp);
	            });
      		}     

      		this.coords(a.ra, a.dec); 		
    	},
      	initialize () {
            this.openChat();
            this.getMyImages();
            this.getAstrnomicObject();
        },

        getAstrnomicObject(){
        	var app=this;
        	axios.get('/api/astronomic_objects?constellation=' + app.contellation +'&catalog='+app.catalog+'&type='+app.type)
            .then(function (resp) {
              	app.FilteredObjects = resp.data;
            	// const distinctConst=[...new Set(app.astronomic_objects.map(x => x.constellation))];
            	// app.Constellations = distinctConst.sort();
            	// alert(JSON.stringify(app.FilteredObjects));
            })
            .catch(function (resp) {
                //console.log(resp);
                alert("Error astronomic_objects :" + resp);
            });
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
        	this.catalog = a;
        	this.getAstrnomicObject();
        },
        filterType(a){
        	this.type = a;
        	this.getAstrnomicObject();	
        	
        },
        filterConstellation(a){
        	if(a=="Todas"){
        		this.FilteredObjects = this.astronomic_objects
        	} else {
        		this.FilteredObjects = this.FilteredObjects.filter(it => it.constellation==a );	
        	}
        },

        move(){
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
        	var $command = {'command': 'ENFOCADOR', 'type': 'focuser', 'status': 'PENDIENTE',
        	                'steps': this.Paso, 'direction': 1, 'user_id': 1, 'equipment_id': 1};

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
    		this.Ar_screen = this.h_ra+'h'+this.m_ra+'m'+this.s_ra+'s'
    		this.Dec_screen = this.h_dec+'h'+this.m_dec+'m'+this.s_dec+'s'

    		this.coords(this.Ar_screen, this.Dec_screen);
    		this.dialog2 = false;

    	},
    	savecoords (){
    		this.Ar_screen = this.h_ra+'h'+this.m_ra+'m'+this.s_ra+'s'
    		this.Dec_screen = this.h_dec+'°'+this.m_dec+'m'+this.s_dec+'s'

    		this.coords(this.Ar_screen, this.Dec_screen);
    		this.dialog3 = false;

    	}

    },
  }
</script>


