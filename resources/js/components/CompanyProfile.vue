<template>
  <v-card style="margin-top: 10px; display: flex; flex-direction: column">
    <div class="background-image"></div>
    <v-icon @click="goToEditPage()" style="margin-left: 97%">mdi-pencil</v-icon>
    <v-row>
      <div style="align-items: center; display: flex; margin-left: 15px">
       
          <v-avatar
          size="130px"
          class="avatar"
          style="margin: 10px"
        
           >
          <input
            type="file"
            id="fileInput"
            ref="fileInput"
            style="display: none"
            @change="handleImageChange()"
          />
          <img
            :src="`/storage/assest/${company.logo}`"
            alt="Selected Image"
            width="150px"
            height="150px"
          />
        </v-avatar>
      </div>
      <v-col cols="4" style="margin-left: 10px; margin-top: 10px">
        <p style="font-size: 30px;">{{ user.name }}</p>
        <p style="font-size: 15px">Representative</p>
        <p v-if="address">
          <v-icon style="font-size: 15px; color: rgb(3, 3, 3)"
            >mdi-map-marker</v-icon
          >
          {{ address.street }}, {{ address.city }},
          {{ address.state }}
        </p>
      </v-col>
    </v-row>
    <div style="display: flex; margin: 40px">
      <v-tabs>
        <v-tab
          :class="{ active: showOverview }"
          @click="
            showOverview = true;
            showJob = false;
            showDescription = false;
            showAddress=false;
          "
          >Overview</v-tab
        >
        <v-tab
          :class="{ active: showJob }"
          @click="
            showOverview = false;
            showJob = true;
            showDescription = false;
            showAddress=false;
          "
          >Activities</v-tab
        >
        <v-tab
          :class="{ active: showDescription }"
          @click="
            showOverview = false;
            showJob = false;
            showDescription = true;
            showAddress=false;
          "
          >Description</v-tab
        >
        <v-tab
          :class="{ active: showAddress }"
          @click="
            showOverview = false;
            showJob = false;
            showDescription = false;
            showAddress=true;
          "
          >Address</v-tab
        >
      </v-tabs>
    </div>
    <v-tab-item>
      <div
        v-if="!showJob && !showDescription && showOverview &&!showAddress"
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
            <span  style="margin-left: 25%">{{
              company.company_name
           
            }} </span
            ><br /><br />
            <label
              for="company name"
              class="ps-0"
              style="font-weight: 600; text-align: inherit"
              >Phone Number</label
            >
            <span style="margin-left: 26%">{{
              company.phone_number
            }}</span
            ><br /><br />
            <label
              for="companyemail"
              class="ps-0"
              style="font-weight: 600; text-align: inherit"
              >Company Email</label
            >
            <span  style="margin-left: 25%">{{
              company.company_email
            }}</span>
          </v-card-text>
        </v-card>
      </div>
    </v-tab-item>
    <v-tab-item>
      <v-card
        v-if="showDescription && !showOverview && !showJob &&!showAddress"
        class="card2"
        style="margin-bottom: 20px"
        
      >
      <v-icon @click="openModal" style="margin-left: 97%">mdi-pencil</v-icon>
        <v-card-title style="font-family: Poppins, sans-serif"
          ><v-icon>mdi-domain</v-icon> Description:</v-card-title
        >
        <v-card-text>
          <div style="font-family: sans-serif" >
            {{ company.description }}
          </div>
        </v-card-text>
      </v-card>
    </v-tab-item>
    <v-dialog v-model="modalOpen" max-width="500">
    <v-card>
        <v-card-title>
            <span class="headline">Edit Description</span>
        </v-card-title>
        <v-card-text>
            <v-textarea  v-model="editedDescription.description" label="Description" outlined></v-textarea>
        </v-card-text>
        <v-card-actions>
            <v-btn color="primary" @click="saveDescription">Save</v-btn>
            <v-btn color="error" @click="closeModal">Close</v-btn>
        </v-card-actions>
    </v-card>
</v-dialog>
    <v-tab-item>
      <v-card
        v-if="showJob"
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
    </v-tab-item>
    <v-tab-item>
  <v-card
  v-if="showAddress"
    class="card2"
    style="margin-bottom: 20px; font-size: 16px"
  >
  <v-icon @click="openEditAddressModal()"  style="margin-left: 97%">mdi-pencil</v-icon>
  
    <v-card-title style="font-family: Poppins, sans-serif"
      >Address:</v-card-title
    >
    <v-table  v-if="address">
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
</v-tab-item>
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
import { useUsersStore } from "../store/user";
export default {
  name: "CompanyProfile",
  setup() {
    const company = ref([]);
    const address=ref({
    first_line_address: "",
      street: "",
      city: "",
      state: "",
      postal_code: "",
  });

     const store = useUsersStore () ;
    const user = ref([]);
    const fileInput = ref();
    const image = ref(null);
    const isEditModalOpen = ref(false);
    const modalOpen = ref(false);
    const editedDescription = ref({
      description:''
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
    const showOverview = ref(true);
    const showJob = ref(false);
    const showAddress = ref(false);
    const showDescription = ref(false);
    const isEditAddressModalOpen = ref(false);
    const fetchCompanyProfile = async () => {
      try {
        const response = await axios.get(`/company/list`);
        company.value = response.data.companydata;
        // store.company.company_name
        user.value = response.data.user;
         address.value=response.data.companydata.address ;
       console.log(response.data.companydata.address);
      } catch (error) {
        console.error("Error fetching company profile:", error);
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
        window.location.reload();
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
    isEditAddressModalOpen.value = true;

    if (company.value?.address) {
        editedAddress.value.first_line_address = company.value.address.first_line_address || '';
        editedAddress.value.street = company.value.address.street || '';
        editedAddress.value.city = company.value.address.city || '';
        editedAddress.value.state = company.value.address.state || '';
        editedAddress.value.postal_code = company.value.address.postal_code || '';
    } else {
        
        editedAddress.value.first_line_address = '';
        editedAddress.value.street = '';
        editedAddress.value.city = '';
        editedAddress.value.state = '';
        editedAddress.value.postal_code = '';
    }
};
    const closeEditAddressModal = () => {
      isEditAddressModalOpen.value = false;
    };
   
    const saveEditedAddress = async () => {
      try {
        const formData = new FormData();
        formData.append("first_line_address",  editedAddress.value.first_line_address);
        formData.append("street",  editedAddress.value.street);
        formData.append("city", editedAddress.value.city);
        formData.append("state",  editedAddress.value.state);
        formData.append("postal_code",  editedAddress.value.postal_code);
        const response = await axios.post("/company/updateaddress", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        });
        closeEditAddressModal();
        window.location.reload();
      } catch (error) {
        console.error("Error updating company profile:", error);
      }
    };
    const openModal = () => {
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
        const response = await axios.post("/company/updatedescription", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        });
        closeModal();
         window.location.reload();
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
      address,
      modalOpen,
      editedDescription,
      store,
      openModal,
      saveDescription,closeModal
    };
  },
};
</script>

<style scoped>


.background-image {

  position: absolute;

  width: 100%;
  height: 170px;

  background: linear-gradient(
      0deg,
      rgba(94, 94, 94, 0.7),
      rgba(99, 99, 99, 0.7)
    ),
    url(/storage/assest/6.jpg);
  background-size: cover;
  opacity: 0.5;
  background-repeat: no-repeat;
}

.active {
  background-color: rgb(122, 118, 118);
  color: white;
}

.user-name {
  color: white;
  background-color: black;
}
</style>
