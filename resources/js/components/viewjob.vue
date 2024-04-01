<template>
  <div v-if="featuredJob && featuredJob.title" class="employers_search_single">
    <div class="employers_search_single_top">
      <v-container class="w-75 mb-6">
        <v-row align="center" justify="center">
          <v-col cols="auto" class="employers_search_col" sm="12" md="12" lg="8" xl="8">
            <v-card class="mx-auto my-12 company_info">
              <!-- <div class="company_logo">
                  <v-img v-if="featuredJob && featuredJob.company && featuredJob.company.logo" :src="`/storage/assest/${featuredJob.company.logo}`"></v-img>
              </div> -->
              <div class="job_info">
                <v-card-title><a href="#"> {{ featuredJob.title }}</a>
                </v-card-title>
                <ul class="company_seat">
                  <li>
                    <v-icon>mdi-clock-time-two-outline</v-icon>{{ formatCreatedAt(featuredJob.created_at) }}
                  </li>

                </ul>
                <ul class="company_time">
                  <li v-if="featuredJob && featuredJob.job_type && featuredJob.job_type.name">{{
    featuredJob.job_type.name }}</li>
                  <li v-if="featuredJob && featuredJob.category && featuredJob.category.name">{{ featuredJob.category
    .name }}</li>

                </ul>

              </div>

            </v-card>
          </v-col>
          <v-col cols="auto" class="employers_search_col position-relative" sm="12" md="12" lg="4" xl="4">
            <!-- <v-btn size="x-large" class="load_more" to="#"
              >Load More Listing</v-btn
            >
            <a href="#" class="bookmark_fr">
              <v-icon>mdi-bookmark-outline</v-icon>
            </a> -->
            <div class="compamy_infor_btn">
              <v-btn class="apply_for_job" @click="apply">Apply For Job</v-btn>
              <v-btn class="save_btn" color="white" @click="save(jobid)">
                <v-icon color="black">mdi-bookmark-outline</v-icon></v-btn>
              <!-- <v-btn icon class="share-btn" @click="shareJob">
              <v-icon>mdi-share</v-icon>
            </v-btn> -->
            </div>
          </v-col>
        </v-row>
      </v-container>
    </div>
    <div class="employers_search_single_body">
      <v-container class="w-75 mb-6">
        <v-row>
          <v-col cols="auto" sm="12" md="12" lg="8" xl="8" class="employers_search_single_left">
            <v-card class="mx-auto">
              <v-card-item>
                <div class="text-h6 mb-1">Job Description</div>
                <div class="text-caption">
                  {{ featuredJob.description }}
                </div>
              </v-card-item>

              <v-card-item>
                <div class="text-h6 mb-1">Experience</div>
                <ul>
                  <li>
                    {{ featuredJob.experience }}
                  </li>
                </ul>
              </v-card-item>
              <v-card-item>
                <div class="text-h6 mb-1">Skill</div>
                <ul>
                  <li>
                    {{ featuredJob.skill_name }}
                  </li>
                </ul>
              </v-card-item>
              <v-card-item>
                <div class="text-h6 mb-1">Salary</div>
                <ul>
                  <li>
                    {{ featuredJob.salary }}
                  </li>
                </ul>
              </v-card-item>
              <v-card-item>
                <div class="text-h6 mb-1">Qualification</div>
                <ul>
                  <li>
                    {{ featuredJob.qualifications }}
                  </li>
                </ul>
              </v-card-item>
            </v-card>
          </v-col>
          <v-col cols="auto" sm="12" md="12" lg="4" xl="4" class="employers_search_single_right">
            <v-card-item>
              <v-row>

                <v-col cols="auto" sm="12" md="12" lg="12" xl="12">

                  <v-list-item>
                    <template v-slot:prepend>

                    </template>
                    <template v-slot:append v-if="featuredJob && featuredJob.company && featuredJob.company.logo">
                      <v-card-text class="pb-0">
                        <img :src="`/storage/assest/${featuredJob.company.logo}`" class="company_logo"></v-card-text>
                    </template>
                  </v-list-item>
                  <v-list-item>
                    <template v-slot:prepend>
                      <v-card-title class="p-0">
                        Company Name
                      </v-card-title>
                    </template>
                    <template v-slot:append
                      v-if="featuredJob && featuredJob.company && featuredJob.company.company_name">
                      <v-card-text class="pb-0"> {{ featuredJob.company.company_name }} </v-card-text>
                    </template>
                  </v-list-item>
                  <v-list-item>
                    <template v-slot:prepend>
                      <v-card-title class="p-0"> Company Email: </v-card-title>
                    </template>
                    <template v-slot:append
                      v-if="featuredJob && featuredJob.company && featuredJob.company.company_email">
                      <v-card-text class="pb-0"> {{ featuredJob.company.company_email }} </v-card-text>
                    </template>
                  </v-list-item>
                  <v-list-item>
                    <template v-slot:prepend>
                      <v-card-title class="p-0"> Company Created: </v-card-title>
                    </template>
                    <template v-slot:append v-if="featuredJob && featuredJob.company && featuredJob.company.created_at">
                      <v-card-text class="pb-0"> {{ formatCreatedAt(featuredJob.company.created_at) }} </v-card-text>
                    </template>

                  </v-list-item>
                  <v-list-item>
                    <template v-slot:prepend>
                      <v-card-title class="p-0"> Company Location: </v-card-title>
                    </template>
                    <template v-slot:append v-if="featuredJob && featuredJob.company && featuredJob.company.address">
                      <v-card-text class="pb-0"> {{ featuredJob.company.address.city }} </v-card-text>
                    </template>

                  </v-list-item>

                </v-col>
              </v-row>
            </v-card-item>
            <v-card-item>

              <div class="social-media-icons"
                v-if="featuredJob && featuredJob.company && featuredJob.company.social_media_accounts[0]">
                <a :href="featuredJob.company.social_media_accounts[0].facebook_url" target="_blank">
                  <v-icon class="mdi mdi-facebook" style="color: 	#1877F2;"></v-icon>

                </a>
                <a :href="featuredJob.company.social_media_accounts[0].twitter_url" target="_blank">
                  <v-icon class="mdi mdi-twitter" style="color: 	#1DA1F2;"></v-icon>
                </a>
                <a :href="featuredJob.company.social_media_accounts[0].linkedin_url" target="_blank">
                  <v-icon class="mdi mdi-linkedin" style="color: 	#0A66C2;"></v-icon>
                </a>
                <a :href="featuredJob.company.social_media_accounts[0].instagram_url" target="_blank">
                  <v-icon class="mdi mdi-instagram" style="color: 	#fa7e1e;"></v-icon>
                </a>
              </div>

            </v-card-item>
          </v-col>
        </v-row>
      </v-container>
    </div>
  </div>
</template>
<script>

import { ref, onMounted } from 'vue';
import { useUsersStore } from "../store/user";
import axios from "axios";
export default {
  name: "viewjob",
  props: {
    data: {
      type: Number,
      default: () => 0,
    },
  },
  setup(props) {
    console.log(props.data);
    const jobid = props.data;
    const usersStore = useUsersStore();
    const featuredJob = ref({});
    const fetchJobs = async (jobid) => {
      console.log(jobid)
      try {
        const response = await axios.get(`/fetchjob/${jobid}`);

        console.log(response.data.data);

        featuredJob.value = response.data.data;
      } catch (err) {
        console.error(err);

      }
    };
    const formatCreatedAt = (createdAt) => {
      const options = { day: 'numeric', month: 'long', year: 'numeric' };
      return new Date(createdAt).toLocaleDateString(undefined, options);
    };
    onMounted(() => {
      fetchJobs(jobid);
    });
    const apply = async () => {

      if (!usersStore.isloggedin) {
        window.Swal.fire({
          title: "Login Required",
          text: "Please log in to apply for this job.",
          icon: "warning",
          confirmButtonText: "OK",
        });
        return;
      }
      try {
        await axios.post(`/apply-job/${jobid}`).then((response) => {
          if (response.data.status == true) {

            window.Swal.fire({
              icon: "success",
              title: "Applied Successfully",
              text: "Applied successfully ",
              confirmButtonText: "OK",
            });
            window.location.href = response.data.company_url;
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
    const save = async () => {
      try {
        await axios.post(`/save-job/${jobid}`).then((response) => {
          if (response.data.status == true) {

            window.Swal.fire({
              icon: "success",
              title: "Saved Successfully",

              confirmButtonText: "OK",
            });
          }
        });
      } catch (err) {
        console.error(err);
        window.Swal.fire({
          title: "Application Failed",
          text: "You Already saved this Job",
          icon: "error",
          confirmButtonText: "OK",
        });
      }
    };


    return {
      featuredJob, formatCreatedAt, apply, save, jobid,

    };
  }
};
</script>

<style>
.employers_search_single .company_info {
  box-shadow: unset;
}

.employers_search_col .company_info {
  display: flex;
  background: transparent;
}

.employers_search_single_right a.v-btn--variant-elevated {
  background: #e2eaf8;
  color: #1967d2;
}

.social-media-icons {
  display: flex;
  justify-content: center;
  margin-top: 10px;
}

.social-media-icons a {
  margin-right: 10px;
  color: #000;
}
</style>