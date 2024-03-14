<template>
  <v-container>
    <v-row justify="space-around" class="my-6">
      <v-card class="elevation-12 mt-3">
        <v-col cols="12" sm="12">
          <v-row class="text-center">
            <v-col cols="12" md="12">
              <v-form ref="form" @submit.prevent="submitForm">
                <h5
                  class="text-primary mt-2 mb-2"
                  style="font-size: 18px; font-style: sans-serif"
                >
                  Forgot Password?
                </h5>
                <p class="text-muted mb-2">Reset password with JobPath</p>
                <v-icon
                  size="80px"
                  icon="mdi-lock-reset"
                  color="teal-darken-2"
                  class="icon"
                >
                </v-icon>
                <div
                  class="alert_msg border-0 mb-2 ml-8 d-flex align-center justify-center"
                >
                  Enter your email and instructions will be sent to you!
                </div>

                <v-text-field
                  label="Enter registered email only"
                  v-model="formData.email"
                  variant="outlined"
                  dense
                  density="compact"
                  color="blue"
                  :rules="emailRules"
                  autocomplete="false"
                  class="mt-8"
                  style="font-size: 10px"
                />

                <v-btn
                  type="submit"
                  class="bg-primary mb-2 email-button"
                  width="100%"
                >
                  Send Reset Link
                </v-btn>

                <p class="mb-0">
                  Wait, I remember my password...
                  <a href="/login" class="text-primary"> Login </a>
                </p>
              </v-form>
            </v-col>
          </v-row>
        </v-col>
      </v-card>
    </v-row>
  </v-container>
</template>
<script>
import { ref } from "vue";
export default {
  name: "ForgetPassword",
  setup() {
    const formData = ref({
      email: "",
    });
    const emailRules = [
      (v) => !!v || "E-mail is required",
      (v) => /.+@.+\..+/.test(v) || "E-mail must be valid",
    ];
    const submitForm = async () => {
      try {
        console.log(formData.value);
        const response = await axios.post(
          "/get/forget/password/link",
          formData.value
        );
        console.log(response.data);
      } catch (error) {
        console.log(error);
      }
    };
    return {
      emailRules,
      submitForm,
      formData,
    };
  },
};
</script>
<style scoped>
.text-muted {
  --vz-text-opacity: 1;
  color: var(--vz-secondary-color) !important;
}

.alert_msg {
  width: 100%;
  color: #e8bc52;
  background-color: #fceecf;
  border-radius: 8px;
  margin-left: 0px !important;
  padding: 5px 15px;
}
</style>