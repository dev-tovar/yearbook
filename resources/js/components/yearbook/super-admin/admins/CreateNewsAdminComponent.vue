<template>
  <v-container fluid class="px-0">
    <v-card color="transparent" tile elevation="0">
      <v-card-title class="font-weight-bold text-h4 py-5">
        <v-row dense>
          <v-col cols="12" md="12" class="pa-0 ma-0 text-center">
            <router-link
              to="/pyb/super-admin/admins"
              class="font-weight-bold"
              style="position: absolute; left: 7px; text-decoration: none"
              ><v-icon color="primary" size="30"
                >mdi-arrow-left</v-icon
              ></router-link
            >
            <span v-if="type_form == 'create'"> Create New Super Admin </span>
            <span v-else-if="type_form == 'edit'"> Edit Admin </span>
            <div class="admin-btn-new-feed">
              <v-btn
               :loading="loading_request"
                :disabled="loading_request"
                v-if="type_form == 'create'"
                right
                x-large
                outlined
                rounded
                width="202"
                color="primary"
                class="text-capitalize font-weight-bold admin-btn-bg"
                @click="saveNewAdmin"
                >Create</v-btn
              >
              <v-btn
               :loading="loading_request"
                :disabled="loading_request"
                v-else-if="type_form == 'edit'"
                right
                x-large
                outlined
                rounded
                width="202"
                color="primary"
                class="text-capitalize font-weight-bold admin-btn-bg"
                @click="updateAdmin"
                >Save</v-btn
              >
            </div>
          </v-col>
        </v-row>
      </v-card-title>
      <v-divider class="mt-3"></v-divider>
      <v-card-text>
        <v-form ref="formadmin">
          <v-row dense>
            <v-col cols="12" md="4" :offset="4">
              <v-card elevation="0" class="mx-auto mt-5" max-width="370">
                <v-row wrap>
                  <v-col cols="12" md="12" sm="12" class="py-1">
                    <span class="font-weight-bold">Name:</span>
                    <v-text-field
                      :rules="[rules_form.required]"
                      v-model="form_admin.name"
                      height="52"
                      class="rounded-lg admin-input"
                      outlined
                      dense
                    ></v-text-field>
                  </v-col>

                  <v-col cols="12" md="12" sm="12" class="py-1">
                    <span class="font-weight-bold">Email:</span>
                    <v-text-field
                      :rules="[rules_form.required, rules_form.email]"
                      v-model="form_admin.email"
                      height="52"
                      class="rounded-lg admin-input"
                      outlined
                      dense
                    ></v-text-field>
                  </v-col>

                  <v-col cols="12" md="12" sm="12" class="py-1">
                    <span class="font-weight-bold"
                      >{{
                        type_form == "create" ? "Password:" : "New password"
                      }}:</span
                    >
                    <v-text-field
                      :rules="[
                        form_admin.password ? rules_form.required : true,
                      ]"
                      v-model="form_admin.password"
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
                    <span class="font-weight-bold">{{
                      type_form == "create"
                        ? "Confirm password:"
                        : "Confirm new password"
                    }}</span>
                    <v-text-field
                      :rules="[
                        form_admin.password ? rules_form.required : true,
                      ]"
                      v-model="form_admin.password_confirmation"
                      height="52"
                      class="rounded-lg admin-input"
                      :class="
                        !showPasswordConfirm
                          ? 'login-input password'
                          : 'login-input'
                      "
                      dense
                      outlined
                      :append-icon="
                        showPasswordConfirm ? 'mdi-eye' : 'mdi-eye-off'
                      "
                      @click:append="showPasswordConfirm = !showPasswordConfirm"
                    ></v-text-field>
                  </v-col>
                </v-row>
              </v-card>
            </v-col>
          </v-row>
        </v-form>
      </v-card-text>
      <v-divider class="mt-3"></v-divider>
      <v-card-actions>
        <v-row dense>
          <v-col cols="12" md="4"> </v-col>
          <v-col cols="12" md="4">
            <v-card elevation="0" class="mx-auto" max-width="450">
              <v-card-actions class="text-center d-block">
                <v-btn
                :loading="loading_request"
                :disabled="loading_request"
                  v-if="type_form == 'create'"
                  x-large
                  outlined
                  rounded
                  width="202"
                  color="primary"
                  class="text-capitalize font-weight-bold admin-btn-bg"
                  @click="saveNewAdmin"
                  >Create</v-btn
                >
                <v-btn
                 :loading="loading_request"
                :disabled="loading_request"
                  v-else-if="type_form == 'edit'"
                  x-large
                  outlined
                  rounded
                  width="202"
                  color="primary"
                  class="text-capitalize font-weight-bold admin-btn-bg"
                  @click="updateAdmin"
                  >Save</v-btn
                >
              </v-card-actions>
            </v-card>
          </v-col>
          <v-col cols="12" md="4"> </v-col>
        </v-row>
      </v-card-actions>
    </v-card>

    <dialog-response
      @close="show_dialog_response = false"
      v-if="show_dialog_response"
      :title_text_dialog="response_title_text"
      :body_text_dialog="response_body_text"
      :redirect_success="response_redirect_success"
      :status="response_status"
    ></dialog-response>

    <v-snackbar top right color="red" v-model="snackbar_errors">
      <ul class="ma-0">
        <template v-for="(error, key1) in snackbar_errors_items">
          <li v-for="(item, key2) in error" :key="key1 + key2">
            {{ item }}
          </li>
        </template>
      </ul>
    </v-snackbar>
  </v-container>
</template>

<script>
import formvalidation from "../../global/RulesValidation";
import dialogresponse from "../../global/DialogResponseComponent.vue";
export default {
  components: {
    "dialog-response": dialogresponse,
  },
  mixins: [formvalidation],
  data() {
    return {
      loading_request: false,
      snackbar_errors: false,
      snackbar_errors_items: [],

      response_title_text: null,
      response_body_text: null,
      response_redirect_success: null,
      response_status: null,
      show_dialog_response: false,

      dialog_delete_contract: false,
      items_social_grades: [],
      selected_file: null,
      is_selecting: false,
      type_form: "create",

      menu_date_start: false,
      form_admin: {
        name: null,
        email: null,
        password: null,
        password_confirmation: null,
      },

      showPassword: false,
      showPasswordConfirm: false,
    };
  },
  computed: {
    id_admin() {
      return this.$route.params.id_admin ? this.$route.params.id_admin : null;
    },
  },
  watch: {
    id_admin: {
      immediate: true,
      handler(value) {
        if (value && value > 0) {
          this.type_form = "edit";
          this.infoAdminSuperAdmin();
        }
      },
    },
  },
  mounted() {},
  methods: {
    infoAdminSuperAdmin() {
      axios
        .get("/info_admins_super_admin/" + this.id_admin)
        .then((res) => {
          this.form_admin = res.data.user;
        })
        .catch((err) => {
          console.error(err);
        });
    },

    saveNewAdmin() {
      this.snackbar_errors_items = [];
      this.snackbar_errors = false;

      if (this.$refs.formadmin.validate()) {
        this.loading_request = true;
        var field_form = Object.keys(this.form_admin);

        let formData = new FormData();
        field_form.forEach((field) => {
          if (this.form_admin[field] != null) {
            formData.append(field, this.form_admin[field]);
          }
        });
        if (this.selected_file) {
          formData.append("file", this.selected_file);
        }

        axios
          .post(
            "/info_admins",
            formData,
            { emulateJSON: true },
            {
              headers: {
                "Content-Type": "application/json;charset=UTF-8",
                "Access-Control-Allow-Origin": "*",
              },
            }
          )
          .then((res) => {
            this.response_title_text = "Success!";
            this.response_body_text = res.data.message;
            this.response_redirect_success = "/pyb/super-admin/admins";
            this.response_status = "success";

            this.show_dialog_response = true;
             this.loading_request = false;
          })
          .catch((err) => {
            if (err.response.status == 422) {
              if (err.response.data.errors) {
                this.snackbar_errors = true;
                this.snackbar_errors_items = err.response.data.errors;
              }
            } else {
              this.response_title_text = "Ups!";
              this.response_body_text = "Admin was </br> not created";
              this.response_redirect_success = "#";
              this.response_status = "error";

              this.show_dialog_response = true;
            }

 this.loading_request = false;

          });

      }
    },
    updateAdmin() {
      if (this.$refs.formadmin.validate()) {
        let formData = new FormData();
        this.loading_request = true;

        formData.append("name", this.form_admin.name);
        formData.append("email", this.form_admin.email);

        if (this.form_admin.password && this.form_admin.password_confirmation) {
          formData.append("password", this.form_admin.password);
          formData.append(
            "password_confirmation",
            this.form_admin.password_confirmation
          );
        }

        axios
          .post(
            "/info_admins_update/" + this.id_admin,
            formData,
            { emulateJSON: true },
            {
              headers: {
                "Content-Type": "application/json;charset=UTF-8",
                "Access-Control-Allow-Origin": "*",
              },
            }
          )
          .then((res) => {
            this.response_title_text = "Success!";
            this.response_body_text = res.data.message;
            this.response_redirect_success = "/pyb/super-admin/admins";
            this.response_status = "success";

            this.show_dialog_response = true;
            this.loading_request = false;
          })
          .catch((err) => {
            if (err.response.status == 422) {
              if (err.response.data.errors) {
                this.snackbar_errors = true;
                this.snackbar_errors_items = err.response.data.errors;
              }
            } else {
              this.response_title_text = "Ups!";
              this.response_body_text = "Admin was </br> not updated";
              this.response_redirect_success = "#";
              this.response_status = "error";

              this.show_dialog_response = true;
              this.loading_request = false;
            }
          });
      }
    },
  },
};
</script>

