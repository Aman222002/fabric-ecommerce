<template>
  <v-card class="user_profile" style="display: flex; flex-direction: column">
    <div class="user_profile_top_bar">
      <v-container>
        <v-row>
          <v-icon @click="goToEditPage()" style="margin-left: 97%"
            >mdi-pencil</v-icon
          >
          <div
            style="
              align-items: center;
              display: flex;
              margin-left: 18px;
              position: relative;
            "
          >
            <v-progress-circular
              :size="150"
              :width="9"
              v-model="progressValue"
              :color="progressColor"
            >
            </v-progress-circular>
            <v-avatar
              size="130px"
              class="avatar"
              style="position: absolute; top: 10px; left: 10px"
            >
              <!-- <img
            :src="`/storage/assest/${user.user_image}`"
           
            width="150px"
            height="150px"
          /> -->
              <img
                :src="
                  user.user_image
                    ? `/storage/assest/${user.user_image}`
                    : '/storage/assest/img1.png'
                "
                width="150px"
                height="150px"
              />
            </v-avatar>
          </div>
          <v-col cols="4" style="margin-left: 10px; margin-top: 10px">
            <p style="font-size: 30px">{{ user.name }}</p>
            <template v-if="address.city || address.state || address.zip_code">
              <div>
                <v-icon style="font-size: 15px">mdi-map-marker</v-icon>
                {{ address.city }}, {{ address.state }}, {{ address.zip_code }}
              </div>
            </template>
          </v-col>
        </v-row>
      </v-container>
    </div>

    <v-container>
      <v-row class="user_profile_infor">
        <v-col sm="12" md="6" lg="8" xl="8" class="user_profile_infor_left">
          <!-- Description -->
          <!-- <v-card class="card2" style="margin-bottom: 20px">
            <v-card-title
              ><v-icon>mdi-domain</v-icon> Candidates About:
            </v-card-title>
            <v-card-text>
              <div style="font-family: sans-serif">
                Hello my name is Nicole Wells and web developer from Portland.
                In pharetra orci dignissim, blandit mi semper, ultricies diam.
                Suspendisse malesuada suscipit nunc non volutpat. Sed porta
                nulla id orci laoreet tempor non consequat enim. Sed vitae
                aliquam velit. Aliquam ante erat, blandit at pretium et,
                accumsan ac est. Integer vehicula rhoncus molestie. Morbi ornare
                ipsum sed sem condimentum, et pulvinar tortor luctus.
                Suspendisse condimentum lorem ut elementum aliquam. Mauris nec
                erat ut libero vulputate pulvinar. Aliquam ante erat, blandit at
                pretium et, accumsan ac est. Integer vehicula rhoncus molestie.
                Morbi ornare ipsum sed sem condimentum, et pulvinar tortor
                luctus. Suspendisse condimentum lorem ut elementum aliquam.
                Mauris nec erat ut libero vulputate pulvinar.
              </div>
            </v-card-text>
          </v-card> -->
          <div class="featured_jobs">
            <div class="sec-title">
              <h2>Experience Jobs</h2>
              <div class="text">
                Know your worth and find the job that qualify your life
              </div>
            </div>

            <v-card
              class="mx-auto mb-3 mt-2 company_info"
              v-for="(experience, index) in experience"
              :key="index"
            >
              <!-- <div class="company_logo">
                <v-img
                  :src="`http://127.0.0.1:8000/${featuredJob.companyLogo}`"
                ></v-img>
              </div> -->
              <div class="job_info">
                <v-card-title><a href="#"> Experience</a> </v-card-title>
                <ul class="company_seat">
                  <li>
                    <v-icon color="#f16666" class="mr-2">mdi-domain</v-icon
                    >{{ experience.company_name }}
                  </li>
                  <li>
                    <v-icon color="#34a853" class="mr-2">mdi-medal </v-icon
                    >{{ experience.position }}
                  </li>
                  <li>
                    <v-icon color="#f9ab00" class="mr-2"
                      >mdi-card-account-details</v-icon
                    >{{ experience.description }}
                  </li>
                </ul>
                <ul class="company_time">
                  <li>{{ experience.start_date }}</li>
                  <li>{{ experience.end_date }}</li>
                </ul>
              </div>
            </v-card>
          </div>
        </v-col>

        <v-col sm="12" md="6" lg="4" xl="4" class="user_profile_infor_right">
          <v-card>
            <v-card-title
              ><v-icon color="#f16666">mdi-domain</v-icon> Candidates
              Information:</v-card-title
            >
            <v-card-text>
              <div>
                <label for="name" class="ps-0">Representative Name:</label>
                <span>{{ user.name }}</span>
              </div>
              <div>
                <label for="email" class="ps-0">Email:</label>
                <span>{{ user.email }}</span>
              </div>
              <div>
                <label for="phone" class="ps-0">Contact No:</label>
                <span>{{ user.phone }}</span>
              </div>
            </v-card-text>
          </v-card>

          <v-card>
            <v-card-title
              ><v-icon color="#34a853">mdi-map-marker</v-icon> Candidates
              Address:</v-card-title
            >
            <v-card-text>
              <div>
                <label class="ps-0">City:</label>
                <span>{{ address.city }}</span>
              </div>
              <div>
                <label class="ps-0">State:</label>
                <span>{{ address.state }}</span>
              </div>
              <div>
                <label class="ps-0">Pin Code:</label>
                <span>{{ address.zip_code }}</span>
              </div>
            </v-card-text>
          </v-card>

          <v-card>
            <v-card-title
              ><v-icon color="#f9ab00">mdi-briefcase</v-icon> Candidates
              Skills:</v-card-title
            >
            <v-card-text>
              <div v-for="skill in skills" :key="skill.id">
                <span> {{ skill.skill_name }}</span>
              </div>
            </v-card-text>
          </v-card>

          <!-- Qualifications  -->
          <v-card>
            <div
              v-for="(educationDetails, index) in educationDetails"
              :key="index"
            >
              <v-card-title
                ><v-icon color="#1967d2">mdi-school</v-icon>
                Qualifications:<br />
                {{ educationDetails.education_type }}</v-card-title
              >
              <v-card-text>
                <div>
                  <label class="ps-0">School:</label>
                  <span>{{ educationDetails.school_university }}</span>
                </div>
                <div>
                  <label class="ps-0">Education:</label>
                  <span>{{ educationDetails.education_type }}</span>
                </div>
                <div>
                  <label class="ps-0">Starting Date:</label>
                  <span>{{ educationDetails.starting_year }}</span>
                </div>
                <div>
                  <label class="ps-0">End Date:</label>
                  <span>{{ educationDetails.passing_year }}</span>
                </div>
              </v-card-text>
            </div>
          </v-card>
        </v-col>
      </v-row>
    </v-container>

    <!-- <v-tabs>
      <v-tab
        :class="{ active: showOverview }"
        @click="
          showOverview = true;
          showJob = false;
          showDescription = false;
        "
        >Overview</v-tab
      >
      <v-tab
        :class="{ active: showJob }"
        @click="
          showOverview = false;
          showJob = true;
          showDescription = false;
        "
        >Skills</v-tab
      >
      <v-tab
        :class="{ active: showDescription }"
        @click="
          showOverview = false;
          showJob = false;
          showDescription = true;
        "
        >Qualifications</v-tab
      >
    </v-tabs>

    <v-tab-item v-if="!showJob && !showDescription && showOverview">
      <div style="display: flex; margin-top: 20px">
        <v-card style="margin-bottom: 20px; width: 80%">
          <v-card-title style="font-size: 16px"
            ><v-icon>mdi-account</v-icon>Details:</v-card-title
          >
          <v-card-text>
            <label for="name" class="ps-0" style="font-weight: bold">
              Name:</label
            >
            <span>{{ user.name }}</span
            ><br /><br />
            <label for="email" class="ps-0" style="font-weight: bold"
              >Email:</label
            >
            <span>{{ user.email }}</span
            ><br /><br />
            <label for="phone" class="ps-0" style="font-weight: bold"
              >Contact No:</label
            >
            <span style="margin-left: 28%">{{ user.phone }}</span>
          </v-card-text>
        </v-card>
        <v-card style="margin-bottom: 20px; width: 80%; margin-left: 40px">
          <v-card-title style="font-size: 16px"
            ><v-icon>mdi-map-marker</v-icon> Details:</v-card-title
          >
          <v-card-text>
            <label for="company name" class="ps-0" style="font-weight: bold"
              >City</label
            >
            <span style="margin-left: 25%">{{ address.city }}</span
            ><br /><br />
            <label for="company name" class="ps-0" style="font-weight: bold"
              >State</label
            >
            <span style="margin-left: 26%">{{ address.state }}</span
            ><br /><br />
            <label for="companyemail" class="ps-0" style="font-weight: bold"
              >Pin Code</label
            >
            <span style="margin-left: 25%">{{ address.zip_code }}</span>
          </v-card-text>
        </v-card>
      </div>
    </v-tab-item>
    <v-tab-item v-if="showDescription && !showOverview && !showJob">
      <v-card class="card2" style="margin-bottom: 20px; font-size: 16px">
        <v-card-title style="font-size: 16px"
          ><v-icon>mdi-school</v-icon>Qualifications:</v-card-title
        >
        <v-table>
          <template v-slot:default>
            <thead>
              <tr>
                <th class="text-left">School</th>
                <th class="text-left">Education</th>
                <th class="text-left">Starting Date</th>
                <th class="text-left">End Date</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(educationDetails, index) in educationDetails"
                :key="index"
              >
                <td>{{ educationDetails.school_university }}</td>
                <td>{{ educationDetails.education_type }}</td>
                <td>{{ educationDetails.starting_year }}</td>
                <td>{{ educationDetails.starting_year }}000</td>
              </tr>
            </tbody>
          </template>
        </v-table>
      </v-card>
    </v-tab-item>
    <v-tab-item v-if="showJob">
      <v-card class="card2" style="margin-bottom: 20px; font-size: 16px">
        <v-card-title style="font-size: 16px">Skills:</v-card-title>
        <v-card-text>
          <template v-if="skills.length > 0">
            <ul>
              <li v-for="skill in skills" :key="skill.id">
                {{ skill.skill_name }}
              </li>
            </ul>
          </template>
          <template v-else>
            <p>No skills available</p>
          </template>
        </v-card-text>
      </v-card>
    </v-tab-item>
     -->
  </v-card>
</template>
  
  <script>
import { ref, onMounted, computed } from "vue";
import axios from "axios";

export default {
  name: "UserProfile",
  setup() {
    const progressValue = ref(0);
    const address = ref([]);
    const user = ref([]);
    const educationDetails = ref([]);
    const experience = ref([]);
    const skills = ref([]);
    const showOverview = ref(true);
    const showJob = ref(false);
    const showDescription = ref(false);
    const image = ref(null);

    const fetchuserProfile = async () => {
      try {
        const response = await axios.get(`/my-profile`);

        const { data } = response.data;
        user.value = data.userDetails;
        address.value = data.address;
        educationDetails.value = data.educationDetails;
        experience.value = data.experience;
        skills.value = data.skills;
        progressValue.value = data.userDetails.status;
        console.log(experience.value);
      } catch (error) {
        console.error("Error fetching company profile:", error);
      }
    };
    onMounted(() => {
      fetchuserProfile();
    });
    const goToEditPage = async () => {
      window.location.href = "/resume";
    };
    const handleImageChange = (event) => {
      const file = event.target.files[0];
      image.value = file;
    };
    const progressColor = computed(() => {
      if (progressValue.value >= 100) {
        return "green";
      } else if (progressValue.value >= 75) {
        return "orange";
      } else if (progressValue.value >= 50) {
        return "yellow";
      } else {
        return "blue";
      }
    });

    return {
      address,
      user,
      fetchuserProfile,
      educationDetails,
      experience,
      goToEditPage,
      progressValue,
      skills,
      showOverview,
      showJob,
      showDescription,
      handleImageChange,
      progressValue,
      progressColor,
    };
  },
};
</script>
  
<style >
.active {
  color: white;
}

.user-name {
  color: white;
  background-color: black;
}
.user_profile_infor_right .v-card-text div {
  display: flex;
  justify-content: space-between;
  margin-bottom: 15px;
}
.user_profile_top_bar {
  background-image: linear-gradient(to right, #f3f6fb, #bfd1f1);
  padding: 15px 0;
}
.user_profile_infor_right .v-card {
  padding: 30px 27px;
  background: #fff;
  border-radius: 8px;
  margin-bottom: 40px;
  width: 75%;
}

.user_profile_infor_right .v-card .v-card-text {
  padding: 0;
}
.user_profile_infor_right .v-card-title {
  padding-left: 0;
  font-weight: 600;
}
.user_profile_infor_right .v-card-text label {
  font-weight: 600;
}
</style>
  