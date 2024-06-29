<template>
  <div class="job-applied">
    <div class="sec-title text-center">
      <h2>My Jobs</h2>
      <!-- <v-breadcrumbs class="breadcrumbs_li" divider="/">
        <v-breadcrumbs-item> Home </v-breadcrumbs-item>
        <v-breadcrumbs-item> / </v-breadcrumbs-item>
        <v-breadcrumbs-item disabled> My Jobs </v-breadcrumbs-item>
      </v-breadcrumbs> -->
      <div class="text">
        Know your worth and find the job that qualify your life
      </div>
    </div>
    <div class="job_applied_body_page_section">
      <v-select
        v-model="filterSelection"
        :items="filterOptions"
        label="Filter" 
        class="job_right"
        density="compact"
        variant="outlined"
      ></v-select>
      <v-container class="w_90 mb-6">
        <v-row class="job_box">
          <v-col
            class="job-applied_col job_box_child"
            v-for="job in filteredJobList"
            :key="job.id"
          >
            <v-card class="mx-auto my-0 company_info job_box_card">
              <div class="job_info">
                <v-card-title>
                  <!-- <a :href="`/jobs/${job.id}`"> {{ job.job.title }}</a> -->
                  <a href="#"> {{ job.job.title }}</a>
                </v-card-title>
                <ul class="company_seat">
                  <li class="mr-2">
                    <v-icon color="#f16666" class="mr-2">mdi-domain</v-icon>
                    {{ job.company.company_name }}
                  </li>
                  <li class="mr-2">
                    <v-icon color="#34a853" class="mr-2"
                      >mdi-map-marker-outline
                    </v-icon>
                    {{ HomeCountryState(job.job.location) }}
                  </li>
                  <li class="mr-2">
                    <v-icon color="#f9ab00" class="mr-2">mdi-email-box</v-icon>
                    {{ job.company.company_email }}
                  </li>
                  <li class="mr-2">
                    <v-icon color="#0146a6" class="mr-2">mdi-school</v-icon>
                    {{ job.job.qualifications }}
                  </li>
                  <li class="mr-2">
                    <v-icon color="#8bc34a" class="mr-2"
                      >mdi-currency-gbp</v-icon>
                    {{ job.job.salary }}
                  </li>
                </ul>
              </div>
              <v-card-actions>
                <v-btn v-if="filterSelection === 'Saved Jobs'" @click="apply(job.job_id)" class="apply">Apply</v-btn>
                <v-icon
                  @click="deleteItem(job.id)"
                  color="red"
                  class="delete-icon"
                  >mdi-delete-outline
                </v-icon>
              </v-card-actions>
            </v-card>
          </v-col>

          <v-alert type="error" class="no_job_found w-100" @click="redirectToPreviousPage" v-if=" filterSelection === 'Applied Jobs' &&noJobsFound ">
            No jobs found.
          </v-alert>
          <v-alert type="error" @click="redirectToPreviousPage" class="no_job_found w-100" v-if="noJobsApplied && filterSelection === 'Saved Jobs' ">
            No saved jobs.
          </v-alert>
        </v-row>
      </v-container>
    </div>
  </div>
</template>

<script>
import { ref, watch } from "vue";
import axios from "axios";
import {Sweetalert} from '../utils/sweetalert';
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
  save: {
      type: Array,
      default: () => [],
     
    },
  },
  setup(props) {
    console.log(props);
    const appliedJobs = ref(props.data);
    const savedJobs = ref(props.save);
    const filterOptions = ["Applied Jobs", "Saved Jobs"];
    const filterSelection = ref("Applied Jobs");
    const filteredJobList = ref([]);

    const updateFilteredJobList = () => {
      switch (filterSelection.value) {
        case "Applied Jobs":
          filteredJobList.value = appliedJobs.value;
          break;
        case "Saved Jobs":
          filteredJobList.value = savedJobs.value;
          console.log( filteredJobList.value);
          break;
      }
    };

    watch(filterSelection, updateFilteredJobList, { immediate: true });

    const deleteItem = async (id) => {
      window.Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then(async (result) => {
        if (result.isConfirmed) {
          window.Swal.fire({
            title: "Deleted!",
            text: "Your file has been deleted.",
            icon: "success",
          });
          try {
            let url = filterSelection.value === "Applied Jobs"
              ? `/remove-applied-jobs/${id}`
              : `/removesavedjobs/${id}`;
            let response = await axios.post(url);
            if (response.data.status === true) {
              window.location.reload();
            } else {
              console.log("Request was not successful:", response.data.message);
            }
          } catch (err) {
            console.log(err);
          }
        }
      });
    };

    //  const noJobsFound = ref(false);
    // watch(filteredJobList, (newList) => {
    //   noJobsFound.value = newList.length === 0;
    // });
    const noJobsFound = ref(false);
    if(appliedJobs.value.length===0){
      noJobsFound.value= true;
    }
    const noJobsApplied = ref(false);
    if ( savedJobs.value.length === 0) {
      noJobsApplied.value = true;
    }
    const apply = async (job_id) => {
      try {
        await axios.post(`/apply-job/${job_id}`).then((response) => {
          if (response.data.status == true) {
           
            Sweetalert.success('Applied Successfully')
            window.location.reload();
          }
        });
      } catch (err) {
        console.error(err);
        Sweetalert.error('Already Apply For This')
      }
    };
    const redirectToPreviousPage = () => {
      window.location.reload();
    };
    return {
      filterOptions,
      filterSelection,
      filteredJobList,
      deleteItem,
      HomeCountryState,
      noJobsFound,noJobsApplied,apply,redirectToPreviousPage
     
    };
  },
};
</script>
<style>
.apply {
    color: #fff;
    background-color: #0146a6;
    font-size: 15px;
    border-radius: 8px;
    font-weight: 400;
    height: 40px !important;
    padding: 5px 11px;
    margin-right: 5px;
}
.job_right {
 margin-left: 80px;
  margin-bottom: 30px;
}
.job_right .v-input {
  width: 155px;
}

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