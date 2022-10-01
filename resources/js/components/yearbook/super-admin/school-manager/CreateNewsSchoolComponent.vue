<template>
  <v-container fluid class="px-0">
    <v-card color="transparent" tile elevation="0">
      <v-card-title class="font-weight-bold text-h4 py-5">
        <v-row dense>
          <v-col cols="12" md="12" class="pa-0 ma-0 text-center">
            <router-link
              to="/pyb/super-admin/school_manager"
              class="font-weight-bold"
              style="position: absolute; left: 7px; text-decoration: none"
              ><v-icon color="primary" size="30"
                >mdi-arrow-left</v-icon
              ></router-link
            >
            <span v-if="type_form == 'create'"> Create New School </span>
            <span v-else-if="type_form == 'edit'"> Edit School </span>
            <div class="admin-btn-new-feed">
              <v-btn
                v-if="type_form == 'create'"
                right
                x-large
                outlined
                rounded
                width="202"
                color="primary"
                class="text-capitalize font-weight-bold admin-btn-bg"
                @click="saveNewSchool"
                >Create</v-btn
              >
              <v-btn
                v-else-if="type_form == 'edit'"
                right
                x-large
                outlined
                rounded
                width="202"
                color="primary"
                class="text-capitalize font-weight-bold admin-btn-bg"
                @click="updateSchool"
                >Save</v-btn
              >
            </div>
          </v-col>
        </v-row>
      </v-card-title>
      <v-divider class="mt-3"></v-divider>
      <v-card-text>
        <v-form ref="formschool">
          <v-row dense>
            <v-col cols="12" md="4" :offset="type_form == 'create' ? 4 : 2">
              <v-card elevation="0" class="mx-auto mt-5" max-width="370">
                <v-row wrap>
                  <v-col cols="12" md="12" sm="12" class="pt-1 pb-3">
                    <span class="font-weight-bold body-1">Basic Info:</span>
                  </v-col>
                  <v-col cols="12" md="12" sm="12" class="py-1">
                    <span class="font-weight-bold">School Name:</span>
                    <v-text-field
                      v-model="form_school.name"
                      height="52"
                      class="rounded-lg admin-input"
                      outlined
                      dense
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="12" sm="12" class="py-1">
                    <span class="font-weight-bold">Address:</span>
                    <v-text-field
                      v-model="form_school.address"
                      height="52"
                      class="rounded-lg admin-input"
                      outlined
                      dense
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="12" sm="12" class="py-1">
                    <span class="font-weight-bold">City:</span>
                    <v-text-field
                      v-model="form_school.city"
                      height="52"
                      class="rounded-lg admin-input"
                      outlined
                      dense
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="12" sm="12" class="py-1">
                    <span class="font-weight-bold">State:</span>
                    <v-select
                      v-model="form_school.state"
                      :items="items_states"
                      height="52"
                      class="rounded-lg admin-input"
                      outlined
                      dense
                    ></v-select>
                  </v-col>
                  <v-col cols="12" md="12" sm="12" class="py-1">
                    <span class="font-weight-bold">Zip Code:</span>
                    <v-text-field
                      v-model="form_school.zip"
                      height="52"
                      class="rounded-lg admin-input"
                      outlined
                      dense
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="12" sm="12" class="py-1">
                    <span class="font-weight-bold">Country:</span>
                    <v-text-field
                      v-model="form_school.country"
                      height="52"
                      class="rounded-lg admin-input"
                      outlined
                      dense
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="12" sm="12" class="py-1">
                    <span class="font-weight-bold"
                      >Total number of students:</span
                    >
                    <v-text-field
                      v-model="form_school.students_number"
                      height="52"
                      class="rounded-lg admin-input"
                      outlined
                      dense
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="12" sm="12" class="pt-1 pb-4 d-flex">
                    <span class="font-weight-bold"
                      >Number of registered students:</span
                    >
                    <v-spacer></v-spacer>
                    <span v-if="type_form == 'create'" class="font-weight-bold"
                      >0</span
                    >
                    <span
                      v-else-if="type_form == 'edit'"
                      class="font-weight-bold"
                      >{{ form_school.total_users_count }}</span
                    >
                  </v-col>
                  <v-col cols="12" md="12" sm="12" class="py-1">
                    <span class="font-weight-bold">Yearbook Advisor:</span>
                    <v-text-field
                      v-model="form_school.advisor"
                      height="52"
                      class="rounded-lg admin-input"
                      outlined
                      dense
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="12" sm="12" class="py-1">
                    <span class="font-weight-bold">Grade level of school:</span>
                    <v-select
                      v-model="form_school.grade"
                      :items="items_grades"
                      height="52"
                      class="rounded-lg admin-input"
                      outlined
                      dense
                    ></v-select>
                  </v-col>
                  <v-col cols="12" md="12" sm="12" class="py-1">
                    <span class="font-weight-bold">Number of years:</span>
                    <v-select
                      v-model="form_school.contract_years"
                      :items="items_number_years"
                      height="52"
                      class="rounded-lg admin-input"
                      outlined
                      dense
                    ></v-select>
                  </v-col>
                  <v-col cols="12" md="12" sm="12" class="py-1">
                    <span class="font-weight-bold">Start Year:</span>

                    <v-menu
                      v-model="menu_date_start"
                      :close-on-content-click="false"
                      :nudge-right="40"
                      transition="scale-transition"
                      offset-y
                      min-width="auto"
                    >
                      <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                          v-model="form_school.contract_start_date"
                          height="52"
                          class="rounded-lg admin-input"
                          outlined
                          dense
                          append-icon="mdi-calendar"
                          readonly
                          v-bind="attrs"
                          v-on="on"
                        ></v-text-field>
                      </template>
                      <v-date-picker
                        v-model="form_school.contract_start_date"
                        @input="menu_date_start = false"
                      ></v-date-picker>
                    </v-menu>
                  </v-col>
                  <v-col
                    v-if="type_form == 'create'"
                    cols="12"
                    md="12"
                    sm="12"
                    class="py-1"
                  >
                    <span class="font-weight-bold">Email:</span>
                    <v-text-field
                      v-model="form_school.admin_email"
                      height="52"
                      class="rounded-lg admin-input"
                      outlined
                      dense
                    ></v-text-field>
                  </v-col>

                  <v-col
                    v-if="type_form == 'create'"
                    cols="12"
                    md="12"
                    sm="12"
                    class="py-1"
                  >
                    <span class="font-weight-bold">Password:</span>
                    <v-text-field
                      v-model="form_school.admin_password"
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

                  <v-col
                    cols="12"
                    md="12"
                    sm="12"
                    class="pt-1 pb-4 d-flex"
                    style="align-items: center"
                  >
                    <span class="font-weight-bold">Attach Contract:</span>
                    <v-spacer></v-spacer>
                    <v-btn
                      @click="onButtonClick"
                      rounded
                      color="primary"
                      large
                      depressed
                      :loading="is_selecting"
                      max-width="200"
                      width="200"
                    >
                      <p v-if="!button_text_file" class="ma-0 pa-0">
                        PDF <span class="text-lowercase pl-2"> Upload</span>
                      </p>
                      <p
                        v-else
                        class="ma-0 pa-0 text-truncate"
                        style="max-width: 150px"
                      >
                        {{ button_text_file }}
                      </p>
                      <v-icon right> mdi-paperclip </v-icon>
                    </v-btn>
                    <input
                      ref="uploader"
                      class="d-none"
                      type="file"
                      accept="application/pdf"
                      @change="onFileChanged"
                    />
                  </v-col>
                  <v-col
                    v-if="form_school && form_school.contract"
                    cols="12"
                    md="12"
                    sm="12"
                    class="pt-1 pb-4 d-flex"
                    style="align-items: center"
                  >
                    <span class="font-weight-bold">Contract:</span>
                    <v-spacer></v-spacer>
                    <v-list-item>
                      <v-list-item-content>
                        <v-list-item-title class="text-right">
                          <a
                            :href="'/' + form_school.contract.path"
                            target="_blank"
                            :rel="form_school.contract.original_name"
                            >{{ form_school.contract.original_name }}</a
                          >
                        </v-list-item-title>
                        <v-list-item-subtitle class="text-right">
                          {{ form_school.contract.size_to_human }}
                        </v-list-item-subtitle>
                      </v-list-item-content>
                      <v-list-item-icon>
                        <v-tooltip right>
                          <template v-slot:activator="{ on, attrs }">
                            <v-icon
                              @click="dialog_delete_contract = true"
                              v-bind="attrs"
                              v-on="on"
                              color="primary"
                              >mdi-trash-can-outline</v-icon
                            >
                          </template>
                          <span>Delete</span>
                        </v-tooltip>
                      </v-list-item-icon>
                    </v-list-item>
                  </v-col>
                </v-row>
              </v-card>
            </v-col>
            <v-col cols="12" md="4" v-if="type_form == 'edit'">
              <v-card elevation="0" class="mx-auto mt-5" max-width="370">
                <v-row wrap>
                  <v-col cols="12" md="12" sm="12" class="pt-1 pb-3">
                    <span class="font-weight-bold body-1"
                      >Social Media settings for Students:</span
                    >
                  </v-col>
                  <v-col
                    cols="12"
                    md="6"
                    sm="12"
                    class="py-1"
                    v-for="(item, index) in items_social_grades"
                    :key="index"
                  >
                    <v-switch
                      v-model="form_school.grades"
                      inset
                      :label="item"
                      color="primary"
                      :value="item"
                      hide-details
                    ></v-switch>
                  </v-col>
                  <v-col cols="12" md="12" sm="12" class="pt-9 pb-3">
                    <span class="font-weight-bold body-1"
                      >Social Media available for Students:</span
                    >
                  </v-col>
                  <v-col cols="12" md="6" sm="12" class="py-1">
                    <v-switch
                      v-model="form_school.is_fb"
                      inset
                      color="primary"
                      :false-value="0"
                      :true-value="1"
                      hide-details
                    >
                      <template v-slot:label>
                        <p class="ma-0 pa-0">
                          <v-icon left>mdi-facebook</v-icon> Facebook
                        </p>
                      </template>
                    </v-switch>
                  </v-col>
                  <v-col cols="12" md="6" sm="12" class="py-1">
                    <v-switch
                      v-model="form_school.is_twitter"
                      inset
                      color="primary"
                      :false-value="0"
                      :true-value="1"
                      hide-details
                    >
                      <template v-slot:label>
                        <p class="ma-0 pa-0">
                          <v-icon left>mdi-instagram</v-icon> Instagram
                        </p>
                      </template>
                    </v-switch>
                  </v-col>
                  <v-col cols="12" md="6" sm="12" class="py-1">
                    <v-switch
                      v-model="form_school.is_inst"
                      inset
                      color="primary"
                      :false-value="0"
                      :true-value="1"
                      hide-details
                    >
                      <template v-slot:label>
                        <p class="ma-0 pa-0">
                          <v-icon left>mdi-twitter</v-icon> Twitter
                        </p>
                      </template>
                    </v-switch>
                  </v-col>
                  <v-col cols="12" md="6" sm="12" class="py-1">
                    <v-switch
                      v-model="form_school.is_linkedin"
                      inset
                      color="primary"
                      :false-value="0"
                      :true-value="1"
                      hide-details
                    >
                      <template v-slot:label>
                        <p class="ma-0 pa-0">
                          <v-icon left>mdi-linkedin</v-icon> LinkedIn
                        </p>
                      </template>
                    </v-switch>
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
                  v-if="type_form == 'create'"
                  x-large
                  outlined
                  rounded
                  width="202"
                  color="primary"
                  class="text-capitalize font-weight-bold admin-btn-bg"
                  @click="saveNewSchool"
                  >Create</v-btn
                >
                <v-btn
                  v-else-if="type_form == 'edit'"
                  x-large
                  outlined
                  rounded
                  width="202"
                  color="primary"
                  class="text-capitalize font-weight-bold admin-btn-bg"
                  @click="updateSchool"
                  >Save</v-btn
                >
              </v-card-actions>
            </v-card>
          </v-col>
          <v-col cols="12" md="4"> </v-col>
        </v-row>
      </v-card-actions>
    </v-card>
    <v-dialog
      v-model="dialog_delete_contract"
      scrollable
      persistent
      max-width="400px"
      transition="dialog-transition"
      content-class="rounded-xl"
    >
      <v-card class="rounded-xl" elevation="3">
        <v-card-title class="d-block text-center py-9 text-h5 font-weight-bold">
          Delete this file?
          <v-btn
            @click="dialog_delete_contract = !dialog_delete_contract"
            class="admin-btn-close-dialog"
            small
            icon
            fab
          >
            <v-icon color="primary" size="30"> mdi-close </v-icon>
          </v-btn>
        </v-card-title>
        <v-card-text class="text-center font-weight-bold grey lighten-4 pt-5">
          Are you sure you want to delete <br />
          this file?
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
            @click="dialog_delete_contract = false"
            >No</v-btn
          >
          <v-btn
            x-large
            outlined
            rounded
            width="140"
            color="primary"
            class="text-capitalize font-weight-bold admin-btn-bg"
            @click="removeContractFile(form_school.contract.id)"
            >Yes</v-btn
          >
          <v-spacer></v-spacer>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <dialog-response
      @close="show_dialog_response = false"
      v-if="show_dialog_response"
      :title_text_dialog="response_title_text"
      :body_text_dialog="response_body_text"
      :redirect_success="response_redirect_success"
      :status="response_status"
    ></dialog-response>
  </v-container>
</template>

<script>
import dialogresponse from "../../global/DialogResponseComponent.vue";
export default {
  components: {
    "dialog-response": dialogresponse,
  },
  data() {
    return {
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
      form_school: {
        name: null,
        address: null,
        city: null,
        state: null,
        zip: null,
        country: null,
        students_number: null,
        advisor: null,
        grade: null,
        contract_years: null,
        contract_start_date: null,
        admin_email: null,
        admin_password: null,
      },

      showPassword: false,
      checkbox: [],
      items_states: [],
      items_grades: [],
      items_number_years: [
        1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20,
      ],
    };
  },
  computed: {
    button_text_file() {
      return this.selected_file ? this.selected_file.name : null;
    },
    id_school() {
      return this.$route.params.id_school ? this.$route.params.id_school : null;
    },
  },
  watch: {
    id_school: {
      immediate: true,
      handler(value) {
        if (value && value > 0) {
          this.type_form = "edit";
          this.infoSchoolSuperAdmin();
        }
      },
    },
  },
  mounted() {
    this.getCreateSchoolManager();
  },
  methods: {
    infoSchoolSuperAdmin() {
      axios
        .get("/info_school_manager_super_admin/" + this.id_school)
        .then((res) => {
          this.form_school = res.data.school;
          this.items_social_grades = res.data.socialGrades;
        })
        .catch((err) => {
          console.error(err);
        });
    },
    removeContractFile(id) {
      axios
        .get("/remove_contract_file_school/" + id)
        .then((res) => {
          this.dialog_delete_contract = false;
          this.infoSchoolSuperAdmin();
        })
        .catch((err) => {
          console.error(err);
        });
    },

    onButtonClick() {
      this.is_selecting = true;
      window.addEventListener(
        "focus",
        () => {
          this.is_selecting = false;
        },
        { once: true }
      );

      this.$refs.uploader.click();
    },
    onFileChanged(e) {
      this.selected_file = e.target.files[0];

      // do something
    },
    getCreateSchoolManager() {
      axios
        .get("/create_school_manager")
        .then((res) => {
          this.items_states = res.data.states
            ? Object.values(res.data.states)
            : [];
          this.items_grades = res.data.grades;
        })
        .catch((err) => {
          console.error(err);
        });
    },
    saveNewSchool() {
      if (this.$refs.formschool.validate()) {
        var field_form = Object.keys(this.form_school);
        console.log(field_form);

        let formData = new FormData();
        field_form.forEach((field) => {
          if(this.form_school[field] != null){
            formData.append(field, this.form_school[field]);
          }
        });
        if (this.selected_file) {
          formData.append("file", this.selected_file);
        }

        axios
          .post(
            "/info_school_manager",
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
            this.response_redirect_success = "/pyb/super-admin/school_manager";
            this.response_status = "success";

            this.show_dialog_response = true;

          })
          .catch((err) => {
            this.response_title_text = "Ups!";
            this.response_body_text = 'School was </br> not created';
            this.response_redirect_success = "#";
            this.response_status = "error";

            this.show_dialog_response = true;
          });
      }
    },
    updateSchool() {
      if (this.$refs.formschool.validate()) {
        var field_form = Object.keys(this.form_school);
        console.log(field_form);

        let formData = new FormData();
        this.form_school.grades.forEach((field) => {
          formData.append("social_grade[]", field);
        });
        // formData.append('_token', this.$root.csrf_token);
        // formData.append('_method', 'PATCH')
        formData.append("name", this.form_school.name);
        formData.append("address", this.form_school.address);
        formData.append("city", this.form_school.city);
        formData.append("state", this.form_school.state);
        formData.append("zip", this.form_school.zip);
        formData.append("country", this.form_school.country);
        formData.append("students_number", this.form_school.students_number);
        formData.append("advisor", this.form_school.advisor);
        formData.append("grade", this.form_school.grade);
        formData.append("contract_years", this.form_school.contract_years);
        formData.append(
          "contract_start_date",
          this.form_school.contract_start_date
        );

        formData.append("is_fb", this.form_school.is_fb);
        formData.append("is_twitter", this.form_school.is_twitter);
        formData.append("is_inst", this.form_school.is_inst);
        formData.append("is_linkedin", this.form_school.is_linkedin);

        if (this.selected_file) {
          formData.append("file", this.selected_file);
        }

        axios
          .post(
            "/info_school_manager_update/" + this.id_school,
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
            this.response_redirect_success = "/pyb/super-admin/school_manager";
            this.response_status = "success";

            this.show_dialog_response = true;
          })
          .catch((err) => {
            this.response_title_text = "Ups!";
            this.response_body_text = 'Update failed, </br> try again';
            this.response_redirect_success = "#";
            this.response_status = "error";

            this.show_dialog_response = true;
          });
      }
    },
  },
};
</script>

