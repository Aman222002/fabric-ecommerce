<template>
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
            
            <span style="font-size: 18px;">Posted At:{{formatCreatedAt(job.company.created_at)}}</span>
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
            <span style="font-size: 18px;">Posted At:{{formatCreatedAt(detail.created_at)}}</span>
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
</style>
