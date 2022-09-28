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
        <span class="mr-2 font-weight-bold">{!! Auth::guard('admin')->user()->name !!}</span> 

        <v-menu offset-y>
          <template v-slot:activator="{ on, attrs }">
            <v-btn 
            v-bind="attrs"
            v-on="on" small icon fab color="primary" class="grey lighten-1">
              <v-icon size="30">mdi-account-outline</v-icon>
            </v-btn>
           
          </template>
          <v-list class="py-0" dense>
            <v-list-item link>
              <v-list-item-title>Profile</v-list-item-title>
              <v-list-item-icon>
                <v-icon>mdi-account</v-icon>
              </v-list-item-icon>
            </v-list-item>
            <v-list-item link onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
              <v-list-item-title>Log out</v-list-item-title>
              <v-list-item-icon>
                <v-icon>mdi-logout</v-icon>
              </v-list-item-icon>
            </v-list-item>
          </v-list>
        </v-menu>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
        </form>
       
</v-app-bar>
