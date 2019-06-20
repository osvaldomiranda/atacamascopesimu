<template>
  <v-layout
    column
    justify-center
  >
    <v-subheader>Ofertas Vigentes</v-subheader>

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
            <v-flex xs4>
              <v-avatar
                size="120px"
              >
                <img
                  v-if="message.image"
                  :src="message.image"
                  alt="Avatar"
                >
              </v-avatar>
            </v-flex>

            <v-flex xs8>
                <span class="headline">{{ message.title }}</span>
            </v-flex>

<!--             <v-flex no-wrap xs5 sm3>
              <strong v-html="message.text"></strong>
            </v-flex> -->

<!--             <v-flex
              v-if="message.text"
              class="grey--text"
              ellipsis
              hidden-sm-and-down
            >
              &mdash;
              {{ message.text }}
            </v-flex> -->
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

            axios.get('/api/offers')
            .then(function (resp) {    

                app.messages = resp.data;
            })
            .catch(function (resp) {
                console.log(resp);
                alert("Error offers :" + resp);
            });
        }
    }


  }
</script>
