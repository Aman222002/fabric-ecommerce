<template>
  <div class="find_Job_list">
    <v-card class="mx-auto my-12 top_page_section">
      <div class="job_info" align="center" justify="center">
        <v-card-title>Jobs </v-card-title>
        <v-breadcrumbs :items="items">
          <template v-slot:title="{ item }">
            {{ item.title.toUpperCase() }}
          </template>
        </v-breadcrumbs>
      </div>
    </v-card>
    <div class="body_page_section">
      <v-container class="w-75">
        <v-row>
          <v-col cols="12" sm="12" md="12" lg="3" xl="3">
            <v-card class="mx-auto find_Job_list_left">
              <v-card-title class="font-weight-bold px-0"
                >Search by Keywords
              </v-card-title>
              <v-text-field
                v-model="jobTitle"
                label="Job Title"
                density="compact"
                variant="solo"
               
                clearable
                style="width: 100%"
              ></v-text-field>
              <v-text-field
                v-model="location"
                label="Location"
                density="compact"
                variant="solo"
              
                clearable
                style="width: 100%"
              ></v-text-field>
              <v-btn @click="searchJobs" class="b_string_btn">Search</v-btn>
            </v-card>
          </v-col>
          <v-col
            cols="auto"
            sm="12"
            md="12"
            lg="9"
            xl="9"
            class="find_Job_list_right"
          >
            <v-alert v-if="showAlert" type="error"> No job Found. </v-alert>
            <v-card
              v-else
              v-for="job in jobs"
              :key="job.id"
              class="custom-card"
              @click="openDetailPanel(job)"
            >
              <v-row>
                <v-col
                  class="cpmany_logo pr-0"
                  cols="12"
                  sm="12"
                  md="12"
                  lg="1"
                  xl="1"
                >
               
                  <v-img :src="`/storage/assest/${job.company.logo}`"></v-img>
                </v-col>
                <v-col class="pl-0" cols="12" sm="12" md="12" lg="11" xl="11">
                  <v-card-title>{{ job.company.company_name }}</v-card-title>
                  <v-card-text class="pa-0 ml-3">
                    <div style="display: flex; align-items: center">
                      <v-icon color="#f16666" class="mr-2"
                        >mdi-newspaper-variant</v-icon
                      >
                      <span>{{ job.title }}</span>
                    </div>

                    <div style="align-items: center">
                      <v-icon color="#34a853" class="mr-2">mdi-note</v-icon>
                      <span> {{ truncateDescription(job.description) }}</span>
                      <span
                        v-if="isDescriptionLong(job.description)"
                        class="read-more"
                        @click="openDetailPanel(job)"
                      >
                        Read More <v-icon>mdi-chevron-right</v-icon>
                      </span>
                    </div>
                  </v-card-text>
                  <v-card-actions>
                    <div style="display: flex; align-items: center">
                      <v-icon color="#f9ab00" class="mr-2">mdi-account</v-icon>
                      <span
                        >{{ job.vacancy }}
                        <v-icon color="#f16666" class="mr-2"
                          >mdi-clipboard-text-clock-outline</v-icon
                        >{{ job.experience
                        }}<v-icon color="#34a853" class="mr-2"
                          >mdi-map-marker</v-icon
                        >{{ job.location }}</span
                      >
                    </div>
                  </v-card-actions>
                </v-col>
              </v-row>
            </v-card>
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
  props: {
    data: {
      type: Object,
      default: () => ({}),
    },
  },
  setup(props) {
    const usersStore = useUsersStore();
    const items = [
      {
        title: "Home",
        disabled: false,
        href: "/",
      },
      {
        title: "Find Jobs",
        disabled: true,
      },
    ];
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
    const category = ref("");
    const detailPanelVisible = ref(false);
    const showAlert = ref(false);
    const searchJobs = async () => {
      try {
        showAlert.value = false;
        const response = await axios.get("/search-jobs", {
          params: {
            jobTitle: jobTitle.value,
            location: location.value,
            category: category.value,
          },
        });
        jobs.value = response.data.data;
        console.log(jobs.value);
      } catch (err) {
        console.error(err);
        if (err.response.status == 404) {
          showAlert.value = true;
        }
      }
    };

   
    // const fetchJobs = async () => {
    //   try {
    //     const response = await axios.get("/company/post");
     
    //     jobs.value = response.data.data;
    //   } catch (err) {
    //     console.error(err);
    //   }
    // };

    const fetchJobs = async () => {
      try {
        const response = await axios.get("/company/post");
        if (response.data.data.length === 0) {
          showAlert.value = true;
        } else {
          showAlert.value = false; 
          jobs.value = response.data.data;
        }
      } catch (err) {
        console.error(err);
        showAlert.value = true; // Set showAlert to true on error
      }
    };
    const fetchpost = async () => {
      try {
        const response = await axios.get("/company/job");
        console.log(response.data);
        jobs.value = response.data.data;
      } catch (err) {
        console.error(err);
      }
    };

    const openDetailPanel = (job) => {
      console.log(job);
      window.location.href = `/view/${job.id}`;
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
      if (!usersStore.isloggedin) {
        window.Swal.fire({
          title: "Login Required",
          text: "Please log in to apply for this job.",
          icon: "warning",
          confirmButtonText: "OK",
        });
        return;
      }
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
      if (description && description.length > 90) {
        return description.substring(0, 90) + "...";
      }
      return description;
    };

    const isDescriptionLong = (description) => {
      return description && description.length > 90;
    };
    const formatCreatedAt = (createdAt) => {
      const options = { day: "numeric", month: "long", year: "numeric" };
      return new Date(createdAt).toLocaleDateString(undefined, options);
    };

    onMounted(() => {
      // companypost();
      if (!usersStore.isloggedin) {
        fetchJobs();
      } else {
        fetchpost();
      }

      // const value =props.data ;
      // console.log(value);
      if (props.data.title || props.data.location) {
        console.log(props.data.title || props.data.location);
        jobTitle.value = props.data.title;
        location.value = props.data.location;
        searchJobs();
      } else if (props.data.category) {
        console.log(props.data.category);
        category.value = props.data.category;
        searchJobs();
      }
      //  else{
      //   fetchJobs();
      //  }
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
      category,
      items,
      showAlert,
      subjectRules,
      fullNameRules,
    };
  },
};
</script>

<style>
.cpmany_logo .v-img {
  width: 45px;
  margin: 0 auto;
}
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
.find_Job_list_left button.search_btn {
  display: table;
  margin: 0 auto;
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
.no-jobs-message {
  margin-bottom: 20px;
  font-size: 20px;
  text-align: center;
  color: #ff0000;
}
span.read-more:hover i.mdi {
  opacity: 0;
  margin-left: 20px;
}
span.read-more i.mdi {
  transition: all 0.3s ease;
}
</style>
