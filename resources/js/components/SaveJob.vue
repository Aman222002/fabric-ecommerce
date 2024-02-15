<template>
  <div>
    <div class="title-container">
      <h1>Jobs <span class="saved-text">Saved</span></h1>
    </div>
    <v-btn color="success" class="new-job-btn">
      <a href="/companypost" class="new-job-link">Check New Job</a>
    </v-btn>
    <div class="card-container">
      <v-card v-for="savedJob in savedJobs" :key="savedJob.id" class="job-card">
        <v-card-title style="text-align: center; color: green;">{{ savedJob.job.title }}</v-card-title>
        <v-card-text style="margin-top: 20px;">
          <div style="font-size: 20px;">
            <v-icon color="black" style="display: inline-block; vertical-align: middle;">mdi-map-marker</v-icon>
            Location: <span style="font-size: 20px;">{{ savedJob.job.location }}</span>
          </div>
          <div style="font-size: 20px; margin-top: 20px;">
            <v-icon color="black" style="display: inline-block; vertical-align: middle;">mdi-currency-rupee</v-icon>
            Salary: <span style="font-size: 20px;">{{ savedJob.job.salary }}</span>
          </div>
          <div style="font-size: 20px; margin-top: 10px;">
            <v-icon color="black" style="display: inline-block; vertical-align: middle;">mdi-domain</v-icon>
            Company Name:<span style="font-size: 20px;"> {{ savedJob.company.company_name }}</span>
          </div>
          <div style="font-size: 20px; margin-top: 10px;">
            <v-icon color="black" style="display: inline-block; vertical-align: middle;">mdi-email-box</v-icon>
            Company Email:<span style="font-size: 20px;"> {{ savedJob.company.company_email }}</span>
          </div>
          
        </v-card-text>
        <v-card-actions>
          <v-btn   color="primary"  style=" color: white;" @click="apply(savedJob.job.id)">Apply</v-btn>
          <v-btn @click="deleteItem(savedJob.id)" color="error">Delete</v-btn>
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
