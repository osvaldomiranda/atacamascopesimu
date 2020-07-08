<style scoped>
.loading_width{
  width: auto;
}
.loading-dialog {
   background-color: #303030; 
}
</style>

<template>
  <v-layout row justify-center>
    <v-dialog v-model="dialog" persistent content content-class="centered-dialog" width="400">
      <v-card color="main_green" dark column justify-center align-center>
        <v-card-text class="loading_width">
          {{title}}
          <v-progress-linear
            indeterminate
            color="white"
            class="mb-0"
          ></v-progress-linear>
        </v-card-text>
      </v-card>
    </v-dialog>
  </v-layout>
</template>

<script>
  export default {
    /*props: {
      title: String,
    },*/
    data () {
      return {
        title: 'Cargando datos ...',
        dialog: false,
      }
    },

    /*watch: {
      dialog (val) {
        if (!val) return

        setTimeout(() => (this.dialog = false), 4000)
      },*/
        methods: {
          show(msje=""){
            if (msje){
              this.title = msje
            }
            this.dialog=true
          },
          hide(){
            this.dialog=false
          }

        }      
    }
</script>