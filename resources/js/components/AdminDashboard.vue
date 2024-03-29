<!-- <template>
    <v-container style="margin-top: 50px">
     
        <v-row>
          <v-col cols="auto">
            <v-card class="mx-auto card" id="Card">
              <v-card-item>
                <div class="cardtop">
                  <h6 class="dashboardh6">Total Jobs</h6>
                  <h6 class="profit">
                    <v-icon size="15">mdi-arrow-top-right</v-icon
                    ><v-icon size="15">mdi-plus</v-icon>16.24 %
                  </h6>
                </div>
                <h1 class="numbering">{{ totalJobs }}</h1>
               
              </v-card-item>
            </v-card>
          </v-col>
  
        </v-row>
        <div id="SupplierDiv">
        <v-card>
          <v-card-title style="background-color: #1976d2; color: white"
            >Recent Posts</v-card-title
          >
          <v-card-text>
            <v-table>
              <thead>
                <tr>
                  <th></th>
                  <th class="text-left">Title</th>
                  <th class="text-left">location</th>
                </tr>
              </thead>
              <tbody>
                <tr  v-for="post in recentPosts" :key="post.id">
                  <td>
                  </td>
                  <td>{{ post.title }}</td>
                  <td>{{ post.location }}</td>
                </tr>
              </tbody>
            </v-table>
          </v-card-text>
        </v-card>
      </div>
    </v-container>
  </template>
  <script>
  import { ref, onMounted } from "vue";

  import axios from "axios";
  export default {
    name: "companydashboard",
    setup() {
      const totalJobs = ref(null);
      const recentPosts = ref([]);

    const fetchTotalJobs = () => {
        try {
          axios.get("/dashboard/total-jobs").then((response) => {
            console.log(response.data.data);
            totalJobs.value = response.data.totalJobs;
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
        });
      } catch (err) {
        console.log(err);
      }
    };
  
      onMounted(() => {
        fetchRecentPosts();
        fetchTotalJobs();
      });
  
      return {
       totalJobs, recentPosts,
      };
    },
  };
  </script>
  -->
<template>
    <div id="cardsDiv">
        <v-row>
            <v-col cols="auto">
                <v-card class="mx-auto card" id="Card">
                    <v-card-item>
                        <div class="cardtop">
                            <h6 class="dashboardh6">Total Users</h6>
                            <!-- <h6 class="profit">
                                <v-icon size="15">mdi-arrow-top-right</v-icon><v-icon size="15">mdi-plus</v-icon>16.24 %
                            </h6> -->
                        </div>
                        <h1 class="numbering">{{ totalUser }}</h1>
                        <div class="cardbottom">
                            <a href="/admin/users" class="link">View all users</a>
                            <v-icon class="bottomicon" size="20">mdi-account</v-icon>
                        </div>
                    </v-card-item>
                </v-card>
            </v-col>

            <v-col cols="auto">
                <v-card class="mx-auto card" id="Card">
                    <v-card-item>
                        <div class="cardtop">
                            <h6 class="dashboardh6">Total Companies</h6>
                            <!-- <h6 class="profit">
                                <v-icon size="15">mdi-arrow-top-right</v-icon><v-icon size="15">mdi-plus</v-icon>16.24 %
                            </h6> -->
                        </div>
                        <h1 class="numbering">
                            {{ totalCompany }}
                        </h1>
                        <div class="cardbottom">
                            <a href="/admin/companies" class="link">View all companies</a>
                            <v-icon class="bottomicon2" size="20">mdi-office-building</v-icon>
                        </div>
                    </v-card-item>
                </v-card>
            </v-col>

            <v-col cols="auto">
                <v-card class="mx-auto card" id="Card">
                    <v-card-item>
                        <div class="cardtop">
                            <h6 class="dashboardh6">Total Jobs Potings</h6>
                            <!-- <h6 class="loss">
                                <v-icon size="15">mdi-arrow-bottom-right</v-icon><v-icon
                                    size="15">mdi-minus</v-icon>4.60%
                            </h6> -->
                        </div>
                        <h1 class="numbering">676</h1>
                        <div class="cardbottom">
                            <a href="" class="link">View all jobs</a>
                            <v-icon class="bottomicon3" size="20">mdi-list-box-outline</v-icon>
                        </div>
                    </v-card-item>
                </v-card>
            </v-col>

            <v-col cols="auto">
                <v-card class="mx-auto card" id="Card">
                    <v-card-item>
                        <div class="cardtop">
                            <h6 class="dashboardh6">Total Blogs</h6>
                            <!-- <h6 class="loss">
                                <v-icon size="15">mdi-arrow-bottom-right</v-icon><v-icon
                                    size="15">mdi-minus</v-icon>4.60%
                            </h6> -->
                        </div>
                        <h1 class="numbering">{{ totalBlog }}</h1>
                        <div class="cardbottom">
                            <a href="/admin/blog/view" class="link">View all Blogs</a>
                            <v-icon class="bottomicon3" size="20">mdi-list-box-outline</v-icon>
                        </div>
                    </v-card-item>
                </v-card>
            </v-col>
        </v-row>
    </div>

    <div id="chartDiv">
        <div class="graph">
            <DxChart id="chart" :data-source="DataSource" title="Total Orders & Total Earning"
                @pointClick="onPointClick">
                <DxCommonSeriesSettings argument-field="Month" type="bar" hover-mode="allArgumentPoints"
                    selection-mode="allArgumentPoints">
                    <DxLabel :visible="true">
                        <DxFormat :precision="0" type="fixedPoint" />
                    </DxLabel>
                </DxCommonSeriesSettings>
                <DxSeries value-field="year2024" name="Total Order" />
                <DxSeries value-field="year2023" name="Total Earning" />
                <DxLegend vertical-alignment="bottom" horizontal-alignment="center" />
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
                                <th></th>
                                <th class="text-left">Name</th>
                                <th class="text-left">Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in suppliers" :key="item.name">
                                <td>
                                    <img v-if="item.image == null" :src="`/storage/pics/avtaar.webp`" style="
                          height: 30px;
                          width: 30px;
                          border-radius: 50px;
                        " />
                                    <img v-else :src="`/storage/pics/${item.image}`" style="
                           height: 30px;
                          width: 30px;
                          border-radius: 50px;
                        " />
                                </td>
                                <td>{{ item.name }}</td>
                                <td>{{ item.email }}</td>
                            </tr>
                        </tbody>
                    </v-table>
                </v-card-text>
            </v-card>
        </div>
    </div>
</template>
<script>
import { ref, onMounted } from "vue";
import axios from "axios";

export default {
    name: "AdminDashboard",
    setup() {
        const totalUser = ref('0');
        const totalCompany = ref('0');
        const totalBlog = ref('0');
        const recentPosts = ref([]);
        const grossProductData = ref([
            {
                Month: "January",
                year2023: 823,
                year2024: 863,
            },
            {
                Month: "February",
                year2023: 332,
                year2024: 332,
            },
            {
                Month: "March",
                year2023: 459,
                year2024: 470,
            },
            {
                Month: "April",
                year2023: 642,
                year2024: 675,
            },
            {
                Month: "May",
                year2023: 294,
                year2024: 301,
            },
            {
                Month: "June",
                year2023: 294,
                year2024: 301,
            },
        ]);
        const fetchTotalUsers = () => {
            try {
                axios.get('/admin/user/index').then((response) => {
                    console.log(response.data.totalCount);
                    totalUser.value = response.data.totalCount;
                })
            } catch (err) {

            }
        }
        const fetchTotalCompany = () => {
            try {
                axios.get('/admin/company/getCompanies').then((response) => {
                    console.log(response.data.totalCount);
                    totalCompany.value = response.data.totalCount;
                })
            } catch (err) {

            }
        }
        const fetchTotalBlogs = () => {
            try {
                axios.get('/admin/blog/fetch').then((response) => {
                    console.log(response.data.totalCount);
                    totalBlog.value = response.data.totalCount;
                })
            } catch (err) {

            }
        }
        const fetchRecentPosts = () => {
            try {
                axios.get("/company/recent-posts").then((response) => {
                    console.log(response.data.data);
                    recentPosts.value = response.data.data;
                });
            } catch (err) {
                console.log(err);
            }
        };
        const totalJobs = ref(null);
        const fetchTotalJobs = () => {
            try {
                axios.get("/dashboard/total-jobs").then((response) => {
                    totalJobs.value = response.data.totalJobs;
                    console.log(totalJobs.value);
                });
            } catch (err) {
                console.log(err);
            }
        };

        onMounted(() => {
            fetchRecentPosts();
            fetchTotalJobs();
            fetchTotalUsers();
            fetchTotalCompany();
            fetchTotalBlogs();
        });

        return {
            recentPosts, totalJobs, fetchTotalUsers, totalUser, totalCompany, fetchTotalBlogs, totalBlog
        };
    },
};
</script>
<style scoped>
.graph {
    margin-top: 50px;
    width: 60%;
    height: 500px;
}

.bottomicon4 {
    color: rgb(224, 101, 0);
    background-color: rgb(248, 224, 202);
    padding: 22px;
    border-radius: 5px;
}

#chartDiv {
    display: flex;
}

#SupplierDiv {
    margin: 50px 0px 0px 30px;
    width: 41%;

}

#Card {
    max-width: 240px;
}

@media only screen and (max-width: 1200px) {
    #chartDiv {
        display: grid;
        margin-left: 0px;
    }

    .graph {
        width: 100%;
        height: 500px;
    }

    #SupplierDiv {
        margin: 0px 0px 20px 0px;
        width: 100%;
    }
}
</style>