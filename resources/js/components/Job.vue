<template>
  <v-container>
    <v-row justify="center">
      <v-col cols="12" md="8" text-xs-center class="job-container">
        <v-img
          src="/storage/assest/1.jpg"
          contain
          class="mb-4"
          style="max-width: 100%; height: 300px; margin-left: 400px"
        ></v-img>
        <h3 class="mb-4 title-text">
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
          class="login-dialog"
        >
          <v-card>
            <v-card-title style="font-size: 30px">Login</v-card-title>
            <v-card-text>
              <v-text-field
                label="Company Email"
                v-model="formData.email"
                :rules="emailRules"
                outlined
                required
                style="font-size: 20px; font-weight: bold"
              ></v-text-field>
              <v-text-field
                label="Password"
                v-model="formData.password"
                outlined
                required
                :rules="companyNameRules"
                type="password"
                style="font-size: 20px; font-weight: bold"
              ></v-text-field>
            </v-card-text>
            <v-card-actions class="login-dialog-actions">
            <v-btn @click="handleLogin" class="login-btn">Login</v-btn>
          </v-card-actions>
          <h4 class="new-client-text">Are you a new client?</h4>
          <v-btn color="secondary" class="register-btn">
            <a href="./company/register" class="register-link">Register Now</a>
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
    const email = ref("");
    const password = ref("");
    const formData = ref({
      password: "",
      email: "",
    });
    
    const companyNameRules = [
      (v) => !!v || "Password is require",
      
    ];

    const emailRules = [
      (v) => !!v || "Email is required",
      (v) => /.+@.+\..+/.test(v) || "Enter a valid email address",
    ];
    const handleLogin = async () => {
      try {
        const response = await axios.post("/company/login", formData.value);
        // if (response.data.status == true) {
        //   window.location.href = "/postjob";
        // }
      } catch (err) {
        console.error(err);
      }
    };
    return {
      jobDialog,
      password,
      email,
      handleLogin,
      companyNameRules,
      emailRules,
      formData,
    };
  },
};
</script>
<style scoped>

.login-dialog {
  font-size: 16px;
}

.login-dialog-actions {
  justify-content: center;
}

.login-btn {
 
  background-color: #3498db; 
}

.new-client-text {
  margin-top: 10px;
}

.register-btn {
  color: #ffffff; 
  background-color: #2ecc71; 
}

.register-link {
  text-decoration: none;
  color: #ffffff; 
}
</style>