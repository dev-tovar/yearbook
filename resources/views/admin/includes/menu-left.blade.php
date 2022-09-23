<v-navigation-drawer permanent color="secondary" width="103" app clipped  mini-variant.sync="mini">
   

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
      >
        {{-- <v-list-item class="px-2">
          <v-list-item-avatar>
            <v-img src="https://randomuser.me/api/portraits/women/75.jpg"></v-img>
          </v-list-item-avatar>
        </v-list-item>

        <v-divider></v-divider> --}}

        <v-list
        class="py-0"
          dense
          two-line
        >
        <template  v-for="(item, index) in items">
            <v-list-item :key="index" :to="item.url">
                <template
                v-slot:default="{ active }">
                <v-list-item-content  class="py-3" style="height: 90px;">
                    <v-icon color="black">@{{ item.icon }}</v-icon>
                    <v-list-item-title :class="active ? 'font-weight-bold' : ''" class="text-break text-center" style="white-space: normal;">
                        <p class="text-break text-center my-0">@{{ item.title }}</p>
                    </v-list-item-title>
                </v-list-item-content>
                </template>
              </v-list-item>
              <v-divider v-if="items.length > index + 1" class="mx-3"></v-divider>
        </template>
          
        </v-list>
      </v-navigation-drawer>

      {{-- <v-list class="grow">
        <v-list-item
          v-for="link in links"
          :key="link"
          link
        >
          <v-list-item-title v-text="link"></v-list-item-title>
        </v-list-item>
      </v-list> --}}
    </v-row>
  </v-navigation-drawer>

