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
            <span> Create New School </span>
            <div class="admin-btn-new-feed">
              <v-btn
                right
                x-large
                outlined
                rounded
                width="202"
                color="primary"
                class="text-capitalize font-weight-bold admin-btn-bg"
                >Create</v-btn
              >
            </div>
          </v-col>
        </v-row>
      </v-card-title>
      <v-divider class="mt-3"></v-divider>
      <v-card-text>
        <v-form ref="formschool">
          <v-row dense>
            <v-col cols="12" md="4"> </v-col>
            <v-col cols="12" md="4">
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
                    <span class="font-weight-bold">0</span>
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
                  <v-col cols="12" md="12" sm="12" class="py-1">
                    <span class="font-weight-bold">Email:</span>
                    <v-text-field
                      v-model="form_school.admin_email"
                      height="52"
                      class="rounded-lg admin-input"
                      outlined
                      dense
                    ></v-text-field>
                  </v-col>

                  <v-col cols="12" md="12" sm="12" class="py-1">
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
                      <p v-if="!button_text_file" class="ma-0 pa-0" >
                        PDF <span class="text-lowercase pl-2"> Upload</span>
                        </p> 
                        <p v-else class="ma-0 pa-0 text-truncate" style="max-width: 150px;">
                          {{button_text_file}}
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
                </v-row>
              </v-card>
            </v-col>
            <v-col cols="12" md="4"> </v-col>
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
                  x-large
                  outlined
                  rounded
                  width="202"
                  color="primary"
                  class="text-capitalize font-weight-bold admin-btn-bg"
                  @click="saveNewSchool"
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
  components: {},
  data() {
    return {
      selected_file: null,
      is_selecting: false,

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
  },
  mounted() {
    this.getCreateSchoolManager();
    console.log("Component mounted.");
  },
  methods: {
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
          formData.append(field, this.form_school[field]);
        });
        if(this.selected_file){
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
          .then((res) => {})
          .catch((err) => {
            console.error(err);
          });
      }
    },
  },
};
</script>

