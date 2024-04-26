<template>
  <div class="featured_jobs">
    <div class="sec-title text-center">
      <h2>Featured Jobs</h2>
      <div class="text">
        Know your worth and find the job that qualifies your life
      </div>
    </div>

    <v-container class="w-75 mb-6">
      <v-row align="center" justify="center">
        <v-col
          cols="12"
          class="featured_jobs_col"
          sm="12"
          md="12"
          lg="6"
          xl="6"
          v-for="job in displayedJobs"
          :key="job.id"
          @click="openDetailPanel(job)"
        >
          <v-card class="mx-auto company_info">
            <div class="company_logo">
              <v-img :src="`/storage/assest/${job.company.logo}`"></v-img>
            </div>
            <v-card class="job_info">
              <v-card-title>
                <a href="#">{{ job.title }}</a>
              </v-card-title>
              <ul class="company_seat">
                <li>
                  <v-icon color="#f16666" class="mr-1">mdi-domain</v-icon
                  >{{ job.company.company_name }}
                </li>
                <li>
                  <v-icon color="#34a853" class="mr-1"
                    >mdi-map-marker-outline</v-icon
                  >{{ job.location }}
                </li>
                <li>
                  <v-icon color="#f9ab00" class="mr-1"
                    >mdi-clock-time-two-outline</v-icon
                  >{{ formatCreatedAt(job.company.created_at) }}
                </li>
                <!-- <li><v-icon>mdi-cash</v-icon>{{ job.price }}</li> -->
              </ul>
              <ul class="company_time">
                <li>{{ job.job_type.name }}</li>
                <li>{{ job.category.name }}</li>
              </ul>
            </v-card>

            <!-- <a href="#" class="bookmark_fr">
              <v-icon>mdi-bookmark-outline</v-icon>
            </a> -->
          </v-card>
        </v-col>
        <!-- <v-navigation-drawer v-model="detailPanelVisible" location="right" class="single_job_search_page">
          <v-icon style="margin-left: 20px; margin-top: 30px; "
            @click="detailPanelVisible = false">mdi-arrow-left-top</v-icon>
          <v-card style="width: 100%">
            <div class="compamy_infor">
              <div class="compamy_infor_left">
                <v-card-title
                  ><v-icon>mdi-format-title</v-icon>
                  <span>{{ detail.title }}</span></v-card-title
                >

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
                <v-btn class="apply_for_job" @click="apply(detail.id)"
                  >Apply For Job</v-btn
                >
                <v-btn class="save_btn" color="white" @click="save(detail.id)">
                  <v-icon color="black">mdi-bookmark-outline</v-icon></v-btn
                >
              </div>
            </div>
            <v-row class="compamy_infor_description">
              <v-col cols="12" sm="12" md="12" lg="8" xl="8">
                <span style="display: block">{{ detail.description }}</span>
              </v-col>
              <v-col cols="auto" sm="12" md="12" lg="4" xl="4">
              
              </v-col>
            </v-row>
          </v-card>
        </v-navigation-drawer> -->
        <v-btn size="x-large" class="load_more" to="#" @click="searchJob">
          Load More Listing
        </v-btn>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useUsersStore } from ".././../store/user";
export default {
  name: "featuredJob",
  setup() {
    const jobs = ref([]);
    const displayedJobs = ref([]);
    const detail = ref({
      title: "",
      company_name: "",
      location: "",
      experience: "",
      description: "",
      vacancy: "",
      id: "",
    });
    const usersStore = useUsersStore();
    const detailPanelVisible = ref(false);
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
    const searchJob = () => {
      window.location.href = "/jobs-detail";
    };
    const fetchJobs = async () => {
      try {
        const response = await axios.get("/company/post");
        jobs.value = Object.values(response.data.data);
        //jobs.value = response.data.data;
        // console.log(jobs.value);
        displayedJobs.value = jobs.value.slice(0, 6);
      } catch (err) {
        console.error(err);
      }
    };

    const formatCreatedAt = (createdAt) => {
      const options = { day: "numeric", month: "long", year: "numeric" };
      return new Date(createdAt).toLocaleDateString(undefined, options);
    };
    onMounted(() => {
      fetchJobs();
    });
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

    return {
      jobs,
      formatCreatedAt,
      displayedJobs,
      closeDetailDialog,
      apply,
      save,
      openDetailPanel,
      detailPanelVisible,
      detail,
      usersStore,
      searchJob,
    };
  },
};
</script>
