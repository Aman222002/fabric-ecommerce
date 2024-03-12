<template>
  <v-container class="background">
    <v-row align="center" justify="center">
      <v-col cols="12" sm="10">
        <v-card class="elevation-12 mt-3" style="margin-bottom: 10px;">
          <v-row>
            <v-col cols="12" md="6">
              <v-card-text class="mt-12">
                <v-form ref="form" @submit.prevent="submitForm">
                  <p class="text-center" style="font-size: 20px;font-style: sans-serif;">
                    Company Login
                  </p>
                  <v-row align="center" justify="center">
                    <v-col cols="12" sm="10">
                      <v-text-field label="Email" variant="outlined" v-model="formData.email" :rules="emailRules" dense
                        density="compact" color="blue" autocomplete="false" class="mt-8" style="font-size: 10px;" />
                 
                      <v-text-field label="Password" variant="outlined" v-model="formData.password" :rules="passRules"
                        dense density="compact" color="blue" autocomplete="false" type="password"
                        style="margin-top: 10px;font-size: 10px;" />
                      <v-row>
                        <v-col cols="12" sm="7">
                          <v-checkbox label="Remember Me" class="mt-n1" color="blue">
                          </v-checkbox>
                        </v-col>
                        <v-col cols="12" sm="5" class="mt-3">
                          <a href="/forget/password" class="register-link" style="text-decoration: none;">forgot
                            password?</a>
                        </v-col>
                      </v-row>
                      <v-btn type="submit" dark block tile color="primary" @click="showCompanyListDialog">Login</v-btn>
                    </v-col>
                  </v-row>
                </v-form>
              </v-card-text>
            </v-col>
            <v-col cols="12" md="6" class="blue rounded-bl-xl">
              <div class="text-center py-8" style="margin-top: 110px">
                <v-card-text class="white--text">
                  <p style="font-size: 20px">Don't Have an Account Yet?</p>
                  <p style="font-size: 13px; margin-top: 10px">
                    Let's get you all set up so you can start creating your
                    first onboarding experience
                  </p>
                  <v-btn color="primary" tile outlined dark @click="signup()" style="margin-top: 20px">Register Now</v-btn>
                </v-card-text>
              </div>
            </v-col>
          </v-row>
        </v-card>
      </v-col>
    </v-row>
    
    <v-dialog v-model="companyListDialog" max-width="500">
      <v-card>
        <v-card-title>Which Company You Want To Login ?</v-card-title>
        <v-card-text>
          <v-list>
            <v-list-item v-for="(company, index) in companyNames" :key="index" @click="selectedCompany = company">
  <v-list-item-title>{{ company.company_name }}</v-list-item-title>
</v-list-item>
          </v-list>
        </v-card-text>
       
      </v-card>
    </v-dialog>
    
  </v-container>
</template>

<script>
import { onMounted, ref, watch } from "vue";
import { useUsersStore } from "../store/user";
import axios from "axios";

export default {
  name: "Job",
  setup() {
    const usersStore = useUsersStore();
    const jobDialog = ref(false);
    const companyListDialog = ref(false);
    const selectedCompany = ref(null);
    const email = ref("");
    const password = ref("");
    const formData = ref({
      password: "",
      email: "",
      company_name:"",
    });
    const companyNameRules = [(v) => !!v || "Company Name is require"];
    const passRules = [(v) => !!v || "Password is require"];
    const emailRules = [
      (v) => !!v || "Email is required",
      (v) => /.+@.+\..+/.test(v) || "Enter a valid email address",
    ];
    const companyNames = ref([]);
    
    const submitForm = async () => {
      if (!formData.value.company_name) {
     
        return;
      }
      try {
        const response = await axios.post("/company/login", formData.value);
        if (response.data.status == true) {
          companyListDialog.value = false;
          usersStore.isLogIn();
          // console.log(response.data.company_data[0].company_name);
          // usersStore.company.company_name = response.data.company_data[0].company_name;
          // usersStore.company.company_email = response.data.company_data[0].company_email;
          // usersStore.company.phone = response.data.company_data[0].phone_number;
          console.log(response.data);
          window.location.href = "/findcv";
        }
      } catch (err) {
        console.error(err);
      }
    };
    
    const showCompanyListDialog = async () => {
      try {
        const response = await axios.get("/company/names",{params: {
          email: formData.value.email,
        }});
        console.log(formData.value.email)
        if (response.data.status == true) {
          companyNames.value = response.data.companyNames;
          companyListDialog.value = true;
        }
      } catch (err) {
        console.error(err);
      }
    };
    
    const closeCompanyListDialog = () => {
      companyListDialog.value = false;
    };
    
    const signup = async () => {
      window.location.href = "/company/register";
    };
    watch(selectedCompany, () => {
      if (selectedCompany.value) {
        formData.value.company_name = selectedCompany.value.company_name;
        submitForm();
      }
    });
    
    return {
      password,
      email,
      submitForm,
      companyNameRules,
      emailRules,
      formData,
      passRules,
      companyNames,
      showCompanyListDialog,
      closeCompanyListDialog,
      companyListDialog,
      signup, selectedCompany,
    };
  },
};
</script>

<style scoped>
.blue {
  background-color: rgb(54, 194, 250);
}

.rounded-bl-xl {
  border-bottom-left-radius: 250px;
}
.background{
  background-image: url('/storage/assest/1.png');
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
}
.v-list-item:hover{
background-color:  rgb(54, 194, 250);
}
</style>
 
 

