<template>
  <v-layout>
    <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
<!--       <template v-slot:activator="{ on }">
        <v-btn color="warning" dark v-on="on">Interfaz de Control</v-btn>
      </template> -->
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
					    		<a  :href="imageUrl">
					      		<v-img
					      	  		v-bind:src="imageUrl"
					      	  		aspect-ratio="1"
					      		></v-img>
					      		</a>
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
							    item-text='latin'
							    label="Constelación"
							    @input= "filterConstellation"
							    return-object
							    single-line
						        hide-details
							    ></v-select>
							<v-spacer></v-spacer>    	
						      <v-text-field
						        v-model="search"
						        label="Buscar"
						        single-line
						        hide-details
						      ></v-text-field>
						      <v-spacer></v-spacer> 
						      <v-btn @click='search_object' flat icon color="blue lighten-2">
            					<v-icon>search</v-icon>
        					  </v-btn>

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
						        <td class="text-xs-right">{{ props.item.name }}</td>
						        <td class="text-xs-right">{{ props.item.catalog }}</td>
						        <td class="text-xs-right">{{ props.item.type_object }}</td>
						        <td class="text-xs-right">{{ props.item.constellation }}</td>
						        <td class="text-xs-right">{{ (props.item.colloquial_name || '') + ' ' + (props.item.nombre_coloquial || '')}}</td>
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
				                	<span class="display-1"> {{ object }}</span>
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
								    readonly=true
								    ></v-text-field>
		          			</v-flex>
							<v-flex align-center xs1>
							</v-flex>
							<v-flex align-center xs4>
								<v-text-field
								    v-model="Dec_screen"
								    label="Declinación"
								    readonly=true
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
								    type="number" 
								    min:0
								    max:23
								    :rules='twentythreeRule'
								    label="AR Horas"
								    ></v-text-field>
		          			</v-flex>
							<v-flex align-center xs1>
							</v-flex>
							<v-flex align-center xs3>
								<v-text-field 
									v-model="m_ra" 
								    min:0
								    max:59
									type="number" 
									:rules='sixtyRule'
									label="AR Minutos" 
									append-outer-icon="add_circle_outline" @click:append-outer="inc_m_ra" 
									prepend-icon="remove_circle_outline" @click:prepend="dec_m_ra">
								</v-text-field>
		          			</v-flex>
							<v-flex align-center xs1>
							</v-flex>	
							<v-flex align-center xs3>

								<v-text-field 
									v-model="s_ra" 
									type="number" 
									label="AR Segundos" 
								    min:0
								    max:59
									:rules='sixtyRule'
									readonly
									append-outer-icon="add_circle_outline" @click:append-outer="inc_s_ra" 
									prepend-icon="remove_circle_outline" @click:prepend="dec_s_ra">
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
								    type="number" 
								    label="DEC Grados"
								    min:-90
								    max:90								        
								    :rules='ninetyRule'
								></v-text-field>
		          			</v-flex>
							<v-flex align-center xs1>
							</v-flex>
							<v-flex align-center xs3>
								<v-text-field 
									v-model="m_dec" 
								    min:0
								    max:59	
									type="number" 
									label="DEC Minutos" 
									:rules='sixtyRule'
									append-outer-icon="add_circle_outline" @click:append-outer="inc_m_dec" 
									prepend-icon="remove_circle_outline" @click:prepend="dec_m_dec">
								</v-text-field>
		          			</v-flex>
							<v-flex align-center xs1>
							</v-flex>	
							<v-flex align-center xs3>
								<v-text-field 
									v-model="s_dec" 
									type="number" 
									label="DEC Segundos" 
									:rules='sixtyRule'
								    min:0
								    max:59	
									append-outer-icon="add_circle_outline" @click:append-outer="inc_s_dec" 
									prepend-icon="remove_circle_outline" @click:prepend="dec_s_dec">
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
								    max:23
								    :rules='twentythreeRule'
								    type="number" 	
								    label="AR Horas"
								    ></v-text-field>
		          			</v-flex>
							<v-flex align-center xs1>
							</v-flex>
							<v-flex align-center xs3>
								<v-text-field
								    min:0
								    max:59
								    :rules='sixtyRule'
								    v-model="m_ra"
								    type="number" 
								    label="AR Minutos"
								    ></v-text-field>
		          			</v-flex>
							<v-flex align-center xs1>
							</v-flex>	
							<v-flex align-center xs3>
								<v-text-field
								    v-model="s_ra"
								    min:0
								    max:59
								    :rules='sixtyRule'
								    label="AR Segundos"
								    type="number" 
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
								    min:-90
								    max:90
								    :rules='ninetyRule'
								    label="DEC Grados"
								    type="number" 
								    ></v-text-field>
		          			</v-flex>
							<v-flex align-center xs1>
							</v-flex>
							<v-flex align-center xs3>
								<v-text-field
								    v-model="m_dec"
								    label="DEC Minutos"
								    min:0
								    max:59
								    :rules='sixtyRule'
								    type="number" 
								    ></v-text-field>
		          			</v-flex>
							<v-flex align-center xs1>
							</v-flex>	
							<v-flex align-center xs3>
								<v-text-field
								    v-model="s_dec"
								    min:0
								    max:59
								    :rules='sixtyRule'
								    label="DEC Segundos"
								    type="number" 
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
							      item-text='iso'
							      return-object
							      :rules="[v => !!v || 'Obligatorio']"
							      label="Sencibilidad"
							      @input= "selectIso"
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

						<v-layout row>
							<v-flex align-center xs1>
							</v-flex>
							<v-flex align-center xs1>
								<p>Tics 0</p>
							</v-flex>	
						    <v-flex xs8>


							    <v-slider
							        v-model="slider"
							        thumb-label="always"
							        min="0"
							        max="30000"
							    >
							    </v-slider>


						    </v-flex>
							<v-flex align-center xs1>
								<p>30000</p>
							</v-flex>	
		          		</v-layout>	
		          		<v-layout row>
		          		    <v-flex xs1>
		          		    </v-flex>
		          		    <v-flex xs4>
		          		    	<v-text-field
								    v-model="slider"
								    min:0
								    max:30000
								    label="Tics"
								    type="number" 
								    ></v-text-field>
		          		    </v-flex>
		          		    <v-flex xs1>
		          		    </v-flex>
		          		    <v-flex xs4>
		          		    	<v-btn color="warning" @click="focus">Enfocar</v-btn>	
		          		    </v-flex>
		          		</v-layout>
		          		
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
					        	<a :href="props.item.path">
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
	        '60',
	    ],

        headers: [
          { text: 'Nombre', value: 'name' },
          { text: 'Catalogo', value: 'catalog' },
          { text: 'Tipo', value: 'type_object' },
          { text: 'Constelación', value: 'constellation' },
          { text: 'Descripción', value: 'colloquial_name' },
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

      		if(a.catalog=='SolarSistem'){
	      		axios.get('/api/astronomic_objects/solarsistem?object=' + a.name)
	            .then(function (resp) {    
	            	//alert(JSON.stringify(resp.data));
	            	app.Ar_screen = resp.data["ar"];
	            	app.Dec_screen = resp.data["dec"];
	            	app.coords(app.Ar_screen, app.Dec_screen); 
	            })
	            .catch(function (resp) {
	                console.log(resp);
	                alert("Error shoot :" + resp);
	            });
      		} else {

      			this.Ar_screen = a.ra;
      			this.Dec_screen = a.dec;
      			this.coords(app.Ar_screen, app.Dec_screen); 
      		}    

      				
    	},
      	initialize () {
      		this.imageRefresh();
            this.openChat();
            this.getMyImages();
            this.getAstrnomicObject();
        },

        search_object() {
        	alert("Search");
        	var app=this;
        	axios.get('/api/search_objects?name=' + app.search )
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

        getAstrnomicObject(){
        	var app=this;
        	axios.get('/api/astronomic_objects?constellation=' + app.constellation +'&catalog='+app.catalog+'&type='+app.type)
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


// app_id = "764758"
// key = "6a09b6dc7cbc0cce55a3"
// secret = "3821c2b9107f68e63aba"
// cluster = "us2"


	        var pusher = new Pusher('6a09b6dc7cbc0cce55a3', {
	            cluster: 'us2',
	            forceTLS: true
	        })

	        var channel = pusher.subscribe('newMessage-1-2') // newMessage-[chatting-with-who]-[my-id]

	        channel.bind('App\\Events\\MessageSent', function (data) {
	            
	            app.state = data.message['message'];
	            alert(JSON.stringify(data.message));

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
        	// alert(JSON.stringify(a));
        	// alert(a.name);
        	this.constellation = a.name;
        	this.getAstrnomicObject();
        },

        move(){

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
        	var $command = {'command': 'CAMARA', 'type': 'shoot', 'status': 'PENDIENTE',
        	                'exptime': this.Exp, 'iso': this.Iso, 'ar': this.Ar_act, 'dec': this.Dec_act, 'user_id': this.$store.getters.user['id'], 'equipment_id': 1};

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
        	                'steps': this.slider, 'direction': 1, 'user_id': this.$store.getters.user['id'], 'equipment_id': 1};

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
    		this.Iso = a.choice;
    	}

    },
  }
</script>
