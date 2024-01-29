<template>
  <v-container class="my-8">
    <v-row align="center" justify="center">
      <v-col cols="12" sm="10" md="8" lg="6">
        <v-card class="custom-card">
          <v-card-title class="mb-4 form-title">Company Profile</v-card-title>

          <v-avatar size="250" v-if="company.length > 0">
            <img :src="`/storage/assest/${company[0].logo}`" />
          </v-avatar>

          <v-card-text class="profile-details">
            <div  class="profile-detail">
                <div class="detail-label">Username:</div>
                <div class="detail-value">{{ user.name }}</div>
              </div>
              <div  class="profile-detail">
                <div class="detail-label">UserEmail:</div>
                <div class="detail-value">{{ user.email }}</div>
              </div>
              <div  class="profile-detail">
                <div class="detail-label">Phone:</div>
                <div class="detail-value">{{ user.phone }}</div>
              </div>

            <div v-if="company.length > 0" class="profile-detail">
              <div class="detail-label">Company Name:</div>
              <div class="detail-value">{{ company[0].company_name }}</div>
            </div>
            <div v-if="company.length > 0" class="profile-detail">
              <div class="detail-label">Company Email:</div>
              <div class="detail-value">{{ company[0].company_email }}</div>
            </div>
          </v-card-text>
          <v-card-actions>
              <v-btn color="primary" @click="goToEditPage" class="custom-button">Edit Profile</v-btn>
              <v-btn color="white" class="bg-primary" >
            <a href="/postjob" style="text-decoration: none; color: white;" >Post a Job</a>
          </v-btn>
            </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
 

</template>
  <script>
import { ref, onMounted } from "vue";
import axios from "axios";

export default {
  name: "CompanyProfile",
  setup() {
    const company = ref([]);
    const user =ref([]);
    const fetchCompanyProfile = async () => {
      try {
        const response = await axios.get(`/company/list`);
        // company.value = response.data;
        console.log(response.data.companydata);
        company.value = response.data.companydata;
        user.value = response.data.user;
        console.log(company.value);
      } catch (error) {
        console.error("Error fetching company profile:", error);
      }
    };

    const goToEditPage = () => {};

    onMounted(() => {
      fetchCompanyProfile();
    });

    return {
      company,
      user,
      fetchCompanyProfile,
      goToEditPage
    };
  },
};
</script>
  
  
<style scoped>
.custom-card {
  width: 100%;
}

.profile-details {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.profile-detail {
  display: flex;
  justify-content: space-between;
  margin-bottom: 8px;
}

.detail-label {
  font-weight: bold;
}
.profile-picture {
  width: 50%;
  height: auto;
  border-radius: 8px;
  margin-bottom: 16px;
}
</style>