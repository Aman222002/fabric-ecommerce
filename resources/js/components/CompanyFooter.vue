<template>
  <v-footer style="margin-top: auto" class="v-footer">
    <v-container class="w-75 footer">
      <v-row no-gutters>
        <v-col class="footer_col" sm="12" md="6" lg="4" xl="4">
          <v-toolbar-title v-cloak>
            <router-link class="logo" to="/" style="cursor: pointer" width="200">
              {{ appName }}</router-link>
          </v-toolbar-title>
          <div class="footer-column about-widget">
            <p class="phone-num">
              <span>Call us </span>
              <a @click="makeCall()">{{ contactDetails.contact }}</a>
            </p>
            <p class="address">
              {{ contactDetails.address }}<br />
              <a id="emailLink" @click="sendEmail()" class="email">
                mailto:{{ contactDetails.email }}
              </a>
            </p>
          </div>
        </v-col>
        <v-col class="footer_col" sm="12" md="4" lg="2" xl="2">
          <h4 class="widget-title">For Candidates</h4>
          <div class="widget-content">
            <ul class="list">
              <li><a href="/jobs-detail">Browse Jobs</a></li>
              <!-- <li><a href="#" @click="scrollToSection()">Browse Categories</a></li> -->
              <!-- <li>
                <a href="#">Candidate Dashboard</a>
              </li> -->
              <!-- <li><a href="#">Job Alerts</a></li> -->
              <li>
                <a href="#">My Bookmarks</a>
              </li>
            </ul>
          </div>
        </v-col>
        <v-col class="footer_col" sm="12" md="4" lg="2" xl="2">
          <h4 class="widget-title">For Employers</h4>
          <div class="widget-content">
            <ul class="list">
              <!-- <li><a href="/jobs-detail">Browse Candidates</a></li> -->
              <li>
                <a :href="employerStore.isloggedin ? '/posted-jobs' : '/job'">Employer Dashboard</a>
              </li>
              <li><a :href="employerStore.isloggedin ? '/postjob' : '/job'">Add Job</a></li>
              <li><a :href="employerStore.isloggedin ? '/product' : '/job'">Job Packages</a></li>
            </ul>
          </div>
        </v-col>
        <v-col class="footer_col" sm="12" md="4" lg="2" xl="2">
          <h4 class="widget-title">About Us</h4>
          <div class="widget-content">
            <ul class="list">
              <li><a href="/about">About Us</a></li>
              <!-- <li><a href="#">Job Page Invoice</a></li> -->
              <!-- <li><a href="#">Terms Page</a></li> -->
              <li><a href="#">Blog</a></li>
              <li><a href="#">Contact</a></li>
            </ul>
          </div>
        </v-col>
        <!-- <v-col class="footer_col" sm="12" md="4" lg="2" xl="2">
          <h4 class="widget-title">Helpful Resources</h4>
          <div class="widget-content">
            <ul class="list">
              <li><a href="#">Site Map</a></li>
              <li><a href="#">Terms of Use</a></li>
              <li><a href="#">Privacy Center</a></li>
              <li><a href="#">Security Center</a></li>
              <li><a href="#">Accessibility Center</a></li>
            </ul>
          </div>
        </v-col> -->
      </v-row>
    </v-container>
  </v-footer>
</template>

<script>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useUsersStore } from "../store/user";
import { useEmployerStore } from "../store/employer";

export default {
  name: "CompanyFooter",
  setup() {
    const appName = ref("JOBS");
    const usersStore = useUsersStore();
    const employerStore = useEmployerStore();
    const contactDetails = ref({});
    const sendEmail = () => {
      window.location.href = `mailto:${contactDetails.value.email}`;
    }
    const makeCall = () => {
      window.location.href = `tel:${contactDetails.value.contact}`;
    }
    const fetchData = () => {
      try {
        axios.get('contact/data').then((response) => {
          contactDetails.value = response.data.data[0];
          // console.log(contactDetails.value);
        })
      } catch (error) {
        console.log(error);
      }
    }
    onMounted(() => {
      fetchData();
    })
    return {
      appName,
      fetchData,
      contactDetails,
      sendEmail,
      makeCall,
      usersStore,
      employerStore
    };
    // methods: {
    //   sendEmail() {
    //     // const emailAddress = "support@superio.com";
    //     window.location.href = `mailto:${contactDetails.value.email}`;
    //   }
    // }
  },
};
</script>

<style scoped>
.footer p.phone-num {
  font-size: 18px;
  line-height: 28px;
  color: #202124;
  font-weight: 500;
  margin-bottom: 15px;
}

.footer p.phone-num a {
  color: #1967d2;
}

.footer .address {
  font-size: 14px;
  line-height: 30px;
  color: #696969;
  font-weight: 400;
}

.footer .address a {
  color: #696969;
}

.footer .widget-title {
  font-size: 18px;
  font-weight: 500;
  color: #2f2d51;
  line-height: 1.4em;
  margin-bottom: 30px;
}

.footer .list {
  position: relative;
}

.footer .list li {
  position: relative;
  display: block;
  font-size: 14px;
  line-height: 20px;
  font-weight: 400;
  color: #696969;
  margin-bottom: 15px;
}

.footer .list li:before {
  position: absolute;
  left: 0;
  top: 10px;
  height: 2px;
  width: 0;
  content: "";
  border-bottom: 2px solid #1967d2;
  transition: all 0.3s ease;
}

.footer .list li:hover:before {
  width: 15px;
}

.footer .list li a {
  display: inline-block;
  color: #696969;
  transition: all 0.2s ease;
}

.footer .list li:hover a {
  transform: translateX(25px);
  color: #1967d2;
}
</style>
