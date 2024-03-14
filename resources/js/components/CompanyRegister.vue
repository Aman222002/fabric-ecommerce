<template>
  <v-container>
    <v-form ref="form" @submit.prevent="submitForm()" class="custom-form">

      <v-row style="margin-top: 20px;">
        <v-col cols="12">
          <p class="mb-4 form-title">User Detail:</p>
        </v-col>
        <v-col cols="3" sm="3">
          <v-text-field variant="outlined" v-model="company.name" label="Representative Name" :rules="nameRules"
            density="compact" outlined :disabled="disabledFields"></v-text-field>
        </v-col>
        <v-col cols="3" sm="3">
          <v-text-field variant="outlined" v-model="company.email" label="Representative Email" :rules="emailRules"
            density="compact" outlined :disabled="disabledFields"></v-text-field>
        </v-col>
        <v-col cols="3" sm="3">
          <v-text-field variant="outlined" v-model="company.password" label="Password" :rules="passwordRules"
            density="compact" type="password" outlined></v-text-field>
        </v-col>
        <v-col cols="3" sm="3">
          <v-text-field variant="outlined" v-model="company.phone" label="Phone" :rules="phoneRules" type="phone"
            density="compact" outlined :disabled="disabledFields"></v-text-field>
        </v-col>
      </v-row>
      <div v-if="showCompanyDetails">
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

        </v-row>
      </div>
      <v-row>

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
import { ref, onMounted } from "vue";
import { useUsersStore } from "../store/user";
import axios from 'axios';

export default {
  name: "CompanyRegister",
  props: {
    data: {
      type: Object,
      default: () => ({}),
    }
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
    const showCompanyDetails = ref(true);
    const disabledFields = ref(false);
    onMounted(() => {
      const value = props.data;
      console.log(value);
      company.value.name = props.data.name;
      company.value.email = props.data.email;
      company.value.phone = props.data.phone;

      if (props.data.name) {
        company.value.name = props.data.name;
        company.value.email = props.data.email;
        company.value.phone = props.data.phone;
        disabledFields.value = true;
      }
      if (window.location.pathname === "/company/register") {
        showCompanyDetails.value = true;
      }
      else {
        showCompanyDetails.value = false;
      }
    });
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
          if (props.data.permission) {
            formData.append("company_Id", props.data.company);
            formData.append("permission", props.data.permission);
          }
          console.log(props.data.permission)
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
      showCompanyDetails,
      disabledFields
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
