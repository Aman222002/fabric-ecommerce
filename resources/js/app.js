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
import VueTelInput from "vue-tel-input";
import "vue-tel-input/vue-tel-input.css";
const VueTelInputOptions = {
    mode: "national",
    onlyCountries: ["NG", "GH", "GB", "US", "CA", "IN"],
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

app.use(vuetify);
app.use(VueTelInput, VueTelInputOptions);
import Registration from "./components/Registration.vue";
app.component("registration-component", Registration);
import Header from "./components/Header.vue";
app.component("header-component", Header);
import Footer from "./components/Footer.vue";
app.component("footer-component", Footer);
import Login from "./components/Login.vue";
app.component("login-component", Login);
import Home from "./components/Home.vue";
app.component("home-component", Home);
import CvComponent from "./components/CvComponent.vue";
app.component("cv-component", CvComponent);

// import UserprofileComponent from "./components/UserprofileComponent.vue";
// app.component("userprofile-component", UserprofileComponent);

import DashboardComponent from "./components/DashboardComponent.vue";
app.component("dashboard-component", DashboardComponent);

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

app.mount("#app");
