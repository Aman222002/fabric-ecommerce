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
        <v-text-field
          label="Phone"
          v-model="users.phone"
          name="phone"
          variant="outlined"
        ></v-text-field>
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
      <v-col cols="12">
        <img v-if="imagePreview" :src="imagePreview" style="max-width: 100%; height: auto;" />
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
    const store = useMyStore();
    const users = ref(store.userDetails);
    const selectedImage = ref(null);
    // const handleImage = (e)=>{
    //     console.log( e.target.files[0].name)
    //     store.userDetails.user_image = e.target.files[0];
    //     console.log(store.userDetails.user_image);
    //     console.log(e)
    // }
    const imagePreview = ref('');
console.log(store.userDetails.user_image)
const handleImage = (e)=>{
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
}
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
      handleImage,imagePreview,selectedImage
    };
  },
};
</script>

<style scoped></style>

