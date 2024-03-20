<template>
  <div class="find_Job_list">
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
    <!--    <v-row>
   
     <v-col cols="12" sm="12" md="12" lg="12" xl="12"> </v-col> 
    </v-row>-->
    <div class="body_page_section">
      <v-container class="w-75">
        <v-row>
          <v-col cols="12" sm="12" md="12" lg="3" xl="3">
            <v-card class="mx-auto find_Job_list_left">
              <v-card-title>Search by Keywords </v-card-title>
              <v-text-field
                v-model="jobTitle"
                label="Job Title"
                density="compact"
                variant="outlined"
                clearable
                style="width: 100%"
              ></v-text-field>
              <v-text-field
                v-model="location"
                label="Location"
                density="compact"
                variant="outlined"
                clearable
                style="width: 100%"
              ></v-text-field>
              <v-btn @click="searchJobs" class="search_company_post"
                >Search</v-btn
              >
            </v-card>
          </v-col>
          <v-col
            cols="12"
            sm="12"
            md="12"
            lg="9"
            xl="9"
            class="find_Job_list_right"
          >
            <v-card
              v-for="job in jobs"
              :key="job.id"
              class="custom-card"
              @click="openDetailPanel(job)"
            >
              <v-card-title>{{ job.company.company_name }}</v-card-title>
              <v-card-text class="pa-0 ml-3">
                <div style="display: flex; align-items: center">
                  <v-icon color="black">mdi-domain</v-icon>
                  <span>{{ job.title }}</span>
                </div>

                <div style="align-items: center">
                  <v-icon color="black">mdi-note</v-icon>
                  <span> {{ truncateDescription(job.description) }}</span>
                  <span
                    v-if="isDescriptionLong(job.description)"
                    class="read-more"
                    @click="openDetailPanel(job)"
                  >
                    Read More
                  </span>
                </div>
              </v-card-text>
              <v-card-actions>
                <div style="display: flex; align-items: center">
                  <v-icon color="black">mdi-human</v-icon>
                  <span
                    >{{ job.vacancy }}
                    <v-icon color="black">mdi-desktop-classic</v-icon
                    >{{ job.experience
                    }}<v-icon color="black">mdi-map-marker</v-icon
                    >{{ job.location }}</span
                  >
                </div>
              </v-card-actions>
            </v-card>
            <v-navigation-drawer
              v-model="detailPanelVisible"
              location="right"
              class="single_job_search_page"
            >
              <v-card style="width: 100%">
                <div class="compamy_infor">
                  <div class="compamy_infor_left">
                    <v-card-title
                      ><v-icon>mdi-account-school-outline</v-icon>
                      <span>{{ detail.title }}</span>
                    </v-card-title>
                    <!-- <v-icon color="black">mdi-domain</v-icon>
                    <span>{{ detail.company_name }}</span>
                    <v-icon color="black">mdi-map-marker</v-icon>
                    <span>{{ detail.location }}</span>
                    <v-icon color="black">mdi-desktop-classic</v-icon>
                    <span>{{ detail.experience }}</span>
                    <v-icon color="black">mdi-human</v-icon>
                    <span>{{ detail.vacancy }}</span> -->
                  </div>
                  <div class="compamy_infor_btn">
                    <v-btn class="apply_for_job" @click="apply(detail.id)"
                      >Apply For Job</v-btn
                    >
                    <v-btn
                      class="save_btn"
                      color="white"
                      @click="save(detail.id)"
                    >
                      <v-icon color="black">mdi-bookmark-outline</v-icon></v-btn
                    >
                    <v-btn
                      class="save_btn"
                      color="white"
                      @click="detailPanelVisible = false"
                    >
                      <v-icon>mdi-arrow-left-top</v-icon></v-btn
                    >
                  </div>
                </div>
                <v-row class="compamy_infor_description">
                  <v-col cols="12" sm="12" md="12" lg="8" xl="8">
                    <span style="display: block">{{ detail.description }}</span>
                  </v-col>
                  <v-col cols="12" sm="12" md="12" lg="4" xl="4">
                    <div class="company_information">
                      <v-list-item>
                        <template v-slot:prepend>
                          <v-card-text class="pa-0">
                            Company Name:
                          </v-card-text>
                        </template>
                        <template v-slot:append>
                          <v-card-text class="pa-0">
                            {{ detail.company_name }}
                          </v-card-text>
                        </template>
                      </v-list-item>
                      <v-list-item>
                        <template v-slot:prepend>
                          <v-card-text class="pa-0">
                            Company Location:
                          </v-card-text>
                        </template>
                        <template v-slot:append>
                          <v-card-text class="pa-0">
                            {{ detail.location }}</v-card-text
                          >
                        </template>
                      </v-list-item>
                      <v-list-item>
                        <template v-slot:prepend>
                          <v-card-text class="pa-0"> Vacancy:</v-card-text>
                        </template>
                        <template v-slot:append>
                          <v-card-text class="pa-0">
                            {{ detail.vacancy }}</v-card-text
                          >
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
  props: {
    data: {
      type: Object,
      default: () => ({}),
    },
  },
  setup(props) {
    console.log(props.data);
    // if(props.data){
    //     jobTitle.value = props.data.title,
    //     location.value = props.data.location,
    //   }else{

    //   }
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
    const searchJobs = async () => {
      try {
        const response = await axios.get("/search-jobs", {
          params: {
            jobTitle: jobTitle.value,
            location: location.value,
            category: category.value,
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
    };
  },
};
</script>

