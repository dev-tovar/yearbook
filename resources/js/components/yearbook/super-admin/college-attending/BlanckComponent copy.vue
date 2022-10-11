<template>
  <v-container fluid class="px-0">
    <v-card color="transparent" tile elevation="0">
      <v-card-title class="font-weight-bold text-h4 text-center d-block py-5">
        <v-row dense>
          <v-col cols="12" md="12" class="pa-0 ma-0 text-center">
            <span> College Attending </span>
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
      
      <v-card-text class="d-flex">
        <v-spacer></v-spacer>
        <v-btn depressed rounded text class="text-capitalize mr-3" @click="addNewItem">Add <v-icon right>mdi-plus</v-icon></v-btn>
        <v-btn depressed rounded color="primary" class="text-capitalize">Save <v-icon right>mdi-content-save</v-icon></v-btn>
      </v-card-text>
      <v-card-text >
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
    };
  },
  mounted() {

  },
  methods: {
   
  },
};
</script>


