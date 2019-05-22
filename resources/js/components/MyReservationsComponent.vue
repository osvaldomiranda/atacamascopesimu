<template>
     <v-container fluid>

        <v-layout align-center row>
            <v-flex xs1>
            </v-flex>
  
        <v-flex xs10 style="overflow: auto">

            <v-card>
              <v-card-title>
                 <span class="headline">Mis Reservas</span>
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
                :items="reservations"
                :search="search"
                v-model="selected"
                :rows-per-page-items="rowsPerPageItems"
                :pagination.sync="pagination"
              >
                <template v-slot:items="props">
                  <tr @click="showAlert(props.item)">
                  <td class="text-xs-left">{{ props.item.equipment_image }}</td>
                  <td class="text-xs-left">{{ props.item.equipment_name }}</td>
                  <td class="text-xs-left">{{ props.item.reservation_date }}</td>
                  <td class="text-xs-left">{{ props.item.reservation_hour }}</td>
                  <td class="text-xs-left">{{ props.item.reservation_time }}</td>
                  <td class="text-xs-left"> <control-component></control-component> </td>
                </tr>
                </template>
                <v-alert v-slot:no-results :value="true" color="error" icon="warning">
                  Your search for "{{ search }}" found no results.
                </v-alert>
              </v-data-table>
            </v-card> 
            <v-flex xs1>
            </v-flex>
        </v-flex>
                
        </v-layout>
    </v-container>    

</template>
<script>
  	export default {
    	data () {
    	}
}
