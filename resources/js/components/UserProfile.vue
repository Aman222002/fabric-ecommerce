<template>
 
    <v-card style=" display: flex; flex-direction: column;">
      <div class="background-image"></div>
      <v-icon @click="goToEditPage()" style=" margin-left: 97%;">mdi-pencil</v-icon>
        <v-row>
          <div style="align-items: center; display: flex; margin-left: 18px;position: relative;">
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
              style="position: absolute; top: 10px; left: 10px;"
             >
              <img
            :src="`/storage/assest/${user.user_image}`"
            alt="Selected Image"
            width="150px"
            height="150px"
          />
         
          
            </v-avatar>
            
         
          </div>
         
          
          <v-col cols="4" style="margin-left: 10px; margin-top: 10px">
              <p style="font-size: 30px;">{{ user.name }}</p>
           
          
            <v-icon style="font-size: 15px;">mdi-map-marker</v-icon>
             {{address.city }}, {{ address.state }},{{ address.zip_code }}
          
          </v-col>
          
        </v-row>
<div style="display: flex; margin: 20px">
      <v-tabs>
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
    </div>
    <v-tab-item v-if="!showJob && !showDescription && showOverview">
      <div style="display: flex; margin-top: 20px;">
          <v-card  style="margin-bottom: 20px; width: 80%;">
            <v-card-title style="font-size: 16px;"><v-icon>mdi-account</v-icon>Details:</v-card-title>
            <v-card-text>
              <label for="name" class="ps-0" style="font-weight: bold;"> Name:</label>
              <span style="margin-left: 32%">{{ user.name }}</span><br /><br />
              <label for="email" class="ps-0" style="font-weight: bold;">Email:</label>
              <span style="margin-left: 32%">{{ user.email }}</span><br /><br />
              <label for="phone" class="ps-0" style="font-weight: bold;">Contact No:</label>
              <span style="margin-left: 28%">{{ user.phone }}</span>
            </v-card-text>
          </v-card>
          <v-card  style="margin-bottom: 20px;  width: 80%; margin-left: 40px;">
          <v-card-title style="font-size: 16px;"><v-icon>mdi-map-marker</v-icon> Details:</v-card-title>
          <v-card-text>
            <label for="company name" class="ps-0" style="font-weight: bold;">City</label>
            <span style="margin-left: 25%">{{ address.city }}</span><br /><br />
            <label for="company name" class="ps-0" style="font-weight: bold;">State</label>
            <span  style="margin-left: 26%">{{ address.state }}</span><br /><br />
            <label for="companyemail" class="ps-0" style="font-weight: bold;">Pin Code</label>
            <span style="margin-left: 25%">{{ address.zip_code }}</span>
          </v-card-text>
        </v-card>
  </div>
</v-tab-item>
<v-tab-item  v-if="showDescription && !showOverview && !showJob">
  <v-card  class="card2" style="margin-bottom: 20px; font-size: 16px;">
          <v-card-title style="font-size: 16px;"><v-icon>mdi-school</v-icon>Qualifications:</v-card-title>
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
                <tr v-for="(educationDetails, index) in educationDetails" :key="index">
                  <td>{{ educationDetails.school_university }}</td>
                  <td>{{ educationDetails.education_type }}</td>
                  <td>{{ educationDetails.starting_year }}</td>
                  <td>{{ educationDetails.passing_year }}</td>
                </tr>
              </tbody>
            </template>
          </v-table>
        </v-card>
      </v-tab-item>
      <v-tab-item  v-if="showJob ">
      <v-card class="card2" style="margin-bottom: 20px; font-size: 16px;" >
        <v-card-title style="font-size: 16px;">Skills:</v-card-title>
        <v-card-text>
    <template v-if="skills.length > 0">
      <p>{{ skills[0].skill_name }}</p>
    </template>
    <template v-else>
      <p>No skills available</p>
    </template>
  </v-card-text>
      </v-card>
    </v-tab-item>
    </v-card>
  
  </template>
  
  <script>
  import { ref, onMounted , computed} from "vue";
  import axios from "axios";
  
  export default {
    name: "UserProfile",
    setup() {
        const progressValue = ref(0);
      const address = ref([]);
      const user = ref([]);
      const educationDetails=ref([]);
  const experience =ref([]);
  const skills=ref([]);
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
            educationDetails.value=data.educationDetails;
            experience.value=data.experience;
            skills.value=data.skills;
             progressValue.value = data.userDetails.status;
            console.log(progressValue.value);
        } catch (error) {
          console.error("Error fetching company profile:", error);
        }
      };
      onMounted(() => {
        fetchuserProfile();
      });
      const goToEditPage = async () => {
       window.location.href="/resume"
      }
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
      progressColor
      };
    },
  };
  </script>
  
  <style scoped>
 
  .background-image {
  position: absolute;
  width: 100%;
  height: 170px; 
  background-image: url('/storage/assest/6.jpg'); 
  background-size: cover;
  opacity: 0.6; 
  z-index: -2; 
}

  </style>
  