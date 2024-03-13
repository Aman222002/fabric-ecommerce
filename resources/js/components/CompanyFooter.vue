<template>
  <v-footer style="margin-top: auto" class="v-footer">
    <v-container class="w-75 footer">
      <v-row no-gutters>
        <v-col class="footer_col" sm="12" md="6" lg="4" xl="4">
          <v-toolbar-title v-cloak>
            <router-link
              class="logo"
              to="/"
              style="cursor: pointer"
              width="200"
            >
              {{ appName }}</router-link
            >
          </v-toolbar-title>
          <div class="footer-column about-widget">
            <p class="phone-num">
              <span>Call us </span>
              <a href="tel:1234567890">123 456 7890</a>
            </p>
            <p class="address">
              329 Queensberry Street, North Melbourne VIC<br />
              3051, Australia. <br />
              <a href="mailto:support@superio.com" class="email">
                mailto:support@superio.com
              </a>
            </p>
          </div>
        </v-col>

        <v-col class="footer_col" sm="12" md="4" lg="2" xl="2">
          <h4 class="widget-title">For Candidates</h4>
          <div class="widget-content">
            <ul class="list">
              <li><a href="#">Browse Jobs</a></li>
              <li><a href="#">Browse Categories</a></li>
              <li>
                <a href="#">Candidate Dashboard</a>
              </li>
              <li><a href="#">Job Alerts</a></li>
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
              <li><a href="#">Browse Candidates</a></li>
              <li>
                <a href="#">Employer Dashboard</a>
              </li>
              <li><a href="#">Add Job</a></li>
              <li><a href="#">Job Packages</a></li>
            </ul>
          </div>
        </v-col>

        <v-col class="footer_col" sm="12" md="4" lg="2" xl="2">
          <h4 class="widget-title">About Us</h4>
          <div class="widget-content">
            <ul class="list">
              <li><a href="#">About Us</a></li>
              <li><a href="#">Job Page Invoice</a></li>
              <li><a href="#">Terms Page</a></li>
              <li><a href="#">Blog</a></li>
              <li><a href="#">Contact</a></li>
            </ul>
          </div>
        </v-col>

        <v-col class="footer_col" sm="12" md="4" lg="2" xl="2">
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
        </v-col>
      </v-row>
    </v-container>
  </v-footer>
</template>

<script>
import { ref } from "vue";

export default {
  name: "CompanyFooter",
  setup() {
    const appName = ref("JOBS");

    return {
      appName,
    };
  },
};
</script>

<style scoped>
/* footer css Only  */
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
