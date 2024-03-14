<template>
  <div class="job-applied">
    <div class="sec-title text-center">
      <h2>Jobs Applied</h2>
      <div class="text">
        Know your worth and find the job that qualify your life
      </div>
    </div>
    <div class="body_page_section">
      <v-container class="w-75 mb-6">
        <v-row align="center" justify="center">
          <v-col
            cols="12"
            class="job-applied_col job-card"
            sm="12"
            md="12"
            lg="6"
            xl="6"
            v-for="jobApplication in jobApplications"
            :key="jobApplication.id"
          >
            <v-card class="mx-auto my-3 company_info">
              <div class="job_info">
                <v-card-title
                  ><a href="#"> {{ jobApplication.job.title }}</a>
                </v-card-title>
                <ul class="company_seat">
                  <li>
                    <v-icon>mdi-compare</v-icon
                    >{{ jobApplication.company.company_name }}
                  </li>
                  <li>
                    <v-icon>mdi-map-marker-outline </v-icon
                    >{{ jobApplication.job.location }}
                  </li>
                  <li>
                    <v-icon>mdi-email-box</v-icon
                    >{{ jobApplication.company.company_email }}
                  </li>
                  <li>
                    <v-icon>mdi-school</v-icon
                    >{{ jobApplication.job.qualifications }}
                  </li>
                  <li>
                    <v-icon>mdi-currency-rupee</v-icon
                    >{{ jobApplication.job.salary }}
                  </li>
                  <!-- <li>
                  <v-icon>mdi-desktop-classic</v-icon
                  >{{ jobApplication.job.experience }}
                </li> -->
                  <!-- <li>
                  <v-icon>mdi-clock-time-two-outline</v-icon
                  >{{ featuredJob.time }}
                </li> -->
                </ul>
                <!-- <ul class="company_time">
                <li>{{ featuredJob.companyTime }}</li>
                <li>{{ featuredJob.companyStates }}</li>
                <li>{{ featuredJob.projectDuration }}</li>
              </ul> -->
              </div>

              <v-card-actions>
                <v-icon
                  @click="deleteItem(jobApplication.id)"
                  color="red"
                  class="delete-icon"
                  >mdi-delete-outline
                </v-icon>
              </v-card-actions>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </div>
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
    console.log(jobApplications.value);
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


<style >
/* // job applied only */
.body_page_section {
  background: #fff;
  padding: 50px 0 100px;
}
.job-applied .sec-title {
  margin: 50px 0;
}
.job-applied .sec-title h2 {
  position: relative;
  display: block;
  font-size: 30px;
  line-height: 1.2em;
  color: #202124;
  font-weight: 500;
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

.v-icon:hover {
  transform: scale(1.2);
}
</style>