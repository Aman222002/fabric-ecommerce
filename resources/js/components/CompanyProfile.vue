<template>
  <v-card
    class="company_profile"
    style="margin-top: 10px; display: flex; flex-direction: column"
  >
    <div class="company_profile_top_bar">
      <v-container fluid>
        <v-row>
          <v-icon @click="goToEditPage()" style="margin-left: 97%"
            >mdi-pencil</v-icon
          >

          <div style="align-items: center; display: flex; margin-left: 15px">
            <v-avatar size="130px" class="avatar" style="margin: 10px">
              <img
                :src="`/storage/assest/${company.logo}`"
                width="150px"
                height="150px"
              />
            </v-avatar>
          </div>
          <v-col cols="4" style="margin-left: 10px; margin-top: 10px">
            <p style="font-size: 30px">{{ user.name }}</p>

            <p
              v-if="address && address.street && address.city && address.state"
            >
              <v-icon style="font-size: 15px; color: rgb(3, 3, 3)"
                >mdi-map-marker</v-icon
              >
              {{ address.street }}, {{ address.city }},
              {{ address.state }}
            </p>
          </v-col>
        </v-row>
      </v-container>
    </div>

    <v-container fluid>
      <v-row class="company_profile_infor">
        <v-col sm="12" md="6" lg="8" xl="8" class="company_profile_infor_left">
          <v-card class="card2" style="margin-bottom: 20px">
            <v-icon
              @click="openModal"
              style="margin-left: 97%"
              class="pr-9 pt-5"
              >mdi-pencil</v-icon
            >
            <v-card-title style="font-family: Poppins, sans-serif"
              ><v-icon>mdi-domain</v-icon> Description:</v-card-title
            >
            <v-card-text>
              <div>
                {{ company.description }}
              </div>
            </v-card-text>
          </v-card>
          <v-card class="card2" style="margin-bottom: 20px; font-size: 16px">
            <v-card-title style="font-family: Poppins, sans-serif">
              Social Media Accounts:
            </v-card-title>
            <v-card-text>
              <div>
                <v-icon style="color: #1877f2">mdi-facebook</v-icon>
                <v-text-field
                  variant="solo"
                  v-model="facebook"
                  outlined
                  placeholder="Facebook"
                ></v-text-field>
              </div>
              <div>
                <v-icon style="color: #1da1f2">mdi-twitter</v-icon>
                <v-text-field
                  variant="solo"
                  v-model="twitter"
                  outlined
                  placeholder="Twitter"
                ></v-text-field>
              </div>
              <div>
                <v-icon style="color: #0a66c2">mdi-linkedin</v-icon>
                <v-text-field
                  variant="solo"
                  v-model="linkedin"
                  outlined
                  placeholder="LinkedIn"
                ></v-text-field>
              </div>
              <div>
                <v-icon style="color: #fa7e1e">mdi-instagram</v-icon>
                <v-text-field
                  variant="solo"
                  v-model="instagram"
                  outlined
                  placeholder="Instagram"
                ></v-text-field>
              </div>
              <v-btn class="btn_cts" @click="saveSocialMedia()">Save</v-btn>
            </v-card-text>
          </v-card>

          <v-dialog v-model="modalOpen" max-width="500">
            <v-card>
              <v-card-title class="title_edit">
                <span class="headline">Edit Description</span>
              </v-card-title>
              <v-card-text>
                <v-textarea
                  v-model="editedDescription.description"
                  label="Description"
                  outlined
                  variant="solo"
                ></v-textarea>
              </v-card-text>
              <v-card-actions>
                <v-btn class="btn_cts" @click="saveDescription">Save</v-btn>
                <v-btn class="btn_cancel" @click="closeModal">Close</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-col>
        <v-col sm="12" md="6" lg="4" xl="4" class="company_profile_infor_right">
          <v-card>
            <div class="edit_btn">
              <v-icon
                @click="openEditCompanyModal()"
                class="right_side_edif_btn"
                >mdi-pencil</v-icon
              >
            </div>
            <v-card-title class="pl-0"> Company: </v-card-title>
            <v-card-text>
              <div>
                <label for="name" class="ps-0"> Name:</label>
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
              <div>
                <label for="company name" class="ps-0">Company Name:</label>
                <span>{{ company.company_name }}</span>
              </div>
              <div>
                <label for="company name" class="ps-0">Phone Number:</label>
                <span>{{ company.phone_number }}</span>
              </div>
              <div>
                <label for="companyemail" class="ps-0">Company Email:</label>
                <span>{{ company.company_email }}</span>
              </div>
            </v-card-text>
          </v-card>
          <v-dialog v-model="isEditCompanyModalOpen" max-width="600px">
            <v-card>
              <v-card-title class="title_edit"
                >Edit Company Details</v-card-title
              >
              <v-card-text>
                <v-text-field
                  v-model="editedCompany.name"
                  label="Company Name"
                  density="compact"
                  variant="solo"
                  :rules="[(value) => !!value || 'Company Name is required']"
                ></v-text-field>
                <v-text-field
                  v-model="editedCompany.email"
                  label="Company Email"
                  density="compact"
                  variant="solo"
                  :rules="[(value) => !!value || 'Company Email is required']"
                ></v-text-field>

                <v-file-input
                  v-model="editedCompany.logo"
                  label="Company Logo"
                  density="compact"
                  variant="solo"
                  name="logo"
                  @change="handleCompanyLogoChange"
                  :rules="[(value) => !!value || 'Company Logo is required']"
                ></v-file-input>
              </v-card-text>
              <v-card-actions>
                <v-btn class="btn_cts" @click="saveEditedCompany">Save</v-btn>
                <v-btn class="btn_cancel" @click="closeEditCompanyModal"
                  >Cancel</v-btn
                >
              </v-card-actions>
            </v-card>
          </v-dialog>
          <v-card>
            <div class="edit_btn">
              <v-icon
                @click="openEditAddressModal()"
                class="right_side_edif_btn"
              >
                mdi-pencil
              </v-icon>
            </div>
            <v-card-title
              style="font-family: Poppins, sans-serif"
              class="pt-0 pl-0"
            >
              Address:
            </v-card-title>

            <v-card-text>
              <div>
                <label for="name" class="ps-0">First line Address:</label>
                <span>{{ address.first_line_address }}</span>
              </div>
              <div>
                <label for="name" class="ps-0">Street:</label>
                <span>{{ address.street }}</span>
              </div>
              <div>
                <label for="name" class="ps-0">City:</label>
                <span>{{ address.city }}</span>
              </div>
              <div>
                <label for="name" class="ps-0">State:</label>
                <span>{{ address.state }}</span>
              </div>
              <div>
                <label for="name" class="ps-0">Postal Code:</label>
                <span>{{ address.postal_code }}</span>
              </div>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
    <v-card
      v-if="showJob && company.jobs"
      class="card2"
      style="margin-bottom: 20px; font-size: 16px"
    >
      <v-card-title style="font-family: Poppins, sans-serif"
        ><v-icon>mdi-note</v-icon>Recently Posted Jobs:</v-card-title
      >
      <v-table>
        <template v-slot:default>
          <thead>
            <tr>
              <th class="text-left">Job Title</th>
              <th class="text-left">Vacancy</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(job, index) in company.jobs" :key="index">
              <td>{{ job.title }}</td>
              <td>{{ job.vacancy }}</td>
            </tr>
          </tbody>
        </template>
      </v-table>
    </v-card>

    <v-card
      v-if="showAddress && company.address"
      class="card2"
      style="margin-bottom: 20px; font-size: 16px"
    >
      <v-icon @click="openEditAddressModal()"> mdi-pencil </v-icon>
      <v-card-title style="font-family: Poppins, sans-serif">
        Address:
      </v-card-title>
      <v-table>
        <template v-slot:default>
          <thead>
            <tr>
              <th class="text-left">First line Address</th>
              <th class="text-left">Street</th>
              <th class="text-left">City</th>
              <th class="text-left">State</th>
              <th class="text-left">Postal Code</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{{ address.first_line_address }}</td>
              <td>{{ address.street }}</td>
              <td>{{ address.city }}</td>
              <td>{{ address.state }}</td>
              <td>{{ address.postal_code }}</td>
            </tr>
          </tbody>
        </template>
      </v-table>
    </v-card>

    <v-dialog v-model="isEditAddressModalOpen" max-width="600px">
      <v-card>
        <v-card-title class="title_edit">Edit Address</v-card-title>
        <v-card-text>
          <v-text-field
            v-model="editedAddress.first_line_address"
            label="First line address"
            variant="solo"
            density="compact"
            :rules="[(value) => !!value || 'First line address is required']"
          ></v-text-field>
          <v-text-field
            v-model="editedAddress.street"
            label="Street"
            variant="solo"
            density="compact"
            :rules="[(value) => !!value || 'Street is required']"
          ></v-text-field>
          <v-text-field
            v-model="editedAddress.city"
            label="City"
            variant="solo"
            density="compact"
            :rules="[(value) => !!value || 'City is required']"
          ></v-text-field>
          <v-text-field
            v-model="editedAddress.state"
            label="State"
            density="compact"
            variant="solo"
            :rules="[(value) => !!value || 'State is required']"
          ></v-text-field>
          <v-text-field
            v-model="editedAddress.postal_code"
            label="Postal Code"
            density="compact"
            variant="solo"
            :rules="[(value) => !!value || 'Postal code is required']"
          ></v-text-field>
          <!-- <v-select  :items="countries" :rules="[v => !!v || 'Country is required']"
                        item-title="country_name" item-value="id" label="country" clearable searchable
                        placeholder="Select Country"></v-select> -->
        </v-card-text>
        <v-card-actions>
          <v-btn class="btn_cts" @click="saveEditedAddress">Save</v-btn>
          <v-btn class="btn_cancel" @click="closeEditAddressModal"
            >Cancel</v-btn
          >
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog v-model="isEditModalOpen" max-width="600px">
      <v-card>
        <v-card-title class="title_edit">Edit Profile</v-card-title>
        <v-card-text>
          <v-text-field
            v-model="editedJob.name"
            label="User Name"
            variant="solo"
            density="compact"
            :rules="[(value) => !!value || 'User name is required']"
          ></v-text-field>
          <v-text-field
            v-model="editedJob.email"
            label="User Email"
            variant="solo"
            density="compact"
            :rules="[(value) => !!value || 'User email is required']"
          ></v-text-field>
          <!-- <v-text-field
            v-model="editedJob.phone"
            label="User Phone"
            variant="solo"
            density="compact"
            :rules="[(value) => !!value || 'User phone is required']"
          ></v-text-field> -->
          <vue-tel-input
          @input="handlePhoneInput"
          :value="editedJob.phone"
          @validate="telValidate"
                        color="blue"
                        density="compact"
                        style="margin-bottom: 10px"
                        variant="outlined"
                        label="Phone"
                        hide-details="auto"
                        mode="international"
                      
                      ></vue-tel-input>
                      <span v-if="errorMessage" class="error">{{ errorMessage }}</span>    
        </v-card-text>
        <v-card-actions>
         
          <v-btn class="btn_cts" @click="saveEditedJob" >Save</v-btn>
          <v-btn class="btn_cancel" @click="closeEditModal">Close</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-card>
</template>
<script>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useUsersStore } from "../store/user";
import { countries } from "../utils/countries";
export default {
  name: "CompanyProfile",
  setup() {
    const company = ref([]);
    const address = ref({
      first_line_address: "",
      street: "",
      city: "",
      state: "",
      postal_code: "",
    });
     
    const errorMessage = ref("");
    const countriesList = ref(countries);
    const facebook = ref("");
    const twitter = ref("");
    const linkedin = ref("");
    const instagram = ref("");
    const store = useUsersStore();
    const user = ref([]);
    const fileInput = ref();
    const image = ref(null);
    const isEditModalOpen = ref(false);
    const modalOpen = ref(false);
    const isEditCompanyModalOpen = ref(false);
    const editedDescription = ref({
      description: "",
    });
    const editedJob = ref({
      name: "",
      email: "",
      phone: "",
      company_name: "",
      company_email: "",
      logo: null,
    
    
    });
    const editedAddress = ref({
      first_line_address: "",
      street: "",
      city: "",
      state: "",
      postal_code: "",
    });
    const editedCompany = ref({
      name: "",
      email: "",
      logo: null,
    });
    const showOverview = ref(true);
    const showJob = ref(false);
    const showAddress = ref(false);
    const showDescription = ref(false);
    const isEditAddressModalOpen = ref(false);
    const fetchCompanyProfile = async () => {
      try {
        const response = await axios.get(`/company/list`);
        console.log(response.data);
        company.value = response.data.companydata;
        user.value = response.data.user;

        if (response.data.companydata.address) {
          address.value = response.data.companydata.address;
        }
        console.log(user.value);

        if (
          response.data.companydata.social_media_accounts &&
          response.data.companydata.social_media_accounts.length > 0
        ) {
          facebook.value =
            response.data.companydata.social_media_accounts[0].facebook_url;
          twitter.value =
            response.data.companydata.social_media_accounts[0].twitter_url;
          linkedin.value =
            response.data.companydata.social_media_accounts[0].linkedin_url;
          instagram.value =
            response.data.companydata.social_media_accounts[0].instagram_url;
        }

        console.log(response.data.companydata.address);
      } catch (error) {
        console.error("Error fetching company profile:", error);
      }
    };

const handlePhoneInput = (event) => {
      try {
        if (typeof event === "string") {
          editedJob.value.phone = event;
        } else if (event && event.target && event.target.value) {
          editedJob.value.phone = event.target.value;
        } else {
          console.error("Invalid event:", event);
        }
      } catch (error) {
        console.error("Error handling phone input:", error);
      }
    };
   
    const telValidate = (isValid) => {
    console.log("Is Valid:", isValid);
  
    if (isValid.valid===true) {

console.log( isValid.value,"Valid Phone Number");
errorMessage.value = "";
return true;
    } else {
    
      console.log("Invalid Phone Number");
        errorMessage.value = "Enter a valid phone number";
      return false
    }
   
};

    const goToEditPage = () => {
      editedJob.value.name = user.value.name;
      editedJob.value.email = user.value.email;
      editedJob.value.phone = user.value.phone;
      editedJob.value.company_name = company.value.company_name;
      editedJob.value.company_email = company.value.company_email;
      editedJob.value.logo = null;
      isEditModalOpen.value = true;
    };
    const closeEditModal = () => {
      isEditModalOpen.value = false;
    };

    const saveEditedJob = async () => {
     
      if (errorMessage.value) {
        telValidate({ isValid: false, number: editedJob.value.phone });
        return;
      }
      try {
          const formData = new FormData();
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
        closeEditAddressModal();
        window.Swal.fire({
          toast: true,
          position: "top-end",
          timer: 2000,
          showConfirmButton: false,
          icon: "success",
          title: "User  Updated",
        });
         window.location.reload();
      } catch (error) {
        console.error("Error updating company profile:", error);
      }
    };
    
    const openEditCompanyModal = () => {
      const isAdmin = user.value.roles.some(
        (role) => role.name === "Company Admin"
      );

      if (!isAdmin) {
        window.Swal.fire({
          toast: true,
          position: "top-end",
          timer: 2000,
          showConfirmButton: false,
          icon: "error",
          title: "You are not authorize",
        });
        return;
      }

      editedCompany.value.name = company.value.company_name;
      editedCompany.value.email = company.value.company_email;

      editedCompany.value.logo = null;

      isEditCompanyModalOpen.value = true;
    };
    const closeEditCompanyModal = () => {
      isEditCompanyModalOpen.value = false;
    };
    const saveEditedCompany = async () => {
      try {
        const formData = new FormData();
        formData.append("company_name", editedCompany.value.name);
        formData.append("company_email", editedCompany.value.email);
        formData.append("logo", editedCompany.value.logo);
        const response = await axios.post("/company/updatecompany", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        });

        closeEditCompanyModal();
        window.Swal.fire({
          toast: true,
          position: "top-end",
          timer: 2000,
          showConfirmButton: false,
          icon: "success",
          title: "Company Updated",
        });

        window.location.reload();
      } catch (error) {
        console.error("Error updating company details:", error);
      }
    };
    const handleCompanyLogoChange = (event) => {
      const file = event.target.files[0];
      editedCompany.value.logo = file;
    };

    const handleImage = (event) => {
      const file = event.target.files[0];
      editedJob.value.logo = file;
    };

    const openFileInput = () => {
      const fileInput = document.getElementById("fileInput");
      fileInput.click();
    };

    const handleImageChange = (event) => {
      const file = event.target.files[0];
      image.value = file;
    };

    onMounted(() => {
      fetchCompanyProfile();
    });
    // const openEditAddressModal = () => {
    //   isEditAddressModalOpen.value = true;

    //   if (company.value?.address) {
    //     editedAddress.value.first_line_address =
    //       company.value.address.first_line_address || "";
    //     editedAddress.value.street = company.value.address.street || "";
    //     editedAddress.value.city = company.value.address.city || "";
    //     editedAddress.value.state = company.value.address.state || "";
    //     editedAddress.value.postal_code =
    //       company.value.address.postal_code || "";
    //   } else {
    //     editedAddress.value.first_line_address = "";
    //     editedAddress.value.street = "";
    //     editedAddress.value.city = "";
    //     editedAddress.value.state = "";
    //     editedAddress.value.postal_code = "";
    //   }
    // };
    const openEditAddressModal = () => {
      const isAdmin = user.value.roles.some(
        (role) => role.name === "Company Admin"
      );

      if (!isAdmin) {
        window.Swal.fire({
          toast: true,
          position: "top-end",
          timer: 2000,
          showConfirmButton: false,
          icon: "error",
          title: "You are not authorize",
        });
        return;
      }
      isEditAddressModalOpen.value = true;

      if (company.value?.address) {
        editedAddress.value.first_line_address =
          company.value.address.first_line_address || "";
        editedAddress.value.street = company.value.address.street || "";
        editedAddress.value.city = company.value.address.city || "";
        editedAddress.value.state = company.value.address.state || "";
        editedAddress.value.postal_code =
          company.value.address.postal_code || "";
      } else {
        editedAddress.value.first_line_address = "";
        editedAddress.value.street = "";
        editedAddress.value.city = "";
        editedAddress.value.state = "";
        editedAddress.value.postal_code = "";
      }
    };

    const closeEditAddressModal = () => {
      isEditAddressModalOpen.value = false;
    };

    const saveEditedAddress = async () => {
      try {
        const formData = new FormData();
        formData.append(
          "first_line_address",
          editedAddress.value.first_line_address
        );
        formData.append("street", editedAddress.value.street);
        formData.append("city", editedAddress.value.city);
        formData.append("state", editedAddress.value.state);
        formData.append("postal_code", editedAddress.value.postal_code);
        const response = await axios.post("/company/updateaddress", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        });
        closeEditAddressModal();
        window.Swal.fire({
          toast: true,
          position: "top-end",
          timer: 2000,
          showConfirmButton: false,
          icon: "success",
          title: "Address Updated",
        });
        window.location.reload();
      } catch (error) {
        console.error("Error updating company profile:", error);
      }
    };
    const openModal = () => {
      const isAdmin = user.value.roles.some(
        (role) => role.name === "Company Admin"
      );

      if (!isAdmin) {
        window.Swal.fire({
          toast: true,
          position: "top-end",
          timer: 2000,
          showConfirmButton: false,
          icon: "error",
          title: "You are not authorize",
        });
        return;
      }
      modalOpen.value = true;
      editedDescription.value.description = company.value.description;
    };
    const closeModal = () => {
      modalOpen.value = false;
    };

    const saveDescription = async () => {
      try {
        const formData = new FormData();
        formData.append("description", editedDescription.value.description);
        const response = await axios.post(
          "/company/updatedescription",
          formData,
          {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          }
        );
        closeModal();
        window.Swal.fire({
          toast: true,
          position: "top-end",
          timer: 2000,
          showConfirmButton: false,
          icon: "success",
          title: "Description Updated",
        });
        window.location.reload();
      } catch (error) {
        console.error("Error updating company profile:", error);
      }
    };
    const saveSocialMedia = async () => {
      try {
        const isAdmin = user.value.roles.some(
          (role) => role.name === "Company Admin"
        );

        if (!isAdmin) {
          window.Swal.fire({
            toast: true,
            position: "top-end",
            timer: 2000,
            showConfirmButton: false,
            icon: "error",
            title: "You are not authorized",
          });
          return;
        }

        const response = await axios.post("/company/updateSocialMedia", {
          facebook: facebook.value,
          twitter: twitter.value,
          linkedin: linkedin.value,
          instagram: instagram.value,
        });
        window.Swal.fire({
          toast: true,
          position: "top-end",
          timer: 2000,
          showConfirmButton: false,
          icon: "success",
          title: "Social Media Links Updated",
        });
        window.location.reload();
      } catch (error) {
        console.error("Error updating social media accounts:", error);
      }
    };

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
      openFileInput,
      handleImageChange,
      fileInput,
      image,
      showOverview,
      showJob,
      showDescription,
      showAddress,
      isEditAddressModalOpen,
      openEditAddressModal,
      closeEditAddressModal,
      saveEditedAddress,
      editedAddress,
      address,
      modalOpen,
      editedDescription,
      store,
      openModal,
      saveDescription,
      closeModal,
      facebook,
      twitter,
      linkedin,
      instagram,
      saveSocialMedia,
      editedCompany,
      isEditCompanyModalOpen,
      openEditCompanyModal,
      closeEditCompanyModal,
      saveEditedCompany,
      handleCompanyLogoChange,
      countries: countriesList,handlePhoneInput,telValidate,errorMessage,
    };
  },
};
</script>

<style>
.user-name {
  color: white;
  background-color: black;
}

.company_profile_infor_right .v-card-text div {
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
  flex-direction: column;
}
.choose_your_plan
  .packages_price
  .plan_choose:nth-child(2)
  div.v-card.v-theme--light {
  height: 97%;
}

.choose_your_plan
  .packages_price
  .plan_choose:nth-child(2)
  div.v-card.v-theme--light
  div.border-left {
  height: 93%;
}

.company_profile_infor_right .edit_btn {
  display: flex;
  justify-content: end;
  margin-bottom: 15px;
  position: absolute;
  right: 15px;
}

.company_profile_top_bar {
  background-image: linear-gradient(to right, #f3f6fb, #bfd1f1);
  padding: 15px 0;
}

.company_profile_infor_right .v-card {
  padding: 30px 27px;
  background: #f5f7fc;
  border-radius: 8px;
  margin-bottom: 40px;
  width: 75%;
}

.company_profile_infor_right .v-card .v-card-text {
  padding: 0;
}

.company_profile_infor_right .v-card-text div label {
  font-weight: 600;
}
.title_edit {
  color: #fff !important;
  background: #0146a6;
  text-align: center;
}
.error {
  color: rgb(204, 65, 65);
  font-size: 13px;
}
</style>
