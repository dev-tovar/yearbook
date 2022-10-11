<template>
  <v-container fluid class="px-0">
    <v-card color="transparent" tile elevation="0">
      <v-card-title class="font-weight-bold text-h4 text-center d-block py-5">
        <v-row dense>
          <v-col cols="12" md="12" class="pa-0 ma-0 text-center">
            <span> List of Super Admins </span>
            <div class="admin-btn-new-feed">
          
              <v-btn
                 to="/pyb/super-admin/admins/create"
                right
                x-large
                outlined
                rounded
                width="230"
                color="primary"
                class="text-capitalize font-weight-bold admin-btn-bg"
                >Add New Super Admin</v-btn
              >
            </div>
          </v-col>
        </v-row>
      </v-card-title>
      <v-divider class="mt-3"></v-divider>
      
      <v-card-text class="px-0">
        <v-data-table
          :headers="headers_admins"
          :items="items_admins"
          :items-per-page="10"
          class="elevation-0 table-custom"
        >
     

          
          <template v-slot:item.actions="{ item }">
            <div class="d-flex">
              <router-link style="text-decoration: none" :to="'/pyb/super-admin/admins/'+item.id+'/edit'">
                <v-icon size="18" color="primary" small>
                  mdi-pencil-outline
                </v-icon></router-link
              >

          
            </div>
          </template>

          
          <!-- <template v-slot:no-data>
            <v-btn color="primary" @click="initialize"> Reset </v-btn>
          </template>-->
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
     

      headers_admins: [
       
        { text: "Name", sortable: false, value: "name" },
        { text: "Email", sortable: false, value: "email" },
        { text: "Date Created	", sortable: false, value: "date_create" },
        { text: "", sortable: false, value: "actions" },
       
       ],
      items_admins: [],
    };
  },
  mounted() {
    console.log("Component mounted.");
    this.getAdminsInfo();
  },
  methods: {
    getAdminsInfo() {
      axios
        .get("/info_admins")
        .then((res) => {
          this.items_admins = res.data.admins.data;
        })
        .catch((err) => {
          console.error(err);
        });
    },
  },
};
</script>


