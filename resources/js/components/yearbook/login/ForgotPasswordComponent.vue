<template>
  <v-container class="accent" fluid fill-height>
    <v-card color="transparent" class="mx-auto" width="465" elevation="0">
      <v-card-actions class="px-0 py-5" style="justify-content: center">
        <v-img
          max-width="84.97"
          src="/img/logos/top-link.png"
          class="mr-5"
        ></v-img>
        <v-img max-width="256.54" src="/img/logos/logo_black.png"></v-img>
      </v-card-actions>
      <v-card-text>
        <v-card class="mt-4 rounded-xl" elevation="3">
          <v-card-title
            class="text-center font-weight-bold d-block text-h4 py-9"
          >
            <p class="my-1">Reset Password</p>
          </v-card-title>
          <v-divider></v-divider>
          <v-form>
            <v-card-text class="px-9 py-9">
              <v-row wrap>
                <v-col sm="12" md="12" cols="12" class="px-7">
                  <span class="font-weight-bold">Email Address:</span>
                  <v-text-field
                    height="52"
                    class="rounded-lg login-input"
                    outlined
                    dense
                  ></v-text-field>
                </v-col>
                
                
              </v-row>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions class="py-9">
              <v-row align="center" no-gutters>
                <v-col  cols="12" class="text-center">
                  <div class="my-2">
                    <v-btn
                      x-large
                      outlined
                      rounded
                      width="350"
                      color="primary"
                      class="text-capitalize font-weight-bold login-btn"
                      >Send Password Reset Link</v-btn
                    >
                  </div>
                </v-col>
                <v-col cols="12" class="text-center">
                  <div class="my-2">
                      <router-link to="/login" class="font-weight-bold"
                    >Back</router-link
                  >
                  </div>
                </v-col>
              </v-row>
            </v-card-actions>
          </v-form>
        </v-card>
      </v-card-text>
    </v-card>
  </v-container>
</template>
<script>
export default {
  data() {
    return {
      showPassword: false,
      usernameRules: {
        required: (value) => !!value || "Requerido",
        minLength: (value) =>
          (value && value.length >= 8) || "Debe contener al menos 8 caracteres",
      },
      passwordRules: {
        required: (value) => !!value || "Requerida",
        minLenght: (value) =>
          value.length >= 8 || "Debe contener al menos 8 caracteres",
      },
    };
  },
};
</script>