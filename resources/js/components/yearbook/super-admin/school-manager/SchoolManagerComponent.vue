<template>
  <v-container fluid class="px-0">
    <v-card color="transparent" tile elevation="0">
      <v-card-title class="font-weight-bold text-h4 text-center d-block py-5">
        <v-row dense>
          <v-col cols="12" md="12" class="pa-0 ma-0 text-center">
            <span> School Manager </span>
            <div class="admin-btn-new-feed">
              <v-btn
              to="/pyb/super-admin/school_manager/create"
              right
              x-large
              outlined
              rounded
              width="182"
              color="primary"
              class="
                text-capitalize
                font-weight-bold
              "
              >Add New School</v-btn
            >
              <v-btn
              right
              x-large
              outlined
              rounded
              width="202"
              color="primary"
              class="
                text-capitalize
                font-weight-bold
                admin-btn-bg
              "
              >Import Schools</v-btn
            >
            </div>

            
          </v-col>
        </v-row>
      </v-card-title>
      <v-divider class="mt-3"></v-divider>
      <v-card-text>
        <v-card elevation="0" class="mx-auto">
          <v-card-text>
            <v-row wrap>
              <v-col cols="12" md="3" sm="12">
                <span class="font-weight-bold">Search</span>
                <v-text-field
                  placeholder="Search"
                  height="52"
                  class="rounded-lg admin-input"
                  outlined
                  dense
                  append-icon="mdi-magnify"
                  hide-details
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="3" sm="12">
                <span class="font-weight-bold">Filter by date</span>
                   <v-select
                  height="52"
                  class="rounded-lg admin-input"
                  outlined
                  dense
                  hide-details
                ></v-select>
              </v-col>
              <v-col cols="12" md="3" sm="12">
                <span class="font-weight-bold">Status</span>
                   <v-select
                  height="52"
                  class="rounded-lg admin-input"
                  outlined
                  dense
                  hide-details
                ></v-select>
              </v-col>
              <v-col cols="12" md="3" sm="12">
                <span class="font-weight-bold">Number of students</span>
                   <v-select
                  height="52"
                  class="rounded-lg admin-input"
                  outlined
                  dense
                  hide-details
                ></v-select>
              </v-col>
              <v-col cols="12" md="3" sm="12">
                <span class="font-weight-bold">Grade level</span>
                   <v-select
                  height="52"
                  class="rounded-lg admin-input"
                  outlined
                  dense
                  hide-details
                ></v-select>
              </v-col>
              
            </v-row>
          </v-card-text>
        </v-card>
      </v-card-text>
      <v-card-text class="px-0">
        <v-data-table
          :headers="headers_feeds"
          :items="items_school"
          :items-per-page="10"
          class="elevation-0 table-custom"
        >
          <template v-slot:item.photo="{ item }">
            <v-avatar size="30" tile>
              <v-img src="https://cdn.vuetifyjs.com/images/john.jpg"></v-img>
            </v-avatar>
          </template>

          <template v-slot:item.actions="{ item }">
          
            <v-icon size="18" color="primary" small class="mr-3">
              mdi-file-pdf-box
            </v-icon>
            <v-icon size="18" color="primary" small class="mr-3">
              mdi-pencil-outline
            </v-icon>
            <v-icon
              @click="dialog_delete_feed = true"
              size="18"
              color="primary"
              small
            >
              mdi-trash-can-outline
            </v-icon>
          </template>
          <!-- <template v-slot:no-data>
            <v-btn color="primary" @click="initialize"> Reset </v-btn>
          </template> -->
        </v-data-table>
      </v-card-text>
    </v-card>
    <v-dialog
      v-model="dialog_delete_feed"
      scrollable
      persistent
      max-width="400px"
      transition="dialog-transition"
      content-class="rounded-xl"
    >
      <v-card class="rounded-xl" elevation="3">
        <v-card-title class="d-block text-center py-9 text-h5 font-weight-bold">
          Delete this post?
          <v-btn @click="dialog_delete_feed = !dialog_delete_feed" class="admin-btn-close-dialog" small icon fab>
            <v-icon color="primary" size="30">
              mdi-close
            </v-icon>
          </v-btn>
        </v-card-title>
        <v-card-text class="text-center font-weight-bold grey lighten-4 pt-5">
          Are you sure you want to delete <br />
          this news feed?
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions class="py-5 grey lighten-4">
          <v-spacer></v-spacer>

          <v-btn
            x-large
            outlined
            rounded
            width="140"
            color="primary"
            class="text-capitalize font-weight-bold mr-3"
            >No</v-btn
          >
          <v-btn
            x-large
            outlined
            rounded
            width="140"
            color="primary"
            class="text-capitalize font-weight-bold admin-btn-bg"
            >Yes</v-btn
          >
          <v-spacer></v-spacer>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script>
import daterange from "../../custom-inputs/datePickerRange.vue";

export default {
  components: {
    "date-picker-range": daterange,
  },
  data() {
    return {
      dialog_delete_feed: false,
      filter_user: {
        filter_fechas: [],
      },

      headers_feeds: [
        {
          text: "Date",
          align: "start",
          value: "date_create",
        },
        { text: "School", value: "name" },
        { text: "Address", value: "address" },
        { text: "Grade Level", value: "grade" },
        { text: "# of students", value: "students_number" },
        { text: "# of uploaded students", value: "total_users_count" },
        { text: "Yearbook Advisor", value: "advisor" },
        { text: "Contract Status", value: "contract_status" },
        { text: "Actions", align: "center", sortable: false, value: "actions" },
      ],
      items_school: [
      ],
    };
  },
  mounted() {
    console.log("Component mounted.");
    this.getSchoolManagerInfo();
  },
  methods: {
    getSchoolManagerInfo(){
      axios.get('/info_school_manager')
      .then(res => {
          this.items_school = res.data.schools.data
      })
      .catch(err => {
        console.error(err); 
      })
    }
   
  },
};
</script>

<style>
.table-custom tbody tr:nth-of-type(odd) {
  background-color: rgba(0, 0, 0, 0.05);
}
</style>
