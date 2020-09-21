<template>

      <v-card>
        <v-toolbar dark color="morado">
          <v-toolbar-title>Galería de imagenes</v-toolbar-title>
        </v-toolbar>
        	<v-card class="px-2 py-4">
			    <v-layout row>
			    <v-flex xs12 class="px-2 py-4">
			                      <v-card>

			                        <v-data-table
			                          :headers="myImagesHeaders"
			                          :items="myImages"
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
	<!-- 		                            <td class="text-xs-left">{{ props.item.ar_string }}</td>
			                            <td class="text-xs-left">{{ props.item.dec_string }}</td>
			                            <td class="text-xs-left">{{ props.item.created_at }}</td> -->
	<!-- 		                            <td>
			                                <v-btn round color="morado" small class="white--text"  @click="download">
			                                  <v-icon>cloud_download</v-icon>
			                                  Imagen Raw
			                                </v-btn>
			                            </td> -->
			                          </template>
			                          
			                        </v-data-table>
			                      </v-card> 
			    </v-flex>
			    </v-layout>
			</v-card>

   
            


      </v-card>


  
</template>
<script>
  import { mapState } from 'vuex';
  export default {
    data () {
      return {
        dialog: true,

        userId: 0,
        selected: '100',
       
        rowsPerPageItems: [3, 5, 10, 20],	
        pagination: {
            rowsPerPage: 3
        },  

        myImages: [],

        myImagesHeaders: [
          { text: 'Foto', value: 'img' },
          { text: 'Nombre', value: 'name' },
          { text: 'ISO', value: 'iso' },
          { text: 'TiempoExp', value: 'exptime' },

        ],
     
      }
    },
    created () {
        this.initialize();
    },
    methods: {

        initialize () {
        	this.getMyImages()
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


        GetFormattedDate() {
            var todayTime = new Date();
            var month = (todayTime.getMonth() + 1);
            var day = (todayTime.getDate());
            var year = (todayTime.getFullYear());
            return  day+ "/" + month + "/" + year;
        }



    },
  }
</script>