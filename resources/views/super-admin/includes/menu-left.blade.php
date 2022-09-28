<v-navigation-drawer permanent color="secondary" :width="size_menu_admin" app clipped  mini-variant.sync="mini">
   

    {{-- <v-navigation-drawer
    permanent
    width="100%"
  > --}}
    <v-row
      class="fill-height"
      no-gutters
    >
      <v-navigation-drawer
        mini-variant
        mini-variant-width="103"
        permanent
        color="secondary"
        class="hidde-scroll-bar"
      >
        {{-- <v-list-item class="px-2">
          <v-list-item-avatar>
            <v-img src="https://randomuser.me/api/portraits/women/75.jpg"></v-img>
          </v-list-item-avatar>
        </v-list-item>

        <v-divider></v-divider> --}}

        <v-list
        class="py-0 admin-menu"
          dense
          two-line
        >
        <v-list-item-group
        v-model="menu_admin_select"
        color="primary"
      >
        <template  v-for="(item, index) in items">
            <v-list-item :value="item.value"  :key="index" link :to="item.url" @click="toValueItem(item.value, item.submenu)">
                <template
                v-slot:default="{ active }">
                <v-list-item-content class="py-3" style="height: 90px;">
                    <v-icon color="black">@{{ item.icon }}</v-icon>
                    <v-list-item-title :class="active ? 'font-weight-bold' : ''" class="text-break text-center" style="white-space: normal;">
                        <p class="text-break text-center my-0">@{{ item.title }}</p>
                    </v-list-item-title>
                </v-list-item-content>
                </template>
              </v-list-item>
              <v-divider v-if="items.length > index + 1" class="mx-4"></v-divider>
        </template>
        </v-list-item-group>
          
        </v-list>
      </v-navigation-drawer>


    
      

    
    </v-row>
  </v-navigation-drawer>

