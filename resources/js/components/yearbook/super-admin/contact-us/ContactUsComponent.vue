<template>
  <v-container fluid class="px-0">
    <v-card color="transparent" tile elevation="0">
      <v-card-title class="font-weight-bold text-h4 text-center d-block py-5">
        <v-row dense>
          <v-col cols="12" md="12" class="pa-0 ma-0 text-center">
            <span> Contact Us </span>
            <!-- <div class="admin-btn-new-feed">
              <v-btn
                to="/pyb/super-admin/school_manager/create"
                right
                x-large
                outlined
                rounded
                width="182"
                color="primary"
                class="text-capitalize font-weight-bold"
                >Add New School</v-btn
              >
              <v-btn
                right
                x-large
                outlined
                rounded
                width="202"
                color="primary"
                class="text-capitalize font-weight-bold admin-btn-bg"
                >Import Schools</v-btn
              >
            </div> -->
          </v-col>
        </v-row>
      </v-card-title>
      <v-divider class="mt-3"></v-divider>
      
      <v-card-text class="px-0">
        <v-data-table
          :headers="headers_contact"
          :items="items_contact"
          :items-per-page="10"
          class="elevation-0 table-custom"
        >
     

          <!-- <template v-slot:item.contract="{ item }">
            <v-icon
              v-if="!item.contract"
              size="18"
              color="primary"
              small
              class="mr-3"
            >
              mdi-file-pdf-box
            </v-icon>
            <a
              v-else
              :href="'/' + item.contract.path"
              target="_blank"
              :rel="item.contract.original_name"
              >{{ item.contract.original_name }}</a
            >
          </template> -->

          
          <!-- <template v-slot:no-data>
            <v-btn color="primary" @click="initialize"> Reset </v-btn>
          </template> -->
        </v-data-table>
      </v-card-text>
    </v-card>
  
  </v-container>
</template>

<script>

export default {
  components: {
  },
  data() {
    return {
     

      headers_contact: [
        {
          text: "User",
          align: "start",
          sortable: false,
          value: "User",
        },
        { text: "School", sortable: false, value: "name" },
        { text: "Subject", sortable: false, value: "Subject" },
        { text: "Message", sortable: false, value: "grade" },
        { text: "Created At", sortable: false, value: "students_number" },
        {
          text: "Attachments",
          sortable: false,
          value: "total_users_count",
        }
       ],
      items_contact: [],
    };
  },
  mounted() {
    console.log("Component mounted.");
  },
  methods: {
    
  },
};
</script>


