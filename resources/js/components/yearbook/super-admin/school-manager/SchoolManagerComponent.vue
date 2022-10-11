<template>
  <v-container fluid class="px-0">
    <v-card color="transparent" tile elevation="0">
      <v-card-title class="font-weight-bold text-h4 text-center d-block py-5">
        <v-row dense>
          <v-col cols="12" md="12" class="pa-0 ma-0 text-center">
            <span> School Manager </span>
            <div class="admin-btn-new-feed">
              <v-btn to="/pyb/super-admin/school_manager/create" right x-large outlined rounded width="182"
                color="primary" class="text-capitalize font-weight-bold">Add New School</v-btn>
              <v-btn right x-large outlined rounded width="202" color="primary"
                class="text-capitalize font-weight-bold admin-btn-bg">Import Schools</v-btn>
            </div>
          </v-col>
        </v-row>
      </v-card-title>
      <v-divider class="mt-3"></v-divider>
      <v-card-text>
        <v-card elevation="0" class="mx-auto">
          <v-card-text>
            <v-row wrap>
              <v-col>
                <span class="font-weight-bold">Search</span>
                <v-text-field clearable placeholder="Search" height="52" class="rounded-lg admin-input" outlined dense
                  append-icon="mdi-magnify" hide-details v-model="filter_search"></v-text-field>
              </v-col>
              <v-col>
                <span class="font-weight-bold">Filter by date</span>
                <date-picker-range @changeDates="changeDatesOk" :solo_custom="false" :outlined_custom="true"
                  :rounded_custom="false" :class_custom="'rounded-lg admin-input'" :height_custom="52">
                </date-picker-range>

              </v-col>
              <v-col>
                <span class="font-weight-bold">Status</span>
                <v-select clearable v-model="filter_status" :items="filter_items_status" item-value="value"
                  item-text="text" height="52" class="rounded-lg admin-input" outlined dense hide-details></v-select>
              </v-col>
              <v-col>
                <span class="font-weight-bold">Number of students</span>
                <v-select clearable v-model="filter_number_students" :items="filter_items_number_students"
                  item-value="value" item-text="text" height="52" class="rounded-lg admin-input" outlined dense
                  hide-details></v-select>
              </v-col>
              <v-col>
                <span class="font-weight-bold">Grade level</span>
                <v-select clearable v-model="filter_grades" :items="filter_items_grades" item-value="value"
                  item-text="text" height="52" class="rounded-lg admin-input" outlined dense hide-details></v-select>
              </v-col>
            </v-row>
            <v-row>
              <v-col offset-md="8">
                <v-card-actions class="text-right d-block">
                  <v-btn v-if="filter_apply" rounded text class="text-capitalize px-5" @click="cancelSchoolFilter">
                    Clear Filter<v-icon right>mdi-filter-remove-outline</v-icon>
                  </v-btn>
                  <v-btn rounded depressed color="primary" class="text-capitalize px-5" @click="applySchoolFilter">
                    Apply Filter <v-icon right>{{ !filter_apply ? 'mdi-filter' : 'mdi-filter-menu'}}</v-icon>
                  </v-btn>
                </v-card-actions>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-card-text>
      <v-card-text class="px-0">
        <v-data-table 
        :server-items-length="items_school_total" 
        :headers="headers_school" 
        :items="items_school" 
        :items-per-page="10"
        :options.sync="options_table_school"
          class="elevation-0 table-custom">


          <template v-slot:item.contract="{ item }">
            <v-icon v-if="!item.contract" size="18" color="primary" small class="mr-3">
              mdi-file-pdf-box
            </v-icon>
            <a v-else :href="'/' + item.contract.path" target="_blank" :rel="item.contract.original_name">{{
            item.contract.original_name }}</a>
          </template>

          <template v-slot:item.actions="{ item }">
            <div class="d-flex">
              <router-link style="text-decoration: none" :to="'/pyb/super-admin/school_manager/' + item.id + '/edit'">
                <v-icon size="18" color="primary" small class="mr-3">
                  mdi-pencil-outline
                </v-icon>
              </router-link>

              <v-icon @click="dialog_delete_school = true" size="18" color="primary" small>
                mdi-trash-can-outline
              </v-icon>
            </div>
          </template>
          <!-- <template v-slot:no-data>
            <v-btn color="primary" @click="initialize"> Reset </v-btn>
          </template> -->
        </v-data-table>
      </v-card-text>
    </v-card>
    <v-dialog v-model="dialog_delete_school" scrollable persistent max-width="400px" transition="dialog-transition"
      content-class="rounded-xl">
      <v-card class="rounded-xl" elevation="3">
        <v-card-title class="d-block text-center py-9 text-h5 font-weight-bold">
          Delete this school?
          <v-btn @click="dialog_delete_school = !dialog_delete_school" class="admin-btn-close-dialog" small icon fab>
            <v-icon color="primary" size="30"> mdi-close </v-icon>
          </v-btn>
        </v-card-title>
        <v-card-text class="text-center font-weight-bold grey lighten-4 pt-5">
          Are you sure you want to delete <br />
          this school?
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions class="py-5 grey lighten-4">
          <v-spacer></v-spacer>

          <v-btn x-large outlined rounded width="140" color="primary" class="text-capitalize font-weight-bold mr-3">No
          </v-btn>
          <v-btn x-large outlined rounded width="140" color="primary"
            class="text-capitalize font-weight-bold admin-btn-bg">Yes</v-btn>
          <v-spacer></v-spacer>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script>
import daterange from "../../custom-inputs/DatePickerRange.vue";

export default {
  components: {
    "date-picker-range": daterange,
  },
  data() {
    return {
      filter_search: null,
      filter_date: [],
      filter_status: null,
      filter_number_students: null,
      filter_grades: null,

      filter_apply: false,
      filter_current: {},

      filter_items_grades: [
        {
          value: "PK-5",
          text: "PK-5",
        },
        {
          value: "PK-8",
          text: "PK-8",
        },
        {
          value: "PK-12",
          text: "PK-12",
        },
        {
          value: "6-8",
          text: "6-8",
        },
        {
          value: "6-12",
          text: "6-12",
        },
        {
          value: "9-12",
          text: "9-12",
        },
      ],
      filter_items_number_students: [
        {
          value: "1",
          text: "Biggest to smallest",
        },
        {
          value: "2",
          text: "Smallest to biggest",
        },
      ],
      filter_items_status: [
        {
          value: "expired",
          text: "Expired",
        },
        {
          value: "1",
          text: "Less then 1 year",
        },
        {
          value: "2",
          text: "From 1 to 2 ",
        },
        {
          value: "3",
          text: "From 2 to 5",
        },
        {
          value: "4",
          text: "From 5 to 10",
        },
        {
          value: "5",
          text: "More than 10",
        },
      ],

      dialog_delete_school: false,
      filter_user: {
        filter_fechas: [],
      },

      headers_school: [
        {
          text: "Date",
          align: "start",
          sortable: false,
          value: "date_create",
        },
        { text: "School", sortable: false, value: "name" },
        { text: "Address", sortable: false, value: "address" },
        { text: "Grade Level", sortable: false, value: "grade" },
        { text: "# of students", sortable: false, value: "students_number" },
        {
          text: "# of uploaded students",
          sortable: false,
          value: "total_users_count",
        },
        { text: "Yearbook Advisor", sortable: false, value: "advisor" },
        { text: "Contract Status", sortable: false, value: "contract_status" },
        {
          text: "Contract PDF	",
          align: "center",
          sortable: false,
          value: "contract",
          width: "150px",
          class: "contract_w",
          cellClass: "contract_w",
        },
        { text: "", align: "center", sortable: false, value: "actions" },
      ],
      items_school_total: 0,
      options_table_school: {},
      items_school: [],
    };
  },
  watch: {
    options_table_school: {
        handler () {
          this.getSchoolManagerInfo(this.filter_current)
        },
        deep: true,
      },
  },
  mounted() {
    console.log("Component mounted.");
    // this.getSchoolManagerInfo();
  },
  methods: {
    applySchoolFilter() {

      let filterFormData = new Object();

      if (this.filter_search) {
        filterFormData.search = this.filter_search;
      }
      if (this.filter_date.length == 2) {
        filterFormData.from = this.filter_date[0];
        filterFormData.to = this.filter_date[1];
      }
      if (this.filter_status) {
        filterFormData.status = this.filter_status;
      }
      if (this.filter_number_students) {
        filterFormData.number_of_students = this.filter_number_students;
      }
      if (this.filter_grades) {
        filterFormData.grade = this.filter_grades;
      }
      filterFormData.filter = 1;
      this.filter_apply = true;

      this.filter_current = filterFormData;

      this.getSchoolManagerInfo(filterFormData);
    },
    cancelSchoolFilter() {
      this.filter_apply = false;
      this.filter_search = null;
      this.filter_date = [];
      this.filter_status = null;
      this.filter_number_students = null;
      this.filter_grades = null;
      this.filter_current = {};
      this.getSchoolManagerInfo(null);
    },
    getSchoolManagerInfo(filter = {}) {

      if(filter){
        filter.page =  this.options_table_school.page ? this.options_table_school.page : 1;
        filter.per_page =  this.options_table_school.itemsPerPage ? this.options_table_school.itemsPerPage : 10;

      }
      axios
        .get("/info_school_manager", { params: filter })
        .then((res) => {
          this.items_school = res.data.schools.data;
          this.items_school_total = res.data.schools.total;
        })
        .catch((err) => {
          console.error(err);
        });
    },
    changeDatesOk(date) {
      this.filter_date = date;
    },
  },
};
</script>

<style>
.table-custom tbody tr:nth-of-type(odd) {
  background-color: rgba(0, 0, 0, 0.05);
}

.contract_w {
  width: 150px !important;
  max-width: 150px !important;
}
</style>
