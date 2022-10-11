<template>
  <v-container fluid class="px-0">
    <v-card color="transparent" tile elevation="0">
      <v-card-title class="font-weight-bold text-h4 text-center d-block py-5">
        <v-row dense>
          <v-col cols="12" md="12" class="pa-0 ma-0 text-center">
            <span> News Feed </span>
            <v-btn
              to="/pyb/admin/news_feed/create"
              right
              x-large
              outlined
              rounded
              width="269"
              color="primary"
              class="
                text-capitalize
                font-weight-bold
                admin-btn-bg admin-btn-new-feed
              "
              >Create new feed</v-btn
            >
          </v-col>
        </v-row>
      </v-card-title>
      <v-divider class="mt-3"></v-divider>
      <v-card-text>
        <v-card elevation="0" class="mx-auto" width="800">
          <v-card-text>
            <v-row wrap>
              <v-col cols="12" md="6" sm="12">
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
              <v-col cols="12" md="6" sm="12">
                <span class="font-weight-bold">Filter by date</span>
                <date-picker-range
                  placeholdercustom="Dates"
                  @changeDates="changeDatesOk"
                  :solo_custom="false"
                  :outlined_custom="true"
                  :rounded_custom="false"
                  :class_custom="'rounded-lg admin-input'"
                  :height_custom="52"
                >
                </date-picker-range>
              </v-col>
              <v-col md="12" cols="12">
                <v-sheet class="mx-auto" max-width="636" elevation="0">
                  <v-slide-group mandatory show-arrows>
                    <v-slide-item
                      v-for="n in tags"
                      :key="n"
                      v-slot="{ active, toggle }"
                    >
                      <v-btn
                        width="111"
                        class="mx-2 text-capitalize"
                        :input-value="active"
                        :outlined="active ? false : true"
                        active-class="primary white--text"
                        depressed
                        rounded
                        @click="toggle"
                      >
                        {{ n }}
                      </v-btn>
                    </v-slide-item>
                  </v-slide-group>
                </v-sheet>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-card-text>
      <v-card-text class="px-0">
        <v-data-table
          :headers="headers_feeds"
          :items="items_feeds"
          :items-per-page="10"
          class="elevation-0 table-custom"
        >
          <template v-slot:item.actions="{ item }">
            <v-icon size="18" color="primary" small class="mr-3">
              mdi-eye-outline
            </v-icon>
            <v-icon size="18" color="primary" small class="mr-3">
              mdi-book-open-page-variant-outline
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
          <template v-slot:no-data>
            <v-btn color="primary" @click="initialize"> Reset </v-btn>
          </template>
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
import daterange from "../custom-inputs/DatePickerRange.vue";

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
      tags: ["All", "Parents", "Students", "Alumni", "Faculty"],

      headers_feeds: [
        {
          text: "Date",
          align: "start",
          value: "name",
        },
        { text: "Time", value: "calories" },
        { text: "Title", value: "fat" },
        { text: "Send to", value: "carbs" },
        { text: "Short Description", value: "protein" },
        { text: "Views", value: "iron" },
        { text: "Actions", align: "center", sortable: false, value: "actions" },
      ],
      items_feeds: [
        {
          name: "Frozen Yogurt",
          calories: 159,
          fat: 6.0,
          carbs: 24,
          protein: 4.0,
          iron: "1%",
        },
        {
          name: "Ice cream sandwich",
          calories: 237,
          fat: 9.0,
          carbs: 37,
          protein: 4.3,
          iron: "1%",
        },
        {
          name: "Eclair",
          calories: 262,
          fat: 16.0,
          carbs: 23,
          protein: 6.0,
          iron: "7%",
        },
        {
          name: "Cupcake",
          calories: 305,
          fat: 3.7,
          carbs: 67,
          protein: 4.3,
          iron: "8%",
        },
        {
          name: "Gingerbread",
          calories: 356,
          fat: 16.0,
          carbs: 49,
          protein: 3.9,
          iron: "16%",
        },
        {
          name: "Jelly bean",
          calories: 375,
          fat: 0.0,
          carbs: 94,
          protein: 0.0,
          iron: "0%",
        },
        {
          name: "Lollipop",
          calories: 392,
          fat: 0.2,
          carbs: 98,
          protein: 0,
          iron: "2%",
        },
        {
          name: "Honeycomb",
          calories: 408,
          fat: 3.2,
          carbs: 87,
          protein: 6.5,
          iron: "45%",
        },
        {
          name: "Donut",
          calories: 452,
          fat: 25.0,
          carbs: 51,
          protein: 4.9,
          iron: "22%",
        },
        {
          name: "KitKat",
          calories: 518,
          fat: 26.0,
          carbs: 65,
          protein: 7,
          iron: "6%",
        },
      ],
    };
  },
  mounted() {
    console.log("Component mounted.");
  },
  methods: {
    changeDatesOk(date) {
      this.filter_user.filter_fechas = date;
    },
  },
};
</script>

<style>
.table-custom tbody tr:nth-of-type(odd) {
  background-color: rgba(0, 0, 0, 0.05);
}
</style>
