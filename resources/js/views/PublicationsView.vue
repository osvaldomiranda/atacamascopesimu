<template>

      <v-card>
        <v-toolbar dark color="verde">
          <v-toolbar-title>Noticias</v-toolbar-title>
        </v-toolbar>

  
            


      </v-card>


  
</template>
<script>
  export default {
    data: () => ({
      messages: [],
    }),
    created () {
        this.initialize();
    },
    methods: {
        initialize (){
            var app = this;

            axios.get('/api/publications')
            .then(function (resp) {    

                app.messages = resp.data;
            })
            .catch(function (resp) {
                console.log(resp);
                alert("Error publications :" + resp);
            });
        }
    }


  }
</script>