<template>
  <v-container>
    <v-row
      class="form_log_reg form_login_el_cd"
      align="center"
      justify="center"
    >
      <v-col sm="12" md="10" lg="12" xl="10" cols="12">
        <v-card class="elevation-12 mt-3" style="margin-bottom: 10px">
          <v-row class="form_page">
            <v-col
              class="form_page_left"
              sm="12"
              md="12"
              lg="6"
              xl="6"
              cols="12"
            >
              <v-card-text>
                <v-form ref="form" @submit.prevent="submitForm">
                  <p
                    class="text-center"
                    style="font-size: 20px; font-style: sans-serif"
                  >
                    Candidates Login
                  </p>
                  <v-row align="center" justify="center">
                    <v-col cols="12" sm="10">
                      <v-text-field
                        label="Email"
                        variant="outlined"
                        v-model="formData.email"
                        :rules="emailRules"
                        dense
                        density="compact"
                        color="blue"
                        autocomplete="false"
                        class="mt-8"
                        style="font-size: 10px"
                      />
                      <v-text-field
                        label="Password"
                        variant="outlined"
                        v-model="formData.password"
                        :rules="passwordRules"
                        dense
                        density="compact"
                        color="blue"
                        autocomplete="false"
                        type="password"
                        style="margin-top: 10px; font-size: 10px"
                      />
                      <v-row>
                        <v-col cols="12" sm="7">
                          <v-checkbox
                            label="Remember Me"
                            class="mt-n1"
                            color="blue"
                          >
                          </v-checkbox>
                        </v-col>
                        <v-col cols="12" sm="5" class="mt-3">
                          <a
                            href="/forget/password"
                            class="register-link"
                            style="text-decoration: none"
                            >Forgot password?</a
                          >
                        </v-col>
                      </v-row>
                      <v-btn type="submit" dark block tile>Login</v-btn>
                    </v-col>
                  </v-row>
                </v-form>
              </v-card-text>
            </v-col>
            <v-col
              class="blue form_page_right"
              sm="12"
              md="12"
              lg="6"
              xl="6"
              cols="12"
            >
              <v-card-text class="white--text">
                <p style="font-size: 20px">Don't Have an Account Yet?</p>
                <p style="font-size: 13px; margin-top: 10px">
                  Let's get you all set up so you can start creating your first
                  onboarding experience
                </p>
                <v-btn
                  tile
                  outlined
                  dark
                  @click="signup()"
                  style="margin-top: 20px"
                  >SIGN UP</v-btn
                >
              </v-card-text>
            </v-col>
          </v-row>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import { ref } from "vue";
import { useUsersStore } from "../store/user";
import axios from "axios";

export default {
  name: "Login",
  setup() {
    const usersStore = useUsersStore();
    const formData = ref({
      email: "",
      password: "",
    });

    const emailRules = [
      (v) => !!v || "E-mail is required",
      (v) => /.+@.+\..+/.test(v) || "E-mail must be valid",
    ];

    const passwordRules = [
      (v) => !!v || "Password is required",
      (v) => (v && v.length >= 6) || "Password must be at least 6 characters",
    ];

    const submitForm = async () => {
      try {
        const response = await axios.post("/login", formData.value);
        const data = response.data;

        if (data.status === true) {
          console.log(data.data.roles[0].name);

          if (data.data.roles[0].name == "Admin") {
            window.location.href = "/admin/users";
            usersStore.isLogIn();
          } else if (data.data.roles[0].name == "Company Admin") {
            window.location.href = "/job";
          } else {
            window.location.href = "/resume";
            usersStore.isLogIn();
          }
        }
      } catch (error) {
        console.error(error);
        if (error.response && error.response.status === 403) {
          window.Swal.fire({
            toast: true,
            position: "top-end",
            timer: 2000,
            showConfirmButton: false,
            icon: "error",
            title: "Please Verify Your Mail",
          });
        }
      }
    };
    const signup = async () => {
      window.location.href = "/registration";
    };

    return {
      formData,
      emailRules,
      passwordRules,
      submitForm,
      signup,
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
}
.form_log_reg .v-card {
  border-radius: 15px;
}
</style>