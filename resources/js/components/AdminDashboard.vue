<template>
  <v-container class="company_dashboard_view">
    <div id="cardsDiv">
      <v-row>
        <v-col sm="12" md="6" lg="3" xl="3" cols="12">
          <v-card class="mx-auto card dashboard_info one_dt" id="Card">
            <v-card-item>
              <div class="flex-container">
                <v-icon class="bottomicon3" size="60">mdi-account</v-icon>
              </div>
              <div class="cardtop">
                <h1 class="numbering">{{ totalUser }}</h1>
                <h6 class="dashboardh6">Total Users</h6>
              </div>
              <div class="cardbottom">
                <a href="/admin/users" class="link">View all users</a>
              </div>
            </v-card-item>
          </v-card>
        </v-col>

        <v-col sm="12" md="6" lg="3" xl="3" cols="12">
          <v-card class="mx-auto card dashboard_info two_dt" id="Card">
            <v-card-item>
              <div class="flex-container">
                <v-icon class="bottomicon3" size="60"
                  >mdi-office-building</v-icon
                >
              </div>
              <div class="cardtop">
                <h1 class="numbering">
                  {{ totalCompany }}
                </h1>
                <h6 class="dashboardh6">Total Companies</h6>
              </div>
              <div class="cardbottom">
                <a href="/admin/companies" class="link">View all companies</a>
              </div>
            </v-card-item>
          </v-card>
        </v-col>

        <v-col sm="12" md="6" lg="3" xl="3" cols="12">
          <v-card class="mx-auto card dashboard_info three_dt" id="Card">
            <v-card-item>
              <div class="flex-container">
                <v-icon class="bottomicon3" size="60">mdi-purse</v-icon>
              </div>
              <div class="cardtop">
                <h1 class="numbering">{{ totalJobs }}</h1>
                <h6 class="dashboardh6">Total Jobs Postings</h6>
              </div>
              <div class="cardbottom">
                <a href="/admin/jobs" class="link">View all jobs</a>
              </div>
            </v-card-item>
          </v-card>
        </v-col>

        <v-col sm="12" md="6" lg="3" xl="3" cols="12">
          <v-card class="mx-auto card dashboard_info four_dt" id="Card">
            <v-card-item>
              <div class="flex-container">
                <v-icon class="bottomicon3" size="60">mdi-post</v-icon>
              </div>
              <div class="cardtop">
                <h1 class="numbering">{{ totalBlog }}</h1>
                <h6 class="dashboardh6">Total Blogs</h6>
              </div>
              <div class="cardbottom">
                <a href="/admin/blog/view" class="link">View all Blogs</a>
              </div>
            </v-card-item>
          </v-card>
        </v-col>
      </v-row>
    </div>

    <div id="chartDiv" class="mt-6">
      <div class="graph">
        <DxChart
          id="chart"
          :data-source="grossProductData"
          title="Job Postings"
          @pointClick="onPointClick"
        >
          <DxCommonSeriesSettings
            argument-field="Month"
            type="bar"
            hover-mode="allArgumentPoints"
            selection-mode="allArgumentPoints"
            :barWidth="40"
          >
            <DxLabel :visible="true">
              <DxFormat :precision="0" type="fixedPoint" />
            </DxLabel>
          </DxCommonSeriesSettings>
          <DxSeries value-field="jobCount" name="Total Job Posted" />
          <!-- <DxSeries value-field="year2023" name="Total Earning" /> -->
          <!-- <DxLegend vertical-alignment="bottom" horizontal-alignment="center" /> -->
          <DxExport :enabled="true" />
        </DxChart>
      </div>

      <div id="SupplierDiv">
        <v-card>
          <v-card-title class="bg-primary">Recent Jobs</v-card-title>
          <v-card-text>
            <v-table>
              <thead>
                <tr>
                  <th class="text-left">Title</th>
                  <th class="text-left">Location</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="item in recentPosts" :key="item.name">
                  <td>{{ item.title }}</td>
                  <td>{{ item.location }}</td>
                </tr>
              </tbody>
            </v-table>
          </v-card-text>
        </v-card>
      </div>
    </div>
  </v-container>
</template>
<script>
import { ref, onMounted } from "vue";
import axios from "axios";

export default {
  name: "AdminDashboard",
  setup() {
    const totalUser = ref("0");
    const totalCompany = ref("0");
    const totalBlog = ref("0");
    const recentPosts = ref([]);
    const grossProductData = ref([]);
    const fetchTotalUsers = () => {
      try {
        axios.get("/admin/user/index").then((response) => {
          // console.log(response.data.totalCount);
          totalUser.value = response.data.totalCount;
        });
      } catch (err) {
        console.log(err);
      }
    };
    const fetchTotalCompany = () => {
      try {
        axios.get("/admin/company/getCompanies").then((response) => {
          // console.log(response.data.totalCount);
          totalCompany.value = response.data.totalCount;
        });
      } catch (err) {
        console.log(err);
      }
    };
    const fetchTotalBlogs = () => {
      try {
        axios.get("/admin/blog/fetch").then((response) => {
          totalBlog.value = response.data.totalCount;
        });
      } catch (err) {
        console.log(err);
      }
    };
    const fetchRecentPosts = () => {
      try {
        axios.get("/company/recent-posts").then((response) => {
          console.log(response.data.data);
          recentPosts.value = response.data.data;
          totalposted.value = response.data.total_posts;
        });
      } catch (err) {
        console.log(err);
      }
    };
    const totalJobs = ref("0");
    const fetchTotalJobs = () => {
      try {
        axios.get("/admin/get/jobs").then((response) => {
          console.log(response.data);
          recentPosts.value = response.data.recentJobs;
          totalJobs.value = response.data.totalCount;
          // console.log(totalJobs.value);
        });
      } catch (err) {
        console.log(err);
      }
    };
    const fetchGraphData = () => {
      try {
        axios.get("/admin/graph/data").then((response) => {
          console.log(response.data.data);
          grossProductData.value = response.data.data;
        });
      } catch (err) {
        console.log(err);
      }
    };
    function onPointClick({ target }) {
      target.select();
    }

    onMounted(() => {
      fetchRecentPosts();
      fetchTotalJobs();
      fetchTotalUsers();
      fetchTotalCompany();
      fetchTotalBlogs();
      fetchGraphData();
    });

    return {
      recentPosts,
      totalJobs,
      fetchTotalUsers,
      totalUser,
      totalCompany,
      fetchTotalBlogs,
      totalBlog,
      fetchTotalJobs,
      grossProductData,
      onPointClick,
      fetchGraphData,
    };
  },
};
</script>
<style scoped>
.company_dashboard_view #chartDiv {
  display: flex;
}

.company_dashboard_view #SupplierDiv {
  margin: 50px 0px 0px 0px;
  width: 100%;
}
.company_dashboard_view div.card:hover {
  background: #1976d2;
  color: #fff;
}
.flex-container {
  display: flex;
  align-items: center;
}
.company_dashboard_view div.card:hover .flex-container i.mdi,
.company_dashboard_view div.card:hover h1.numbering,
.company_dashboard_view div.card:hover .cardtop h6.dashboardh6 {
  color: #fff !important;
}

.company_dashboard_view div.card:hover .flex-container i.mdi {
  background-color: #0e0f0f4d;
}
.company_dashboard_view .cardtop h6.dashboardh6 {
  font-size: 15px;
}
.company_dashboard_view div.card h1.numbering,
.company_dashboard_view .cardtop h6.dashboardh6 {
  color: #696969;
}
.company_dashboard_view div#chartDiv div#SupplierDiv .v-card-title {
  padding: 3px 15px;
}
.company_dashboard_view div#cardsDiv div#Card .v-card-item__content {
  display: flex;
}
.company_dashboard_view .v-table--density-default {
  --v-table-header-height: 40px;
  --v-table-row-height: 40px;
}
.company_dashboard_view #SupplierDiv table thead th.text-left {
  font-weight: 600;
}
.company_dashboard_view .cardbottom {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  padding: 10px;
  background-color: rgba(255, 255, 255, 0.8);
  text-align: center;
}

.company_dashboard_view .cardbottom a {
  color: #1976d2;
  text-decoration: none;
  font-weight: bold;
}

.company_dashboard_view .cardbottom a:hover {
  text-decoration: underline;
}
.company_dashboard_view .card {
  height: 170px;
  position: relative;
}
</style>