<template>
  <v-dialog
    v-if="status == 'error'"
    v-model="dialog"
    scrollable
    persistent
    max-width="400px"
    transition="dialog-transition"
    content-class="rounded-xl"
  >
    <v-card class="rounded-xl" elevation="3">
      <v-card-title class="d-block text-center py-9 text-h5 font-weight-bold">
        {{ title_text_dialog }}
        <v-btn
          @click="closeDialog"
          class="admin-btn-close-dialog"
          small
          icon
          fab
        >
          <v-icon color="primary" size="30"> mdi-close </v-icon>
        </v-btn>
      </v-card-title>
      <v-card-text
        class="text-center font-weight-bold grey lighten-4 pt-5"
        v-html="body_text_dialog"
      >
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
          class="text-capitalize font-weight-bold admin-btn-bg"
          @click="closeDialog"
          >Ok</v-btn
        >
        <v-spacer></v-spacer>
      </v-card-actions>
    </v-card>
  </v-dialog>
  <v-dialog
    v-else-if="status == 'success'"
    v-model="dialog"
    scrollable
    persistent
    max-width="400px"
    transition="dialog-transition"
    content-class="rounded-xl"
  >
    <v-card class="rounded-xl" elevation="3">
      <v-card-title class="d-block text-center py-9 text-h5 font-weight-bold">
        {{ title_text_dialog }}
        <v-btn
          @click="redirectAction"
          class="admin-btn-close-dialog"
          small
          icon
          fab
        >
          <v-icon color="primary" size="30"> mdi-close </v-icon>
        </v-btn>
      </v-card-title>
      <v-card-text
        class="text-center font-weight-bold grey lighten-4 pt-5"
        v-html="body_text_dialog"
      >
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
          class="text-capitalize font-weight-bold admin-btn-bg"
          @click="redirectAction"
          >Ok</v-btn
        >
        <v-spacer></v-spacer>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
<script>
export default {
  props: [
    "title_text_dialog",
    "body_text_dialog",
    "redirect_success",
    "status",
  ],
  data() {
    return {
      dialog: true,
    };
  },
  methods: {
    redirectAction() {
      this.$router.push(this.redirect_success);
    },
    closeDialog(){
        this.$emit('close')
    }
  },
};
</script>