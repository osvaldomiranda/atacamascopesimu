<template>


	 <v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="500">
      <template v-slot:activator="{ on }">

        <v-btn v-on="on" flat icon color="red lighten-2">
            <v-icon>account_circle</v-icon>
        </v-btn>
        <!-- <v-btn color="primary" dark v-on="on">Upload</v-btn> -->
      </template>
      <v-card>
        <v-card-text>

			<v-flex xs12 class="text-xs-center text-sm-center text-md-center text-lg-center">
				<img :src="imageUrl" height="150" v-if="imageUrl"/>
				<v-text-field label="Select Image" @click='pickFile' v-model='imageName' prepend-icon='attach_file'></v-text-field>
				<input
					type="file"
					style="display: none"
					ref="image"
					accept="image/*"
					@change="onFilePicked"
				>
			</v-flex>
			
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" flat @click="submitFile">Guardar</v-btn>
          <v-btn color="green darken-1" flat @click="dialog = false">Cancelar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-layout>


</template>  





<script>
export default {
   data: () => ({
        title: "Image Upload",
        dialog: false,
		imageName: '',
		imageUrl: '',
		imageFile: ''
    }),

    methods: {
        pickFile () {
            this.$refs.image.click ()
        },
		
		onFilePicked (e) {
			const files = e.target.files
			if(files[0] !== undefined) {
				this.imageName = files[0].name
				if(this.imageName.lastIndexOf('.') <= 0) {
					return
				}
				const fr = new FileReader ()
				fr.readAsDataURL(files[0])
				fr.addEventListener('load', () => {
					this.imageUrl = fr.result
					this.imageFile = files[0] // this is an image file that can be sent to server...
				})
			} else {
				this.imageName = ''
				this.imageFile = ''
				this.imageUrl = ''
			}
		},

		submitFile(){
            var app= this;
            let formData = new FormData();
            formData.append('avatar', this.imageFile);

            axios.post( 'api/save_avatar',
                formData,
                {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
              }
            ).then(function (resp) {    
                //alert(JSON.stringify(resp.data));
                app.$store.commit('changeUser',resp.data);
            })
        	.catch(function(){
          		console.log('FAILURE!!');
        	});
        	this.dialog = false;
      },
    }

}	
</script>