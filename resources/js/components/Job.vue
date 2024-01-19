<template>
  
    
  <div class="full-screen-image-container">
    
    <v-img
      src="/storage/assest/1.png"
      contain
      class="mb-4 full-screen-image"
    ></v-img>
   
  </div>
  <div style="text-align: center;">
        <h3 class="mb-4 title-text">
          Let's hire your next great candidate Fast.
        </h3>
        <br />
        <v-btn large color="primary" @click="jobDialog = true">
          Post a Job
        </v-btn>
      </div>
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
      
  <div class="aa">
  <v-row justify="center" align="center" class="mt-5">
    <v-col cols="12" md="4" class="card-col">
      <v-card>
        <v-img src="/storage/assest/23.png" alt="Cinque Terre" style="height: 140px;"></v-img>
        <v-card-title style="font-size: 30px;">Create your free account</v-card-title>
        <v-card-text style="font-style: 20px; margin-top: 10px;">
          All you need is your email address to create an account<br> and start building your job post.
        </v-card-text>
      </v-card>
    </v-col>

    <v-col cols="12" md="4" class="card-col">
      <v-card>
        <v-img src="/storage/assest/24.png" alt="Cinque Terre" style="height: 140px;"></v-img>
        <v-card-title style="font-size: 30px;">Build your job post</v-card-title>
        <v-card-text style="font-style: 20px; margin-top: 10px;">
          Then just add a title, description and location to your job post,<br> and you're ready to go.
        </v-card-text>
      </v-card>
    </v-col>

    <v-col cols="12" md="4" class="card-col">
      <v-card>
        <v-img src="/storage/assest/25.png" alt="Cinque Terre" style="height: 140px;"></v-img>
        <v-card-title style="font-size: 30px;">Post your job</v-card-title> 
        <v-card-text style="font-style: 20px; margin-top: 10px;">
          After you post your job, use our state-of-the-art <br>tools to help you find dream talent.
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</div>

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
        if (response.data.status == true) {
          window.location.href = "/postjob";
        }
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
.aa{ 
    margin-top: 30px;
    border-style: solid;
  border-color: rgb(12, 11, 11);
  width: 100%;
  }
  .card-col {
  margin-bottom: 15px;
  border-bottom: 1px solid #ccc; 
}
.full-screen-image-container {
    width: 100vw;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  
  .full-screen-image {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain; 
    opacity: 0.8;
  }
 
</style>