<template>
  <v-container>
    <v-row justify="center">
      <v-col cols="12" md="8" text-xs-center>
        <v-img src="/storage/assest/1.jpg" contain class="mb-4" style="max-width: 100%; height: 300px; margin-left: 400px;"></v-img>
        <v-text-display-4
          class="mb-4"
          style="font-size: xx-large; margin-top: 20px"
        >
          Let's hire your next great candidate Fast.
        </v-text-display-4>
        <br />
        <v-btn large color="primary" @click="openJobDialog"> Post a Job </v-btn>
        <v-dialog v-model="jobDialog" max-width="600px">
          <v-card>
            <v-card-title style="font-size: 30px"
              >Login
            </v-card-title>
            <v-card-text>
              <v-text-field
                label="Company Name"
                v-model="companyName"
                outlined
                required
                style="font-size: 20px; font-weight: bold"
              ></v-text-field>
              <v-text-field
                label="Email"
                v-model="email"
                outlined
                required
                type="email"
                style="font-size: 20px; font-weight: bold"
              ></v-text-field>
            </v-card-text>
            <v-card-actions>
              <v-btn  color="primary" @click="login">Login</v-btn>
            </v-card-actions>
            <h4>Are you a new client?</h4>
            <v-btn  color="secondary">
              <a href="./companyregister">RegisterNow</a>  </v-btn>
           
          </v-card>
        </v-dialog>
      </v-col>
    </v-row>
    <v-row justify="center" class="mb-4">
      <v-col cols="12" md="4">
        <v-card class="mx-auto" width="400" height="200" >
          <template v-slot:title>Create your free account</template>
          <v-card-text>
            All you need is your email address to create an account and start
            building your job post.
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" md="4">
        <v-card class="mx-auto" width="400" height="200">
          <template v-slot:title>Build your job post</template>
          <v-card-text>
            Then just add a title, description and location to your job post,
            and you're ready to go.
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" md="4">
        <v-card class="mx-auto" width="400" height="200">
          <template v-slot:title>Post your job</template>
          <v-card-text>
            After you post your job, use our state-of-the-art tools to help you
            find dream talent.
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <v-row justify="center">
      <v-col cols="12" md="8" text-xs-center>
        <h2 style="margin-top: 30px; font-size: xx-large;">
          Save time and effort in your <br> recruitment journey.
        </h2><br>
        <h3>Finding the best fit for the job shouldn’t be a full-time job. Indeed’s simple and powerful tools let you source, screen and hire faster.</h3>
        <v-img src="/storage/assest/2.jpg" contain class="mb-4" style="max-width: 100%; height: 300px; margin-left: 400px;"></v-img>
      </v-col>
    </v-row>
    
  </v-container>
</template>
  
  <script>
export default {
  data() {
    return {
      jobDialog: false,
      companyName: "",
      email: "",
    };
  },
  methods: {
    openJobDialog() {
      this.jobDialog = true;
    },
    closeJobDialog() {
      this.jobDialog = false;
    },
    login() {
      console.log("Job submitted!");
      this.closeJobDialog();
    },
    register() {
    }
  },
};
</script>
  