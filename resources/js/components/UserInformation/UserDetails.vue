<!-- 
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
</script> -->
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
        <vue-tel-input
          @input="handlePhoneInput"
          
          :value="formattedPhone"
          name="phone"
          variant="outlined"
          label="Phone"
          mode="international"
          @validate="telValidate"
        ></vue-tel-input>
        <span v-if="phoneErrorMessage" class="error">{{ phoneErrorMessage }}</span> 
      </v-col>
      <v-col cols="12" @dragover.prevent @drop="handleImageDrop">
        <v-file-input
          label="Image"
          name="user_image"
          v-model="selectedImage"
          variant="outlined"
          :rules="[v=> v || 'Image is required.',customeValidation]"
          @change="handleImage"
          accept="image/png, image/jpeg"
        
        >
        </v-file-input>
        <span v-if="imageErrorMessage" class="error">{{ imageErrorMessage }}</span>
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
import { ref, onMounted,computed,reactive,toRefs} from "vue";
import { useMyStore } from "../../store";

export default {
  name: "UserDetails",
  setup() {
    const phoneErrorMessage = ref("");
    const imageErrorMessage = ref("");
    const store = useMyStore();
    const users = ref(store.userDetails);
    const selectedImage = ref([]);
    const imagePreview = ref("");
    const customeValidation = ()=>{
      if (selectedImage.value.length === 0) {
        return 
      }
      console.log(selectedImage.value)
      
      return ["image/png", "image/jpeg"].includes(selectedImage.value[0].type) || 'Please upload a valid PNG, JPG, Or JPEG image';
    };
    const formattedPhone = computed(() => {
  try {
    if (users.value && users .value.country_code && users .value.phone) {
      console.log("Country Code:", users.value.country_code);
      console.log("Phone:",users.value.phone);

      const countryCode =users.value.country_code;
      const phoneNumber = String(users.value.phone);

      return `${countryCode}${phoneNumber}`;
    } else {
      console.warn("Country code or phone number is missing.");
      return users.value.phone || '';
    }
  } catch (error) {
    console.error("Error in formattedPhone computed property:", error);
    return '';
  }
});
    const handlePhoneInput = (event) => {
      // try {
      //   if (typeof event === "string") {
      //     users.value.phone = event;
      //   } else if (event && event.target && event.target.value) {
      //     users.value.phone = event.target.value;
      //   } else {
      //     console.error("Invalid event:", event);
      //   }
      // } catch (error) {
      //   console.error("Error handling phone input:", error);
      // }
    };

   
    const telValidate = (isValid) => {
      console.log("Is Valid:", isValid);

      if (isValid.valid === true) {
       
        phoneErrorMessage.value = "";
        users.value.phone=isValid.nationalNumber;
        users.value.country_code=isValid.countryCallingCode;
        return true;
      } else {
        console.log("Invalid Phone Number");
        phoneErrorMessage.value = "Enter a valid phone number";
        return false;
      }
    };

    const handleImage = (e) => {
      console.log('user_image',e);
      console.log('user_image',selectedImage.value);
      const file = e.target.files[0];
      store.userDetails.user_image = file;
      selectedImage.value = [file];

      const reader = new FileReader();
      reader.onload = (e) => {
        imagePreview.value = reader.result;
      };
      reader.readAsDataURL(file);
    };

    const handleImageDrop = (e) => {
      console.log(e);
      const file = e.dataTransfer.files[0];
      if (file && !["image/png", "image/jpeg"].includes(file.type)) {
        imageErrorMessage.value = "Please upload a valid PNG, JPG, Or JPEG image";
        return;
      }
      imageErrorMessage.value = "";
      store.userDetails.user_image = file;
      selectedImage.value = [file];

      const reader = new FileReader();
      reader.onload = (e) => {
        imagePreview.value = reader.result;
      };
      reader.readAsDataURL(file);
    };
    const reactiveObject = reactive({
  name: '',
  email: '',
  phone: '',
  country_code: '',
  status: [],
  user_image: ''
  
});
const user = ref([]);
const fetchuserProfile = async () => {
      try {
        const response = await axios.get(`/my-profile`);
        const { data } = response.data;
        user.value = data.userDetails;
        
        // Check if user_image is a filename (string)
        if (typeof user.value.user_image === 'string') {
         
          imagePreview.value = `/storage/assest/${user.value.user_image}`;
        } else {
          console.error("user_image is not a string (filename):", user.value.user_image);
         
        }
      } catch (error) {
        console.error("Error fetching user profile:", error);
      }
    };
    const storedImage = ref(null);
    onMounted(() => {
      fetchuserProfile().then(() => {
        console.log(user.value.user_image);
        storedImage.value = user.value.user_image; 
      });
    // console.log(  user.user_image);
     
    //   console.log(storedImage)
    //   reactiveObject.user_image = storedImage;
    //  console.log(storedImage);
      // if (storedImage) {
      //   reactiveObject.user_image = storedImage;
      //   console.log('hete' ,storedImage)
      // }
     
      const formData = new FormData();

      if (storedImage) {
       
        if (storedImage instanceof Blob) {
     console.log('here');
          const reader = new FileReader();
          reader.onload = (e) => {
            console.log(e);
            imagePreview.value = e.target.result;
            console.log(imagePreview.value);
            selectedImage.value = [storedImage];
          };
          reader.readAsDataURL(storedImage);
         // formData.append('user_image', storedImage);
        } else if (typeof storedImage === "string") {
         
          console.log('here');
          axios
            .get(`/storage/assest/${storedImage}`, { responseType: "blob" })
            .then((response) => {
              const file = new File([response.data], storedImage);
             
              // imagePreview.value = `/storage/assest/${storedImage}`;
              imagePreview.value = URL.createObjectURL(response.data);
              selectedImage.value = [file];
              console.log(selectedImage.value);
              selectedImage.value[0].type = file.name.substring(file.name.indexOf('.'),file.name.length);
              formData.append('user_image', file);
              //console.log('user_image',selectedImage.value);
             
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
      selectedImage,
      phoneErrorMessage,
      imageErrorMessage,
      telValidate,
      handlePhoneInput,
      handleImageDrop,
      customeValidation,formattedPhone,  reactiveObject,user ,storedImage
    };
  }
};
</script>

<style scoped></style>

