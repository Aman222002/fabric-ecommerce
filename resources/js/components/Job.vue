<template>
  <v-container>
    <v-row justify="center">
      <v-col cols="12" md="8" text-xs-center>
        <v-img
          src="/storage/assest/1.jpg"
          contain
          class="mb-4"
          style="max-width: 100%; height: 300px; margin-left: 400px"
        ></v-img>
        <h3
          class="mb-4"
          style="font-size: xx-large; margin-top: 20px"
        >
          Let's hire your next great candidate Fast.
        </h3>
        <br />
        <v-btn large color="primary" @click="jobDialog = true">
          Post a Job
        </v-btn>
        <v-dialog
          v-model="jobDialog"
          max-width="600px"
          @click:outside="jobDialog = false"
        >
          <v-card>
            <v-card-title style="font-size: 30px">Login</v-card-title>
            <v-card-text>
              <v-text-field
                label="Company Name"
                v-model="formData.company_name"
                :rules="companyNameRules"
                outlined
                required
                style="font-size: 20px; font-weight: bold"
              ></v-text-field>
              <v-text-field
                label="Email"
                v-model="formData.company_email"
                outlined
                required
                :rules="emailRules"
                type="email"
                style="font-size: 20px; font-weight: bold"
              ></v-text-field>
            </v-card-text>
            <v-card-actions>
              <v-btn  @click="handleLogin">Login</v-btn>
            </v-card-actions>
            <h4>Are you a new client?</h4>
            <v-btn color="secondary">
              <a href="./company/register">Register Now</a>
            </v-btn>
          </v-card>
        </v-dialog>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
import { onMounted, ref } from "vue";
export default {
  name: "Job",
  setup() {
    const jobDialog = ref(false);
    const company_name = ref("");
    const company_email = ref("");
    const formData = ref({
      company_name: "",
      company_email: "",
    });
    
    const companyNameRules = [
      (v) => !!v || "Company Name is required",
      (v) => (v && v.length <= 50) || "Company Name must be less than 50 characters",
    ];

    const emailRules = [
      (v) => !!v || "Email is required",
      (v) => /.+@.+\..+/.test(v) || "Enter a valid email address",
    ];
    const handleLogin = async () => {
      try {
        const response = await axios.post("/company/login", formData.value);
        if (response.data.status == true) {
          Swal.fire({
            icon: "success",
            title: "Login Successful!",
            text: "You have successfully logged in.",
          });
          window.location.href = "/postjob";
        }
      } catch (err) {
        console.error(err);
      }
    };
    return {
      jobDialog,
      company_name,
      company_email,
      handleLogin,
      companyNameRules,
      emailRules,
      formData,
    };
  },
};
</script>
