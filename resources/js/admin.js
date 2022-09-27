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
import draggable from 'vuedraggable'




window.Vue = require('vue');





Vue.use(Vuetify);
Vue.use(VueRouter);

Vue.component("yearbook-admin-home-component", require("./components/yearbook/admin/HomeComponent.vue").default);
Vue.component("yearbook-admin-news-feed-component", require("./components/yearbook/admin/NewsFeedComponent.vue").default);
Vue.component("yearbook-admin-create-news-feed-component", require("./components/yearbook/admin/CreateNewsFeedComponent.vue").default);




Vue.component("yearbook-admin-user-manager-component", require("./components/yearbook/admin/user-manager/UserManagerComponent.vue").default);
Vue.component("yearbook-admin-new-user-manager-component", require("./components/yearbook/admin/user-manager/CreateNewsUserManagerComponent.vue").default);



Vue.component("yearbook-admin-content-manager-submenu-component", require("./components/yearbook/admin/content-manager/sub-menu/SubMenuComponent.vue").default);

let yearbook_admin_home_component = {
    template: `<yearbook-admin-home-component></yearbook-admin-home-component>`
}
let yearbook_admin_news_feed_component = {
    template: `<yearbook-admin-news-feed-component></yearbook-admin-news-feed-component>`
}
let yearbook_admin_create_news_feed_component = {
    template: `<yearbook-admin-create-news-feed-component></yearbook-admin-create-news-feed-component>`
}
let yearbook_admin_user_manager_component = {
    template: `<yearbook-admin-user-manager-component></yearbook-admin-user-manager-component>`
}
let yearbook_admin_new_user_manager_component = {
    template: `<yearbook-admin-new-user-manager-component></yearbook-admin-new-user-manager-component>`
}


const router = new VueRouter({
    routes: [
        {
            path: '/admin',
            name: 'yearbook_admin_home_component',
            component: yearbook_admin_home_component
        },
        {
            path: '/admin/news_feed',
            name: 'yearbook_admin_news_feed_component',
            component: yearbook_admin_news_feed_component
        },
        {
            path: '/admin/news_feed/create',
            name: 'yearbook_admin_create_news_feed_component',
            component: yearbook_admin_create_news_feed_component
        },
        {
            path: '/admin/user_manager/:id',
            name: 'yearbook_admin_user_manager_component',
            component: yearbook_admin_user_manager_component,
            // children: [
            //     {
            //       path: '/admin/user_manager/:id/create',
            //       component: yearbook_admin_new_user_manager_component,
            //     },
            // ]
        },
        {
            path: '/admin/user_manager/:id/create',
            name: 'yearbook_admin_new_user_manager_component',
            component: yearbook_admin_new_user_manager_component,
        }
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
                { value: "news-feed", submenu: false, url: '/admin/news_feed', title: 'News Feed', icon: 'mdi-image-outline' },
                { value: "user-manager", submenu: true, url: '/admin/user_manager', title: 'User Manager', icon: 'mdi-image-outline' },
                { value: "content-manager", submenu: true, url: '/admin/content_manager', title: 'Content Manager', icon: 'mdi-image-outline' },
                { value: "gallery", submenu: false, url: '/admin/4', title: 'Gallery', icon: 'mdi-image-outline' },
                { value: "alumni", submenu: false, url: '/admin/5', title: 'Alumni', icon: 'mdi-image-outline' },
                { value: "alumni-events", submenu: false, url: '/admin/6', title: 'Alumni Events', icon: 'mdi-image-outline' },
                { value: "colors", submenu: false, url: '/admin/7', title: 'Colors', icon: 'mdi-image-outline' },
                { value: "bank-account", submenu: false, url: '/admin/8', title: 'Bank Account', icon: 'mdi-image-outline' },
                { value: "contact-us", submenu: false, url: '/admin/9', title: 'Contact Us', icon: 'mdi-image-outline' },
            ],
            sub_menu: [
                {
                    id: 1,
                    text: "2018  -  2019",
                    img: "https://cdn.vuetifyjs.com/images/lists/2.jpg",
                    url: "/admin/user_manager/1"
                },
                {
                    id: 2,
                    text: "2019  -  2020",
                    img: "https://cdn.vuetifyjs.com/images/lists/2.jpg",
                    url: "/admin/user_manager/2"
                },
                {
                    id: 3,
                    text: "2020  -  2021",
                    img: "https://cdn.vuetifyjs.com/images/lists/2.jpg",
                    url: "/admin/user_manager/3"
                },
                {
                    id: 4,
                    text: "2021  -  2022",
                    img: "https://cdn.vuetifyjs.com/images/lists/2.jpg",
                    url: "/admin/user_manager/4"
                },
                {
                    id: 5,
                    text: "2022  -  2023",
                    img: null,
                    url: "/admin/user_manager/5"
                },

            ],
            // '2018  -  2019', '2019  -  2020', '2020  -  2021', '2021  -  2022', '2022  -  2023'
            mini: true,
            
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
