
  <template>
    <v-container  class="company_dashboard_view">
      <div id="cardsDiv">
        <v-row>
            <v-col sm="12" md="6" lg="3" xl="3" cols="12">
            <v-card class="mx-auto card one_dt" id="Card">
              <v-card-item>
                <div class=" flex-container">
                  <v-icon class="bottomicon3" size="48">mdi-purse</v-icon>
                </div>
                <div class="cardtop">
                 
                  <h6 class="dashboardh6"> Published Jobs</h6>
                <h1 class="numbering">{{ totalJobs }}</h1>
            </div>
              </v-card-item>
            </v-card>
          </v-col>
  
          <v-col sm="12" md="6" lg="3" xl="3" cols="12">
            <v-card class="mx-auto card two_dt" id="Card">
              <v-card-item>
                <div class="flex-container">
                
                  <v-icon class="bottomicon3" size="48">mdi-account-group</v-icon>
                </div>
                <div class=" cardtop">
                  <h6 class="dashboardh6">Total Users</h6>
                <h1 class="numbering"> {{ totalUser }}</h1>
            </div>
              </v-card-item>
            </v-card>
          </v-col>
  
          <v-col sm="12" md="6" lg="3" xl="3" cols="12">
            <v-card class="mx-auto card three_dt" id="Card">
              <v-card-item>
                <div class="flex-container">
                  <v-icon class="bottomicon3" size="48">mdi-post</v-icon>
                </div>
               <div class=" cardtop">
                <h6 class="dashboardh6">Total Posted Jobs</h6>
                <h1 class="numbering"> {{ totalposted }}</h1>
            </div>
           
              </v-card-item>
            </v-card>
          </v-col>
  
          <v-col  sm="12" md="6" lg="3" xl="3" cols="12">
            <v-card class="mx-auto card four_dt" id="Card">
              <v-card-item>
                <div class="flex-container">
                  <v-icon class="bottomicon3" size="48">mdi-swap-vertical</v-icon>
                </div>
                <div class=" cardtop">
                  <h6 class="dashboardh6">Expired Jobs</h6>
                <h1 class="numbering">{{  expiredjob }}</h1>
            </div>
              </v-card-item>
            </v-card>
          </v-col>
        </v-row>
      </div>
  
      <div id="chartDiv">
        <v-row>
          <v-col  sm="12" md="6" lg="6" xl="6" cols="12">
        <div id="SupplierDiv">
        <v-card>
          <v-card-title style="background-color: #1976d2; color: white"
            >Recent Job Post</v-card-title
          >
          <v-card-text>
            <v-table>
              <thead>
                <tr>

                  <th class="text-left">Position</th>
                  <th class="text-left">Location</th>
                  <th class="text-left">Qualification</th>
                  <th class="text-left">Experience</th>
                </tr>
              </thead>
              <tbody>
                <tr  v-for="post in recentPosts" :key="post.id">

                  <td>{{ post.title }}</td>
                  <td>{{ post.location }}</td>
                  <td>{{ post.qualifications }}</td>
                  <td>{{ post.experience }}</td>
                </tr>
              </tbody>
            </v-table>
          </v-card-text>
        </v-card>
      </div>
    </v-col>
    <v-col  sm="12" md="6" lg="6" xl="6" cols="12">
            <div id="SupplierDiv" v-if="expiredPosts.length > 0">
        <v-card>
          <v-card-title style="background-color: #1976d2; color: white"
            >Post Expired Soon</v-card-title
          >
          <v-card-text>
            <v-table>
              <thead>
                <tr>

                  <th class="text-left">Position</th>
                  <th class="text-left">Location</th>
                  <th class="text-left">Qualification</th>
                  <th class="text-left">Experience</th>
                </tr>
              </thead>
              <tbody>
                <tr  v-for="post in expiredPosts" :key="post.id">

                  <td>{{ post.title }}</td>
                  <td>{{ post.location }}</td>
                  <td>{{ post.qualifications }}</td>
                  <td>{{ post.experience }}</td>
                </tr>
              </tbody>
            </v-table>
          </v-card-text>
        </v-card>
      </div>
          </v-col>
        </v-row>
      </div>
    </v-container>
  </template>
  <script>
  import { ref, onMounted } from "vue";
  import axios from "axios";
  
  export default {
    name: "Dashboard",
    setup() {
      const recentPosts = ref([]);
      const totalposted = ref(null);
      const totalJobs = ref(null);
      const totalUser = ref('0');
      const Users = ref([]);
      const expiredjob = ref(null);
      const expiredPosts = ref([]);
      const showMore = ref(false);
  
      const fetchRecentPosts = async () => {
        try {
          const response = await axios.get("/company/recent-posts");
          recentPosts.value = response.data.data;
          totalposted.value = response.data.total_posts;
        } catch (err) {
          console.log(err);
        }
      };
  
      const fetchTotalJobs = async () => {
        try {
          const response = await axios.get("/dashboard/total-jobs");
          totalJobs.value = response.data.totalJobs;
        } catch (err) {
          console.log(err);
        }
      };
  
      const fetchTotalUser = async () => {
        try {
          const response = await axios.get("/fetch-user");
          totalUser.value = response.data.totalCount;
          Users.value = response.data.data;
        } catch (err) {
          console.log(err);
        }
      };
  
      const fetchExpiredJobs = async () => {
        try {
          const response = await axios.get("/dashboard/total-expiredjobs");
          expiredjob.value = response.data.totalJobs;
        } catch (err) {
          console.log(err);
        }
      };
  
      const fetchRecentlyExpired = async () => {
        try {
          const response = await axios.get("/posts/about-to-expire");
          expiredPosts.value = response.data.data;
        } catch (err) {
          console.log(err);
        }
      };
  
      const toggleShowMore = () => {
        showMore.value = !showMore.value;
      };
  
      onMounted(() => {
        fetchRecentPosts();
        fetchTotalJobs();
        fetchTotalUser();
        fetchExpiredJobs();
        fetchRecentlyExpired();
      });
  
      return {
        recentPosts,
        totalJobs,
        totalUser,
        totalposted,
        expiredjob,
        expiredPosts,
        Users,
        showMore,
        toggleShowMore,
        fetchTotalUser
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
.company_dashboard_view div.card:hover .flex-container i.mdi, .company_dashboard_view div.card:hover h1.numbering, .company_dashboard_view div.card:hover .cardtop h6.dashboardh6 {
    color: #fff !important;
}
.company_dashboard_view div.card .flex-container i.mdi {
    color: #1976d2;
    margin-right: 10px;
    background-color: #1976d24d;
    border-radius: 25px;
    font-size: 27px !important;
}
.company_dashboard_view div.card:hover .flex-container i.mdi{background-color: #0e0f0f4d;}
.company_dashboard_view .cardtop h6.dashboardh6{
      font-size: 15px;
}
.company_dashboard_view div.card h1.numbering, .company_dashboard_view .cardtop h6.dashboardh6 {
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
  </style>