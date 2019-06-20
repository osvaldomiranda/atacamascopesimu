<template>
  <v-layout
    column
    justify-center
  >
    <v-subheader>Publicaciones</v-subheader>

    <v-expansion-panel popout>
      <v-expansion-panel-content
        v-for="(message, i) in messages"
        :key="i"
        hide-actions
      >
        <template v-slot:header>
          <v-layout
            row
            spacer
          >
            <v-flex xs2>
                <v-card>
                    <v-img
                        v-bind:src="message.image"
                        aspect-ratio="1"
                    ></v-img>

                </v-card> 
            </v-flex>
            <v-flex xs1>
            </v-flex>
            <v-flex xs6>
                <span class="headline">{{ message.title }}</span>

            </v-flex>

            <v-flex xs2 v-if="message.external_link" >
                <a  :href="message.external_link" target=_blank> 
                    <v-chip color="green" text-color="white">Ver Fuente</v-chip>
                </a>
            </v-flex>

           
          </v-layout>
        </template>

        <v-card>
          <v-divider></v-divider>
          <v-card-text v-text="message.text"></v-card-text>
        </v-card>
      </v-expansion-panel-content>
    </v-expansion-panel>
  </v-layout>
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