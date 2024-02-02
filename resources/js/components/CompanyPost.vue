<template>
    <v-container>
      
     <v-row  style="margin-top: 30px;">
      <v-col cols="12" md="6">
        <v-text-field v-model="jobTitle" label="Job Title" outlined clearable style="max-width: 60%;"></v-text-field>
      </v-col>
      <v-col cols="12" md="6">
        <v-text-field v-model="location" label="Location" outlined clearable style="max-width: 60%;"></v-text-field>
        <v-btn @click="searchJobs" color="primary">Search</v-btn>
      </v-col>
    </v-row>

    <div class="card-container">
     
      
      <v-card v-for="job in jobs" :key="job.id" class="custom-card">
        
        <v-card-title style="font-size: 20px; font-weight: bolder;">{{ job.title }}</v-card-title>
  
        <v-card-text>
          <div style="font-size: 15px;">Company Name: {{ job.company.company_name }}</div><br>
          <div>Location: {{ job.location }}</div><br>
          <div>Experience: {{ job.experience }}</div><br>
          <div>Salary: {{ job.salary }}</div><br>
          <div>Vacancy: {{ job.vacancy }}</div>
        </v-card-text>
        <v-card-actions>
            
            <v-btn  color="white" class="bg-primary" @click="detail(job.id)">Detail</v-btn>
        </v-card-actions>
      </v-card>
    </div>
</v-container>
  </template>
  
  <script>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  import { useUsersStore } from '../store/user';
  export default {
    name: 'CompanyPost',
    setup() {
      const usersStore = useUsersStore();
      const jobs = ref({

      });
      const jobTitle = ref('');
    const location = ref('');
    const searchJobs = async () => {
    
    try {
      
        const response = await axios.get('/search-jobs', {
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
          const response = await axios.get('/company/post');
          jobs.value = response.data.data;
        } catch (err) {
          console.error(err);
        }
      };
      const companypost = async () => {
        try {
          const response = await axios.get('/companypost');
          jobs.value = response.data.data;
        } catch (err) {
          console.error(err);
        }
      };
      const detail = async(id) => {
  window.location.href = `/jobs/detail/${id}`;
}
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
      // apply,
      detail,
     
      };
    },
  };
  </script>
  
  <style scoped>
  .card-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px; 
    margin-top: 20px;
  }
  .custom-card {
    display: flex;
    flex-direction: column;
    height: 330px;
    width: 350px;
    border: 1px solid rgb(7, 5, 5);
 
  }
  
  
  
  </style>
  