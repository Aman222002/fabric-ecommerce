<template>
  <div class="save_Jobs">
    <div class="sec-title text-center">
      <h2>Save Jobs</h2>
      <div class="text">
        Know your worth and find the job that qualify your life
      </div>
    </div>
    <div class="body_page_section">
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
            <v-card class="mx-auto my-3 company_info">
              <div class="job_info">
                <v-card-title
                  ><a href="#"> {{ savedJob.job.title }}</a>
                </v-card-title>
                <ul class="company_seat">
                  <li>
                    <v-icon>mdi-compare</v-icon
                    >{{ savedJob.company.company_name }}
                  </li>
                  <li>
                    <v-icon>mdi-map-marker-outline </v-icon
                    >{{ savedJob.job.location }}
                  </li>
                  <li>
                    <v-icon>mdi-email-box</v-icon
                    >{{ savedJob.company.company_email }}
                  </li>
                  <li>
                    <v-icon>mdi-school</v-icon>{{ savedJob.job.qualifications }}
                  </li>
                  <li>
                    <v-icon>mdi-currency-rupee</v-icon>{{ savedJob.job.salary }}
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



<style >
/* // save Jobs only */
.body_page_section {
  background: #fff;
  padding: 50px 0 100px;
}
.save_Jobs .sec-title {
  margin-bottom: 50px;
}
.save_Jobs .sec-title h2 {
  position: relative;
  display: block;
  font-size: 30px;
  line-height: 1.2em;
  color: #202124;
  font-weight: 500;
}
.save_Jobs .sec-title .text {
  position: relative;
  margin-top: 15px;
  font-size: 15px;
  line-height: 26px;
  color: #696969;
  font-weight: 400;
}
.save_Jobs a.load_more {
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
.save_Jobs .company_info {
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

.job_info .v-card-title a {
  color: #202124;
  text-decoration: unset;
}
.body_page_section .company_info .v-card-actions button.v-btn {
  color: #fff;
  background-color: #1967d2;
  font-size: 15px;
  border-radius: 8px;
  font-weight: 400;
  height: 100% !important;
  padding: 5px 11px;
  margin-right: 5px;
}
</style>
