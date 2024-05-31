
  <template>
  <v-container>
    <v-alert
      v-if="errorMessage"
      :value="true"
      type="error"
      dense
      outlined
    >
      {{ errorMessage }}
    </v-alert>
    <v-row align="center" justify="center">
      <v-col cols="12" sm="10">
        <v-card class="elevation-6 mt-3" style="margin-bottom: 10px">
          <v-row class="form_page">
            <v-col
              class="blue form_page_right"
              sm="12"
              md="12"
              lg="6"
              xl="6"
              cols="12"
            >
              <v-card-text class="white--text">
                <p class="text-center" style="font-size: 20px">
                  Already Sign up?
                </p>
                <p class="text-center" style="font-size: 13px">
                  Log in to your account so you can continue building and
                  <br />
                  editing your onboarding flows
                </p>
                <v-btn
                  color="primary"
                  tile
                  outlined
                  dark
                  @click="login()"
                  style="margin-top: 20px"
                  >Login</v-btn
                >
              </v-card-text>
            </v-col>

            <v-col
              class="form_page_left"
              sm="12"
              md="12"
              lg="6"
              xl="6"
              cols="12"
            >
              <v-card-text class="mt-8">
                <v-form ref="form" @submit.prevent="submitForm">
                  <p class="text-center" style="font-size: 20px">
                    Candidates Sign Up for an Account
                  </p>

                  <v-row align="center" justify="center">
                    <v-col cols="12" sm="12">
                      <v-text-field
                        label="First Name"
                        variant="outlined"
                        density="compact"
                        color="blue"
                        autocomplete="false"
                        class="mt-4"
                        v-model="formData.name"
                        :rules="nameRules"
                        style="margin-bottom: 10px"
                      />

                      <v-text-field
                        label="Email"
                        variant="outlined"
                        density="compact"
                        color="blue"
                        autocomplete="false"
                        v-model="formData.email"
                        :rules="emailRules"
                        style="margin-bottom: 10px"
                      />
                      <v-text-field
                        label="Password"
                        variant="outlined"
                        density="compact"
                        color="blue"
                        autocomplete="false"
                        v-model="formData.password"
                        :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                        @click:append="showPassword = !showPassword"
                        :type="showPassword ? 'text' : 'password'"
                        :rules="passwordRules"
                        style="margin-bottom: 10px"
                      />
                      <v-text-field
                        label="Confirm Password"
                        variant="outlined"
                        density="compact"
                        color="blue"
                        autocomplete="false"
                        v-model="confirmPassword"
                        :rules="confirmPasswordRules"
                        style="margin-bottom: 10px"
                        :type="showPassword ? 'text' : 'password'"
                      >
                      </v-text-field>
                      <!-- <v-text-field
                        v-model="formData.phone"
                        :rules="phoneRules"
                        color="blue"
                        density="compact"
                        style="margin-bottom: 10px"
                        variant="outlined"
                        label="Phone"
                        mask="##########"
                        hide-details="auto"
                        @input="filterNonNumeric"
                      ></v-text-field> -->

                      <vue-tel-input
                        v-model="formData.phone"
                      
                       
                        @validate="telValidate"

                        color="blue"
                        density="compact"
                        style="margin-bottom: 10px"
                        variant="outlined"
                        label="Phone"
                        hide-details="auto"
                     
                        mode="international"
                      ></vue-tel-input>
                      <span v-if="formData.phoneError" class="error-message">{{
                        formData.phoneError
                      }}</span>

                      <v-btn type="submit" dark block tile color="primary"
                        >Register</v-btn
                      >
                    </v-col>
                  </v-row>
                </v-form>
              </v-card-text>
            </v-col>
          </v-row>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
import { ref, computed } from "vue";
import axios from "axios";

export default {
  name: "Registration",
  setup() {
    const valid = ref(false);
    const response = ref({});
    const formData = ref({
      name: "",
      email: "",
      password: "",
      phone: "",
      phoneError: "",
    });
    const phoneError = ref("");
    const confirmPassword = ref("");
    const confirmPasswordRules = [
      (v) => !!v || "Confirm password is required",
      (v) => v === formData.value.password || "Passwords do not match",
    ];
    const errorMessage = ref(""); 
    const form = ref(null);
    const nameRules = [
      (v) => !!v || "Full Name is required",
      (v) => (v && v.length >= 3) || "Full Name must be at least 3 characters",
    ];
    const emailRules = [
      (v) => !!v || "E-mail is required",
      (v) => /.+@.+\..+/.test(v) || "E-mail must be valid",
    ];
    const passwordRules = [
      (v) => !!v || "Password is required",
      (v) => (v && v.length >= 6) || "Password must be at least 6 characters",
    ];
    const phoneRules = [
      (v) => /^[0-9]{10}$/.test(v) || "Enter a valid 10-digit phone number",
    ];
    const phoneValidationRule = computed(() => {
      return validatePhone() || "Enter a valid phone number";
    });
    // const filterNonNumeric = (value) => {
    //   formData.value.phone = value.replace(/\D/g, "");
    // };
    // const filterNonNumeric = (value) => {
    //   if (typeof value === 'string') {
    //     formData.value.phone = value.replace(/\D/g, "");
    //   }
    // };
    const showPassword = ref(false);
    const checkUsername = async () => {
      try {
        const response = await axios.post("/check-username", {
          username: formData.value.name,
        });
        return response.data.available;
      } catch (error) {
        console.error("Error checking username availability:", error);
        return false;
      }
    };
    
    const telValidate = (telnumber) => {
  if (telnumber && telnumber.valid) {
    formData.value.phone = telnumber.number;
    if (/[a-zA-Z]/.test(telnumber.number)) {
    
      formData.value.phoneError = "Phone number cannot contain alphabets";
    } else {
      formData.value.phoneError = "";
    }
  } else {
    formData.value.phone = null;
    formData.value.phoneError = "Enter a valid phone number";
  }
};
//     const telValidate = (telnumber) => {
//   if (telnumber && telnumber.number) {
//     const countryCodeMatch = telnumber.number.match(/^\+\d{1,3}/);
//     console.log(countryCodeMatch);
//     if (countryCodeMatch) {
//       const countryCode = countryCodeMatch[0];
//       const digitsAfterCountryCode = telnumber.number
//         .replace(countryCode, "")
//         .replace(/\D/g, "");
//         console.log(digitsAfterCountryCode);
//       if (digitsAfterCountryCode.length >= 10) {
//         const formattedPhoneNumber = countryCode + digitsAfterCountryCode;
//         formData.value.phone = formattedPhoneNumber;
//         console.log( formData.value.phone)
//         formData.value.phoneError = "";
//       } else {
//         formData.value.phone = "";
//         formData.value.phoneError =
//           "Enter a valid phone numbe";
//       }
//     }
//   } else {
//     formData.value.phone = "";
//     formData.value.phoneError = "Enter a valid phone number";
//   }
// };

// const filterNonNumeric = (value) => {
//   if (typeof value === "string") {
//     const numericValue = value.replace(/\D/g, "");
//     const digitsAfterCountryCode = value.replace(/^\+\d{1,3}/, "").replace(/\D/g, "");
    
//     if (digitsAfterCountryCode.length < 6) {
//       formData.value.phoneError = "Enter a valid phone numbe";
//     } else if (digitsAfterCountryCode.length > 10 || /[^\d]/.test(numericValue.substring(10))) {
//       formData.value.phoneError = " phone number not valid";
//     } else if (/[a-zA-Z]/.test(value)) {
//       formData.value.phoneError = "Alphabets are not allowed";
//     } else if (/[^\d]/.test(value.substring(10))) {
//       formData.value.phoneError = "Alphabets are not allowed ";
//     } else {
//       formData.value.phoneError = "";
//     }
//     formData.value.phone = numericValue;
//   }
// };


    const submitForm = async () => {
      telValidate({ valid: true, number: formData.value.phone });
      if (formData.value.phoneError) {
        return;
      }
      try {
        const usernameAvailable = await checkUsername();
        if (!usernameAvailable) {
          // window.Swal.fire({
          //   toast: true,
          //   position: "top-end",
          //   timer: 2000,
          //   showConfirmButton: false,
          //   icon: "error",
          //   title: "Username already exist",
          // });
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
        } else {
          console.log(formData.value);
          const response = await axios.post("/registration", formData.value);
          if (response.data.status === true) {
            window.location.href = "/login";
          } else {
            console.error("Registration failed:", response.data.message);
          }
        }
      } catch (error) {
        console.error("Error during registration:", error);
      }
    };
    const login = async () => {
      window.location.href = "/login";
    };
    return {
      valid,
      response,
      formData,
      nameRules,
      emailRules,
      passwordRules,
      phoneRules,
      submitForm,
      login,
      form,
      showPassword,
      confirmPassword,
      confirmPasswordRules,
      errorMessage,
      telValidate,
      phoneValidationRule,
      phoneError,
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
  background-color: #0146a6 !important;
  font-size: 17px;
  line-height: 20px;
  font-weight: 400;
  padding: 11px 0;
  height: 100%;
  border-radius: 6px !important;
  color: #fff;
  text-transform: capitalize;
}
.error-message {
  color: rgb(204, 65, 65);
  font-size: 13px;
}
</style>
 
 
 

  
   
