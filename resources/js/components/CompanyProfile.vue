<template>
  <v-card
    class="company_profile"
    style="margin-top: 10px; display: flex; flex-direction: column"
  >
    <div class="company_profile_top_bar">
      <v-container>
        <v-row>
          <v-icon @click="goToEditPage()" class="right_side_edif_btn"
            >mdi-pencil</v-icon
          >
          <div style="align-items: center; display: flex; margin-left: 15px">
            <!-- <v-avatar
           size="130px"
          class="avatar"
          style="margin: 10px"
          v-if="company.length > 0"
          @click="openFileInput()" 
        > -->
            <!-- <span class="mdi mdi-pencil" id="icon"></span> -->
            <v-avatar
              size="130px"
              class="avatar"
              style="margin: 10px"
              v-if="company.length > 0"
            >
              <input
                type="file"
                id="fileInput"
                ref="fileInput"
                style="display: none"
                @change="handleImageChange()"
              />
              <img
                :src="`/storage/assest/${company[0].logo}`"
                alt="Selected Image"
                width="150px"
                height="150px"
              />
            </v-avatar>
          </div>
          <v-col cols="4" style="margin-left: 10px; margin-top: 10px">
            <p style="font-size: 30px">{{ user.name }}</p>
            <p style="font-size: 15px">Representative</p>
            <p v-if="company.length > 0 && company[0].address">
              <v-icon style="font-size: 15px; color: rgb(3, 3, 3)"
                >mdi-map-marker</v-icon
              >
              {{ company[0].address.street }}, {{ company[0].address.city }},
              {{ company[0].address.state }}
            </p>
          </v-col>
        </v-row>
      </v-container>
    </div>
    <v-container>
      <v-row class="company_profile_infor">
        <v-col sm="12" md="6" lg="8" xl="8" class="company_profile_infor_left">
          <!-- Description -->
          <v-card class="card2" style="margin-bottom: 20px">
            <v-card-title style="font-family: Poppins, sans-serif"
              ><v-icon>mdi-domain</v-icon> Description:</v-card-title
            >
            <v-card-text>
              <div style="font-family: sans-serif" v-if="company.length > 0">
                {{ company[0].description }}
              </div>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col sm="12" md="6" lg="4" xl="4" class="company_profile_infor_right">
          <v-card>
            <!-- <v-card-title style="font-family: Poppins, sans-serif"
              ><v-icon>mdi-account</v-icon> Details:</v-card-title
            > -->
            <v-card-text>
              <div>
                <label
                  for="name"
                  class="ps-0"
                  style="font-weight: 600; text-align: inherit"
                  >Representative Name:</label
                >
                <span style="margin-left: 23%">{{ user.name }}</span>
              </div>

              <div>
                <label
                  for="email"
                  class="ps-0"
                  style="font-weight: 600; text-align: inherit"
                  >Email:</label
                >
                <span style="margin-left: 32%">{{ user.email }}</span>
              </div>
              <div>
                <label
                  for="phone"
                  class="ps-0"
                  style="font-weight: 600; text-align: inherit"
                  >Contact No:</label
                >
                <span style="margin-left: 29%">{{ user.phone }}</span>
              </div>
              <div>
                <label
                  for="company name"
                  class="ps-0"
                  style="font-weight: 600; text-align: inherit"
                  >Company Name</label
                >
                <span v-if="company.length > 0" style="margin-left: 25%">{{
                  company[0].company_name
                }}</span>
              </div>
              <div>
                <label
                  for="company name"
                  class="ps-0"
                  style="font-weight: 600; text-align: inherit"
                  >Phone Number</label
                >
                <span v-if="company.length > 0" style="margin-left: 26%"
                  >{{}}</span
                >
              </div>
              <div>
                <label
                  for="companyemail"
                  class="ps-0"
                  style="font-weight: 600; text-align: inherit"
                  >Company Email</label
                >
                <span v-if="company.length > 0" style="margin-left: 25%">{{
                  company[0].company_email
                }}</span>
              </div>
            </v-card-text>
          </v-card>
          <v-card>
            <v-icon @click="openEditAddressModal()" class="right_side_edif_btn">
              mdi-pencil
            </v-icon>
            <v-card-title style="font-family: Poppins, sans-serif">
              Address:
            </v-card-title>

            <v-card-text v-if="showAddress && company[0].address">
              <div>
                <label
                  for="name"
                  class="ps-0"
                  style="font-weight: 600; text-align: inherit"
                  >First line Address:</label
                >
                <span style="margin-left: 23%">{{
                  company[0].address.first_line_address
                }}</span>
              </div>
              <div>
                <label
                  for="name"
                  class="ps-0"
                  style="font-weight: 600; text-align: inherit"
                  >Street:</label
                >
                <span style="margin-left: 23%">{{
                  company[0].address.street
                }}</span>
              </div>
              <div>
                <label
                  for="name"
                  class="ps-0"
                  style="font-weight: 600; text-align: inherit"
                  >City:</label
                >
                <span style="margin-left: 23%">{{
                  company[0].address.city
                }}</span>
              </div>
              <div>
                <label
                  for="name"
                  class="ps-0"
                  style="font-weight: 600; text-align: inherit"
                  >State:</label
                >
                <span style="margin-left: 23%">{{
                  company[0].address.state
                }}</span>
              </div>
              <div>
                <label
                  for="name"
                  class="ps-0"
                  style="font-weight: 600; text-align: inherit"
                  >Postal Code:</label
                >
                <span style="margin-left: 23%">{{
                  company[0].address.postal_code
                }}</span>
              </div>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
    <!-- <div style="display: flex; margin: 40px">
      <v-tabs>
        <v-tab
          :class="{ active: showOverview }"
          @click="
            showOverview = true;
            showJob = false;
            showDescription = false;
            showAddress = false;
          "
          >Overview</v-tab
        >
        <v-tab
          :class="{ active: showJob }"
          @click="
            showOverview = false;
            showJob = true;
            showDescription = false;
            showAddress = false;
          "
          >Activities</v-tab
        >
        <v-tab
          :class="{ active: showDescription }"
          @click="
            showOverview = false;
            showJob = false;
            showDescription = true;
            showAddress = false;
          "
          >Description</v-tab
        >
        <v-tab
          :class="{ active: showAddress }"
          @click="
            showOverview = false;
            showJob = false;
            showDescription = false;
            showAddress = true;
          "
          >Address</v-tab
        >
      </v-tabs>
    </div> -->

    <!-- Overview start -->
    <!-- <div
      v-if="!showJob && !showDescription && showOverview && !showAddress"
      style="display: flex; margin-top: 70px"
    >
      <v-card style="margin-bottom: 20px; width: 80%">
        <v-card-title style="font-family: Poppins, sans-serif"
          ><v-icon>mdi-account</v-icon> Details:</v-card-title
        >
        <v-card-text>
          <label
            for="name"
            class="ps-0"
            style="font-weight: 600; text-align: inherit"
            >Representative Name:</label
          >
          <span style="margin-left: 23%">{{ user.name }}</span
          ><br /><br />
          <label
            for="email"
            class="ps-0"
            style="font-weight: 600; text-align: inherit"
            >Email:</label
          >
          <span style="margin-left: 32%">{{ user.email }}</span
          ><br /><br />
          <label
            for="phone"
            class="ps-0"
            style="font-weight: 600; text-align: inherit"
            >Contact No:</label
          >
          <span style="margin-left: 29%">{{ user.phone }}</span>
        </v-card-text>
      </v-card>
      <v-card style="margin-bottom: 20px; width: 80%; margin-left: 40px">
        <v-card-title style="font-family: Poppins, sans-serif"
          ><v-icon>mdi-domain</v-icon> Details:</v-card-title
        >
        <v-card-text>
          <label
            for="company name"
            class="ps-0"
            style="font-weight: 600; text-align: inherit"
            >Company Name</label
          >
          <span v-if="company.length > 0" style="margin-left: 25%">{{
            company[0].company_name
          }}</span
          ><br /><br />
          <label
            for="company name"
            class="ps-0"
            style="font-weight: 600; text-align: inherit"
            >Phone Number</label
          >
          <span v-if="company.length > 0" style="margin-left: 26%">{{}}</span
          ><br /><br />
          <label
            for="companyemail"
            class="ps-0"
            style="font-weight: 600; text-align: inherit"
            >Company Email</label
          >
          <span v-if="company.length > 0" style="margin-left: 25%">{{
            company[0].company_email
          }}</span>
        </v-card-text>
      </v-card>
    </div> -->
    <!--  -->

    <!-- Description start -->
    <!-- <v-card class="card2" style="margin-bottom: 20px">
      <v-card-title style="font-family: Poppins, sans-serif"
        ><v-icon>mdi-domain</v-icon> Description:</v-card-title
      >
      <v-card-text>
        <div style="font-family: sans-serif" v-if="company.length > 0">
          {{ company[0].description }}
        </div>
      </v-card-text>
    </v-card> -->
    <!-- Description end -->

    <!--  -->
    <v-card
      v-if="showJob && company[0].jobs"
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
            <tr v-for="(job, index) in company[0].jobs" :key="index">
              <td>{{ job.title }}</td>
              <td>{{ job.vacancy }}</td>
            </tr>
          </tbody>
        </template>
      </v-table>
    </v-card>
    <!--  -->

    <!--  -->
    <v-card
      v-if="showAddress && company[0].address"
      class="card2"
      style="margin-bottom: 20px; font-size: 16px"
    >
      <v-icon @click="openEditAddressModal()" style="margin-left: 97%">
        mdi-pencil
      </v-icon>
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
              <td>{{ company[0].address.first_line_address }}</td>
              <td>{{ company[0].address.street }}</td>
              <td>{{ company[0].address.city }}</td>
              <td>{{ company[0].address.state }}</td>
              <td>{{ company[0].address.postal_code }}</td>
            </tr>
          </tbody>
        </template>
      </v-table>
    </v-card>
    <!--  -->

    <v-dialog v-model="isEditAddressModalOpen" max-width="600px">
      <v-card>
        <v-card-title>Edit Address</v-card-title>
        <v-card-text>
          <v-text-field
            v-model="editedAddress.first_line_address"
            label="First_line_address"
            variant="outlined"
            density="compact"
          ></v-text-field>
          <v-text-field
            v-model="editedAddress.street"
            label="Street"
            variant="outlined"
            density="compact"
          ></v-text-field>
          <v-text-field
            v-model="editedAddress.city"
            label="City"
            variant="outlined"
            density="compact"
          ></v-text-field>
          <v-text-field
            v-model="editedAddress.state"
            label="State"
            density="compact"
            variant="outlined"
          ></v-text-field>
          <v-text-field
            v-model="editedAddress.postal_code"
            label="postal_code"
            density="compact"
            variant="outlined"
          ></v-text-field>
        </v-card-text>
        <v-card-actions>
          <v-btn @click="saveEditedAddress">Save</v-btn>
          <v-btn @click="closeEditAddressModal">Cancel</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog v-model="isEditModalOpen" max-width="600px">
      <v-card>
        <v-card-title>Edit Profile</v-card-title>
        <v-card-text>
          <v-text-field
            v-model="editedJob.name"
            label="User Name"
            variant="outlined"
            density="compact"
          ></v-text-field>
          <v-text-field
            v-model="editedJob.email"
            label="User Email"
            variant="outlined"
            density="compact"
          ></v-text-field>
          <v-text-field
            v-model="editedJob.phone"
            label="User Phone"
            variant="outlined"
            density="compact"
          ></v-text-field>
          <v-text-field
            v-model="editedJob.company_name"
            label="Company Name"
            density="compact"
            variant="outlined"
          ></v-text-field>
          <v-text-field
            v-model="editedJob.company_email"
            label="Company Email"
            density="compact"
            variant="outlined"
          ></v-text-field>
          <v-file-input
            v-model="editedJob.logo"
            label="Company Logo"
            density="compact"
            variant="outlined"
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
  </v-card>
</template>

<script>
import { ref, onMounted } from "vue";
import axios from "axios";

export default {
  name: "CompanyProfile",
  setup() {
    const company = ref([]);
    const user = ref([]);
    const fileInput = ref();
    const image = ref(null);
    const isEditModalOpen = ref(false);
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
    const showOverview = ref(true);
    const showJob = ref(false);
    const showAddress = ref(false);
    const showDescription = ref(false);
    const isEditAddressModalOpen = ref(false);
    const fetchCompanyProfile = async () => {
      try {
        const response = await axios.get(`/company/list`);
        company.value = response.data.companydata;
        user.value = response.data.user;
        console.log(response.data.companydata);
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
    const openEditAddressModal = () => {
      if (company.value.length > 0 && company.value[0].address) {
        editedAddress.value.first_line_address =
          company.value[0].address.first_line_address;
        editedAddress.value.street = company.value[0].address.street;
        editedAddress.value.city = company.value[0].address.city;
        editedAddress.value.state = company.value[0].address.state;
        editedAddress.value.postal_code = company.value[0].address.postal_code;
        isEditAddressModalOpen.value = true;
      } else {
        console.error("Company data or address not available.");
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
      } catch (error) {
        console.error("Error updating company profile:", error);
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
.company_profile_infor_right .v-card-text div {
  display: flex;
  justify-content: space-between;
  margin-bottom: 15px;
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
.right_side_edif_btn {
  position: absolute;
  right: 25px;
}
.company_profile_infor_right .v-card .v-card-text {
  padding: 0;
}
</style>
