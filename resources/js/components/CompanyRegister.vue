<template>
  <v-container>
    <v-form ref="form" @submit.prevent="submitForm()" class="custom-form">

      <v-row style="margin-top: 20px;">
        <v-col cols="12">
          <p class="mb-4 form-title">User Detail:</p>
        </v-col>
        <v-col cols="3" sm="3">
          <v-text-field variant="outlined" v-model="company.name" label="Representative Name" :rules="nameRules"
            density="compact" outlined></v-text-field>
        </v-col>
        <v-col cols="3" sm="3">
          <v-text-field variant="outlined" v-model="company.email" label="Representative Email" :rules="emailRules"
            density="compact" outlined></v-text-field>
        </v-col>
        <v-col cols="3" sm="3">
          <v-text-field variant="outlined" v-model="company.password" label="Password" :rules="passwordRules"
            density="compact" type="password" outlined></v-text-field>
        </v-col>
        <v-col cols="3" sm="3">
          <v-text-field variant="outlined" v-model="company.phone" label="Phone" :rules="phoneRules" type="phone"
            density="compact" outlined></v-text-field>
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="12" sm="12">
          <p class="mb-4 form-title">Company Details:</p>
        </v-col>
        <v-col cols="3" sm="3">
          <v-text-field variant="outlined" v-model="company.company_name" label="Company Name" :rules="nameRules"
            density="compact" outlined></v-text-field>
        </v-col>
        <v-col cols="3" sm="3">
          <v-text-field variant="outlined" v-model="company.company_email" label="Company Email" :rules="emailRules"
            density="compact" outlined></v-text-field>
        </v-col>
        <v-col cols="3" sm="3">
          <v-text-field variant="outlined" v-model="company.phone_number" label="Phone Number" :rules="phoneRules"
            density="compact" outlined></v-text-field>
        </v-col>
        <v-col cols="3" sm="3">
          <v-file-input variant="outlined" v-model="company.logo" label="Company Logo" outlined
            density="compact"></v-file-input>
        </v-col>
        <v-col cols="6" sm="6">
          <v-textarea variant="outlined" v-model="company.description" label="Description" outlined
            density="compact"></v-textarea>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="12">
          <p class="mb-4 form-title">Company Address:</p>
        </v-col>
        <v-col cols="3" sm="3">
          <v-text-field variant="outlined" v-model="company.first_line_address" label="First Line Address"
            density="compact" outlined></v-text-field>
        </v-col>
        <v-col cols="3" sm="3">
          <v-text-field variant="outlined" v-model="company.street" label="Street" outlined
            density="compact"></v-text-field>
        </v-col>
        <v-col cols="3" sm="3">
          <v-text-field variant="outlined" v-model="company.city" label="City" :rules="cityRules" outlined
            density="compact"></v-text-field>
        </v-col>
        <v-col cols="3" sm="3">
          <v-text-field variant="outlined" v-model="company.state" label="State" :rules="stateRules" density="compact"
            outlined></v-text-field>
        </v-col>
        <v-col cols="3" sm="3">
          <v-text-field variant="outlined" v-model="company.postal_code" label="Postal Code" :rules="postalCodeRules"
            density="compact" outlined></v-text-field>
        </v-col>
      </v-row>
      <v-row justify="center">
        <v-col cols="12" class="text-center">
          <v-btn type="submit" color="primary" class="custom-button">Register Company</v-btn>
        </v-col>
      </v-row>
    </v-form>
  </v-container>
</template>
<script>
import { ref } from "vue";
import axios from 'axios';
export default {
  name: "CompanyRegister",
  setup() {
    const usersStore = useUsersStore();
    const form = ref(null);
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

        } else {
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
      usersStore,
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


