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
                        <h1 class="numbering">{{ totalJobs }}</h1>
                        <div class="cardbottom">
                            <a href="/admin/jobs" class="link">View all jobs</a>
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
            <DxChart id="chart" :data-source="grossProductData" title="Job Postings" @pointClick="onPointClick">
                <DxCommonSeriesSettings argument-field="Month" type="bar" hover-mode="allArgumentPoints"
                    selection-mode="allArgumentPoints">
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
        ]);
        const fetchTotalUsers = () => {
            try {
                axios.get('/admin/user/index').then((response) => {
                    // console.log(response.data.totalCount);
                    totalUser.value = response.data.totalCount;
                })
            } catch (err) {
                console.log(err);
            }
        }
        const fetchTotalCompany = () => {
            try {
                axios.get('/admin/company/getCompanies').then((response) => {
                    // console.log(response.data.totalCount);
                    totalCompany.value = response.data.totalCount;
                })
            } catch (err) {
                console.log(err);
            }
        }
        const fetchTotalBlogs = () => {
            try {
                axios.get('/admin/blog/fetch').then((response) => {
                    totalBlog.value = response.data.totalCount;
                })
            } catch (err) {
                console.log(err);
            }
        }
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
        const totalJobs = ref('0');
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
        }
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
            recentPosts, totalJobs, fetchTotalUsers, totalUser, totalCompany, fetchTotalBlogs, totalBlog, fetchTotalJobs, grossProductData, onPointClick, fetchGraphData
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