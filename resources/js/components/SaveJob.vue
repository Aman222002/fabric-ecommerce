<template>
  <div>
   
    <v-btn color="success" class="new-job-btn">
      <a href="/jobs-detail" class="new-job-link">Check New Job</a>
    </v-btn>
    <div class="card-container">
      <v-card v-for="savedJob in savedJobs" :key="savedJob.id" class="job-card">
        <v-card-title style="text-align: center; color: green;">{{ savedJob.job.title }}</v-card-title>
        <v-card-text style="margin-top: 20px;">
          <div style="display: flex; align-items: center;">
    <v-icon color="black">mdi-domain</v-icon>
    <span style="font-size: 20px;">{{ savedJob.company.company_name }}<v-icon color="black" style="margin-left: 200px;font-size: 20px;">mdi-map-marker</v-icon>{{ savedJob.job.location }} </span>
  </div><br><br>
  <div style="display: flex; align-items: center;">
    <v-icon color="black" >mdi-email-box</v-icon>
  <span style="font-size: 20px;">{{ savedJob.company.company_email }}<v-icon    color="black" style="margin-left: 85px;font-size: 20px;">mdi-school</v-icon>{{savedJob.job.qualifications }}   </span>
  </div><br><br>
  <div style="display: flex; align-items: center;">
   
    <v-icon color="black" >mdi-currency-rupee</v-icon>
  <span style="font-size: 20px;">{{savedJob.job.salary }}<v-icon color="black" style="margin-left: 270px;font-size: 20px;" >mdi-desktop-classic</v-icon>{{ savedJob.job.experience}} </span>
  </div>
          
        </v-card-text>
        <v-card-actions>
          <v-btn   color="primary"  style=" color: white;" @click="apply(savedJob.job.id)">Apply</v-btn>
   
          <v-icon @click="deleteItem(savedJob.id)" color="red" style="font-size: 40px;"  class="delete-icon">mdi-delete-outline </v-icon>
        </v-card-actions>
      </v-card>
    </div>
  </div>
</template>

<script>
import { ref } from "vue";
import axios from 'axios';

export default {
  name: "JobSaved",
  props: {
    data: {
      type: Array,
      default: () => [],
    },
  },
  setup(props) {
    const savedJobs = ref(props.data);

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
            axios.post(`/removesavedjobs/${id}`).then((response) => {
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

    const apply = async (id) => {
      try {
        await axios.post(`/apply-job/${id}`).then((response) => {
          if (response.data.status == true) {
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
        window.Swal.fire({
          title: "Application Failed",
          text: "You Already apply on this Job",
          icon: "error",
          confirmButtonText: "OK",
        });
      }
    };

    return {
      savedJobs,
      deleteItem,
      apply,
    };
  },
};
</script>

<style>
.title-container {
  text-align: center;
  margin-top: 20px;
}

.saved-text {
  color: red;
}

.new-job-btn {
  margin-top: 20px;
}

.new-job-link {
  text-decoration: none;
}

.card-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
}

.job-card {
  width: 600px; 
  margin: 20px;
}

.job-info {
  display: flex;
  justify-content: space-between;
}

.info-label {
  font-weight: bold;
}

</style>
