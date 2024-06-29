<!-- 
<template>
  <v-container fluid>
    <v-alert
      v-if="errorMessage"
      :value="true"
      type="warning"
      dense
      outlined
      color="blue"
    >
      {{ errorMessage }}
    </v-alert>
    <v-form @submit.prevent="addUser" class="form_fild_com" ref="form">
      <v-row>
        <v-col cols="12">
          <h2 class="mb-4 form_fild_title">User add:</h2>
        </v-col>
        <v-col sm="12" md="6" lg="6" xl="6" cols="12 " class="pb-0">
          <v-text-field
            v-model="userData.name"
            label="Name"
            variant="solo"
            density="compact"
            :rules="nameRules"
          ></v-text-field>
        </v-col>
        <v-col sm="12" md="6" lg="6" xl="6" cols="12" class="pb-0">
          <v-text-field
            v-model="userData.email"
            label="Email"
            variant="solo"
            density="compact"
            :rules="emailRules"
          ></v-text-field>
        </v-col>
        <v-col sm="12" md="6" lg="6" xl="6" cols="12">
        
          <vue-tel-input
                        v-model="userData.phone"
                      
                       
                        @validate="telValidate"

                        variant="solo"
            density="compact"
                     
                        mode="international"
                      ></vue-tel-input>
                      <span v-if="userData.phoneError" class="error-message">{{
                        userData.phoneError
                      }}</span>
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
            variant="solo"
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
      phoneError: "",
    });
    const form = ref(null);
    const nameRules = [(v) => !!v || "Name is required"];
    const emailRules = [
      (v) => !!v || "Email is required",
      (v) => /.+@.+\..+/.test(v) || "Enter a valid email",
    ];
    const phoneRules = [
      (v) => !!v || "Phone number is required",
      (v) => /^[0-9]{10}$/.test(v) || "Enter a valid 10-digit phone number",
    ];
    const errorMessage = ref(""); 
    const permissionRules = [
      (v) => (!!v && v.length > 0) || "Permission is required",
    ];
    const telValidate = (telnumber) => {
  if (telnumber && telnumber.valid) {
    userData.value.phone = telnumber.number;
    if (/[a-zA-Z]/.test(telnumber.number)) {
    
      userData.value.phoneError = "Phone number cannot contain alphabets";
    } else {
      userData.value.phoneError = "";
    }
  } else {
    userData.value.phone = null;
    userData.value.phoneError = "Enter a valid phone number";
  }
};
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
    const checkUsername = async () => {
      try {
        const response = await axios.post("/check-username", {
          username: userData.value.name,
        });
        return response.data.available;
      } catch (error) {
        console.error("Error checking username availability:", error);
        return false;
      }
    };

    onMounted(fetchPermissions);
    const addUser = async () => {
      telValidate({ valid: true, number: userData.value.phone });
      if (userData.value.phoneError) {
        return;
      }
      try {
        const usernameAvailable = await checkUsername();
        if (!usernameAvailable) {
         
          errorMessage.value = "Username already exist.";
          return;
        }
        const valid = await form.value.validate();
    if (!valid.valid) {
      const errors = JSON.parse(JSON.stringify(valid.errors));
      let errorField = form.value[errors[0].id];
      errorField = Array.isArray(errorField) ? errorField[0] : errorField;
      errorField.scrollIntoView({
        behavior: "smooth",
        block: "center",
        inline: "center",
      });
      window.Swal.fire({
              toast: true,
              position: 'top-end',
              timer: 2000,
              showConfirmButton: false,
              icon: 'error',
              title: 'use valid data',
            });
    } else {
      await axios.post("/admin/user/addnewuser", userData.value);
      userData.value.permission.forEach((permission) => {
         //console.log(permission);
       });
        window.Swal.fire({
              toast: true,
              position: 'top-end',
              timer: 2000,
              showConfirmButton: false,
              icon: 'success',
              title: 'Invitation sent Successfully to the user Email',
            });
        window.location.reload();
    }
  } catch (error) {
    console.error("Error during invitation:", error);
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
      phoneRules,form,telValidate,checkUsername,  errorMessage,
    };
  },
};
</script>
<style scoped>
.error-message {
  color: rgb(204, 65, 65);
  font-size: 13px;
}
</style>
 -->
 <template>
  <v-container fluid>
  
    <v-btn @click="dialog = true">Add User</v-btn>
    <v-dialog v-model="dialog" max-width="600px">
      <v-card>
        <v-card-title>User Add</v-card-title>
        <v-card-text>
          <v-alert
            v-if="errorMessage"
            :value="true"
            type="warning"
            dense
            outlined
            color="blue"
          >
            {{ errorMessage }}
          </v-alert>

          <v-form @submit.prevent="addUser" ref="form">
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="userData.name"
                  label="Name"
                  dense
                  :rules="nameRules"
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  v-model="userData.email"
                  label="Email"
                  dense
                  :rules="emailRules"
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <vue-tel-input
                v-model="userData.phone"
                        @validate="telValidate"

                        variant="solo"
            density="compact"
                     
                        mode="international"
                ></vue-tel-input>
                <span v-if="formSubmitted &&userData.phoneError" class="error-message">
                  {{ userData.phoneError }}
                </span>
              </v-col>
              <v-col cols="12">
                <v-select
                  v-model="userData.permission"
                  :items="userPermissions"
                  item-value="id"
                  item-text="name"
                  label="Permission"
                  multiple
                  chips
                  dense
                  small-chips
                  :rules="permissionRules"
                ></v-select>
              </v-col>
            </v-row>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn type="submit" color="blue darken-1">
                Send Invitation
              </v-btn>
              <v-btn color="blue darken-1" text @click="dialog = false">
                Cancel
              </v-btn>
             
            </v-card-actions>
          </v-form>
        </v-card-text>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script>
import { ref, onMounted } from "vue";
import axios from "axios";
import {Sweetalert} from '../utils/sweetalert';
export default {
  name: "UserForm",
  setup() {
    const userData = ref({
      name: "",
      email: "",
      phone: "",
      permission: [],
      phoneError: "",
    });
    const dialog = ref(false);
    const nameRules = [(v) => !!v || "Name is required"];
    const emailRules = [
      (v) => !!v || "Email is required",
      (v) => /.+@.+\..+/.test(v) || "Enter a valid email",
    ];
    const permissionRules = [
      (v) => (!!v && v.length > 0) || "Permission is required",
    ];

    const formSubmitted = ref(false);
    const form = ref(null);
  
    const phoneRules = [
      (v) => !!v || "Phone number is required",
      (v) => /^[0-9]{10}$/.test(v) || "Enter a valid 10-digit phone number",
    ];
    const errorMessage = ref(""); 
  
    const telValidate = (telnumber) => {
  if (telnumber && telnumber.valid) {
    userData.value.phone = telnumber.number;
    if (/[a-zA-Z]/.test(telnumber.number)) {
    
      userData.value.phoneError = "Phone number cannot contain alphabets";
    } else {
      userData.value.phoneError = "";
    }
  } else {
    userData.value.phone = null;
    userData.value.phoneError = "Enter a valid phone number";
  }
};
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
    const checkUsername = async () => {
      try {
        const response = await axios.post("/check-username", {
          username: userData.value.name,
        });
        return response.data.available;
      } catch (error) {
        console.error("Error checking username availability:", error);
        return false;
      }
    };

    onMounted(fetchPermissions);

 
    const addUser = async () => {
      formSubmitted.value = true;
      telValidate({ valid: true, number: userData.value.phone });
      if (userData.value.phoneError) {
        return;
      }
      try {
        const usernameAvailable = await checkUsername();
        if (!usernameAvailable) {
         
          errorMessage.value = "Username already exist.";
          return;
        }
        const valid = await form.value.validate();
    if (!valid.valid) {
      const errors = JSON.parse(JSON.stringify(valid.errors));
      let errorField = form.value[errors[0].id];
      errorField = Array.isArray(errorField) ? errorField[0] : errorField;
      errorField.scrollIntoView({
        behavior: "smooth",
        block: "center",
        inline: "center",
      });
   
            Sweetalert.error('use valid data')
    } else {
      await axios.post("/admin/user/addnewuser", userData.value);
      userData.value.permission.forEach((permission) => {
         //console.log(permission);
       });
      
            Sweetalert.success('Invitation sent Successfully to the user Email')
            dialog.value = false;
        window.location.reload();
    }
  } catch (error) {
    console.error("Error during invitation:", error);
  }
};

    return {
      userData,
      userPermissions,
      addUser,
      nameRules,
      emailRules,
      permissionRules,
      telValidate,
      errorMessage,
      dialog,form,checkUsername,phoneRules,formSubmitted,
    };
  },
};
</script>

<style scoped>
.error-message {
  color:#B00020;
  font-size: 12px ;
  font-family: Roboto,sans-serif;
  margin-left: 13px;
}
</style>
