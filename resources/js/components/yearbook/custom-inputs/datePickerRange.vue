<template>
  <v-menu
    v-model="menu_dates"
    :close-on-content-click="false"
    transition="scale-transition"
    offset-y
    min-width="auto"
    ref="menudate"
    :return-value.sync="dates"
    nudge-left="70"
    origin="top center"
  >
    <template v-slot:activator="{ on, attrs }">
      <v-text-field
        append-icon="mdi-calendar"
        :height="height_custom"
        :solo="solo_custom"
        :outlined="outlined_custom"
        v-model="dates"
        clearable
        @click:clear="clearValue"
        hide-details
        :rounded="rounded_custom"
        :class="class_custom"
        dense
        :placeholder="placeholdercustom"
        readonly
        v-bind="attrs"
        v-on="on"
      >
        <!-- <template v-slot:append>
          <v-icon color="primary">mdi-chevron-down</v-icon>
        </template> -->
      </v-text-field>
    </template>

    <v-card class="py-3" max-width="600">
      <v-card-text>
        <v-layout row wrap>
          <v-flex xs6>
            <v-date-picker
              id="picker1"
              ref="picker1"
              v-model="dates"
              color="primary"
              multiple
              no-title
              full-width
              :events="events"
              :event-color="eventColor"
              :picker-date.sync="pickerPage1"
            ></v-date-picker>
          </v-flex>
          <v-flex xs6>
            <v-date-picker
              id="picker2"
              ref="picker2"
              v-model="dates"
              multiple
              color="primary"
              no-title
              full-width
              :events="events"
              :event-color="eventColor"
              :picker-date.sync="pickerPage2"
            ></v-date-picker>
          </v-flex>
        </v-layout>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn
        class="text-capitalize"
          depressed
          text
          rounded
          color="primary"
          @click="menu_dates = false"
          >Cancel</v-btn
        >
        <v-btn class="text-capitalize" depressed rounded color="primary" @click="changeDates"
          >Done</v-btn
        >
      </v-card-actions>
    </v-card>
  </v-menu>
</template>

<script>
export default {
  props: {
    placeholdercustom: String,
    solo_custom: Boolean,
    outlined_custom: Boolean,
    rounded_custom: Boolean,
    class_custom: String,
    height_custom: Number,
  },
  data() {
    return {
      dates: [],
      menu_dates: false,
      dark: false,
      vertical: false,
      events: [],
      eventColor: {},
      dateRange: [],
      dateRangePrevious: [],
      pickerPage1: null,
      pickerPage2: null,
      pickerPage1Adjusted: false,
      pickerPage2Adjusted: false,
      shadeAccent: true,
    };
  },
  computed: {
    valid: function () {
      return this.dates.length === 2;
    },
  },
  methods: {
    clearValue() {
      this.dates = [];
      this.$refs.menudate.save(this.dates.sort());
      this.$emit("changeDates", this.dates.sort());
      this.menu_dates = false;
    },
    changeDates() {
      this.$refs.menudate.save(this.dates.sort());
      this.$emit("changeDates", this.dates.sort());
      this.menu_dates = false;
    },

    render() {
      this.events = this.getDateRange(this.dates);
      this.eventColor = this.buildEventColors(this.events);
    },
    addDaysToDate(date, days) {
      var d = new Date(date);
      d.setDate(d.getDate() + days);
      return d;
    },
    formatDate(date) {
      return date.toISOString().split("T")[0];
    },
    buildEventColors(range) {
      let colors = {};
      for (let i = 0; i < range.length; i++) {
        let accentShade = "";
        this.shadeAccent
          ? this.dark
            ? (accentShade = "darken-2")
            : (accentShade = "lighten-4")
          : (accentShade = "");
        colors[range[i]] =
          "brown  " + accentShade + " v-date-picker-table__event";
        if (i === 0) {
          colors[range[i]] += " v-date-picker-table__events--start";
        }
        if (i === range.length - 1) {
          colors[range[i]] += " v-date-picker-table__events--end";
        }
      }
      return colors;
    },
    getDateRange(dates) {
      if (dates && dates.length > 0) {
        let date1 = new Date(dates[0]);
        let date2 = new Date(dates[dates.length - 1]);
        let cur = new Date(Math.min(date1, date2)),
          range = [];
        while (cur <= Math.max(date1, date2)) {
          range.push(this.formatDate(new Date(cur)));
          cur.setDate(cur.getDate() + 1);
        }
        return range;
      } else {
        return [];
      }
    },
    getDefaultDates() {
      let today = new Date();
      return [
        this.formatDate(today),
        this.formatDate(this.addDaysToDate(today, 1)),
      ];
    },
    setDefaultDates() {
      this.dateRange = this.getDefaultDates();
      this.render();
      this.bringDateIntoView();
    },
    clearDates() {
      this.dateRange = [];
    },
    arrayDifference(array1, array2) {
      return array1.filter(function (i) {
        return array2.indexOf(i) < 0;
      });
    },
    parsePickerPage(date) {
      let dateParts = date.split("-");
      return {
        year: parseInt(dateParts[0]),
        month: parseInt(dateParts[1]),
      };
    },
    increasePickerPage(pickerPage) {
      pickerPage.month == 12
        ? (pickerPage.year++, (pickerPage.month = 1))
        : pickerPage.month++;
      return pickerPage;
    },
    decreasePickerPage(pickerPage) {
      pickerPage.month == 1
        ? (pickerPage.year--, (pickerPage.month = 12))
        : pickerPage.month--;
      return pickerPage;
    },
    pickerPageToString(pickerPage) {
      pickerPage.month < 10
        ? (pickerPage.month = "0" + pickerPage.month.toString())
        : (pickerPage.month = pickerPage.month.toString());
      return pickerPage.year.toString() + "-" + pickerPage.month;
    },
    bringDateIntoView() {
      if (this.dateRange.length > 0) {
        this.pickerPage1 = this.pickerPageToString(
          this.parsePickerPage(this.dateRange[0])
        );
      }
    },
  },
  watch: {
    dates(value) {
      if (value && value.length > 0) {
        if (value.length == 3) {
          this.dates.shift();
        } else if (value.length == 2) {
          this.dateRange = value;
        } else {
          let difference = [];
          value.length == 1
            ? (difference = this.arrayDifference(this.dateRangePrevious, value))
            : (difference = this.arrayDifference(value, this.dateRange));
          if (difference.length) {
            this.dateRange = difference;
          }
        }
      }
      this.render();
      this.dateRangePrevious = this.dateRange;
    },
    dark(value) {
      this.render();
    },
    shadeAccent(value) {
      this.render();
    },
    pickerPage1(value) {
      if (!this.pickerPage1Adjusted) {
        this.pickerPage2Adjusted = true;
        this.pickerPage2 = this.pickerPageToString(
          this.increasePickerPage(this.parsePickerPage(value))
        );
      }
      this.pickerPage1Adjusted = false;
    },
    pickerPage2(value) {
      if (!this.pickerPage2Adjusted) {
        this.pickerPage1Adjusted = true;
        this.pickerPage1 = this.pickerPageToString(
          this.decreasePickerPage(this.parsePickerPage(value))
        );
      }
      this.pickerPage2Adjusted = false;
    },
  },
};
</script>

<style >
#picker1.v-picker .v-date-picker-header .v-btn:last-of-type,
#picker2.v-picker .v-date-picker-header .v-btn:first-of-type {
  display: none;
}

.v-picker.v-card {
  box-shadow: none;
}

.v-date-picker-table--date table {
  border-collapse: separate;
  border-spacing: 0px 8px;
}

.v-date-picker-table__current {
  border: 0px !important;
}

.v-date-picker-table--date table td button {
  width: 100% !important;
}

.v-date-picker-table__events {
  width: 100% !important;
  height: 100% !important;
  z-index: -1;
  top: 0px;
  right: 0px;
  left: 0;
  bottom: 0;
}

.v-date-picker-table__events > div {
  display: revert !important;
}

.v-date-picker-table__event {
  z-index: -1;
  width: 100% !important;
  height: 100% !important;
  left: 0;
  top: 0;
  bottom: 0;
  right: 0;
  border-radius: 0 !important;
  transform: none;
}

.v-date-picker-table__events--start {
  margin-left: 50% !important;
}

.v-date-picker-table__events--end {
  margin-right: 50% !important;
  width: auto !important;
}
</style>