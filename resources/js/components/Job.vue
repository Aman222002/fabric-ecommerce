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
              <v-btn
                color="primary"
                @click="
                  () => {
                    jobDialog = false;
                    login();
                  }
                "
                >Login</v-btn
              >
            </v-card-actions>
            <h4>Are you a new client?</h4>
            <v-btn color="secondary">
              <a href="./companyregister">Register Now</a>
            </v-btn>
          </v-card>
        </v-dialog>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
import { ref } from "vue";
export default {
  name: "Job",
  setup() {
    const jobDialog = ref(false);
    const companyName = ref("");
    const email = ref("");

    return {
      jobDialog,
      companyName,
      email,
    };
  },
};
</script>
