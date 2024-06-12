<template>
  <div class="find_Job_list">
    <v-card class="mx-auto py-12 top_page_section">
      <div class="job_info" align="center" justify="center">
        <v-card-title>Jobs </v-card-title>
        <v-breadcrumbs :items="items">
          <template v-slot:title="{ item }">
            {{ item.title.toUpperCase() }}
          </template>
        </v-breadcrumbs>
      </div>
    </v-card>
    <div class="body_page_section featured_jobs">
      <v-container class="w_90">
        <v-row v-if="showAlert">
          <v-col
            cols="auto"
            sm="12"
            md="12"
            lg="12"
            xl="12"
            class="find_Job_list_right"
          >
            <v-alert type="error" class="no_job_found"> No job Found. </v-alert>
          </v-col>
        </v-row>
        <v-row v-if="showAlert2">
          <v-col
            cols="auto"
            sm="12"
            md="12"
            lg="12"
            xl="12"
            class="find_Job_list_right"
          >
            <v-alert type="error" class="no_job_found"> No job Found for your skill. </v-alert>
          </v-col>
        </v-row>
        <v-row v-else>
          <v-col cols="12" sm="12" md="3" lg="3" xl="3">
            <v-card class="mx-auto find_Job_list_left">
              <div class="job_search_forms">
                <h4 class="my-2">Job search</h4>
                <v-text-field
                  prepend-inner-icon="mdi-magnify"
                  v-model="jobTitle"
                  label="Job title, keywords, or company"
                  density="compact"
                  variant="solo"
                  clearable
                  style="width: 100%"
                  placeholder="Job title, keywords, or company"
                ></v-text-field>

                <h4 class="my-2 mt-4">City or postcode</h4>
                <v-text-field
                  prepend-inner-icon="mdi-map-marker-outline"
                  v-model="location"
                  label="City or postcode"
                  density="compact"
                  variant="solo"
                  clearable
                  style="width: 100%"
                  placeholder="City or postcode"
                ></v-text-field>
                <h4 class="my-2 mt-4">Category</h4>
                <v-select
                  v-model="category"
                  :items="categories"
                  item-title="name"
                  density="compact"
                  label="Category"
                  variant="solo"
                ></v-select>

                <h4 class="my-2 mt-4">Experience</h4>
                <v-select
                  v-model="experience"
                  :items="experienceOptions"
                  density="compact"
                  label="Experience"
                  variant="solo"
                ></v-select>
                <v-btn @click="searchJobs" class="b_string_btn mt-5"
                  >Search</v-btn
                >
              </div>
            </v-card>
          </v-col>
          <v-col cols="12" sm="12" md="9" lg="9" xl="9">
            <v-row class="ma-0 job_box">
              <v-col cols="12" sm="12" md="12" lg="12" xl="12">
                <div class="job_filter">
                  <div class="job_left">
                    <v-btn class="filter_btn"
                      ><v-icon>mdi-filter-variant</v-icon>filter</v-btn
                    >
                  </div>
                  <div class="job_right">
                    <v-select
                      v-model="statusFilter"
                      :items="filterdata"
                      density="compact"
                      label="Sort by"
                      variant="outlined"
                    ></v-select>
                  </div>
                </div>
              </v-col>
              <v-col
                class="featured_jobs_col job_box_child"
                v-for="job in paginatedTickets"
                :key="job.id"
                @click="openDetailPanel(job)"
              >
                <v-card class="mx-auto company_info job_box_card">
                  <div class="featured_jobs_logo">
                    <v-img :src="`/storage/assest/${job.company.logo}`"></v-img>
                  </div>
                  <v-card class="job_info">
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
                        <span
                          ><v-icon color="#f9ab00" class="mr-2"
                            >mdi-account</v-icon
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
                  </v-card>
                </v-card>
              </v-col>
            </v-row>
          </v-col>
        </v-row>
      </v-container>

      <div style="text-align: center;margin-top: 20px">
        <v-pagination
          v-if="jobs.length > 0"
          v-model="currentPage"
          :length="totalPages"
          @input="paginate"
          rounded="circle"
          :total-visible="4"
        ></v-pagination>
      </div>
    </div>
  </div>
</template>
<script>
import { ref, onMounted, watch, computed } from "vue";
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
    const experienceOptions = ref([
      "Fresher",
      "1 Year",
      "2 Years",
      "3 Years",
      "4 Years",
      "5 Years",
      "6 Years",
      "7 Years",
      "8 Years",
      "9 Years",
      "10 Years",
      "10+ Years",
    ]);
    const filterdata = ref(["All", "Newest", "Oldest"]);
    const statusFilter = ref("All");
    const filterpagedata = ref(["All", "5", "10", "15"]);
    const pageFilter = ref("All");
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
    const totalJobPostings = ref(0);
    const jobs = ref([]);
    const detail = ref({
      title: "",
      company_name: "",
      location: "",
      experience: "",
      description: "",
      vacancy: "",
      id: "",
    });
    const job = ref({
      category: "",
      experience: "",
    });
    const jobTitle = ref("");
    const location = ref("");
    const category = ref("");
    const experience = ref("");
    const detailPanelVisible = ref(false);
    const showAlert = ref(false);
    const showAlert2 = ref(false);
    const searchJobs = async () => {
      try {
        showAlert.value = false; 
        const response = await axios.get("/search-jobs", {
          params: {
            jobTitle: jobTitle.value,
            location: location.value,
            category: category.value,
            experience: experience.value,
          },
        });
        const fetchedJobs = response.data.data;
        if (!Array.isArray(fetchedJobs)) {
          showAlert.value = true;
          jobs.value = [];
        } else {
          if (statusFilter.value === "All") {
            jobs.value = fetchedJobs;
          } else if (statusFilter.value === "Newest") {
            fetchedJobs.sort(
              (a, b) => new Date(b.created_at) - new Date(a.created_at)
            );
            jobs.value = fetchedJobs;
          } else if (statusFilter.value === "Oldest") {
            fetchedJobs.sort(
              (a, b) => new Date(a.created_at) - new Date(b.created_at)
            );
            jobs.value = fetchedJobs;
          }
          if (jobs.value.length === 0) {
            showAlert.value = true;
          }
        }
      } catch (err) {
        console.error(err);
        showAlert.value = true;
      }
    };

    watch(statusFilter, () => {
      searchJobs();
    });

    // const fetchJobs = async () => {
    //   try {
    //     showAlert.value = false;
    //     const response = await axios.get("/company/post");
    //     const fetchedJobs = response.data.data;
    //     if (typeof fetchedJobs !== "object" || Array.isArray(fetchedJobs)) {
    //       showAlert.value = true;
    //       jobs.value = [];
    //     } else {
    //       jobs.value = Object.values(fetchedJobs);
    //       totalJobPostings.value = response.data.total;
    //       if (jobs.value.length === 0) {
    //         showAlert.value = true;
    //       }
    //     }
    //   } catch (error) {
    //     console.error("Error fetching jobs:", error);
    //     showAlert.value = true;
    //   }
    // };
    const fetchJobs = async () => {
  try {
    showAlert.value = false;
    const response = await axios.get("/company/post");
    const fetchedJobs = response.data.data;
    console.log(fetchedJobs); 
    if (Array.isArray(fetchedJobs)) {
      jobs.value = fetchedJobs;
    } else if (typeof fetchedJobs === 'object') {
     
      jobs.value = Object.values(fetchedJobs);
    } else {
      showAlert.value = true;
      jobs.value = [];
    }
    totalJobPostings.value = jobs.value.length; 
    if (jobs.value.length === 0) {
      showAlert.value = true;
    }
  } catch (error) {
    console.error("Error fetching jobs:", error);
    showAlert.value = true;
  }
};

    
    const fetchpost = async () => {
  try {
    const response = await axios.get("/company/job");
    const fetchedJobs = response.data.data;
    if (Array.isArray(fetchedJobs)) {
      jobs.value = fetchedJobs;
    } else {
     
      showAlert2.value = true;
      jobs.value = []; 
    }
    totalJobPostings.value = jobs.value.length; 
    if (jobs.value.length === 0) {
      showAlert2.value = true;
    }
  } catch (error) {
    console.error(error);
  }
};

    const fetchTotalJobPostings = async () => {
      try {
        const response = await fetch("/total-published-jobs");
        const data = await response.json();
        totalJobPostings.value = data.totalPublishedJobs;
      } catch (error) {
        console.error("Error fetching total job postings:", error);
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
      if (description && description.length > 65) {
        return description.substring(0, 65) + "...";
      }
      return description;
    };

    const isDescriptionLong = (description) => {
      return description && description.length > 65;
    };
    const formatCreatedAt = (createdAt) => {
      const options = { day: "numeric", month: "long", year: "numeric" };
      return new Date(createdAt).toLocaleDateString(undefined, options);
    };
    const categories = ref([]);

    const fetchCategories = async () => {
      try {
        axios.get("/categories").then((response) => {
          categories.value = response.data;
          console.log(response.data);
        });
      } catch (error) {
        console.error("Error fetching categories:", error);
      }
    };
    const selectCategory = (selectedCategory) => {
      job.category = selectedCategory.name;
    };
    const currentPage = ref(1);
    const ticketsPerPage = 6;
    const totalPages = computed(() =>
      Math.ceil(jobs.value.length / ticketsPerPage)
    );
    const paginatedTickets = computed(() => {
      const startIndex = (currentPage.value - 1) * ticketsPerPage;
      const endIndex = startIndex + ticketsPerPage;
      return jobs.value.slice(startIndex, endIndex);
    });
    const paginate = (page) => {
      currentPage.value = page;
    };

    onMounted(() => {
      if (!usersStore.isloggedin) {
        fetchJobs();
        
      } else {
        fetchpost();
       
      }
      fetchTotalJobPostings();
      fetchCategories();
      // if (usersStore.isloggedin) {
      //   fetchpost();
      // } else if(!usersStore.isloggedin) {
      //   fetchJobs();
      // }

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
    });

    return {
      jobs,
      jobTitle,
      location,
      searchJobs,
      statusFilter,
      usersStore,
      closeDetailDialog,
      experience,
      apply,
      save,
      job,
      categories,
      currentPage,
      openDetailPanel,
      detailPanelVisible,

      detail,
      paginatedTickets,
      totalPages,
      truncateDescription,
      isDescriptionLong,
      paginate,
      category,
      items,
      showAlert,
      totalJobPostings,
      experienceOptions,
      filterdata,
      pageFilter,
      filterpagedata,showAlert2
    };
  },
};
</script>
<style>
.cpmany_logo .v-img {
  width: 45px;
  margin: 0 auto;
}

.find_Job_list .top_page_section {
  background: #f5f7fc;
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
.find_Job_list_right {
  cursor: pointer;
}
.find_Job_list_right .v-card-title {
  font-size: 30px;
  font-weight: bolder;
  color: #202124;
  font-family: sans-serif;
  text-transform: capitalize;
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

.compamy_infor_description {
  width: 90%;
  margin: 2% auto;
}
.find_Job_list_left button.search_btn {
  display: table;
  margin: 0 auto;
  color: #fff;
  background-color: #0146a6;
  font-size: 15px;
  border-radius: 8px;
  font-weight: 400;
  padding: 18px 35px;
  height: 50px !important;
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
.job_filter {
  display: flex;
  width: 100%;
  justify-content: space-between;
}
.job_right {
  display: flex;
  gap: 25px;
}
.job_right .v-input {
  width: 155px;
}
.filter_btn {
  background: #e2eaf8;
  color: #0146a6;
  margin-left: 15px;
  display: none;
}
@media screen and (max-width: 992px) {
  .filter_btn {
    display: block;
  }
}
</style>
