<template>
  <v-card class="user_profile" style="display: flex; flex-direction: column">
    <div class="user_profile_top_bar">
      <v-container class="w_90">
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
    <v-container class="w_90">
      <v-row class="user_profile_infor">
        <v-col
          sm="12"
          md="6"
          lg="8"
          xl="8"
          class="user_profile_infor_left"
          v-if="!hasNullCompany"
        >
          <div class="featured_jobs">
            <div class="sec-title">
              <h2>Experience Jobs</h2>
              <div class="text">
                Know your worth and find the job that qualifies your life
              </div>
            </div>
            <v-card
              class="mx-auto mb-3 mt-2 company_info"
              v-for="(experience, index) in experience"
              :key="index"
            >
              <div class="job_info">
                <v-card-title><a href="#">Experience</a></v-card-title>
                <ul class="company_seat">
                  <li class="mr-2">
                    <v-icon color="#f16666" class="mr-2">mdi-domain</v-icon
                    >{{ experience.company_name }}
                  </li>
                  <li class="mr-2">
                    <v-icon color="#34a853" class="mr-2">mdi-medal </v-icon
                    >{{ experience.position }}
                  </li>
                  <li class="mr-2">
                    <v-icon color="#f9ab00" class="mr-2"
                      >mdi-card-account-details</v-icon
                    >{{ experience.description }}
                  </li>
                </ul>
                <ul class="company_time">
                  <li>{{ experience.start_date }}</li>
                  <li>
                    {{
                      experience.end_date
                        ? experience.end_date
                        : "Currently Working"
                    }}
                  </li>
                </ul>
               
              </div>
            </v-card>
            <!-- <v-card   >
                <v-card-title>Experience</v-card-title>
        <v-table class="education-table">
          
            <thead>
              <tr>
                <th>Company Name</th>
                <th>Position</th>
                <th>Description</th>
                <th>End Date</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(experience, index) in experience" :key="index">
                <td>{{  experience.company_name  }}</td>
                <td>{{experience.position  }}</td>
                <td>{{ experience.description }}</td>
                <td>{{ experience.start_date}}-{{  experience.end_date
                        ? experience.end_date
                        : "Currently Working" }}</td>
              </tr>
            </tbody>
          
        </v-table>
      </v-card> -->
            <div class="sec-title">
              <h2>Education Details</h2>
              <div class="text">
                Know your worth and find the job that qualifies your life
              </div>
            </div>
          <v-card>
                <v-card-title>Education</v-card-title>
        <v-table class="education-table">
          
            <thead>
              <tr>
                <th>School/University</th>
                <th>Education Type</th>
                <th>Starting Year</th>
                <th>Passing Year</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(education, index) in educationDetails" :key="index">
                <td>{{ education.school_university }}</td>
                <td>{{ education.education_type }}</td>
                <td>{{ education.starting_year }}</td>
                <td>{{ education.passing_year }}</td>
              </tr>
            </tbody>
          
        </v-table>
      </v-card>
        
          </div>
        </v-col>
        <v-col
          sm="12"
          md="6"
          lg="8"
          xl="8"
          class="user_profile_infor_left"
          v-else
        >
          <div class="featured_jobs">
            <div class="sec-title">
              <h2>Experience Jobs</h2>
              <div class="text">
                Know your worth and find the job that qualifies your life
              </div>
            </div>
            <v-card>
              <div class="job_info">
                <v-card-title><a href="#">Experience</a></v-card-title>
                <v-card-text>Fresher</v-card-text>
              </div>
            </v-card>

            <div class="sec-title">
              <h2 style="margin-top: 20px">Education Details</h2>
              <div class="text">
                Know your worth and find the job that qualifies your life
              </div>
            </div>
            <v-card>
                <v-card-title>Education</v-card-title>
        <v-table class="education-table">
         
            <thead>
              <tr>
                <th class="text-left" >School/University</th>
                <th class="text-left">Education Type</th>
                <th class="text-left">Starting Year</th>
                <th class="text-left">Passing Year</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(education, index) in educationDetails" :key="index">
                <td>{{ education.school_university }}</td>
                <td>{{ education.education_type }}</td>
                <td>{{ education.starting_year }}</td>
                <td>{{ education.passing_year }}</td>
              </tr>
            </tbody>
        
        </v-table>
      </v-card>
          </div>
        </v-col>
       

        <v-col sm="12" md="6" lg="4" xl="4" class="user_profile_infor_right">
          <v-card>
            <v-card-title
              ><v-icon color="#f16666" style="margin-top: -5px"
                >mdi-domain</v-icon
              ><span class="pt-1"> User Information:</span></v-card-title
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
              ><v-icon color="#34a853">mdi-map-marker</v-icon> User
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
              ><v-icon color="#f9ab00">mdi-briefcase</v-icon> User
              Skills:</v-card-title
            >
            <v-card-text>
              <div v-for="skill in skills" :key="skill.id">
                <span> {{ skill.skill_name }}</span>
              </div>
            </v-card-text>
          </v-card>
       
          <!-- <v-card
            v-for="(educationDetails, index) in educationDetails"
            :key="index"
          >
            <div>
              <v-card-title
                ><v-icon color="#0146a6">mdi-school</v-icon>
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
          </v-card> -->
         
        </v-col>
      </v-row>
    
    </v-container>
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
      window.location.href = "/personal-detail";
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
    // const hasNullCompany = computed(() => {
    //   return experience.value.some(
    //     (exp) =>
    //       exp.company_name === null ||
    //       exp.position === null ||
    //       exp.description === null ||
    //       exp.start_date === null
    //   );
     
    // });
    const hasNullCompany = computed(() => {
    const hasNull = experience.value.some(
      (exp) =>
        exp.company_name === null ||
        exp.position === null ||
        exp.description === null
        
    );
    console.log('Has Null Company:', hasNull);
    return hasNull;
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
      hasNullCompany,
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
.education-table {
  margin-top: 15px;
  border-collapse: collapse; 
}

.education-table th
 {
  padding: 12px; 
  text-align: left; 
  font-weight: 600;
}
.education-table td{
  padding: 12px; 
  text-align: left; 
}
.education-table th {
  background-color: #f0f0f0; 
  
}


.header-cell {
  font-weight: 600; 
}
.v-table > .v-table__wrapper > table > tbody > tr > th, .v-table > .v-table__wrapper > table > thead > tr > th {
  
    font-weight: 600;
    user-select: none;
    text-align: start;
}
/* .w_90 .education-table table thead th.text-left {
  font-weight: 500;
} */

</style>
  