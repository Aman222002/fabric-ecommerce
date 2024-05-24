<template>
  <div class="job-applied">
    <div class="sec-title text-center">
      <h2>Job Applied</h2>
      <v-breadcrumbs class="breadcrumbs_li" divider="/">
        <v-breadcrumbs-item> Home </v-breadcrumbs-item>
        <v-breadcrumbs-item> / </v-breadcrumbs-item>
        <v-breadcrumbs-item disabled> Job Applied </v-breadcrumbs-item>
      </v-breadcrumbs>
      <div class="text">
        Know your worth and find the job that qualify your life
      </div>
    </div>
    <div class="job_applied_body_page_section">
      <v-container class="w_90 mb-6">
        <v-row class="job_box">
          <v-col
            class="job-applied_col job_box_child"
            v-for="jobApplication in jobApplications"
            :key="jobApplication.id"
          >
            <v-card class="mx-auto my-0 company_info job_box_card">
              <div class="job_info">
                <v-card-title
                  ><a href="#"> {{ jobApplication.job.title }}</a>
                </v-card-title>
                <ul class="company_seat">
                  <li class="mr-2">
                    <v-icon color="#f16666" class="mr-2">mdi-domain</v-icon
                    >{{ jobApplication.company.company_name }}
                  </li>
                  <li class="mr-2">
                    <v-icon color="#34a853" class="mr-2"
                      >mdi-map-marker-outline
                    </v-icon>
                    {{ HomeCountryState(jobApplication.job.location) }}
                  </li>
                  <li class="mr-2">
                    <v-icon color="#f9ab00" class="mr-2">mdi-email-box</v-icon
                    >{{ jobApplication.company.company_email }}
                  </li>
                  <li class="mr-2">
                    <v-icon color="#0146a6" class="mr-2">mdi-school</v-icon
                    >{{ jobApplication.job.qualifications }}
                  </li>
                  <li class="mr-2">
                    <v-icon color="#8bc34a" class="mr-2"
                      >mdi-currency-gbp</v-icon
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
          
          <v-alert type="error" class="no_job_found w-100" v-if="noJobsApplied">
            Not Applied For Any Job.
          </v-alert>
        </v-row>
      </v-container>
    </div>
  </div>
</template>
<script>
import { ref } from "vue";
import axios from "axios";
const HomeCountryState = (countryStateName) => {
  if (countryStateName && countryStateName.length > 15) {
    return countryStateName.substring(0, 15) + "....";
  }
  return countryStateName;
};
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
    const noJobsApplied = ref(false);
    if (jobApplications.value.length === 0) {
      noJobsApplied.value = true;
    }
    return {
      jobApplications,
      deleteItem,
      HomeCountryState,noJobsApplied
    };
  },
};
</script>

<style>
.job_box {
  gap: 30px;
}
.job_box_child {
  height: auto;
  box-shadow: 0px 1px 8px 0px #c7c4c4;
  border-radius: 5px;
  background-color: #fff;
  flex: 0 0 50%;
  max-width: calc(max(48%, 50% - 20px));
  margin: 0 auto;
}

.job_box .job_box_child .job_box_card {
  box-shadow: unset;
}

@media (max-width: 1200px) {
  .job_box_child {
    flex: 0 0 100%;
    max-width: calc(max(100%, 100% - 20px));
  }
}
@media (max-width: 650px) {
  .job_box_child {
    flex: 0 0 90%;
    max-width: calc(max(90%, 90% - 20px));
    margin: 0 auto;
  }
}
</style>