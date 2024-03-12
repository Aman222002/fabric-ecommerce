
<template>
  <v-container fluid style="margin-top: 30px;">
    <v-row justify="center">
      <v-col cols="12" sm="8">
        <v-form @submit.prevent="addUser">
          <v-row>
            <v-col cols="7">
              <v-text-field v-model="userData.name" label="Name" variant="outlined" density="compact" :rules="nameRules"></v-text-field>
            </v-col>
            <v-col cols="7">
              <v-text-field v-model="userData.email" label="Email" variant="outlined" density="compact" :rules="emailRules"></v-text-field>
            </v-col>
            <v-col cols="7">
              <v-text-field v-model="userData.phone" label="Phone" variant="outlined" density="compact" :rules="phoneRules"></v-text-field>
            </v-col>
            <v-col cols="7">
              <v-select
                v-model="userData.permission"
                :items="userPermissions"
                item-value="id"
                item-text="name"
                label="Permission"
                multiple
                chips
                variant="outlined"
                density="compact"
                small-chips
              ></v-select>
            </v-col>
          </v-row>
          <v-row justify="center">
            <v-col cols="12">
              <v-btn type="submit" color="primary" style="text-align: center;">Send Invitation</v-btn>
            </v-col>
          </v-row>
        </v-form>
      </v-col>
    </v-row>
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
      permission:[]
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

    const userPermissions = ref([]);

    const fetchPermissions = async () => {
      try {
        const response = await axios.get("/permission");
        userPermissions.value = response.data.map(data => data.name);
        console.log( userPermissions.value)
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
        userData.value.permission.forEach(permission => {
      //console.log(permission);
    });
    window.Swal.fire({
                  icon: "success",
                  title: "Invitation sent",
                  text: "Invitation sent Successfully to the user Email",
                  confirmButtonText: "OK",
                });
        userData.value = {
          name: "",
          email: "",
          phone: "",
          permission: []
        };
       
      } catch (error) {
        console.error("Error adding user:", error);
      }
    };

    return {
      userData,
      userPermissions,
      addUser,selectCategory ,
      nameRules,
      emailRules,
     
      phoneRules,
    };
  }
};
</script>
