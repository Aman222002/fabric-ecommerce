<template>
  <v-container fluid>
    <v-row align="center" justify="center">
      <v-col cols="12" sm="8" md="6" lg="4">
        <v-form ref="form" @submit.prevent="submitForm()" class="custom-form">
          
          <div class="custom-col left-side">
            <h3 class="mb-4 form-title">User Detail:</h3>
            <v-text-field
              variant="outlined"
              v-model="company.name"
              label="Representative Name"
              :rules="nameRules"
              outlined
              style="margin-bottom: 10px; margin-top: 5px; max-width: 140%"
            ></v-text-field>
            <v-text-field
              variant="outlined"
              v-model="company.email"
              label=" Representative Email"
              :rules="emailRules"
              outlined
              style="margin-bottom: 10px; max-width: 140%"
            ></v-text-field>
            <v-text-field
              variant="outlined"
              v-model="company.password"
              label=" Password"
              :rules="passwordRules"
              type="password"
              outlined
              style="margin-top: 10px; max-width: 140%"
            ></v-text-field>
            <v-text-field
              variant="outlined"
              v-model="company.phone"
              label="Phone"
              :rules="phoneRules"
              type="phone"
              outlined
              style="margin-top: 10px; max-width: 140%"
            ></v-text-field
            ><br />
          </div>
          <div class="custom-col right-side">
            <div class="company-details">
              <h3 class="mb-4 form-title">Company Details:</h3>
              <v-text-field
                variant="outlined"
                v-model="company.company_name"
                label="Company Name"
                :rules="nameRules"
                outlined
                style="margin-bottom: 10px; max-width: 140%"
              ></v-text-field>
              <v-text-field
                variant="outlined"
                v-model="company.company_email"
                label="Company Email"
                :rules="emailRules"
                outlined
                style="margin-bottom: 10px; max-width: 140%"
              ></v-text-field>
              <v-text-field
                variant="outlined"
                v-model="company.phone_number"
                label="Phone Number"
                :rules="phoneRules"
                outlined
                style="margin-bottom: 10px; max-width: 140%"
              ></v-text-field>
              <v-textarea
                variant="outlined"
                v-model="company.description"
                label="Description"
                outlined
                style="margin-bottom: 10px; max-width: 140%"
              ></v-textarea>
              <v-file-input
                variant="outlined"
                v-model="company.logo"
                label="Company Logo"
                outlined
                style="max-width: 140%"
              ></v-file-input>
            </div>
          </div>

          <div class="custom-col left-side">
            <h3 class="mb-4 form-title">Company Address:</h3>
            <v-text-field
              variant="outlined"
              v-model="company.first_line_address"
              label="First_Line_Address"
              outlined
              style="max-width: 140%"
            ></v-text-field>
            <v-text-field
              variant="outlined"
              v-model="company.street"
              label="Street"
              outlined
              style="max-width: 140%"
            ></v-text-field>
            <v-text-field
              variant="outlined"
              v-model="company.city"
              label="City"
              :rules="cityRules"
              outlined
              style="margin-bottom: 10px;max-width: 140%"
            ></v-text-field>
            <v-text-field
              variant="outlined"
              v-model="company.state"
              label="State"
              :rules="stateRules"
              outlined
              style="margin-bottom: 10px;max-width: 140%"
            ></v-text-field>
            <v-text-field
              variant="outlined"
              v-model="company.postal_code"
              label="Postal Code"
              :rules=" postalCodeRules"
              outlined
              style="margin-bottom: 10px;max-width: 140%"
            ></v-text-field>
          </div>

          <v-btn type="submit"  color="primary" class="custom-button" style=" color: white;  width: 180px; height: 50px; margin-left: 30%; "
            >Register Company</v-btn
          >
        </v-form>
      </v-col>
    </v-row>
  </v-container>
</template>


<script>
import { ref } from "vue";
import axios from 'axios';
export default {
  name: "CompanyRegister",
  setup() {
    const form =ref(null);
    const company = ref({
      name: "",
      email: "",
      password: "",
      phone: "",
      company_name: "",
      company_email: "",
      first_line_address: "",
      street: "",
      state: "",
      city: "",
      postal_code: "",
      phone_number: "",
      description: "",
      status: "1",
      logo: [],
    });
    const nameRules = [(v) => !!v || "Name is required"];
    const emailRules = [
      (v) => !!v || "Email is required",
      (v) => /.+@.+\..+/.test(v) || "Enter a valid email",
    ];
    const passwordRules = [(v) => !!v || "Password is required"];
    const phoneRules = [
    (v) => !!v || "Phone number is required",
    (v) => /^[0-9]{10}$/.test(v) || "Enter a valid 10-digit phone number",
  ];
  const stateRules = [(v) => !!v || "State is required"];
  const cityRules = [(v) => !!v || "city is required"];
 

  const postalCodeRules = [
    (v) => !!v || "Postal code is required",
    (v) => /^[0-9]{6}$/.test(v) || "Enter a valid 6-digit postal code",
  ];
    const submitForm = () => {
      form.value.validate().then((valid) => {
        // console.log(valid.errors);
    if (!valid.valid) {
      const errors = JSON.parse(JSON.stringify(valid.errors));
  
        let errorField = form.value[errors[0].id];
        
        errorField = Array.isArray(errorField) ? errorField[0] : errorField;
        errorField.scrollIntoView({
          behavior: "smooth",
          block: "center",
          inline: "center"
        });

    } else{
      const formData = new FormData();
      for (let key in company.value) {
        if (key !== "logo") {
          formData.append(key, company.value[key]);
          console.log(key, company.value[key]);
        } else {
          console.log(key, company.value[key][0]);
          formData.append("logo", company.value[key][0]);
        }
      }
      axios
        .post("/company/post", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          console.log(response);
          if (response.data.status == true) {
            window.Swal.fire({
              icon: "success",
              title: "Company Registered",
              text: "Your company has been successfully registered!",
              confirmButtonText: "OK",
            });
            window.location.href = "/job";
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
    
    };
  },
};
</script>
<style scoped>
.v-row.center {
  margin: auto;
}
.v-col.center {
  text-align: center;
}
</style>


