<template>
  <v-layout
    column
    justify-center
  >
    <v-subheader>Equipamiento</v-subheader>

    <new-equipment></new-equipment>

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
                <upload-equipment-image></upload-equipment-image>
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

      dialog: false,
      headers: [
        {
          text: 'Dessert (100g serving)',
          align: 'left',
          sortable: false,
          value: 'name'
        },
        { text: 'Calories', value: 'calories' },
        { text: 'Fat (g)', value: 'fat' },
        { text: 'Carbs (g)', value: 'carbs' },
        { text: 'Protein (g)', value: 'protein' },
        { text: 'Actions', value: 'name', sortable: false }
      ],
      desserts: [],
      editedIndex: -1,
      editedItem: {
        name: '',
        calories: 0,
        fat: 0,
        carbs: 0,
        protein: 0
      },
      defaultItem: {
        name: '',
        calories: 0,
        fat: 0,
        carbs: 0,
        protein: 0
      }


    }),
    created () {
        this.initialize();
    },
    // methods: {
    //  initialize (){
    //      var app = this;


    //  axios.get('/api/equipments')
    //      .then(function (resp) {    
    //          // alert(JSON.stringify(resp.data));
    //          app.equipments=resp.data;
    //      })
    //      .catch(function (resp) {
    //          console.log(resp);
    //          alert("Error equipments :" + resp);
    //      });
    //  }
    // }

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
      }
    },

    watch: {
      dialog (val) {
        val || this.close()
      }
    },


    methods: {
      initialize () {
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
        

        this.desserts = [
          {
            name: 'Frozen Yogurt',
            calories: 159,
            fat: 6.0,
            carbs: 24,
            protein: 4.0
          },
          {
            name: 'Ice cream sandwich',
            calories: 237,
            fat: 9.0,
            carbs: 37,
            protein: 4.3
          },
          {
            name: 'Eclair',
            calories: 262,
            fat: 16.0,
            carbs: 23,
            protein: 6.0
          },
          {
            name: 'Cupcake',
            calories: 305,
            fat: 3.7,
            carbs: 67,
            protein: 4.3
          },
          {
            name: 'Gingerbread',
            calories: 356,
            fat: 16.0,
            carbs: 49,
            protein: 3.9
          },
          {
            name: 'Jelly bean',
            calories: 375,
            fat: 0.0,
            carbs: 94,
            protein: 0.0
          },
          {
            name: 'Lollipop',
            calories: 392,
            fat: 0.2,
            carbs: 98,
            protein: 0
          },
          {
            name: 'Honeycomb',
            calories: 408,
            fat: 3.2,
            carbs: 87,
            protein: 6.5
          },
          {
            name: 'Donut',
            calories: 452,
            fat: 25.0,
            carbs: 51,
            protein: 4.9
          },
          {
            name: 'KitKat',
            calories: 518,
            fat: 26.0,
            carbs: 65,
            protein: 7
          }
        ]
      },

      editItem (item) {
        this.editedIndex = this.desserts.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        const index = this.desserts.indexOf(item)
        confirm('Are you sure you want to delete this item?') && this.desserts.splice(index, 1)
      },

      close () {
        this.dialog = false
        setTimeout(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        }, 300)
      },

      save () {
        if (this.editedIndex > -1) {
          Object.assign(this.desserts[this.editedIndex], this.editedItem)
        } else {
          this.desserts.push(this.editedItem)
        }
        this.close()
      }
    }



  }
</script>


