<template>
  <div class="job-applied">
    <div class="sec-title text-center">
      <h2>Featured Jobs</h2>
      <div class="text">
        Know your worth and find the job that qualify your life
      </div>
    </div>
    <div class="body_page_section">
      <v-container class="w-75 mb-6">
        <v-row align="center" justify="center">
          <v-col
            cols="auto"
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
  margin-bottom: 50px;
}
.job-applied .sec-title h2 {
  position: relative;
  display: block;
  font-size: 30px;
  line-height: 1.2em;
  color: #202124;
  font-weight: 500;
}
.job-applied .sec-title .text {
  position: relative;
  margin-top: 15px;
  font-size: 15px;
  line-height: 26px;
  color: #696969;
  font-weight: 400;
}
.job-applied a.load_more {
  font-size: 19px;
  line-height: 20px;
  border-radius: 8px;
  font-weight: 400;
  padding: 15px 28px;
  background-color: #1967d2;
  text-decoration: unset;
  display: table;
  color: #fff;
}
.job-applied .company_info {
  padding: 15px;
  width: 100%;
  display: flex;
  background: #f5f7fc;
}

.job_info .v-card-title {
  padding-top: 0;
}
.job_info ul {
  display: flex;
  justify-content: flex-start;
  flex-direction: row;
  flex-wrap: wrap;
  padding-left: 13px;
  list-style: none;
}
.job_info ul li {
  font-size: 15px;
  margin-right: 15px;
}
.job_info ul li i {
  font-size: 19px;
}
.job_info ul.company_time {
  margin-top: 8px;
}
.job_info ul.company_time li {
  position: relative;
  font-size: 13px;
  line-height: 15px;
  margin-right: 15px;
  padding: 5px 20px;
  border-radius: 50px;
  margin-bottom: 10px;
  background: rgba(25, 103, 210, 0.15);
  color: #1967db;
}
.job_info ul.company_time li:nth-child(2) {
  background: #93faae;
  color: #34a853;
}
.job_info ul.company_time li:nth-child(3) {
  background: #fddb91;
  color: #ffae00;
}
.bookmark_fr {
  position: absolute;
  top: 5%;
  right: 2%;
  font-size: 25px;
}
.job_info .v-card-title a {
  color: #202124;
  text-decoration: unset;
}
.body_page_section .company_info .v-card-actions {
  position: absolute;
  right: 0;
  top: 0;
}
</style>