<!-- <template>
  <v-container>
    <v-row style="margin-top: 10px; margin-left: 10%;">
      <v-col cols="12" md="4">
        <v-text-field v-model="jobTitle" label="Job Title" density="compact" variant="outlined" clearable
          style="width: 100%"></v-text-field>
      </v-col>
      <v-col cols="12" md="4">
        <v-text-field v-model="location" label="Location" density="compact" variant="outlined" clearable
          style="width: 100%"></v-text-field>
      </v-col>
      <v-col cols="10" md="3">
        <v-btn @click="searchJobs" style="color: white;" color="primary">Search</v-btn>
      </v-col>
    </v-row>
    <div class="card-container">
      <v-card v-for="job in jobs" class="custom-card" @click="openDetailPanel(job)">
        <v-card-title style="
            font-size: 30px;
            font-weight: bolder;
            margin-left: 30px;
            color: rgb(44, 44, 151);
            font-family: sans-serif;
          ">{{ job.title }}</v-card-title>
        <v-card-text>
          <div style="display: flex; align-items: center;">
            <v-icon color="black">mdi-domain</v-icon>
            <span style="font-size: 18px;">{{ job.company.company_name }}</span>
          </div><br>
          <div style="align-items: center;">
            <v-icon color="black">mdi-note</v-icon>
            <span style="font-size: 15px;"> {{ truncateDescription(job.description) }}</span>
            <span v-if="isDescriptionLong(job.description)" class="read-more" @click="openDetailPanel(job)">
              Read More
            </span>
          </div><br>
          <div style=" align-items: center;">

            <span style="font-size: 18px;">Posted At:{{ formatCreatedAt(job.company.created_at) }}</span>
          </div><br>

        </v-card-text>
        <hr>
        <v-card-actions style="margin-left: 20px;">
          <div style="display: flex; align-items: center;">
            <v-icon color="black">mdi-human</v-icon>
            <span style="font-size: 18px;">{{ job.vacancy }} <v-icon color="black"
                style="margin-left: 530px; font-size: 20px;">mdi-desktop-classic</v-icon>{{ job.experience }}<v-icon
                color="black" style="margin-left: 280px; font-size: 20px;">mdi-map-marker</v-icon>{{ job.location
              }}</span>
          </div><br>
        </v-card-actions>
      </v-card>
      <v-navigation-drawer v-model="detailPanelVisible" location="right" style="width: 70%;">
        <v-card style="width: 100%;">
          <v-icon style="margin-left: 20px; margin-top: 30px; "
            @click="detailPanelVisible = false">mdi-arrow-left-top</v-icon>
          <v-card-title
            style="font-size: 40px; font-weight: bolder; text-align: center; margin-top: 30px; color: rgb(139, 238, 144);">{{
          detail.title }}</v-card-title>
          <v-card-text>
            <div style="font-size: 18px">
              <v-icon color="black" style="display: inline-block; vertical-align: middle;">mdi-domain</v-icon>
              <span style="color: rgb(59, 145, 243); font-size: 25px; margin-left: 50px;">{{ detail.company_name
                }}</span>
            </div>
            <br />
            <div style="font-size: 18px">
              <v-icon color="black" style="display: inline-block; vertical-align: middle;">mdi-map-marker</v-icon>
              <span style="font-size: 20px; margin-left: 140px;">{{ detail.location }}</span>
            </div>
            <br />
            <div style="font-size: 18px">
              <v-icon color="black" style="display: inline-block; vertical-align: middle;">mdi-desktop-classic</v-icon>
              <span style="font-size: 20px; margin-left: 110px;">{{ detail.experience }}</span>
            </div>
            <br />
            <div style="font-size: 18px">
              <v-icon color="black" style="display: inline-block; vertical-align: middle;">mdi-human</v-icon>
              <span style="font-size: 20px; margin-left: 140px;">{{ detail.vacancy }}</span>
            </div>
            <br />
            <div style="font-size: 18px">
              <v-icon color="black">mdi-note</v-icon>
              <span style="font-size: 15px; margin-left: 90px; display: block;">{{ detail.description }}</span>
            </div><br />
            <div style=" align-items: center;">
              <span style="font-size: 18px;">Posted At:{{ formatCreatedAt(detail.created_at) }}</span>
            </div><br>
          </v-card-text>
          <v-card-actions>
            <v-btn class="bg-primary" v-if="usersStore.isloggedin" @click="apply(detail.id)">Apply</v-btn>
            <v-btn color="white" class="bg-success" @click="save(detail.id)">Save</v-btn>
          </v-card-actions>
        </v-card>
      </v-navigation-drawer>
    </div>
  </v-container>
</template>
<script>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useUsersStore } from "../store/user";
export default {
  name: "CompanyPost",
  setup() {
    const usersStore = useUsersStore();
    const jobs = ref({});
    const detail = ref({
      title: "",
      company_name: "",
      location: "",
      experience: "",
      description: "",
      vacancy: "",
      id: ""
    });

    const jobTitle = ref("");
    const location = ref("");

    const detailPanelVisible = ref(false);
    const searchJobs = async () => {
      try {
        const response = await axios.get("/search-jobs", {
          params: {
            jobTitle: jobTitle.value,
            location: location.value,
          },
        });

        jobs.value = response.data.data;
      } catch (err) {
        console.error(err);
      }
    };
    //getting Jobs posted by company
    const fetchJobs = async () => {
      try {
        const response = await axios.get("/company/post");
        console.log(response.data);
        jobs.value = response.data.data;
      } catch (err) {
        console.error(err);
      }
    };
    const openDetailPanel = (job) => {
      detailPanelVisible.value = true;
      detail.value.company_name = job.company.company_name;
      detail.value.location = job.location;
      detail.value.experience = job.experience;
      detail.value.description = job.description;
      detail.value.vacancy = job.vacancy;
      detail.value.title = job.title;
      detail.value.created_at = job.company.created_at;
      detail.value.id = job.id;
    };
    const closeDetailDialog = () => {
      detailPanelVisible.value = false;
    };
    //For job apply
    const apply = async (id) => {
      try {
        await axios.post(`/apply-job/${id}`).then((response) => {
          if (response.data.status == true) {
            detailPanelVisible.value = false;
            window.Swal.fire({
              icon: "success",
              title: "Applied Successfully",
              text: "Applied successfully ",
              confirmButtonText: "OK",
            });
            window.location.href = response.data.company_url;
          }
        });
      } catch (err) {
        console.error(err);
        detailPanelVisible.value = false;
        window.Swal.fire({
          title: "Application Failed",
          text: "You Already apply on this Job",
          icon: "error",
          confirmButtonText: "OK",
        });
      }
    };
    const save = async (id) => {
      try {
        await axios.post(`/save-job/${id}`).then((response) => {
          if (response.data.status == true) {
            detailPanelVisible.value = false;
            window.Swal.fire({
              icon: "success",
              title: "saved Successfully",
              text: "saved successfully ",
              confirmButtonText: "OK",
            });
          }
        });
      } catch (err) {
        console.error(err);
        detailPanelVisible.value = false;
        window.Swal.fire({
          title: "Application Failed",
          text: "You Already saved this Job",
          icon: "error",
          confirmButtonText: "OK",
        });
      }
    };

    const truncateDescription = (description) => {
      if (description.length > 90) {
        return description.substring(0, 90) + "...";
      }
      return description;
    };

    const isDescriptionLong = (description) => {
      return description.length > 90;
    };
    const formatCreatedAt = (createdAt) => {
      const options = { day: 'numeric', month: 'long', year: 'numeric' };
      return new Date(createdAt).toLocaleDateString(undefined, options);
    };

    onMounted(() => {
      // companypost();
      fetchJobs();
    });
    return {
      jobs,
      jobTitle,
      location,
      searchJobs,
      // companypost,
      usersStore,
      closeDetailDialog,
      apply,
      save,
      openDetailPanel,
      detailPanelVisible,
      detail,
      truncateDescription,
      isDescriptionLong,
      formatCreatedAt
    };
  },
};
</script>

<style scoped>
.card-container {
  display: flex;
  flex-wrap: wrap;
  gap: 60px;
  margin-top: 20px;
}

.custom-card {
  display: flex;
  flex-direction: column;
  height: 290px;
  width: 1100px;
  border: 1px solid rgb(21, 21, 22);
  background-color: white;
  cursor: pointer;
  transition: background-color 0.3s, color 0.3s;
}

.v-icon:hover {
  transform: scale(1.2);
}

.read-more {
  color: blue;
  cursor: pointer;
  margin-left: 10px;
}
</style> -->
<template>
  <div class="find_Job_list">
    <v-row>
      <v-col cols="auto" sm="12" md="12" lg="12" xl="12">
        <v-card class="mx-auto my-12 top_page_section">
          <div class="job_info" align="center" justify="center">
            <v-card-title>Companies </v-card-title>
            <v-breadcrumbs :items="items">
              <template v-slot:title="{ item }">
                {{ item.title.toUpperCase() }}
              </template>
            </v-breadcrumbs>
          </div>
        </v-card>
      </v-col>
    </v-row>
    <div class="body_page_section">
      <v-container class="w-75">
        <v-row>
          <v-col cols="auto" sm="12" md="12" lg="3" xl="3">
            <v-card class="mx-auto find_Job_list_left">
              <v-card-title>Search by Keywords </v-card-title>
              <v-text-field v-model="jobTitle" label="Job Title" density="compact" variant="outlined" clearable
                style="width: 100%"></v-text-field>
              <v-text-field v-model="location" label="Location" density="compact" variant="outlined" clearable
                style="width: 100%"></v-text-field>
              <v-btn @click="searchJobs">Search</v-btn>
            </v-card>
          </v-col>
          <v-col cols="auto" sm="12" md="12" lg="9" xl="9" class="find_Job_list_right">
            <v-card v-for="job in jobs" :key="job.id" class="custom-card" @click="openDetailPanel(job)">
              <v-card-title>{{ job.company.company_name }}</v-card-title>
              <v-card-text class="pa-0 ml-3">
                <div style="display: flex; align-items: center">
                  <v-icon color="black">mdi-domain</v-icon>
                  <span>{{ job.title }}</span>
                </div>
                <div style="align-items: center">
                  <v-icon color="black">mdi-note</v-icon>
                  <span> {{ truncateDescription(job.description) }}</span>
                  <span v-if="isDescriptionLong(job.description)" class="read-more" @click="openDetailPanel(job)">
                    Read More
                  </span>
                </div>
              </v-card-text>

              <v-card-actions>
                <div style="display: flex; align-items: center">
                  <v-icon color="black">mdi-human</v-icon>
                  <span>{{ job.vacancy }}
                    <v-icon color="black">mdi-desktop-classic</v-icon>{{ job.experience
                    }}<v-icon color="black">mdi-map-marker</v-icon>{{ job.location }}</span>
                </div>
              </v-card-actions>
            </v-card>
            <v-navigation-drawer v-model="detailPanelVisible" location="right" class="single_job_search_page">
              <v-icon style="margin-left: 20px; margin-top: 30px;"
                @click="detailPanelVisible = false">mdi-arrow-left-top</v-icon>
              <v-card style="width: 100%">
                <div class="compamy_infor">
                  <div class="compamy_infor_left">
                    <v-card-title><v-icon>mdi-format-title</v-icon>
                      <span>{{ detail.title }}</span></v-card-title>
                    <v-icon color="black">mdi-domain</v-icon>
                    <span>{{ detail.company_name }}</span>
                    <v-icon color="black">mdi-map-marker</v-icon>
                    <span>{{ detail.location }}</span>
                    <v-icon color="black">mdi-desktop-classic</v-icon>
                    <span>{{ detail.experience }}</span>
                    <v-icon color="black">mdi-human</v-icon>
                    <span>{{ detail.vacancy }}</span>
                  </div>
                  <div class="compamy_infor_btn">
                    <v-btn class="apply_for_job" v-if="usersStore.isloggedin" @click="apply(detail.id)">Apply For
                      Job</v-btn>
                    <v-btn class="save_btn" color="white" @click="save(detail.id)">
                      <v-icon color="black">mdi-bookmark-outline</v-icon></v-btn>
                  </div>
                </div>
                <v-row class="compamy_infor_description">
                  <v-col cols="auto" sm="12" md="12" lg="8" xl="8">
                    <span style="display: block">{{ detail.description }}</span>
                  </v-col>
                  <v-col cols="auto" sm="12" md="12" lg="4" xl="4">
                    <div>
                      <v-list-item>
                        <template v-slot:prepend>
                          <v-card-text class="p-0">
                            Primary industry:
                          </v-card-text>
                        </template>
                        <template v-slot:append>
                          <v-card-text class="pb-0">Software </v-card-text>
                        </template>
                      </v-list-item>
                      <v-list-item>
                        <template v-slot:prepend>
                          <v-card-text class="p-0"> Company size: </v-card-text>
                        </template>
                        <template v-slot:append>
                          <v-card-text class="pb-0"> 501-1,000 </v-card-text>
                        </template>
                      </v-list-item>
                      <v-list-item>
                        <template v-slot:prepend>
                          <v-card-text class="p-0"> Founded in: </v-card-text>
                        </template>
                        <template v-slot:append>
                          <v-card-text class="pb-0"> 2011</v-card-text>
                        </template>
                      </v-list-item>
                      <v-list-item>
                        <template v-slot:prepend>
                          <v-card-text class="p-0"> Phone:</v-card-text>
                        </template>
                        <template v-slot:append>
                          <v-card-text class="pb-0"> 123 456 7890</v-card-text>
                        </template>
                      </v-list-item>
                    </div>
                  </v-col>
                </v-row>
              </v-card>
            </v-navigation-drawer>
          </v-col>
        </v-row>
      </v-container>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useUsersStore } from "../store/user";
export default {
  name: "CompanyPost",
  setup() {
    const usersStore = useUsersStore();
    const jobs = ref({});
    const detail = ref({
      title: "",
      company_name: "",
      location: "",
      experience: "",
      description: "",
      vacancy: "",
      id: "",
    });
    const jobTitle = ref("");
    const location = ref("");
    const detailPanelVisible = ref(false);
    const searchJobs = async () => {
      try {
        const response = await axios.get("/search-jobs", {
          params: {
            jobTitle: jobTitle.value,
            location: location.value,
          },
        });

        jobs.value = response.data.data;
      } catch (err) {
        console.error(err);
      }
    };
    //getting Jobs posted by company
    const fetchJobs = async () => {
      try {
        const response = await axios.get("/company/post");
        console.log(response.data);
        jobs.value = response.data.data;
      } catch (err) {
        console.error(err);
      }
    };
    const openDetailPanel = (job) => {
      detailPanelVisible.value = true;
      detail.value.company_name = job.company.company_name;
      detail.value.location = job.location;
      detail.value.experience = job.experience;
      detail.value.description = job.description;
      detail.value.vacancy = job.vacancy;
      detail.value.title = job.title;
      detail.value.created_at = job.company.created_at;
      detail.value.id = job.id;
    };
    const closeDetailDialog = () => {
      detailPanelVisible.value = false;
    };
    //For job apply
    const apply = async (id) => {
      try {
        await axios.post(`/apply-job/${id}`).then((response) => {
          if (response.data.status == true) {
            detailPanelVisible.value = false;
            window.Swal.fire({
              icon: "success",
              title: "Applied Successfully",
              text: "Applied successfully ",
              confirmButtonText: "OK",
            });
            window.location.href = response.data.company_url;
          }
        });
      } catch (err) {
        console.error(err);
        detailPanelVisible.value = false;
        window.Swal.fire({
          title: "Application Failed",
          text: "You Already apply on this Job",
          icon: "error",
          confirmButtonText: "OK",
        });
      }
    };
    const save = async (id) => {
      try {
        await axios.post(`/save-job/${id}`).then((response) => {
          if (response.data.status == true) {
            detailPanelVisible.value = false;
            window.Swal.fire({
              icon: "success",
              title: "saved Successfully",
              text: "saved successfully ",
              confirmButtonText: "OK",
            });
          }
        });
      } catch (err) {
        console.error(err);
        detailPanelVisible.value = false;
        window.Swal.fire({
          title: "Application Failed",
          text: "You Already saved this Job",
          icon: "error",
          confirmButtonText: "OK",
        });
      }
    };

    const truncateDescription = (description) => {
      if (description.length > 90) {
        return description.substring(0, 90) + "...";
      }
      return description;
    };

    const isDescriptionLong = (description) => {
      return description.length > 90;
    };
    const formatCreatedAt = (createdAt) => {
      const options = { day: "numeric", month: "long", year: "numeric" };
      return new Date(createdAt).toLocaleDateString(undefined, options);
    };

    onMounted(() => {
      // companypost();
      fetchJobs();
    });
    return {
      jobs,
      jobTitle,
      location,
      searchJobs,
      // companypost,
      usersStore,
      closeDetailDialog,
      apply,
      save,
      openDetailPanel,
      detailPanelVisible,
      detail,
      truncateDescription,
      isDescriptionLong,
    };
  },
  data: () => ({
    items: [
      {
        title: "Home",
        disabled: false,
        href: "/",
      },
      {
        title: "Find Jobs",
        disabled: true,
      },
    ],
  }),
};
</script>

<style>
.find_Job_list_left {
  position: relative;
  background: #f5f7fc;
  border-radius: 8px;
  margin-bottom: 30px;
  padding: 7% 7% 10px;
}

.find_Job_list .top_page_section {
  background: transparent;
  box-shadow: unset;
  display: flex;
  justify-content: center;
}

.find_Job_list .top_page_section .v-card-title {
  font-weight: 500;
  font-size: 30px;
  text-align: center;
  color: #202124;
}

.find_Job_list .body_page_section {
  background: #fff;
  padding: 50px 0 100px;
}

.find_Job_list_right .custom-card {
  padding: 2% 1%;
  background: #fff;
  border: 1px solid #ecedf2;
  box-sizing: border-box;
  border-radius: 10px;
  transition: all 0.3s ease;
  margin-bottom: 15px;
}

.find_Job_list_right .v-card-title {
  font-size: 30px;
  font-weight: bolder;
  color: #202124;
  font-family: sans-serif;
  text-transform: capitalize;
}

.find_Job_list_right .custom-card:hover .v-card-title {
  color: #1967d2;
}

.single_job_search_page {
  width: 70% !important;
}

.compamy_infor .compamy_infor_left i.mdi {
  margin-right: 5px;
}

.compamy_infor {
  display: flex;
  justify-content: space-between;
  margin-bottom: 25px;
  background-color: #ecedf2;
  padding: 1% 15px;
  align-items: center;
}

button.apply_for_job {
  text-align: center;
  color: #fff;
  background-color: #1967d2;
  font-size: 15px;
  border-radius: 8px;
  font-weight: 400;
  padding: 18px 35px;
  height: 50px !important;
}

button.save_btn {
  height: 50px !important;
  line-height: 50px;
  text-align: center;
  font-size: 16px;
  cursor: pointer;
  color: #1967d2;
  border-radius: 7px;
  background: #1967d212;
  transition: all 0.3s ease;
  margin-left: 20px;
}

.compamy_infor_description {
  width: 90%;
  margin: 2% auto;
}
</style>
