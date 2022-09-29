<template>
  <v-container fluid class="px-0">
    <v-card color="transparent" tile elevation="0">
      <v-card-title class="font-weight-bold text-h4 text-center d-block py-5">
        <v-row dense>
          <v-col cols="12" md="12" class="pa-0 ma-0 text-center">
            <span> Dashboard </span>
          </v-col>
        </v-row>
      </v-card-title>
      <v-divider class="mt-3"></v-divider>
      <v-card-text>
        <v-card elevation="0" class="mx-auto" width="1400">
          <v-card-text>
            <v-slide-group v-model="model" class="pa-0">
              <v-slide-item>
                <v-card
                  color="#F8F8F8"
                  elevation="1"
                  class="ma-4 rounded-lg"
                  style="align-content: center; display: grid"
                  height="205"
                  width="235"
                >
                  <v-card-title
                    class="text-h3 font-weight-bold text-center d-block"
                  >
                    <number
                      ref="number1"
                      :from="0"
                      :to="9"
                      :format="theFormat"
                      :duration="1"
                      :delay="1"
                    />
                  </v-card-title>
                  <v-card-text class="text-center"
                    >Total # Of <br />
                    Schools</v-card-text
                  >
                </v-card>
              </v-slide-item>
              <v-slide-item>
                <v-card
                  color="#F8F8F8"
                  elevation="1"
                  class="ma-4 rounded-lg"
                  style="align-content: center; display: grid"
                  height="205"
                  width="235"
                >
                  <v-card-title
                    class="text-h3 font-weight-bold text-center d-block"
                  >
                    <number
                      ref="number1"
                      :from="0"
                      :to="114636"
                      :format="theFormat"
                      :duration="1"
                      :delay="1"
                    />
                  </v-card-title>
                  <v-card-text class="text-center"
                    >Total # Of Uploaded Users <br />
                    (From All Schools)</v-card-text
                  >
                </v-card>
              </v-slide-item>
              <v-slide-item>
                <v-card
                  color="#F8F8F8"
                  elevation="1"
                  class="ma-4 rounded-lg"
                  style="align-content: center; display: grid"
                  height="205"
                  width="235"
                >
                  <v-card-title
                    class="text-h3 font-weight-bold text-center d-block"
                  >
                    <number
                      ref="number1"
                      :from="0"
                      :to="1426"
                      :format="theFormat"
                      :duration="1"
                      :delay="1"
                    />
                  </v-card-title>
                  <v-card-text class="text-center">
                    Total # Of Active <br />
                    Students
                  </v-card-text>
                </v-card>
              </v-slide-item>
              <v-slide-item>
                <v-card
                  color="#F8F8F8"
                  elevation="1"
                  class="ma-4 rounded-lg"
                  style="align-content: center; display: grid"
                  height="205"
                  width="235"
                >
                  <v-card-title
                    class="text-h3 font-weight-bold text-center d-block"
                  >
                    <number
                      ref="number1"
                      :from="0"
                      :to="329"
                      :format="theFormat"
                      :duration="1"
                      :delay="1"
                    />
                  </v-card-title>
                  <v-card-text class="text-center">
                    Total # Of Registered <br />
                    Parents
                  </v-card-text>
                </v-card>
              </v-slide-item>
              <v-slide-item>
                <v-card
                  color="#F8F8F8"
                  elevation="1"
                  class="ma-4 rounded-lg"
                  style="align-content: center; display: grid"
                  height="205"
                  width="235"
                >
                  <v-card-title
                    class="text-h3 font-weight-bold text-center d-block"
                  >
                    <number
                      ref="number1"
                      :from="0"
                      :to="0"
                      :format="theFormat"
                      :duration="1"
                      :delay="1"
                    />
                  </v-card-title>
                  <v-card-text class="text-center">
                    Total # Of Students <br />
                    Who Paid This Year
                  </v-card-text>
                </v-card>
              </v-slide-item>
            </v-slide-group>
          </v-card-text>
        </v-card>
      </v-card-text>
      <v-card-text>
        <div v-if="show_graph" id="chart" style="width: 100%">
          <apexchart
            type="line"
            height="450"
            :options="chartOptions"
            :series="series"
          ></apexchart>
        </div>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
export default {
  components: {},
  data() {
    return {
      model: null,
      show_graph: false,
      series: [
        {
          name: "",
          data: [49, 102, 83, 120, 81, 157, 205, 248, 207, 153, 179, 201],
        }
      ],
      chartOptions: {
        chart: {
          height: 350,
          type: "line",
          dropShadow: {
            enabled: true,
            color: "#000",
            top: 18,
            left: 7,
            blur: 10,
            opacity: 0.2,
          },
          toolbar: {
            show: false,
          },
        },
        colors: ["#545454"],
        dataLabels: {
          enabled: true,
        },
        stroke: {
          curve: "smooth",
        },
        title: {
          text: "",
          align: "left",
        },
        grid: {
          borderColor: "#e7e7e7",
          row: {
            colors: ["transparent", "transparent"], // takes an array which will be repeated on columns
            opacity: 0.5,
          },
        },
        markers: {
          size: 1,
        },
        xaxis: {
          categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
          title: {
            text: "",
          },
        },
        yaxis: {
          title: {
            text: "",
          },
        },
        legend: {
          position: "top",
          horizontalAlign: "right",
          floating: true,
          offsetY: -25,
          offsetX: -5,
        },
      },
    };
  },
  mounted() {
    console.log("Component mounted.");
    setTimeout(() => {
        this.show_graph = true;
    }, 500);
  },
  methods: {
    theFormat(number) {
      return number.toFixed(0);
    },
  },
};
</script>

<style>
</style>
