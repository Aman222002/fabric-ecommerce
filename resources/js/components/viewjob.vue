<template>
  <div class="employers_search_single">
    <div class="employers_search_single_top">
      <v-container class="w-75">
        <v-row align="center" justify="center">
          <v-col
            cols="auto"
            class="employers_search_col"
            sm="12"
            md="12"
            lg="8"
            xl="8"
          >
            <v-card class="mx-auto my-12 company_info">
              <div class="company_logo">
                <v-img
                  v-if="
                    featuredJob &&
                    featuredJob.company &&
                    featuredJob.company.logo
                  "
                  :src="`/storage/assest/${featuredJob.company.logo}`"
                ></v-img>
              </div>
              <div class="job_info">
                <v-card-title
                  ><a href="#"> {{ featuredJob.title }}</a>
                </v-card-title>
                <ul class="company_seat">
                  <li>
                    <v-icon class="mr-2">mdi-clock-time-two-outline</v-icon
                    >{{ formatCreatedAt(featuredJob.created_at) }}
                  </li>
                  <li
                    v-if="
                      featuredJob &&
                      featuredJob.company &&
                      featuredJob.company.address
                    "
                  >
                    <v-icon class="mr-2">mdi-map-marker</v-icon
                    >{{ featuredJob.company.address.city }}
                  </li>
                </ul>
                <ul class="company_time">
                  <li
                    v-if="
                      featuredJob &&
                      featuredJob.job_type &&
                      featuredJob.job_type.name
                    "
                  >
                    {{ featuredJob.job_type.name }}
                  </li>
                  <li
                    v-if="
                      featuredJob &&
                      featuredJob.category &&
                      featuredJob.category.name
                    "
                  >
                    {{ featuredJob.category.name }}
                  </li>
                </ul>
              </div>
            </v-card>
          </v-col>
          <v-col
            cols="auto"
            class="employers_search_col position-relative"
            sm="12"
            md="12"
            lg="4"
            xl="4"
          >
            <!-- <v-btn size="x-large" class="load_more" to="#"
                >Load More Listing</v-btn
              >
              <a href="#" class="bookmark_fr">
                <v-icon>mdi-bookmark-outline</v-icon>
              </a> -->
            <div class="compamy_infor_btn">
              <v-btn class="apply_for_job" @click="apply">Apply For Job</v-btn>
              <v-btn class="save_btn" color="white" @click="save(jobid)">
                <v-icon color="black">mdi-bookmark-outline</v-icon></v-btn
              >
            </div>
          </v-col>
        </v-row>
      </v-container>
    </div>
    <div class="employers_search_single_body">
      <v-container class="w-75 pt-6">
        <v-row>
          <v-col
            cols="auto"
            sm="12"
            md="12"
            lg="8"
            xl="8"
            class="employers_search_single_left"
          >
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
          <v-col
            cols="auto"
            sm="12"
            md="12"
            lg="4"
            xl="4"
            class="employers_search_single_right"
          >
            <v-card class="company_profile_infor_right">
              <div class="text-h6 mb-1 ml-4 pt-2">Job Overview</div>
              <!-- <v-list-item>
                <template
                  v-slot:prepend
                  v-if="
                    featuredJob &&
                    featuredJob.company &&
                    featuredJob.company.logo
                  "
                >
                  <v-card-text class="pa-0">
                    <img
                      :src="`/storage/assest/${featuredJob.company.logo}`"
                      class="employers_search_company_logo"
                  /></v-card-text>
                </template>
                <template v-slot:append> </template>
              </v-list-item> -->

              <v-card-text class="py-2 job_overview_info">
                <div
                  class="text-h6 mb-1"
                  v-if="
                    featuredJob &&
                    featuredJob.company &&
                    featuredJob.company.company_name
                  "
                >
                  <label for="name" class="ps-0">
                    <v-icon>mdi-domain</v-icon> Company Name:
                  </label>
                  <span> {{ featuredJob.company.company_name }}</span>
                </div>
              </v-card-text>

              <v-card-text class="py-2 job_overview_info">
                <div
                  class="text-h6 mb-1"
                  v-if="
                    featuredJob &&
                    featuredJob.company &&
                    featuredJob.company.company_email
                  "
                >
                  <label for="name" class="ps-0"
                    ><v-icon>mdi-email-outline</v-icon>Company Email:</label
                  >
                  <span>{{ featuredJob.company.company_email }}</span>
                </div>
              </v-card-text>

              <v-card-text class="py-2 job_overview_info">
                <div
                  class="text-h6 mb-1"
                  v-if="
                    featuredJob &&
                    featuredJob.company &&
                    featuredJob.company.created_at
                  "
                >
                  <label for="name" class="ps-0"
                    ><v-icon>mdi-calendar-range</v-icon>Company Created:</label
                  >
                  <span>
                    {{ formatCreatedAt(featuredJob.company.created_at) }}</span
                  >
                </div>
              </v-card-text>

              <v-card-text class="py-2 job_overview_info">
                <div
                  class="text-h6 mb-1"
                  v-if="
                    featuredJob &&
                    featuredJob.company &&
                    featuredJob.company.address
                  "
                >
                  <label for="name" class="ps-0"
                    ><v-icon>mdi-map-marker-outline</v-icon>Company
                    Location:</label
                  >
                  <span>{{ featuredJob.company.address.city }}</span>
                </div>
              </v-card-text>

              <!-- <v-btn size="x-large" class="" to="#">
                      Load More Listing
                    </v-btn> -->
            </v-card>
            <v-card-item>
              <!-- <div
                class="text-h6 mb-1"
                v-if="
                  featuredJob &&
                  featuredJob.company &&
                  featuredJob.company.address
                "
              >
                CompanyLocation:{{ featuredJob.company.address.city }}
              </div> -->
              <div
                class="social-media-icons"
                v-if="
                  featuredJob &&
                  featuredJob.company &&
                  featuredJob.company.social_media_accounts[0]
                "
              >
                <a
                  :href="
                    featuredJob.company.social_media_accounts[0].facebook_url
                  "
                  target="_blank"
                >
                  <v-icon
                    class="mdi mdi-facebook"
                    style="color: #1877f2"
                  ></v-icon>
                </a>
                <a
                  :href="
                    featuredJob.company.social_media_accounts[0].twitter_url
                  "
                  target="_blank"
                >
                  <v-icon
                    class="mdi mdi-twitter"
                    style="color: #1da1f2"
                  ></v-icon>
                </a>
                <a
                  :href="
                    featuredJob.company.social_media_accounts[0].linkedin_url
                  "
                  target="_blank"
                >
                  <v-icon
                    class="mdi mdi-linkedin"
                    style="color: #0a66c2"
                  ></v-icon>
                </a>
                <a
                  :href="
                    featuredJob.company.social_media_accounts[0].instagram_url
                  "
                  target="_blank"
                >
                  <v-icon
                    class="mdi mdi-instagram"
                    style="color: #fa7e1e"
                  ></v-icon>
                </a>
              </div>
              <!-- <iframe
                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3431.5022673812873!2d76.73736487619195!3d30.676141388364538!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390fec06bceb7def%3A0x1931f58b31410a85!2sBetasoft%20Solutions%20Pvt%20Ltd!5e0!3m2!1sen!2sin!4v1709537050814!5m2!1sen!2sin"
                  width="100%"
                  height="350"
                  style="border: 0"
                  allowfullscreen=""
                  loading="lazy"
                  referrerpolicy="no-referrer-when-downgrade"
                ></iframe> -->
            </v-card-item>
          </v-col>
        </v-row>
      </v-container>
    </div>
  </div>
</template>
  <script>
import { ref, onMounted } from "vue";
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

    //   const featuredJob = ref([
    //     {
    //       id: "1",
    //       companyLogo: "assets/img/featured-Jobs/1-1.webp",
    //       title: "Software Engineer (Android), Libraries",
    //       companyName: "Segment",
    //       location: "London, UK",
    //       time: "12:09",
    //       price: "1500$",
    //       companyTime: "Open Jobs – 15",
    //     },
    //   ]);
    const fetchJobs = async (jobid) => {
      console.log(jobid);
      try {
        const response = await axios.get(`/fetchjob/${jobid}`);

        console.log(response.data.data);

        featuredJob.value = response.data.data;
      } catch (err) {
        console.error(err);
      }
    };
    const formatCreatedAt = (createdAt) => {
      const options = { day: "numeric", month: "long", year: "numeric" };
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
      featuredJob,
      formatCreatedAt,
      apply,
      save,
      jobid,
    };
  },
};
</script>

  <style>
button.save_btn {
  color: #1967d2 !important;
  background: #d6e2f7 !important;
}
.employers_search_single_top {
  background-image: url(../assest/img/banner/bg-banner.svg);
}
.employers_search_single_body {
  padding: 30px;
}
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
img.employers_search_company_logo {
  width: 160px;
  height: 100%;
  border-radius: 15px;
}
.employers_search_single_right .company_profile_infor_right .v-card-text label,
.employers_search_single_right .company_profile_infor_right .v-card-text span {
  font-size: 16px;
}
.employers_search_single_right .company_profile_infor_right .v-card-text span {
  margin-left: 37px;
  text-transform: capitalize;
}
h2.job_overview {
  font-weight: 500;
  font-size: 30px;
  line-height: 24px;
  color: #202124;
  padding: 15px;
}
.job_overview_info label i.mdi {
  color: #1967d2;
  margin-right: 10px;
}
</style>