<template>
  <v-list color="#ECECEC" class="grow">
      <v-list-item>
      <v-list-item-content>
        <v-list-item-title style="max-width: 225px;" class="font-weight-bold body-1 primary--text">
      <span
        style="cursor: pointer"
        @click="move_section = false"
        v-if="move_section && submenu_cm_step == 2"
      >
        <v-icon left>mdi-arrow-left</v-icon> Move category</span
      >
      <span
        style="cursor: pointer"
        @click="submenu_cm_step = 1"
        v-else-if="!move_section && submenu_cm_step == 2"
      >
        <v-icon left>mdi-arrow-left</v-icon> {{ submenu_cm_title_1 }}</span
      >
      <span
        style="cursor: pointer"
        @click="submenu_cm_step = 2"
        v-else-if="submenu_cm_step == 3"
      >
        <v-icon left>mdi-arrow-left</v-icon> {{ submenu_cm_title_1 + " - " +submenu_cm_title_2 }}</span
      >
      <span v-else>Yearbooks</span>
        </v-list-item-title>
      </v-list-item-content>
    </v-list-item>
        

    <v-divider class="mb-4"></v-divider>

    <v-list-item-group v-if="submenu_cm_step == 1" v-model="submenu_cm_step_1">
      <v-list-item
        v-for="(sub, index) in $root.sub_menu"
        :key="index"
        link
        :value="sub.id"
      >
        <v-list-item-avatar tile> </v-list-item-avatar>
        <v-list-item-title class="body-2">{{ sub.text }}</v-list-item-title>
        <v-list-item-action>
          <v-icon @click="selectStepSubmenuCM(1, 2, sub.id, sub.text)">
            mdi-chevron-right
          </v-icon>
        </v-list-item-action>
      </v-list-item>
    </v-list-item-group>
    <v-list-item-group v-if="submenu_cm_step == 2" v-model="submenu_cm_step_2">
      <draggable
        :list="items_section"
        handle=".handle"
        ghost-class="ghost-options"
      >
        <v-list-item
          v-for="(item, index) in items_section"
          :key="index"
          link
          :value="item.id"
        >
          <v-list-item-action v-if="!move_section">
            <v-menu bottom left rounded="lg">
              <template v-slot:activator="{ on, attrs }">
                <v-icon v-bind="attrs" v-on="on">mdi-dots-vertical</v-icon>
              </template>

              <v-list dense class="pa-0">
                <v-list-item>
                  <v-list-item-title>Edit</v-list-item-title>
                  <v-list-item-action>
                    <v-icon>mdi-pencil-outline</v-icon>
                  </v-list-item-action>
                </v-list-item>
                <v-list-item @click="move_section = true">
                  <v-list-item-title>Move</v-list-item-title>
                  <v-list-item-action>
                    <v-icon>mdi-pan-vertical</v-icon>
                  </v-list-item-action>
                </v-list-item>
                <v-list-item>
                  <v-list-item-title>Delete</v-list-item-title>
                  <v-list-item-action>
                    <v-icon>mdi-trash-can-outline</v-icon>
                  </v-list-item-action>
                </v-list-item>
              </v-list>
            </v-menu>
          </v-list-item-action>
          <v-list-item-title class="body-2">{{ item.text }}</v-list-item-title>
          <v-list-item-action>
            <v-icon
              @click="
                !move_section ? selectStepSubmenuCM(2, 3, item.id, item.text) : false
              "
              v-if="!move_section"
            >
              mdi-chevron-right
            </v-icon>
            <v-icon class="handle" v-else-if="move_section">
              mdi-pan-vertical
            </v-icon>
          </v-list-item-action>
        </v-list-item>
      </draggable>
      <v-divider class="my-4"></v-divider>
      <div class="d-block text-center">
        <v-btn
          v-if="move_section"
          outlined
          rounded
          width="201"
          color="primary"
          class="text-capitalize font-weight-bold"
          >Save</v-btn
        >
        <v-btn
          v-else
          outlined
          rounded
          width="201"
          color="primary"
          class="text-capitalize font-weight-bold"
          >Add new Section</v-btn
        >
      </div>
    </v-list-item-group>
    <v-list-item-group v-if="submenu_cm_step == 3" v-model="submenu_cm_step_3">
     
        <v-list-item
          v-for="(item, index) in items_sub_section"
          :key="index"
          link
          :value="item.id"
        >
          <v-list-item-action v-if="!move_section">
            <v-menu bottom left rounded="lg">
              <template v-slot:activator="{ on, attrs }">
                <v-icon v-bind="attrs" v-on="on">mdi-dots-vertical</v-icon>
              </template>

              <v-list dense class="pa-0">
                <v-list-item>
                  <v-list-item-title>Edit</v-list-item-title>
                  <v-list-item-action>
                    <v-icon>mdi-pencil-outline</v-icon>
                  </v-list-item-action>
                </v-list-item>
                <v-list-item @click="move_section = true">
                  <v-list-item-title>Move</v-list-item-title>
                  <v-list-item-action>
                    <v-icon>mdi-pan-vertical</v-icon>
                  </v-list-item-action>
                </v-list-item>
                <v-list-item>
                  <v-list-item-title>Delete</v-list-item-title>
                  <v-list-item-action>
                    <v-icon>mdi-trash-can-outline</v-icon>
                  </v-list-item-action>
                </v-list-item>
              </v-list>
            </v-menu>
          </v-list-item-action>
          <v-list-item-title class="body-2">{{ item.text }}</v-list-item-title>
          <v-list-item-action>
            <v-icon
              @click="
                !move_section ? selectStepSubmenuCM(2, 3, item.id) : false
              "
              v-if="!move_section"
            >
              mdi-chevron-right
            </v-icon>
            <v-icon class="handle" v-else-if="move_section">
              mdi-pan-vertical
            </v-icon>
          </v-list-item-action>
        </v-list-item>
        <p class="text-center caption" v-if="items_sub_section.length == 0">
            No Sub-section
        </p>
      <v-divider class="my-4"></v-divider>
      <div class="d-block text-center">
        <v-btn
          v-if="move_section && submenu_cm_step == 2"
          outlined
          rounded
          width="201"
          color="primary"
          class="text-capitalize font-weight-bold"
          >Save</v-btn
        >
       
        <v-btn
          v-else-if="!move_section && submenu_cm_step == 2"
          outlined
          rounded
          width="201"
          color="primary"
          class="text-capitalize font-weight-bold"
          >Add new Section</v-btn
        > <v-btn
          v-if="submenu_cm_step == 3"
          outlined
          rounded
          width="201"
          color="primary"
          class="text-capitalize font-weight-bold"
          >Add New Sub-Section</v-btn
        >
      </div>
    </v-list-item-group>
  </v-list>
</template>
<script>
import draggable from "vuedraggable";

export default {
  components: {
    draggable,
  },
  data() {
    return {
      move_section: false,
      items_section: [
        {
          id: "cover",
          text: "Cover",
        },
        {
          id: "school-spirit",
          text: "School Spirit",
        },
        {
          id: "sports",
          text: "Sports",
        },
        {
          id: "clubs",
          text: "Clubs",
        },
        {
          id: "student-tributes",
          text: "Student tributes",
        },
        {
          id: "grades",
          text: "Grades",
        },
        {
          id: "students-profile",
          text: "Students Profile",
        },
      ],
      items_sub_section: [],
      submenu_cm_step: 1,
      submenu_cm_step_1: null,
      submenu_cm_step_2: null,
      submenu_cm_step_3: null,
      submenu_cm_step_4: null,
      submenu_cm_title_1: null,
      submenu_cm_title_2: null,
    };
  },
  methods: {
    selectStepSubmenuCM(step_actual, step_next, value, title) {
      if (step_actual == 1) {
        this.submenu_cm_title_1 = title;
        this.submenu_cm_step_1 = value;
      }
      if (step_actual == 2) {
         this.submenu_cm_title_2 = title;
        this.submenu_cm_step_2 = value;
      }
      if (step_actual == 3) {
        this.submenu_cm_step_3 = value;
      }
      if (step_actual == 4) {
        this.submenu_cm_step_4 = value;
      }

      this.submenu_cm_step = step_next;
    },
  },
};
</script>
<style>
.ghost-options {
  opacity: 0.5;
  background: #ffd3d3;
}
</style>