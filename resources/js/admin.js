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




 window.Vue = require('vue');





 Vue.use(Vuetify);
 Vue.use(VueRouter);

 Vue.component("yearbook-admin-home-component", require("./components/yearbook/admin/HomeComponent.vue").default);
 Vue.component("yearbook-admin-news-feed-component", require("./components/yearbook/admin/NewsFeedComponent.vue").default);
 Vue.component("yearbook-admin-create-news-feed-component", require("./components/yearbook/admin/CreateNewsFeedComponent.vue").default);

let yearbook_admin_home_component = {
    template: `<yearbook-admin-home-component></yearbook-admin-home-component>`
}
let yearbook_admin_news_feed_component = {
    template: `<yearbook-admin-news-feed-component></yearbook-admin-news-feed-component>`
}
let yearbook_admin_create_news_feed_component = {
    template: `<yearbook-admin-create-news-feed-component></yearbook-admin-create-news-feed-component>`
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
     data: () => ({
        items: [
            { url: '/admin/news_feed', title: 'News Feed', icon: 'mdi-image-outline' },
            { url: '/admin/news_feed2', title: 'User Manager', icon: 'mdi-image-outline' },
            { url: '/admin/news_feed3', title: 'Content Manager', icon: 'mdi-image-outline' },
            { url: '/admin/news_feed4', title: 'Gallery', icon: 'mdi-image-outline' },
            { url: '/admin/news_feed5', title: 'Alumni', icon: 'mdi-image-outline' },
            { url: '/admin/news_feed6', title: 'Alumni Events', icon: 'mdi-image-outline' },
            { url: '/admin/news_feed7', title: 'Colors', icon: 'mdi-image-outline' },
            { url: '/admin/news_feed8', title: 'Bank Account', icon: 'mdi-image-outline' },
            { url: '/admin/news_feed9', title: 'Contact us', icon: 'mdi-image-outline' },
          ],
          links: ['Home', 'Contacts', 'Settings'],
          mini: true,
     }),

 });
