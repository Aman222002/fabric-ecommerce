
<template>
  <v-btn color="success" class="new-job-btn">
      <a href="/jobs-detail" class="new-job-link">Check New Job</a>
    </v-btn>
    <div class="card-container">
      
      <v-card v-for="jobApplication in jobApplications" :key="jobApplication.id" class="job-card">
        <v-card-title
          style="
            font-size: 30px;
            font-weight: bolder;
            color: rgb(44, 44, 151);
          "
          >{{ jobApplication.job.title }}</v-card-title
        >
        <v-card-text>
  <div style="display: flex; align-items: center;">
    <v-icon color="black">mdi-domain</v-icon>
    <span style="font-size: 20px;">{{ jobApplication.company.company_name }}<v-icon color="black" style="margin-left: 200px;font-size: 20px;">mdi-map-marker</v-icon>{{ jobApplication.job.location }} </span>
  </div><br><br>
  <div style="display: flex; align-items: center;">
    <v-icon color="black" >mdi-email-box</v-icon>
  <span style="font-size: 20px;">{{ jobApplication.company.company_email }}<v-icon    color="black" style="margin-left: 85px;font-size: 20px;">mdi-school</v-icon>{{jobApplication.job.qualifications }}   </span>
  </div><br><br>
  <div style="display: flex; align-items: center;">
   
    <v-icon color="black" >mdi-currency-rupee</v-icon>
  <span style="font-size: 20px;">{{ jobApplication.job.salary }}<v-icon color="black" style="margin-left: 270px;font-size: 20px;" >mdi-desktop-classic</v-icon>{{ jobApplication.job.experience}} </span>
  </div>
  
          
</v-card-text>
<v-card-actions>
         
          <v-icon @click="deleteItem(jobApplication.id)" color="red" style="font-size: 40px;"  class="delete-icon">mdi-delete-outline </v-icon>
        </v-card-actions>
      
      </v-card>
      </div>
</template>

<script>
import { ref } from "vue";
import axios from "axios";

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
  width: 100%;
  height: auto;
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
.delete-icon:hover {
  cursor: pointer;
  transform: scale(1.4);
 
}
.v-icon:hover{
  transform: scale(1.2);
}
</style>