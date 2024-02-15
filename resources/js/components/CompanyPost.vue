<template>
  <v-container>
    <v-row style="margin-top: 10px;">
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
    <v-btn @click="searchJobs"  style="margin-top: 15px; color: white;" color="primary">Search</v-btn>
  </v-col>
</v-row>
    <div class="card-container">
      <v-card v-for="job in jobs" :key="job.id" class="custom-card" @click="openDetailDialog(job)">
        <v-card-title
          style="
            font-size: 30px;
            font-weight: bolder;
            color: rgb(44, 44, 151);
          "
          >{{ job.title }}</v-card-title
        >

        <v-card-text>
  <div style="display: flex; align-items: center;">
    <v-icon color="black">mdi-domain</v-icon>
    <span style="font-size: 20px;">{{ job.company.company_name }}  <v-icon color="black" style="margin-left: 200px;font-size: 20px;" >mdi-map-marker</v-icon> {{ job.location }}<v-icon color="black" style="margin-left: 200px;font-size: 20px;">mdi-currency-rupee</v-icon>{{ job.salary }} </span>
  </div><br>
  <div style="display: flex; align-items: center;">
    <v-icon color="black" >mdi-human</v-icon>
  <span style="font-size: 20px;">  {{ job.vacancy }} <v-icon color="black" style="margin-left: 310px;font-size: 20px;" >mdi-desktop-classic</v-icon>{{ job.experience }}<v-icon color="black" style="margin-left: 200px;font-size: 20px;">mdi-school</v-icon>{{ job.qualifications }} </span>
  </div><br>
  <div style="align-items: center;" >
  <v-icon color="black">mdi-note</v-icon>
  <span style=" font-size: 15px;"> {{ job.description }}</span></div>
          
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
            <v-icon color="black" >mdi-domain</v-icon>
            <span style="color: rgb(59, 145, 243); font-size: 25px;margin-left: 50px;"> {{ detail.company_name }}</span>
          </div>
          <br />
         <div style="font-size: 20px" >
          <v-icon color="black" >mdi-map-marker</v-icon>
          <span style=" font-size: 20px;margin-left: 140px;"> {{ detail.location }}</span>
        </div>
         <br />
         <div style="font-size: 20px" >
          <v-icon color="black" >mdi-desktop-classic</v-icon>
          <span style=" font-size: 20px;margin-left: 110px; "> {{ detail.experience }}</span></div>
          <br />
          <div style="font-size: 20px" >
            <v-icon color="black" >mdi-human</v-icon>
          <span style=" font-size: 20px;margin-left: 140px; "> {{ detail.vacancy }}</span></div>
          <br />
          <div style="font-size: 20px" >
            <v-icon color="black">mdi-note</v-icon>
        <span style=" font-size: 15px; margin-left: 90px; display: block;"> {{ detail.description }}</span></div>
          </v-card-text>
          <v-card-actions>
            <v-btn
            color="primary"
             style=" color: white;"
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
  height: auto;
  width: auto;
  border: 1px solid rgb(86, 50, 250);
  background-color: white;
  cursor: pointer;
  transition: background-color 0.3s, color 0.3s;
}
.custom-card:hover {
    box-shadow: 0 0 20px hsla(78, 87%, 50%, 0.788); 
    background-color: #44494b; 
  color: white;
  }
.custom-card:hover v-icon {
  color: white; 
}
</style>
  