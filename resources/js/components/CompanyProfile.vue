
<template>
  <v-container>
    <v-card-title class="form-title">Company Profile :</v-card-title>
      <v-row>
          <v-col cols="12">
              <v-card class="card">
                      <v-row>
                          <v-col cols="12">
                              <v-card>
                                  <v-card-text>
                                    <p style=" margin-bottom: 30px; font-size: 20px; margin-left: 190px; font-weight: bold;"> Represantative Detail :</p>
                                      <v-row>
                                          <v-col cols="2">
                                            <v-avatar size="150" v-if="company.length > 0">
            <img :src="`/storage/assest/${company[0].logo}`" style="width: 100%; height: 200px;" />
          </v-avatar>
         
                                          </v-col>
                                          <v-col cols="3">
                                              <label for="name" class="custom-text-field"> Representative Name</label>
                                              <v-text-field v-model="user.name" readonly></v-text-field>
                                          </v-col>
                                          <v-col cols="3">
                                              <label for="email" class="custom-text-field">Email</label>
                                              <v-text-field v-model="user.email" readonly></v-text-field>
                                          </v-col>
                                          <v-col cols="3">
                                              <label for="phone" class="custom-text-field">Contact No.</label>
                                              <v-text-field v-model="user.phone" readonly></v-text-field>
                                          </v-col>
                                      </v-row>
                                      <p style=" margin-bottom: 30px; font-size: 20px; margin-left: 190px; font-weight: bold;"> Company Detail :</p>
                                      <v-row  style="margin-left: 170px;">
                                      
                                          <v-col cols="4">
                                           <label for="company name" class="custom-text-field">Company Name</label>
                                           <v-text-field v-if="company.length > 0" v-model="company[0].company_name" readonly></v-text-field>
                                          </v-col>
                                          <v-col cols="4">
                                            <label for="companyemail" class="custom-text-field">Company Email</label>
                                           <v-text-field v-if="company.length > 0" v-model="company[0].company_email" readonly></v-text-field>
                                          </v-col>
                                         
                                      </v-row>
                                  </v-card-text>
                                  <v-card-actions>
      <v-btn  @click="goToEditPage()"  class="bg-primary" style="margin-left: 50%;  width: 130px; height: 50px;">Edit Profile</v-btn>
    </v-card-actions>
    <v-dialog v-model="isEditModalOpen" max-width="600px">
      <v-card>
        <v-card-title>Edit Profile</v-card-title>
        <v-card-text>
          <v-text-field v-model="editedJob.name" label="User Name" outlined></v-text-field>
          <v-text-field v-model="editedJob.email" label="User Email" outlined></v-text-field>
          <v-text-field v-model="editedJob.phone" label="User Phone" outlined></v-text-field>
          <v-text-field v-model="editedJob.company_name" label="Company Name" outlined></v-text-field>
          <v-text-field v-model="editedJob.company_email" label="Company Email" outlined></v-text-field>
          <v-file-input v-model="editedJob.logo" label="Company Logo" outlined name="logo" @change="handleImage"></v-file-input>
        </v-card-text>
        <v-card-actions>
          <v-btn @click="saveEditedJob">Save</v-btn>
          <v-btn @click="closeEditModal">Close</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
                              </v-card>
                          </v-col>
                      </v-row>
                
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
    const user = ref([]);
    const isEditModalOpen = ref(false);
    const editedJob = ref({
      name: "",
      email: "",
      phone: "",
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
      editedJob.value.company_name = company.value[0].company_name;
      editedJob.value.company_email = company.value[0].company_email;
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
  border: 1px white;
  padding: 40px;
  
}

.form-title {
  font-size: 30px;
  margin-bottom: 20px;
}

/* .profile-details {
  margin-top: 20px;
} */

/* .detail-label {
  font-weight: bold;
  font-size: 20px;
  margin: 10px;
 
}

.detail-value {
  margin-left: 8px;
  font-size: 20px;
}

.profile-detail {
  display: flex;
  justify-content: space-between;
  margin-bottom: 8px;
} */
.input-group {
  display: flex;
  font-size: 20px;
}

.input-group label {
  margin-right: 50px;
  min-width: 100px;
}

</style>
 
