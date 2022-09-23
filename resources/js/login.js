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

 Vue.component("example-component", require("./components/ExampleComponent.vue").default);
 Vue.component("yearbook-login-component", require("./components/yearbook/login/LoginComponent.vue").default);
 Vue.component("yearbook-forgotpassword-component", require("./components/yearbook/login/ForgotPasswordComponent.vue").default);

let example_component = {
    template: `<example-component></example-component>`
}
let yearbook_login_component = {
    template: `<yearbook-login-component></yearbook-login-component>`
}
let yearbook_forgotpassword_component = {
    template: `<yearbook-forgotpassword-component></yearbook-forgotpassword-component>`
}

 const router = new VueRouter({
     routes: [
         {
             path: '/login',
             name: 'yearbook_login_component',
             component: yearbook_login_component
         },
         {
             path: '/password/reset',
             name: 'yearbook_forgotpassword_component',
             component: yearbook_forgotpassword_component
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
     data: () => ({
     }),

 });
