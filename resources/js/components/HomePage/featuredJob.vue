<template>
  <div class="featured_jobs">
    <div class="sec-title text-center">
      <h2>Featured Jobs</h2>
      <div class="text">
        Know your worth and find the job that qualifies your life
      </div>
    </div>

    <v-container class="w-75 mb-6">
      <v-row class="job_box">
        <v-col
          class="featured_jobs_col job_box_child"
          v-for="job in displayedJobs"
          :key="job.id"
          @click="openDetailPage(job.id)"
        >
          <v-card class="mx-auto company_info job_box_card">
            <div
              class="featured_jobs_logo"
              v-if="job.company && job.company.logo"
            >
              <v-img :src="`/storage/assest/${job.company.logo}`"></v-img>
            </div>
            <v-card class="job_info">
              <v-card-title>
                <a href="#">{{ job.title || "No Title" }}</a>
              </v-card-title>
              <ul class="company_seat">
                <li class="mr-2" v-if="job.company">
                  <v-icon color="#f16666" class="mr-1">mdi-domain</v-icon>
                  {{ job.company.company_name || "Unknown Company" }}
                </li>
                <li class="mr-2">
                  <v-icon color="#34a853" class="mr-1"
                    >mdi-map-marker-outline</v-icon
                  >
                  {{ HomeCountryState(job.location || "Unknown Location") }}
                </li>
                <li class="mr-2" v-if="job.company && job.company.created_at">
                  <v-icon color="#f9ab00" class="mr-1"
                    >mdi-clock-time-two-outline</v-icon
                  >
                  {{ formatCreatedAt(job.company.created_at) }}
                </li>
              </ul>
              <ul class="company_time">
                <li>{{ job.job_type?.name || "Unknown Job Type" }}</li>
                <li>{{ job.category?.name || "Unknown Category" }}</li>
              </ul>
            </v-card>
          </v-card>
        </v-col>
        <div class="w-100" v-if="showAlert">
          <v-alert type="error" class="no_job_found w-100">
            No job Found for your skill.
          </v-alert>
        </div>

        <div class="load_more_div" v-if="jobs.length > 0">
          <v-btn size="x-large" class="load_more mt-5" @click="searchJob">
            Load More Listing
          </v-btn>
        </div>
        <div class="w-100" v-if="jobs.length < 0">
          <v-alert type="error" class="no_job_found w-100">
            No job Found.
          </v-alert>
        </div>
      </v-row>
    </v-container>
  </div>
</template>
<script>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useUsersStore } from "../../store/user";
import { Sweetalert } from "../../utils/sweetalert";
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
      detail.value.company_name = job.company.company_name || "Unknown Company";
      detail.value.location = job.location || "Unknown Location";
      detail.value.experience = job.experience || "Unknown Experience";
      detail.value.description = job.description || "No Description";
      detail.value.vacancy = job.vacancy || "No Vacancy";
      detail.value.title = job.title || "No Title";
      detail.value.created_at = job.company.created_at || "Unknown Date";
      detail.value.id = job.id;
    };
    const showAlert = ref(false);
    const openDetailPage = (id) => {
      window.location.href = `/jobs/${id}`;
    };

    const closeDetailDialog = () => {
      detailPanelVisible.value = false;
    };

    const searchJob = () => {
      window.location.href = "/find-job";
    };

    const fetchJobs = async () => {
      try {
        const response = await axios.get("/company/post");
        jobs.value = Object.values(response.data.data);
        displayedJobs.value = jobs.value.slice(0, 6);
      } catch (err) {
        console.error(err);
      }
    };

    const totalJobPostings = ref(0);
    const fetchpost = async () => {
      try {
        const response = await axios.get("/company/job");
        jobs.value = Object.values(response.data.data);

        displayedJobs.value = jobs.value.slice(0, 6);
        totalJobPostings.value = jobs.value.length;

        if (jobs.value.length === 0) {
          showAlert.value = true;
        } else {
          showAlert.value = false;
        }
      } catch (error) {
        console.error(error);
      }
    };

    const formatCreatedAt = (createdAt) => {
      const options = { day: "numeric", month: "long", year: "numeric" };
      return new Date(createdAt).toLocaleDateString(undefined, options);
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

            Sweetalert.success("Applied Successfully");
            window.location.href = response.data.company_url;
          }
        });
      } catch (err) {
        console.error(err);
        detailPanelVisible.value = false;

        Sweetalert.error("You Already apply on this Job");
      }
    };

    const save = async (id) => {
      try {
        await axios.post(`/save-job/${id}`).then((response) => {
          if (response.data.status == true) {
            detailPanelVisible.value = false;

            Sweetalert.success("saved Successfully");
          }
        });
      } catch (err) {
        console.error(err);
        detailPanelVisible.value = false;

        Sweetalert.error("You Already saved this Job");
      }
    };

    const HomeCountryState = (countryStateName) => {
      if (countryStateName && countryStateName.length > 15) {
        return countryStateName.substring(0, 15) + "....";
      }
      return countryStateName;
    };

    onMounted(() => {
      if (usersStore.isloggedin) {
        
        fetchpost();
      } else {
        fetchJobs();
      }
      fetchTotalJobPostings();
    });

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
      openDetailPage,
      HomeCountryState,
      totalJobPostings,
      showAlert,
    };
  },
};
</script>

<style>
.featured_jobs_logo {
  width: 90px;
}
.featured_jobs_logo img.v-img__img {
  width: 90px;
  border-radius: 15px;
}
.load_more_div {
  width: 100%;
  text-align: center;
}
</style>
