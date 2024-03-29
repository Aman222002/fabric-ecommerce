
<template>
  <v-container fluid>
    <v-form @submit.prevent="addUser" class="form_fild_com">
      <v-row>
        <v-col cols="12">
          <h2 class="mb-4 form_fild_title">User add:</h2>
        </v-col>
        <v-col sm="12" md="6" lg="6" xl="6" cols="12">
          <v-text-field
            v-model="userData.name"
            label="Name"
            variant="outlined"
            density="compact"
            :rules="nameRules"
          ></v-text-field>
        </v-col>
        <v-col sm="12" md="6" lg="6" xl="6" cols="12">
          <v-text-field
            v-model="userData.email"
            label="Email"
            variant="outlined"
            density="compact"
            :rules="emailRules"
          ></v-text-field>
        </v-col>
        <v-col sm="12" md="6" lg="6" xl="6" cols="12">
          <v-text-field
            v-model="userData.phone"
            label="Phone"
            variant="outlined"
            density="compact"
            :rules="phoneRules"
          ></v-text-field>
        </v-col>
        <v-col sm="12" md="6" lg="6" xl="6" cols="12">
          <v-select
            v-model="userData.permission"
            :items="userPermissions"
            item-value="id"
            item-text="name"
            label="Permission"
            multiple
            chips
            :rules="permissionRules"
            variant="outlined"
            density="compact"
            small-chips
          ></v-select>
        </v-col>
        <v-col cols="12" class="text-center">
          <v-btn type="submit" class="form_fild_btn">Send Invitation</v-btn>
        </v-col>
      </v-row>
    </v-form>
  </v-container>
</template>
<script>
import { ref, onMounted } from "vue";
import axios from "axios";

export default {
  name: "UserForm",
  setup() {
    const userData = ref({
      name: "",
      email: "",
      phone: "",
      permission: [],
    });
    const nameRules = [(v) => !!v || "Name is required"];
    const emailRules = [
      (v) => !!v || "Email is required",
      (v) => /.+@.+\..+/.test(v) || "Enter a valid email",
    ];
    const phoneRules = [
      (v) => !!v || "Phone number is required",
      (v) => /^[0-9]{10}$/.test(v) || "Enter a valid 10-digit phone number",
    ];
  
    const permissionRules = [
      (v) => !!v && v.length > 0 || "Permission is required", 
    ];
    const userPermissions = ref([]);
    const fetchPermissions = async () => {
      try {
        const response = await axios.get("/permission");
        userPermissions.value = response.data.map((data) => data.name);
        console.log(userPermissions.value);
      } catch (error) {
        console.error("Error fetching permissions:", error);
      }
    };
    const selectCategory = (selectedCategory) => {
      userData.permission = selectedCategory.name;
    };

    onMounted(fetchPermissions);

    const addUser = async () => {
      try {
        await axios.post("/admin/user/addnewuser", userData.value);
        userData.value.permission.forEach((permission) => {
          //console.log(permission);
        });
        window.Swal.fire({
          icon: "success",
          title: "Invitation sent",
          text: "Invitation sent Successfully to the user Email",
          confirmButtonText: "OK",
        });
        window.location.reload(); 
      } catch (error) {
        console.error("Error adding user:", error);
      }
    };
    return {
      userData,
      userPermissions,
      addUser,
      selectCategory,
      nameRules,
      emailRules,
      permissionRules,
      phoneRules,
    };
  },
};
</script>
