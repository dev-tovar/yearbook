/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import '@mdi/font/css/materialdesignicons.css' // Ensure you are using css-loader

import Vue from 'vue'
import Vuetify from 'vuetify'
import VueRouter from 'vue-router'
import 'vuetify/dist/vuetify.min.css'


import VueNumber from 'vue-number-animation'

import VueApexCharts from 'vue-apexcharts'
Vue.use(VueApexCharts)

Vue.component('apexchart', VueApexCharts)



window.Vue = require('vue');

Vue.use(VueNumber)
Vue.use(Vuetify);
Vue.use(VueRouter);

Vue.component("yearbook-super-admin-dashboard-component", require("./components/yearbook/super-admin/dashboard/DashboardComponent.vue").default);
Vue.component("yearbook-super-admin-school-manager-component", require("./components/yearbook/super-admin/school-manager/SchoolManagerComponent.vue").default);
Vue.component("yearbook-super-admin-new-school-component", require("./components/yearbook/super-admin/school-manager/CreateNewsSchoolComponent.vue").default);
Vue.component("yearbook-super-admin-contact-us-component", require("./components/yearbook/super-admin/contact-us/ContactUsComponent.vue").default);
Vue.component("yearbook-super-admin-admins-component", require("./components/yearbook/super-admin/admins/AdminsComponent.vue").default);
Vue.component("yearbook-super-admin-new-admin-component", require("./components/yearbook/super-admin/admins/CreateNewsAdminComponent.vue").default);

let yearbook_super_admin_dashboard_component = {
    template: `<yearbook-super-admin-dashboard-component></yearbook-super-admin-dashboard-component>`
}
let yearbook_super_admin_school_manager_component = {
    template: `<yearbook-super-admin-school-manager-component></yearbook-super-admin-school-manager-component>`
}
let yearbook_super_admin_new_school_component = {
    template: `<yearbook-super-admin-new-school-component></yearbook-super-admin-new-school-component>`
}
let yearbook_super_admin_contact_us_component = {
    template: `<yearbook-super-admin-contact-us-component></yearbook-super-admin-contact-us-component>`
}
let yearbook_super_admin_admins_component = {
    template: `<yearbook-super-admin-admins-component></yearbook-super-admin-admins-component>`
}
let yearbook_super_admin_new_admin_component = {
    template: `<yearbook-super-admin-new-admin-component></yearbook-super-admin-new-admin-component>`
}



const router = new VueRouter({
    routes: [
        {
            path: '/pyb/super-admin/dashboard',
            name: 'yearbook_super_admin_dashboard_component',
            component: yearbook_super_admin_dashboard_component
        },
        {
            path: '/pyb/super-admin/school_manager',
            name: 'yearbook_super_admin_school_manager_component',
            component: yearbook_super_admin_school_manager_component
        },
        {
            path: '/pyb/super-admin/school_manager/create',
            name: 'yearbook_super_admin_new_school_component',
            component: yearbook_super_admin_new_school_component
        },
        {
            path: '/pyb/super-admin/school_manager/:id_school/edit',
            name: 'yearbook_super_admin_new_school_component_edit',
            component: yearbook_super_admin_new_school_component
        },
        {
            path: '/pyb/super-admin/contact_us',
            name: 'yearbook_super_admin_contact_us_component',
            component: yearbook_super_admin_contact_us_component
        },
        {
            path: '/pyb/super-admin/admins',
            name: 'yearbook_super_admin_admins_component',
            component: yearbook_super_admin_admins_component
        },
        {
            path: '/pyb/super-admin/admins/create',
            name: 'yearbook_super_admin_new_admin_component',
            component: yearbook_super_admin_new_admin_component
        },
        {
            path: '/pyb/super-admin/admins/:id_admin/edit',
            name: 'yearbook_super_admin_edit_admin_component',
            component: yearbook_super_admin_new_admin_component
        },
        
    ],
    mode: 'history'
})

const app = new Vue({
    router,
    vuetify: new Vuetify({
        iconfont: 'mdi',
        theme: {
            themes: {
                light: {
                    primary: '#000000',
                    secondary: '#D9D9D9',
                    accent: '#E6E6E6',
                    error: '#FF5252',
                    info: '#2196F3',
                    success: '#4CAF50',
                    warning: '#FFC107',
                }
            }
        },
    }),
    el: '#app',
    data() {
        return {

            size_menu_admin: 103,
            sub_menu_admin: false,
            menu_admin_select: null,
            items: [
                {
                    value: "dashboard",
                    submenu: false,
                    url: '/pyb/super-admin/dashboard', 
                    title: 'Dashboard',
                    icon: 'mdi-image-outline'
                },
                {
                    value: "school-manager",
                    submenu: false,
                    url: '/pyb/super-admin/school_manager',
                    title: 'School manager',
                    icon: 'mdi-image-outline'
                },
                {
                    value: "contact-us",
                    submenu: false,
                    url: '/pyb/super-admin/contact_us',
                    title: 'Contact us', 
                    icon: 'mdi-image-outline'
                },
                {
                    value: "admins",
                    submenu: false,
                    url: '/pyb/super-admin/admins',
                    title: 'Admins', 
                    icon: 'mdi-image-outline'
                },
                {
                    value: "college-attending",
                    submenu: false,
                    url: '/pyb/super-admin/college_attending',
                    title: 'College attending', 
                    icon: 'mdi-image-outline'
                },
                {
                    value: "future-aspirations",
                    submenu: false,
                    url: '/pyb/super-admin/future_aspirations',
                    title: 'Future aspirations', 
                    icon: 'mdi-image-outline'
                },
                {
                    value: "sports_clubs",
                    submenu: false,
                    url: '/pyb/super-admin/sports_clubs',
                    title: 'Sports / Clubs', 
                    icon: 'mdi-image-outline'
                },
            ],
            sub_menu: [
                {
                    id: 1,
                    text: "2018  -  2019",
                    img: "https://cdn.vuetifyjs.com/images/lists/2.jpg",
                    url: "/pyb/admin/user_manager/1"
                },
                {
                    id: 2,
                    text: "2019  -  2020",
                    img: "https://cdn.vuetifyjs.com/images/lists/2.jpg",
                    url: "/pyb/admin/user_manager/2"
                },
                {
                    id: 3,
                    text: "2020  -  2021",
                    img: "https://cdn.vuetifyjs.com/images/lists/2.jpg",
                    url: "/pyb/admin/user_manager/3"
                },
                {
                    id: 4,
                    text: "2021  -  2022",
                    img: "https://cdn.vuetifyjs.com/images/lists/2.jpg",
                    url: "/pyb/admin/user_manager/4"
                },
                {
                    id: 5,
                    text: "2022  -  2023",
                    img: null,
                    url: "/pyb/admin/user_manager/5"
                },

            ],
            // '2018  -  2019', '2019  -  2020', '2020  -  2021', '2021  -  2022', '2022  -  2023'
            mini: true,
            csrf_token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

        }
    },
    //  data: () => ({
    //  }),
    methods: {

        toValueItem(value, submenu) {
            this.menu_admin_select = value;
            if (submenu) {
                this.size_menu_admin = 380;
            } else {
                this.size_menu_admin = 103;
            }
            this.sub_menu_admin = submenu;
        }
    },

});
