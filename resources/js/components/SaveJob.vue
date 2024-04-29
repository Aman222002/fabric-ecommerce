<template>
  <div class="save_Jobs">
    <div class="sec-title text-center">
      <h2>Save Jobs</h2>
      <div class="text">
        Know your worth and find the job that qualify your life
      </div>
    </div>
    <div class="save_job_body_page_section">
      <v-container class="w-75 mb-6">
        <v-row align="center" justify="center">
          <v-col
            cols="auto"
            class="save_Jobs_col job-card"
            sm="12"
            md="12"
            lg="6"
            xl="6"
            v-for="savedJob in savedJobs"
            :key="savedJob.id"
          >
            <v-card class="mx-auto my-0 company_info">
              <div class="job_info">
                <v-card-title
                  ><a href="#"> {{ savedJob.job.title }}</a>
                </v-card-title>
                <ul class="company_seat">
                  <li>
                    <v-icon color="#f16666" class="mr-2">mdi-domain</v-icon
                    >{{ savedJob.company.company_name }}
                  </li>
                  <li>
                    <v-icon color="#34a853" class="mr-2"
                      >mdi-map-marker-outline </v-icon
                    >{{ savedJob.job.location }}
                  </li>
                  <li>
                    <v-icon color="#f9ab00" class="mr-2">mdi-email-box</v-icon
                    >{{ savedJob.company.company_email }}
                  </li>
                  <li>
                    <v-icon color="#1967d2" class="mr-2">mdi-school</v-icon
                    >{{ savedJob.job.qualifications }}
                  </li>
                  <li>
                    <v-icon color="#8bc34a" class="mr-2"
                      >mdi-currency-gbp</v-icon
                    >{{ savedJob.job.salary }}
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
                <v-btn @click="apply(savedJob.job.id)">Apply</v-btn>

                <v-icon
                  @click="deleteItem(savedJob.id)"
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



