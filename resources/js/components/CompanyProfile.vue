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
            <div class="profile-detail">
              <div class="detail-label">Username:</div>
              <div class="detail-value">{{ user.name }}</div>
            </div>
            <div class="profile-detail">
              <div class="detail-label">UserEmail:</div>
              <div class="detail-value">{{ user.email }}</div>
            </div>
            <div class="profile-detail">
              <div class="detail-label">UserPhone:</div>
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
            <v-btn color="primary" @click="goToEditPage()" class="custom-button"
              >Edit Profile</v-btn
            >
            <v-btn color="white" class="bg-primary">
              <a href="/postjob" style="text-decoration: none; color: white"
                >Post a Job</a
              >
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
    <v-dialog v-model="isEditModalOpen" max-width="600px">
      <v-card>
        <v-card-title>Edit Profile</v-card-title>
        <v-card-text>
          <v-text-field
            v-model="editedJob.name"
            label="User Name"
            outlined
          ></v-text-field>
          <v-text-field
            v-model="editedJob.email"
            label="User Email"
            outlined
          ></v-text-field>
          <v-text-field
            v-model="editedJob.phone"
            label="User Phone"
            outlined
          ></v-text-field>
          <v-text-field
            v-model="editedJob.company_name"
            label="Company Name"
            outlined
          ></v-text-field>
          <v-text-field
            v-model="editedJob.company_email"
            label="Company Email"
            outlined
          ></v-text-field>
          <v-file-input
            v-model="editedJob.logo"
            label="Company Logo"
            outlined
            name="logo"
            @change="handleImage"
          ></v-file-input>
        </v-card-text>
        <v-card-actions>
          <v-btn @click="saveEditedJob">Save</v-btn>
          <v-btn @click="closeEditModal">Close</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>

</template>

<script>
import { ref, onMounted } from "vue";
import axios from "axios";

export default {
  name: "CompanyProfile",
  setup() {
    const company = ref([]);
    const user = ref([]);
    const isEditModalOpen = ref(false);
    const editedJob = ref({
      name:"",
      email:"",
      phone:"",
      company_name: "",
      company_email: "",
      logo: null,
    });

    const fetchCompanyProfile = async () => {
      try {
        const response = await axios.get(`/company/list`);
        company.value = response.data.companydata;
        user.value = response.data.user;
      } catch (error) {
        console.error("Error fetching company profile:", error);
      }
    };
    const goToEditPage = () => {
      editedJob.value.name = user.value.name; 
      editedJob.value.email = user.value.email;
      editedJob.value.phone = user.value.phone;
      editedJob.value.company_name = company.value[0].company_name ;
      editedJob.value.company_email =  company.value[0].company_email;
      editedJob.value.logo = null;
      isEditModalOpen.value = true;
    };
    const closeEditModal = () => {
      isEditModalOpen.value = false;
    };

    const saveEditedJob = async () => {
      try {
        const formData = new FormData();
        console.log(editedJob.value);
        formData.append("name", editedJob.value.name);
        formData.append("email", editedJob.value.email);
        formData.append("phone", editedJob.value.phone);
        formData.append("company_name", editedJob.value.company_name);
        formData.append("company_email", editedJob.value.company_email);
        formData.append("logo", editedJob.value.logo);
        const response = await axios.post("/company/update", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        });
        isEditModalOpen.value = false;
      } catch (error) {
        console.error("Error updating company profile:", error);
      }
    };
    const handleImage = (event) => {
  const file = event.target.files[0];
  editedJob.value.logo = file;
};

    onMounted(() => {
      fetchCompanyProfile();
    });

    return {
      company,
      user,
      fetchCompanyProfile,
      goToEditPage,
      isEditModalOpen,
      closeEditModal,
      editedJob,
      saveEditedJob,
      handleImage,
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
