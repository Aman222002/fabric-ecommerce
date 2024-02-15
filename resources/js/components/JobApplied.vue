
<template>
<div>
    <div class="title-container">
      <h1>Jobs <span class="applied-text">Applied</span></h1>
    </div>
    <v-btn color="success" class="new-job-btn">
      <a href="/jobs-detail" class="new-job-link">Apply For New Job</a>
    </v-btn>
    <div class="card-container">
     
      <v-card v-for="jobApplication in jobApplications" :key="jobApplication.id" class="job-card">
        <v-card-title style="text-align: center; color: green;">{{ jobApplication.job.title }}</v-card-title>
        <v-card-text style="margin-top: 20px;">
          <div style="font-size: 20px;">
            <v-icon color="black" style="display: inline-block; vertical-align: middle;">mdi-map-marker</v-icon>
            Location:<span style="font-size: 20px;"> {{ jobApplication.job.location }}</span>
          </div>
          <div style="font-size: 20px; margin-top: 10px;">
            <v-icon color="black" style="display: inline-block; vertical-align: middle;">mdi-currency-rupee</v-icon>
            Salary:<span style="font-size: 20px;"> {{ jobApplication.job.salary }}</span>
          </div>
          <div style="font-size: 20px; margin-top: 10px;">
            <v-icon color="black" style="display: inline-block; vertical-align: middle;">mdi-domain</v-icon>
            Company Name:<span style="font-size: 20px;"> {{ jobApplication.company.company_name }}</span>
          </div>
          <div style="font-size: 20px; margin-top: 10px;">
            <v-icon color="black" style="display: inline-block; vertical-align: middle;">mdi-email-box</v-icon>
            Company Email:<span style="font-size: 20px;"> {{ jobApplication.company.company_email }}</span>
          </div>
        </v-card-text>
        <v-card-actions>
          <v-btn @click="deleteItem(jobApplication.id)" color="error">Delete</v-btn>
        </v-card-actions>
      </v-card>
    </div>
  </div>
</template>

<script>
import { ref } from "vue";
import axios from 'axios';

export default {
  name: "JobApplied",
  props: {
    data: {
      type: Array,
      default: () => [],
    },
  },
  setup(props) {
    const jobApplications = ref(props.data);

    const deleteItem = (id) => {
      window.Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          window.Swal.fire({
            title: "Deleted!",
            text: "Your file has been deleted.",
            icon: "success",
          });
          try {
            axios.post(`/remove-applied-jobs/${id}`).then((response) => {
              if (response.data.status == true) {
                window.location.reload();
              } else {
                console.log(
                  "Request was not successful:",
                  response.data.message
                );
              }
            });
          } catch (err) {
            console.log(err);
          }
        }
      });
    };
    return {
      jobApplications,
      deleteItem,
    };
  },
};
</script>

<style>
.title-container {
  text-align: center;
  margin-top: 20px;
}

.applied-text {
  color: red;
}

.job-card {
  width: 800px; 
  height: 350px;
  display: flex;
  flex-direction: column;
  
  border: 1px solid rgb(86, 50, 250);
  background-color: white;
}

.v-card__title,
.v-card__text {
  padding: 0; 
}
.card-container {
  display: flex;
  flex-wrap: wrap;
  gap: 60px;
  margin-top: 20px;
}

</style>