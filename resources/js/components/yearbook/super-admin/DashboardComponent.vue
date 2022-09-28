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
      <v-card-text class="px-0"> </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
export default {
  components: {},
  data() {
    return {
      model: null,
    };
  },
  mounted() {
    console.log("Component mounted.");
  },
  methods: {
    theFormat(number) {
      return number.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
    },
  },
};
</script>

<style>
</style>
