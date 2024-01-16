/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import "./bootstrap";
import "@mdi/font/css/materialdesignicons.css";
import { createApp } from "vue";
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import VueTelInput from "vue3-tel-input";
import "vue3-tel-input/dist/vue3-tel-input.css";
import eventBus from "./event-bus";
const VueTelInputOptions = {
    mode: "international",
    onlyCountries: ["NG", "GH", "GB", "US", "CA"],
};

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

const vuetify = createVuetify({
    components,
    directives,
});

import Registration from "./components/Registration.vue";
app.component("register-component", Registration);

import Header from "./components/Header.vue";
app.component("header-component", Header);

import Footer from "./components/Footer.vue";
app.component("footer-component", Footer);

import Login from "./components/Login.vue";
app.component("login-component", Login);

// import UserprofileComponent from "./components/UserprofileComponent.vue";
// app.component("userprofile-component", UserprofileComponent);
import NavbarComponent from "./components/NavbarComponent.vue";
app.component("navbar-component", NavbarComponent);
import AllUser from "./components/AllUser.vue";
app.component("alluser-component", AllUser);
import SidebarComponent from "./components/SidebarComponent.vue";
app.component("sidebar-component", SidebarComponent);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.use(vuetify);
app.config.globalProperties.eventBus = eventBus;
app.use(VueTelInput, VueTelInputOptions);
app.mount("#app");
