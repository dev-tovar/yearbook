<template>
  <v-container fluid class="px-0">
    <v-card color="transparent" tile elevation="0">
      <v-card-title class="font-weight-bold text-h4 py-5">
        <v-row dense>
          <v-col cols="12" md="12" class="pa-0 ma-0 text-center">
            <router-link
              to="/admin/user_manager/1"
              class="font-weight-bold"
              style="position: absolute; left: 7px;text-decoration: none"
              ><v-icon color="primary" size="30"
                >mdi-arrow-left</v-icon
              ></router-link
            >
            <span> User manager </span>
            <div class="admin-btn-new-feed">
              
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
              >Create</v-btn
            >
            </div>

            
          </v-col>
        </v-row>
      </v-card-title>
      <v-divider class="mt-3"></v-divider>
      <v-card-text>
        <v-row dense>
          <v-col cols="12" md="4"> </v-col>
          <v-col cols="12" md="4">
            <v-card elevation="0" class="mx-auto mt-5" max-width="370">
              <v-row wrap>
                <v-col cols="12" md="12" sm="12" class="py-1">
                  <span class="font-weight-bold">Name:</span>
                  <v-text-field
                    height="52"
                    class="rounded-lg admin-input"
                    outlined
                    dense
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="12" sm="12" class="py-1">
                  <span class="font-weight-bold">Email:</span>
                  <v-text-field
                    height="52"
                    class="rounded-lg admin-input"
                    outlined
                    dense
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="12" sm="12" class="py-1">
                  <span class="font-weight-bold">Grade level:</span>
                  <v-select
                    height="52"
                    class="rounded-lg admin-input"
                    outlined
                    dense
                  ></v-select>
                </v-col>
                <v-col cols="12" md="12" sm="12" class="py-1">
                  <span class="font-weight-bold">Status:</span>
                  <v-select
                    height="52"
                    class="rounded-lg admin-input"
                    outlined
                    dense
                  ></v-select>
                </v-col>
                <v-col cols="12" md="12" sm="12" class="py-1">
                  <span class="font-weight-bold">User type:</span>
                  <v-select
                    height="52"
                    class="rounded-lg admin-input"
                    outlined
                    dense
                  ></v-select>
                </v-col>
                
               <v-col cols="12" md="12" sm="12" class="py-1">
                  <v-divider class="mb-4"></v-divider>
                </v-col>

               <v-col cols="12" md="12" sm="12" class="py-1">          
                        <span class="font-weight-bold">Password:</span>
                <v-text-field
                    height="52"
                    class="rounded-lg admin-input"
                    :class="
                      !showPassword ? 'login-input password' : 'login-input'
                    "
                    dense
                    outlined
                    :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                    @click:append="showPassword = !showPassword"
                  ></v-text-field>
                </v-col>
               <v-col cols="12" md="12" sm="12" class="py-1">
                  <v-divider></v-divider>
                </v-col>
                <v-col cols="12" md="12" sm="12" class="py-1">
                  <v-checkbox
                    class="mt-0"
                    v-model="checkbox"
                    value="1"
                    label="Faculty"
                  ></v-checkbox>
                  <v-checkbox
                    class="mt-0"
                    v-model="checkbox"
                    value="2"
                    label="Alumni"
                  ></v-checkbox>
                </v-col>
               
                
              
              </v-row>
            </v-card>
          </v-col>
          <v-col cols="12" md="4">
          </v-col>
        </v-row>
      </v-card-text>
      <v-divider class="mt-3"></v-divider>
      <v-card-actions>
        <v-row dense>
          <v-col cols="12" md="4"> </v-col>
          <v-col cols="12" md="4">
            <v-card elevation="0" class="mx-auto" max-width="450">
              <v-card-actions class="text-center d-block">
              
                <v-btn
                  x-large
                  outlined
                  rounded
                  width="269"
                  color="primary"
                  class="text-capitalize font-weight-bold admin-btn-bg"
                  >Create</v-btn
                >
              </v-card-actions>
            </v-card>
          </v-col>
          <v-col cols="12" md="4"> </v-col>
        </v-row>
      </v-card-actions>
    </v-card>
  </v-container>
</template>

<script>

export default {
  components: {
  },
  data() {
    return {
      showPassword: false,
      checkbox: [],
     

      
      
    };
  },
  computed: {
   
  },
  mounted() {
    console.log("Component mounted.");
  },
  methods: {
   
   
  },
};
</script>

