<template>
  <v-container>
    <v-alert
      v-if="warningMessage"
      :value="true"
      type="warning"
      dense
      outlined
      color="blue"
    >
      {{ warningMessage }}
    </v-alert>
    <v-card class="elevation-12 mt-3 form_log_reg" style="margin-bottom: 10px">
      <v-form ref="form" @submit.prevent="submitForm()" class="custom-form">
        <v-row class="form_page">
          <v-col class="form_page_left" sm="12" md="12" lg="6" xl="6" cols="12">
            <v-card-text>
              <p
                class="text-center"
                style="font-size: 20px; font-style: sans-serif"
              >
                Employers Register
              </p>
              <v-row style="margin-top: 20px">
                <v-col cols="12">
                  <h4 class="form-title">User Detail:</h4>
                </v-col>
                <v-col sm="12" md="12" lg="6" xl="6" cols="12">
                  <v-text-field
                    variant="outlined"
                    v-model="company.name"
                    label="Representative Name"
                    :rules="nameRules"
                    density="compact"
                    outlined
                    :disabled="disabledFields"
                  ></v-text-field>
                </v-col>
                <v-col sm="12" md="12" lg="6" xl="6" cols="12">
                  <v-text-field
                    variant="outlined"
                    v-model="company.email"
                    label="Representative Email"
                    :rules="emailRules"
                    density="compact"
                    outlined
                    :disabled="disabledFields"
                  ></v-text-field>
                </v-col>
                <v-col sm="12" md="12" lg="6" xl="6" cols="12">
                  <v-text-field
                    variant="outlined"
                    v-model="company.password"
                    label="Password"
                    :rules="passwordRules"
                    density="compact"
                    outlined
                    :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                    @click:append="showPassword = !showPassword"
                    :type="showPassword ? 'text' : 'password'"
                  ></v-text-field>
                </v-col>
                <v-col sm="12" md="12" lg="6" xl="6" cols="12">
                  <!-- <v-text-field
                    variant="outlined"
                    v-model="company.phone"
                    label="Phone"
                    :rules="phoneRules"
                    type="phone"
                    density="compact"
                    outlined
                    :disabled="disabledFields"
                    mask="##########"
                        hide-details="auto"
                    @input="filterNonNumeric"
                  ></v-text-field> -->
                  <vue-tel-input
                    variant="outlined"
                    v-model="company.phone"
                      :value="disabledFields ? company.phone : ''"
                    @validate="teluser"
                    label="Phone"
                    :rules="phoneRules"
                    type="phone"
                    density="compact"
                    :disabled="disabledFields"
                    mask="##########"
                    :autoDefaultCountry='false'
                    v-if="showCompanyDetails"
                        hide-details="auto"
                    
                        mode="international"
                        :class="{'error-border': formSubmitted && company.phoneErrors}"
                      ></vue-tel-input>
                      <span v-if="formSubmitted && company.phoneErrors" class="error-message">{{
                        company.phoneErrors
                      }}</span>
                </v-col>
              </v-row>
              <div v-if="showCompanyDetails">
                <v-row>
                  <v-col cols="12" sm="12">
                    <h4 class="form-title">Company Details:</h4>
                  </v-col>
                  <v-col sm="12" md="12" lg="6" xl="6" cols="12">
                    <v-text-field
                      variant="outlined"
                      v-model="company.company_name"
                      label="Company Name"
                      :rules="nameRules"
                      density="compact"
                      outlined
                    ></v-text-field>
                  </v-col>
                  <v-col sm="12" md="12" lg="6" xl="6" cols="12">
                    <v-text-field
                      variant="outlined"
                      v-model="company.company_email"
                      label="Company Email"
                      :rules="emailRules"
                      density="compact"
                      outlined
                    ></v-text-field>
                  </v-col>
                  <v-col sm="12" md="12" lg="6" xl="6" cols="12">
                    <!-- <v-text-field
                      variant="outlined"
                      v-model="company.phone_number"
                      label="Phone Number"
                      :rules="phoneRules"
                      density="compact"
                      mask="##########"
                        hide-details="auto"
                      @input="filterNonNumerical"
                      outlined
                    ></v-text-field> -->
                    <vue-tel-input
                    variant="outlined"
                      v-model="company.phone_number"
                      label="Phone Number"
                      :rules="phoneRules"
                      @validate="telValidate"
                      density="compact"
                      mask="##########"
                        hide-details="auto"
                    
                      outlined
                        mode="international"
                        :autoDefaultCountry='false'
                        :class="{'error-border': formSubmitted && company.phoneError}"
                      ></vue-tel-input>
                      <span v-if="formSubmitted && company.phoneError" class="error-message">{{
                        company.phoneError
                      }}</span>
                  </v-col>
                  <v-col sm="12" md="12" lg="6" xl="6" cols="12">
                    <v-file-input
                      variant="outlined"
                      v-model="company.logo"
                      label="Company Logo"
                      outlined
                      density="compact"
                    ></v-file-input>
                  </v-col>
                </v-row>
              </div>
              <v-col cols="12" class="text-center">
                <v-btn type="submit" class="custom-button">
                  Register Company
                </v-btn>
              </v-col>
            </v-card-text>
          </v-col>
          <v-col
            class="blue form_page_right"
            sm="12"
            md="12"
            lg="6"
            xl="6"
            cols="12"
          >
            <v-card-text class="white--text text-center">
              <p style="font-size: 20px">Already Sign up?</p>
              <p style="font-size: 13px; margin: 15px 0">
                Log in to your account so you can continue building and
                <br />
                editing your onboarding flows
              </p>
              <a href="/company/login" class="company_loging">Login</a>
            </v-card-text>
          </v-col>
        </v-row>
      </v-form>
    </v-card>
  </v-container>
</template>
<script>
import { ref, onMounted,computed } from "vue";
import { useUsersStore } from "../store/user";
import axios from "axios";

export default {
  name: "CompanyRegister",
  props: {
    data: {
      type: Object,
      default: () => ({}),
    },
  },
  setup(props) {
    const usersStore = useUsersStore();
    const form = ref(null);
    const company = ref({
      name: "",
      email: "",
      password: "",
      phone: "",
      company_name: "",
      company_email: "",
      phone_number: "",
      status: "1",
      logo: [],
      phoneError: "",
      phoneErrors: "",
    });
    const warningMessage = ref("");
    const nameRules = [(v) => !!v || "Name is required"];
    const emailRules = [
      (v) => !!v || "Email is required",
      (v) => /.+@.+\..+/.test(v) || "Enter a valid email",
    ];
    const passwordRules = [(v) => !!v || "Password is required"];
    const phoneRules = [
 
  (v) =>
    /^[0-9]{10}$/.test(v) || "Enter a valid 10-digit phone number",
 
];
    const stateRules = [(v) => !!v || "State is required"];
    const cityRules = [(v) => !!v || "city is required"];
    const formSubmitted = ref(false);
    const postalCodeRules = [
      (v) => !!v || "Postal code is required",
      (v) => /^[0-9]{6}$/.test(v) || "Enter a valid 6-digit postal code",
    ];
 
    const phoneValidationRule = computed(() => {
      return validatePhone() || "Enter a valid phone numbe";
    });
   

//     const telValidate = (telnumber) => {
//   if (telnumber && telnumber.valid) {
//     company.value.phone_number = telnumber.number;
//     if (/[a-zA-Z]/.test(telnumber.number)) {
//       console.log("Alphabets detected in phone number");
//       company.value.phoneError = "Enter a valid phone number";
//     } else {
//       company.value.phoneError = "";
//     }
//   } else {
//     company.value.phone_number = null;
//     company.value.phoneError = "Enter a valid phone number";
//   }
// };
const telValidate = (telnumber) => {
  
  if (telnumber && telnumber.valid) {
    if (!telnumber.number || telnumber.number.trim() === "") {
      company.value.phone_number = null;
      company.value.phoneError = "Phone number is required";
    } else {
      company.value.phone_number = telnumber.number;

      if (/[a-zA-Z]/.test(telnumber.number)) {
        console.log("Alphabets detected in phone number");
        company.value.phoneError = "Enter a valid phone number";
      } else {
        company.value.phoneError = "";
      }
    }
  } else {
    
    company.value.phone_number = null;
    company.value.phoneError = "Enter a valid phone number";
  }
};
    
    
    const teluser = (telnumber) => {
  if (telnumber && telnumber.valid) {
    if (!telnumber.number || telnumber.number.trim() === "") {
      company.value.phone = null;
      company.value.phoneErrors = "Phone number is required";
    } else{
    company.value.phone = telnumber.number;
    if (/[a-zA-Z]/.test(telnumber.number)) {
      console.log("Alphabets detected in phone number");
      company.value.phoneErrors = "Enter a valid phone number";
    } else {
      company.value.phoneErrors = "";
    }
    }
   } 
 else {
    company.value.phone = null;
    company.value.phoneErrors = "Enter a valid phone number";
  }
};


    const showCompanyDetails = ref(true);
    const disabledFields = ref(false);
    const showPassword = ref(false);
    onMounted(() => {
      const value = props.data;
      console.log(value);
      company.value.name = props.data.name;
      company.value.email = props.data.email;
      company.value.phone = props.data.phone;
    
      if (props.data.name) {
        company.value.name = props.data.name.replace(/\+/g, " ");
        company.value.email = props.data.email;
        company.value.phone = props.data.phone;
        disabledFields.value = true;
      }
      if (window.location.pathname === "/company/register") {
        showCompanyDetails.value = true;
      } else {
        showCompanyDetails.value = false;
      }
    });
   
    const submitForm = () => {
   console.log(props.data);
   if (props.data.permission) {
   const formData = new FormData();
            for (let key in company.value) {
              if (key !== "logo") {
                formData.append(key, company.value[key]);
              } else {
                formData.append("logo", company.value[key][0]);
              }
            }
  
              formData.append("company_Id", props.data.company);
              formData.append("permission", props.data.permission);
            
            console.log(props.data.permission);
            axios
              .post("/company/post", formData, {
                headers: {
                  "Content-Type": "multipart/form-data",
                },
              })
              .then((response) => {
                if (response.data.status == true) {
                  window.location.href = "/company/login";
                }
              })
            }
      formSubmitted.value = true;
      
     telValidate({ valid: true, number: company.value.phone_number });
     if (company.value.phoneError) {
       return;
     }
     teluser({ valid: true, number: company.value.phone });
     if (company.value.phoneErrors) {
       return;
     }
    console.log('here');
  form.value.validate().then((valid) => {
   
    if (!valid.valid) {
      
      const errors = JSON.parse(JSON.stringify(valid.errors));
      let errorField = form.value[errors[0].id];
      errorField = Array.isArray(errorField) ? errorField[0] : errorField;
      errorField.scrollIntoView({
        behavior: "smooth",
        block: "center",
        inline: "center",
      });
    } else {
      
      axios
        .post("/company/check", {
          company_name: company.value.company_name,
          company_email: company.value.company_email,
        })
        .then((response) => {
          if (response.data.exists) {
        //     window.Swal.fire({
        //   toast: true,
        //   position: "top-end",
        //   timer: 2000,
        //   showConfirmButton: false,
        //   icon: "error",
        //   title: "Company Email And Company Name Already Exist",
        // });
        warningMessage.value = "Company Email And Company Name Already Exist.";
          } else {
          
            const formData = new FormData();
            for (let key in company.value) {
              if (key !== "logo") {
                formData.append(key, company.value[key]);
              } else {
                formData.append("logo", company.value[key][0]);
              }
            }
            if (props.data.permission) {
              formData.append("company_Id", props.data.company);
              formData.append("permission", props.data.permission);
            }
            console.log(props.data.permission);
            axios
              .post("/company/post", formData, {
                headers: {
                  "Content-Type": "multipart/form-data",
                },
              })
              .then((response) => {
                if (response.data.status == true) {
                  window.location.href = "/company/login";
                }
              })
              .catch((error) => {
                console.error("Error:", error);
              });
          }
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    }
  });
};


    return {
      form,
      company,
      submitForm,
      nameRules,
      emailRules,
      passwordRules,
      postalCodeRules,
      phoneRules,
      cityRules,
      stateRules,
      usersStore,
      showCompanyDetails,warningMessage,
      disabledFields,showPassword,telValidate ,phoneValidationRule,teluser, formSubmitted,
    };
  },
};
</script>

<style scoped>
.blue {
  background-color: rgb(54, 194, 250);
}

.form_page {
  margin: 25px;
}

.form_page_right {
  border-bottom-left-radius: 250px;
  display: flex;
  align-items: center;
  text-align: center;
}

.form_page_left button.v-btn,
.form_page_right button.v-btn {
  min-width: 150px;
  margin: 0 auto;
  background-color: #0146a6;
  font-size: 17px;
  line-height: 20px;
  font-weight: 400;
  padding: 11px 0;
  height: 100%;
  border-radius: 5px !important;
  color: #fff;
  text-transform: capitalize;
}

.form_page_left button.v-btn {
  min-width: 260px;
}

a.company_loging {
  display: flex;
  width: 150px;
  margin: 15px auto;
  background-color: #0146a6;
  font-size: 17px;
  line-height: 20px;
  font-weight: 400;
  padding: 11px 0;
  border-radius: 5px;
  color: #fff;
  justify-content: center;
}
.form_log_reg {
  border-radius: 15px;
}
.error-message {
  color:#B00020;
  font-size: 12px ;
  font-family: Roboto,sans-serif;
  margin-left: 13px;
}
.error-border {
  border-color: #B00020 !important; 
}
</style>
