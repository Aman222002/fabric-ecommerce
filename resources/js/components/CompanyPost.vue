<template>
  <v-container>
    <v-row style="margin-top: 30px">
      <v-col cols="12" md="4">
        <v-text-field
          v-model="jobTitle"
          label="Job Title"
          outlined
          clearable
          style="width: 100%"
        ></v-text-field>
      </v-col>
      <v-col cols="12" md="4">
        <v-text-field
          v-model="location"
          label="Location"
          outlined
          clearable
          style="width: 100%"
        ></v-text-field>
      </v-col>
      <v-col cols="12" md="4">
        <v-btn @click="searchJobs" color="primary" style="margin-top: 15px;">Search</v-btn>
      </v-col>
    </v-row>

    <div class="card-container">
      <v-card v-for="job in jobs" :key="job.id" class="custom-card" @click="openDetailDialog(job)">
        <v-card-title
          style="
            font-size: 30px;
            font-weight: bolder;
            text-align: center;
            color: rgb(81, 81, 85);
          "
          >{{ job.title }}</v-card-title
        >

        <v-card-text style="display: flex;">
          <div style="font-size: 20px">
            <v-icon color="black" style="display: inline-block; vertical-align: middle;">mdi-domain</v-icon>
            Company Name:<span style=" font-size: 25px;"> {{ job.company.company_name }}</span>
          </div>
         <div style="font-size: 20px;margin-left: 140px;" >
          <v-icon color="black" style="display: inline-block; vertical-align: middle;">mdi-map-marker</v-icon>
           Location:<span style=" font-size: 20px;"> {{ job.location }}</span>
        </div>
      <br />
        
        </v-card-text>
      
      </v-card>
      <v-dialog v-model="dialogVisible" max-width="auto">
        {{ detail.value }}
        <v-card>
          <v-card-title
            style="
              font-size: 40px;
              font-weight: bolder;
              text-align: center;
              margin-top: 30px;
              color: rgb(139, 238, 144);
            "
            >{{ detail.title }}</v-card-title
          >
          <v-card-text >
         
          <div style="font-size: 20px">
            <v-icon color="black" style="display: inline-block; vertical-align: middle;">mdi-domain</v-icon>
            Company Name:<span style="color: rgb(59, 145, 243); font-size: 25px;margin-left: 50px;"> {{ detail.company_name }}</span>
          </div>
          <br />
         <div style="font-size: 20px" >
          <v-icon color="black" style="display: inline-block; vertical-align: middle;">mdi-map-marker</v-icon>
           Location:<span style=" font-size: 20px;margin-left: 140px;"> {{ detail.location }}</span>
        </div>
         <br />
         <div style="font-size: 20px" >
          <v-icon color="black" style="display: inline-block; vertical-align: middle;">mdi-desktop-classic</v-icon>
         Experience:<span style=" font-size: 20px;margin-left: 110px; "> {{ detail.experience }}</span></div>
          <br />
          <div style="font-size: 20px" >
            <v-icon color="black" style="display: inline-block; vertical-align: middle;">mdi-human</v-icon>
          Vacancy:<span style=" font-size: 20px;margin-left: 140px; "> {{ detail.vacancy }}</span></div>
          <br />
          <div style="font-size: 20px" >
            <v-icon color="black" style="display: inline-block; vertical-align: middle;">mdi-note</v-icon>
        Description:<span style=" font-size: 20px; margin-left: 90px; display: block;"> {{ detail.description }}</span></div>
          <br />
       
          </v-card-text>
          <v-card-actions>
            <v-btn
              color="white"
              class="bg-primary"
              v-if="usersStore.isloggedin"
              @click="apply(detail.id)"
              >Apply</v-btn
            >
            <v-btn color="white" class="bg-success" @click="save(detail.id)"
              >Save</v-btn
            >
            <v-btn @click="closeDetailDialog()">Close</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
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
      title:"",
      company_name: "",
      location:"",
      experience:"",
      description:"",
      vacancy:"",
      id:""

    });
    
    const jobTitle = ref("");
    const location = ref("");
    const dialogVisible = ref(false);
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
    const fetchJobs = async () => {
      try {
        const response = await axios.get("/company/post");
        jobs.value = response.data.data;
      } catch (err) {
        console.error(err);
      }
    };
    const companypost = async () => {
      try {
        const response = await axios.get("/companypost");
        jobs.value = response.data.data;
      } catch (err) {
        console.error(err);
      }
    };

    const openDetailDialog = (job) => {
      dialogVisible.value = true;
      detail.value.company_name = job.company.company_name;
      detail.value.location= job.location;
      detail.value.experience=job.experience;
      detail.value.description=job.description;
      detail.value.vacancy=job.vacancy;
      detail.value.title=job.title;
      detail.value.id = job.id;
      console.log(detail.value)
     
    };

    const closeDetailDialog = () => {
      dialogVisible.value = false;
    };
    const apply = async (id) => {
      try {
        await axios.post(`/apply-job/${id}`).then((response) => {
          if (response.data.status == true) {
            dialogVisible.value = false;
            window.Swal.fire({
              icon: "success",
              title: "Applied Successfully",
              text: "Applied successfully ",
              confirmButtonText: "OK",
            });
          }
        });
      } catch (err) {
        console.error(err);
        dialogVisible.value = false;
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
            dialogVisible.value = false;
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
        dialogVisible.value = false;
        window.Swal.fire({
          title: "Application Failed",
          text: "You Already saved this Job",
          icon: "error",
          confirmButtonText: "OK",
        });
      }
    };
    onMounted(() => {
      companypost();
      fetchJobs();
    });
    return {
      jobs,
      jobTitle,
      location,
      searchJobs,
      companypost,
      usersStore,
      openDetailDialog,
      closeDetailDialog,
      dialogVisible,
      apply,
      save,
      detail,
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
  height: 100px;
  width: 900px;
  border: 1px solid rgb(86, 50, 250);
  background-color: white;
  cursor: pointer;
}
.custom-card:hover {
    box-shadow: 0 0 20px hsla(78, 87%, 50%, 0.788); 
    transform: translateY(15px); 
  }
</style>
  