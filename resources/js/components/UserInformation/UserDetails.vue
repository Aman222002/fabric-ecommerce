<!-- <template>
  <div>
    <v-card-title class="mb-2"> Basic Information </v-card-title>
    <v-row class="px-4">
      <v-col cols="12">
        <v-text-field
          label="Name"
          v-model="users.name"
          name="name"
          variant="outlined"
        ></v-text-field>
      </v-col>
      <v-col cols="12">
        <v-text-field
          label="Email"
          v-model="users.email"
          name="email"
          variant="outlined"
        ></v-text-field>
      </v-col>
      <v-col cols="12">
    
        <vue-tel-input
        @input="handlePhoneInput"
          :value="users.phone"
          name="phone"
          variant="outlined"
          label="Phone"
          mode="international"
          @validate="telValidate"
        ></vue-tel-input>
        <span v-if="errorMessage" class="error">{{ errorMessage }}</span> 
      </v-col>
      <v-col cols="12">
        <v-file-input
          label="Image"
          name="user_image"
          v-model="selectedImage"
          variant="outlined"
          @change="handleImage"
          accept="image/*"
        ></v-file-input>
      </v-col>
      <v-col class="ml-10 user_image" cols="12">
        <img
          v-if="imagePreview"
          :src="imagePreview"
          style="width: 200px; height: 200px; border-radius: 15px"
        />
      </v-col>
    </v-row>
  </div>
</template>
<script>
import axios from "axios";
import { ref, onMounted } from "vue";
import { useMyStore } from "../../store";
export default {
  name: "UserDetails",
  setup() {
    const errorMessage = ref("");
    const store = useMyStore();
    const users = ref(store.userDetails);
    const selectedImage = ref(null);
   
    const handlePhoneInput = (event) => {
      try {
        if (typeof event === "string") {
          users.value.phone = event;
        } else if (event && event.target && event.target.value) {
          users.value.phone = event.target.value;
        } else {
          console.error("Invalid event:", event);
        }
      } catch (error) {
        console.error("Error handling phone input:", error);
      }
    };
    const telValidate = (isValid, phoneNumber, country) => {
      console.log("Is Valid:", isValid);
      console.log("Phone Number:", phoneNumber);
      console.log("Country:", country);
      if (isValid.valid==false) {
        console.log("Invalid Phone Number");
        errorMessage.value = "Enter a valid phone number";
      } else {
      
        console.log("Valid Phone Number");
        errorMessage.value = ""; 
       
      }
    };
    const imagePreview = ref("");
    console.log(store.userDetails.user_image);
    const handleImage = (e) => {
      const file = e.target.files[0];
      console.log(file.name);
      store.userDetails.user_image = file;
      console.log(store.userDetails.user_image);
      console.log(e);
      const reader = new FileReader();
      reader.onload = () => {
        imagePreview.value = reader.result;
      };
      reader.readAsDataURL(file);
    };
    onMounted(() => {
      const storedImage = store.userDetails.user_image;
      if (storedImage instanceof Blob) {
        const reader = new FileReader();
        reader.onload = () => {
          imagePreview.value = reader.result;
        };
        reader.readAsDataURL(storedImage);
      }
    });

    return {
      users,
      handleImage,
      imagePreview,
      selectedImage,errorMessage,telValidate,handlePhoneInput
    };
  },
};
</script>

<style scoped></style>
 -->

 <template>
  <div>
    <v-card-title class="mb-2"> Basic Information </v-card-title>
    <v-row class="px-4">
      <v-col cols="12">
        <v-text-field
          label="Name"
          v-model="users.name"
          name="name"
          variant="outlined"
        ></v-text-field>
      </v-col>
      <v-col cols="12">
        <v-text-field
          label="Email"
          v-model="users.email"
          name="email"
          variant="outlined"
        ></v-text-field>
      </v-col>
      <v-col cols="12">
        <!-- <v-text-field
          label="Phone"
          v-model="users.phone"
          name="phone"
          variant="outlined"
        ></v-text-field> -->
        <vue-tel-input
        @input="handlePhoneInput"
          :value="users.phone"
          name="phone"
          variant="outlined"
          label="Phone"
          mode="international"
          @validate="telValidate"
        ></vue-tel-input>
        <span v-if="errorMessage" class="error">{{ errorMessage }}</span> 
      </v-col>
      <v-col cols="12" @dragover.prevent @drop="handleImageDrop">
        <v-file-input
          label="Image"
          name="user_image"
          v-model="selectedImage"
          variant="outlined"
          @change="handleImage"
          accept="image/*"
         
        >
       </v-file-input>
      </v-col>
      <v-col class="ml-10 user_image" cols="12">
        <img
          v-if="imagePreview"
          :src="imagePreview"
          style="width: 200px; height: 200px; border-radius: 15px"
        />
      </v-col>
    </v-row>
  </div>
</template>
<script>
import axios from "axios";
import { ref, onMounted } from "vue";
import { useMyStore } from "../../store";
export default {
  name: "UserDetails",
  setup() {
    const errorMessage = ref("");
    const store = useMyStore();
    const users = ref(store.userDetails);
    const selectedImage = ref([]);
    const handlePhoneInput = (event) => {
      try {
        if (typeof event === "string") {
          users.value.phone = event;
        } else if (event && event.target && event.target.value) {
          users.value.phone = event.target.value;
        } else {
          console.error("Invalid event:", event);
        }
      } catch (error) {
        console.error("Error handling phone input:", error);
      }
    };
    const telValidate = (isValid, phoneNumber, country) => {
      console.log("Is Valid:", isValid);
      console.log("Phone Number:", phoneNumber);
      console.log("Country:", country);
      if (isValid.valid==false) {
        console.log("Invalid Phone Number");
        errorMessage.value = "Enter a valid phone number";
      } else {
        console.log("Valid Phone Number");
        errorMessage.value = ""; 
      }
    };
    const imagePreview = ref("");
    console.log(store.userDetails.user_image);
    const handleImage = (e) => {
      const file = e.target.files[0];
    
      console.log(file.name);
      store.userDetails.user_image = file;
      selectedImage.value = [file];
      console.log(store.userDetails.user_image);
      console.log(e);
      const reader = new FileReader();
      reader.onload = (e) => {
        console.log(e);
        imagePreview.value = reader.result;
      };
      reader.readAsDataURL(file);
    };
    const handleImageDrop = (e) => {
      const file = e.dataTransfer.files[0];
      
      store.userDetails.user_image = file;
      selectedImage.value = [file];
      if (file) {
        if (!file.type.startsWith("image/")) {
          alert("Please drop a valid image file.");
          return;
        }
        const reader = new FileReader();
        reader.onload = (e) => {
          imagePreview.value = reader.result;
        };
        reader.readAsDataURL(file);
      }
    };

onMounted(() => {
  const storedImage = store.userDetails.user_image;
  const formData = new FormData();

  if (storedImage) {
    if (storedImage instanceof Blob) {   
  
      const reader = new FileReader();
      reader.onload = (e) => {
        imagePreview.value = e.target.result;
        selectedImage.value = [storedImage];
      };
      reader.readAsDataURL(storedImage);
      formData.append('user_image', storedImage);
    } else if (typeof storedImage === "string") {
    
      axios
        .get(`/storage/assest/${storedImage}`, { responseType: "blob" })
        .then((response) => {
          const file = new File([response.data], storedImage);
          imagePreview.value = `/storage/assest/${storedImage}`;
          selectedImage.value = [file];
          
          // Append the File to the FormData
          formData.append('user_image', file);
        })
        .catch((error) => {
          console.error("Error fetching image:", error);
        });
    }
  }
});

    return {
      users,
      handleImage,
      imagePreview,
      selectedImage,errorMessage,telValidate,handlePhoneInput,handleImageDrop, 
    };
  },
};
</script>

<style scoped></style>


