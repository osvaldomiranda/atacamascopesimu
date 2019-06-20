<template>
  <v-layout
    column
    justify-center
  >
    <v-subheader>Equipamiento</v-subheader>

    <v-expansion-panel popout>
      <v-expansion-panel-content
        v-for="(equipment, i) in equipments"
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
                        v-bind:src="equipment.image"
                        aspect-ratio="1"
                    ></v-img>

                </v-card> 
            </v-flex>
            <v-flex xs1>
            </v-flex>
            <v-flex xs6>
                <span class="headline">{{ equipment.name }}</span>

            </v-flex>

            <v-flex xs2 v-if="equipments.points" >
                    <v-chip color="green" text-color="white">Puntos por hora: {{ equipment.points }}</v-chip>                
            </v-flex>

           
          </v-layout>
        </template>

        <v-card>
          <v-divider></v-divider>
          <v-card-text v-text="equipment.description"></v-card-text>
        </v-card>
      </v-expansion-panel-content>
    </v-expansion-panel>
  </v-layout>
</template>
<script>
  export default {
    data: () => ({
      equipments: [],
    }),
    created () {
        this.initialize();
    },
    methods: {
        initialize (){
            var app = this;


        axios.get('/api/equipments')
            .then(function (resp) {    
                // alert(JSON.stringify(resp.data));
                app.equipments=resp.data;
            })
            .catch(function (resp) {
                console.log(resp);
                alert("Error equipments :" + resp);
            });
        }
    }


  }
</script>