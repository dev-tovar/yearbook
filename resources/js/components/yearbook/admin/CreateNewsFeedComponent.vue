<template>
  <v-container fluid class="px-0">
    <v-card color="transparent" tile elevation="0">
      <v-card-title class="font-weight-bold text-h4 py-5">
        <v-row dense>
          <v-col
            cols="12"
            md="1"
            class="pa-0 ma-0 text-left"
            style="align-self: center"
          >
            <router-link
              style="text-decoration: none"
              to="/pyb/admin/news_feed"
              class="font-weight-bold"
              ><v-icon color="primary" size="30"
                >mdi-arrow-left</v-icon
              ></router-link
            >
          </v-col>
          <v-col
            cols="12"
            md="7"
            class="pa-0 ma-0 text-center"
            style="align-self: center"
          >
            <span> Create New Feed </span>
          </v-col>
          <v-col cols="12" md="4" class="pa-0 ma-0 text-right">
            <div class="admin-btn-new-feed">
              <v-btn
                x-large
                outlined
                rounded
                width="182"
                color="primary"
                class="text-capitalize font-weight-bold mr-3"
                >Preview</v-btn
              >
              <v-btn
                x-large
                outlined
                rounded
                width="192"
                color="primary"
                class="text-capitalize font-weight-bold admin-btn-bg"
                >Publish</v-btn
              >
            </div>
          </v-col>
        </v-row>
      </v-card-title>
      <v-divider class="mt-3"></v-divider>
      <v-card-text>
        <v-row dense>
          <v-col cols="12" md="1"> </v-col>
          <v-col cols="12" md="7">
            <v-card elevation="0" class="mx-auto mt-5" max-width="370">
              <v-row wrap>
                <v-col cols="12" md="12" sm="12" class="py-1">
                  <span class="font-weight-bold">Send to:</span>
                  <v-select
                    v-model="selectedFruits"
                    :items="fruits"
                    height="52"
                    class="rounded-lg admin-input"
                    outlined
                    dense
                    :closeOnSelect="true"
                    multiple
                    attach
                    :menu-props="{
                      contentClass: 'asdasdasd',
                      offsetY: true,
                      bottom: true,
                    }"
                  >
                    <template v-slot:selection="{ item, index }">
                      <span v-if="index < 2">{{ item }}</span>
                      <span
                        v-if="index == 0 && selectedFruits.length > 1"
                        class="pr-2"
                        >,</span
                      >
                      <span
                        v-if="index === 2"
                        class="grey--text text-caption pl-2"
                      >
                        (+{{ selectedFruits.length - 2 }} others)
                      </span>
                    </template>

                    <template v-slot:prepend-item>
                      <v-list-item ripple @mousedown.prevent @click="toggle">
                        <v-list-item-action>
                          <v-icon color="primary">
                            {{ icon }}
                          </v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                          <v-list-item-title> Select All </v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                      <v-divider class="mt-2"></v-divider>
                    </template>
                  </v-select>
                </v-col>
                <v-col cols="12" md="12" sm="12" class="py-1">
                  <span class="font-weight-bold">Choose grade:</span>
                  <v-select
                    height="52"
                    class="rounded-lg admin-input"
                    outlined
                    dense
                  ></v-select>
                </v-col>
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
                  <span class="font-weight-bold">Text:</span>
                  <v-textarea
                    class="rounded-lg admin-input"
                    outlined
                    dense
                    :rows="5"
                  ></v-textarea>
                </v-col>
                <v-col cols="12" md="12" sm="12" class="py-1">
                  <span class="font-weight-bold">Link:</span>
                  <v-text-field
                    height="52"
                    class="rounded-lg admin-input"
                    outlined
                    dense
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="12" sm="12" class="py-1">
                  <v-checkbox
                    class="mt-0"
                    v-model="checkbox"
                    value="1"
                    label="Push notification"
                  ></v-checkbox>
                  <v-checkbox
                    class="mt-0"
                    v-model="checkbox"
                    value="2"
                    label="Publish as Yearbook Page"
                  ></v-checkbox>
                </v-col>
                <v-col cols="12" md="12" sm="12" class="py-1">
                  <v-divider></v-divider>
                </v-col>
                <v-col cols="12" md="12" sm="12" class="py-1">
                  <span class="font-weight-bold"
                    >Select the yearbook categor:</span
                  >
                  <v-select
                    height="52"
                    class="rounded-lg admin-input"
                    outlined
                    dense
                  ></v-select>
                </v-col>
                <v-col cols="12" md="12" sm="12" class="py-1">
                  <span class="font-weight-bold"
                    >Select the yearbook subcategory</span
                  >
                  <v-select
                    height="52"
                    class="rounded-lg admin-input"
                    outlined
                    dense
                  ></v-select>
                </v-col>
              </v-row>
            </v-card>
          </v-col>
          <v-col cols="12" md="4">
             <v-card color="#F3F3F2" class="rounded-lg" height="100%">
                <v-navigation-drawer color="#F3F3F2" right style="width:100%"  v-model="drawer_uploads">
             
            </v-navigation-drawer>
              </v-card>
           
          </v-col>
        </v-row>
      </v-card-text>
      <v-divider class="mt-3"></v-divider>
      <v-card-actions>
        <v-row dense>
          <v-col cols="12" md="1"> </v-col>
          <v-col cols="12" md="7">
            <v-card elevation="0" class="mx-auto" max-width="450">
              <v-card-actions>
                <v-btn
                  x-large
                  outlined
                  rounded
                  width="202"
                  color="primary"
                  class="text-capitalize font-weight-bold mr-3"
                  >Save as Draft</v-btn
                >
                <v-spacer></v-spacer>
                <v-btn
                  x-large
                  outlined
                  rounded
                  width="202"
                  color="primary"
                  class="text-capitalize font-weight-bold admin-btn-bg"
                  >Publish</v-btn
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
import daterange from "../custom-inputs/datePickerRange.vue";

export default {
  components: {
    "date-picker-range": daterange,
  },
  data() {
    return {
      drawer_uploads:true,
      checkbox: [],
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
      fruits: [
        "Apples",
        "Apricots",
        "Avocado",
        "Bananas",
        "Blueberries",
        "Blackberries",
        "Boysenberries",
        "Bread fruit",
        "Cantaloupes (cantalope)",
        "Cherries",
        "Cranberries",
        "Cucumbers",
        "Currants",
        "Dates",
        "Eggplant",
        "Figs",
        "Grapes",
        "Grapefruit",
        "Guava",
        "Honeydew melons",
        "Huckleberries",
        "Kiwis",
        "Kumquat",
        "Lemons",
        "Limes",
        "Mangos",
        "Mulberries",
        "Muskmelon",
        "Nectarines",
        "Olives",
        "Oranges",
        "Papaya",
        "Peaches",
        "Pears",
        "Persimmon",
        "Pineapple",
        "Plums",
        "Pomegranate",
        "Raspberries",
        "Rose Apple",
        "Starfruit",
        "Strawberries",
        "Tangerines",
        "Tomatoes",
        "Watermelons",
        "Zucchini",
      ],
      selectedFruits: [],
    };
  },
  computed: {
    likesAllFruit() {
      return this.selectedFruits.length === this.fruits.length;
    },
    likesSomeFruit() {
      return this.selectedFruits.length > 0 && !this.likesAllFruit;
    },
    icon() {
      if (this.likesAllFruit) return "mdi-close-box";
      if (this.likesSomeFruit) return "mdi-minus-box";
      return "mdi-checkbox-blank-outline";
    },
  },
  mounted() {
    console.log("Component mounted.");
  },
  methods: {
    toggle() {
      this.$nextTick(() => {
        if (this.likesAllFruit) {
          this.selectedFruits = [];
        } else {
          this.selectedFruits = this.fruits.slice();
        }
      });
    },
    changeDatesReserva(date) {
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
