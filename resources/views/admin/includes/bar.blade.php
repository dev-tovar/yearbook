<v-app-bar outlined elevation="1"  color="secondary" app clipped-left>
    {{-- <v-app-bar-nav-icon @click.stop="clickToggleDrawer">
        <v-icon>@{{ drawer_help == false ? 'mdi-menu-open' : 'mdi-menu' }} </v-icon>
        </v-icon>
    </v-app-bar-nav-icon> --}}
    <v-toolbar-title>
        <v-card-actions>
            <v-img
              max-width="52"
              src="/img/logos/top-link.png"
              class="mr-5"
            ></v-img>
            <v-img max-width="220" src="https://admin-pocketyearbook.com/images/logo.png"></v-img>
          </v-card-actions>
         
    </v-toolbar-title> 
    <v-spacer></v-spacer>
        <span class="mr-2 font-weight-bold">Admin</span> 
        <v-btn small icon fab color="primary" class="grey lighten-1">
          <v-icon size="30">mdi-account-outline</v-icon>
        </v-btn>
</v-app-bar>
