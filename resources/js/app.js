/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// import "./bootstrap";
import "@mdi/font/css/materialdesignicons.css";
import { createApp } from "vue";
import "vuetify/styles";
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import "vue3-tel-input/dist/vue3-tel-input.css";
import mitt from "mitt";
import "devextreme/dist/css/dx.common.css";
import "devextreme/dist/css/dx.light.css";
const emitter = mitt();
import "vue-tel-input/vue-tel-input.css";
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";

import { createPinia } from "pinia";

import piniaPluginPersistedstate from "pinia-plugin-persistedstate";

const pinia = createPinia({
    components,
    directives,
});

pinia.use(piniaPluginPersistedstate);

const VueTelInputOptions = {
    mode: "national",
    onlyCountries: ["NG", "GH", "GB", "US", "CA", "IN"],
};
/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */
const app = createApp({
    theme: {
        defaultTheme: "light",
    },
});
const vuetify = createVuetify({
    components,
    directives,
});
import {
    DxDataGrid,
    DxPager,
    DxPaging,
    DxFilterRow,
    DxColumn,
    DxButton as DxGridButton,
    DxSearchPanel,
    DxSummary,
    DxTotalItem,
    DxFormat,
    DxHeaderFilter,
    DxScrolling,
    DxMasterDetail,
    DxSorting,
    DxLoadPanel,
    DxItem as DxGridItem,
    DxToolbar,
    DxSelection,
    DxColumnChooser,
    DxEditing,
    DxLookup,
    DxPatternRule,
    DxRequiredRule,
    DxEmailRule,
    DxExport,
} from "devextreme-vue/data-grid";
import {
    DxForm,
    DxItem as DxFormItem,
    DxLabel,
    DxGroupItem,
} from "devextreme-vue/form";
import { DxTooltip } from "devextreme-vue/tooltip";
import { DxTabPanel, DxItem as DxTabItem } from "devextreme-vue/tab-panel";
import { DxBox, DxItem as DxBoxItem } from "devextreme-vue/box";
import { DxButton } from "devextreme-vue/button";
import { DxDropDownBox } from "devextreme-vue/drop-down-box";
import DxList from "devextreme-vue/list";
app.use(vuetify);
app.use(pinia);
app.use(VueSweetalert2);
//app.use(VueTelInput, VueTelInputOptions);

import Registration from "./components/Registration.vue";
app.component("registration-component", Registration);

import Header from "./components/Header.vue";
app.component("header-component", Header);

import Footer from "./components/Footer.vue";
app.component("footer-component", Footer);

import Login from "./components/Login.vue";
app.component("login-component", Login);

import ForgetPassword from "./components/ForgetPassword.vue";
app.component("forgetpassword-component", ForgetPassword);

import ResetPassword from "./components/ResetPassword.vue";
app.component("resetpassword-component", ResetPassword);

import ResumeComponent from "./components/ResumeComponent.vue";
app.component("resume-component", ResumeComponent);

import ExpiredComponent from "./components/Expired.vue";
app.component("expired-component", ExpiredComponent);

import AddressTabComponent from "./components/AddressTab.vue";
app.component("address-component", AddressTabComponent);

// import UserprofileComponent from "./components/UserprofileComponent.vue";
// app.component("userprofile-component", UserprofileComponent);
import NavbarComponent from "./components/NavbarComponent.vue";
app.component("navbar-component", NavbarComponent);
import AllUser from "./components/AllUser.vue";
app.component("alluser-component", AllUser);
import ProfileComponent from "./components/ProfileComponent.vue";
app.component("profile-component", ProfileComponent);
import CompaniesComponent from "./components/CompaniesComponent.vue";
app.component("companies-component", CompaniesComponent);
import SubscriptionPlans from "./components/SubscriptionPlans.vue";
app.component("plans-component", SubscriptionPlans);
import SidebarComponent from "./components/SidebarComponent.vue";
app.component("sidebar-component", SidebarComponent);
app.config.globalProperties.emitter = emitter;
const component = {
    DxDataGrid,
    DxPager,
    DxPaging,
    DxFilterRow,
    DxColumn,
    DxGridButton,
    DxButton,
    DxSearchPanel,
    DxSummary,
    DxTotalItem,
    DxFormat,
    DxHeaderFilter,
    DxScrolling,
    DxToolbar,
    DxGridItem,
    DxSorting,
    DxLoadPanel,
    DxMasterDetail,
    DxSelection,
    DxColumnChooser,
    DxForm,
    DxLabel,
    DxGroupItem,
    DxTooltip,
    DxEditing,
    DxFormItem,
    DxLookup,
    DxPatternRule,
    DxRequiredRule,
    DxEmailRule,
    DxExport,
    DxTabPanel,
    DxBox,
    DxBoxItem,
    DxTabItem,
    DxDropDownBox,
    DxList,
};
Object.entries(component).forEach(([name, component]) => {
    app.component(name, component);
});

import DashBoard from "./components/DashBoard.vue";
app.component("dashboard-component", DashBoard);

import FindCv from "./components/FindCv.vue";
app.component("findcv-component", FindCv);

import Job from "./components/Job.vue";
app.component("job-component", Job);

import CompanyRegister from "./components/CompanyRegister.vue";
app.component("company-component", CompanyRegister);

import Product from "./components/Product.vue";
app.component("product-component", Product);

import cart from "./components/Cart.vue";
app.component("cart-component", cart);

import postjob from "./components/postjob.vue";
app.component("postjob-component", postjob);

import JobCrud from "./components/Jobcrud.vue";
app.component("jobcrud-component", JobCrud);

import CompanyNav from "./components/CompanyNav.vue";
app.component("companynav-component", CompanyNav);

import CompanyFooter from "./components/CompanyFooter.vue";
app.component("companyfooter-component", CompanyFooter);

import CompanyPage from "./components/CompanyPage.vue";
app.component("company-page", CompanyPage);

import CompanyPost from "./components/CompanyPost.vue";
app.component("company-post", CompanyPost);

import CompanyProfile from "./components/CompanyProfile.vue";
app.component("company-profile", CompanyProfile);

import JobApplied from "./components/JobApplied.vue";
app.component("jobapply-component", JobApplied);

import BuySubscription from "./components/Buy.vue";
app.component("buy-component", BuySubscription);
import PostDetail from "./components/PostDetail.vue";
app.component("job-detail", PostDetail);

import SaveJob from "./components/SaveJob.vue";
app.component("savejob-component", SaveJob);

import UserProfile from "./components/UserProfile.vue";
app.component("user-profile", UserProfile);

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
window.Swal = app.config.globalProperties.$swal;
app.component("VueDatePicker", VueDatePicker);
app.mount("#app");
