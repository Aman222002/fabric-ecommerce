<template>
  <v-container>
    <v-row class="form_log_reg" align="center" justify="center">
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
                    Employers Login
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
                        :rules="passRules"
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
                      <v-btn
                        type="submit"
                        dark
                        block
                        tile
                        color="primary"
                        @click="showCompanyListDialog"
                        >Login</v-btn
                      >
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
                  color="primary"
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

    <v-dialog v-model="companyListDialog" max-width="500">
      <v-card class="which_company">
        <v-card-title>Which Company You Want To Login ?</v-card-title>
        <v-card-text>
          <v-list>
            <v-list-item
              v-for="(company, index) in companyNames"
              :key="index"
              @click="selectedCompany = company"
            >
              <v-list-item-title>{{ company.company_name }}</v-list-item-title>
            </v-list-item>
          </v-list>
        </v-card-text>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script>
import { onMounted, ref, watch } from "vue";
import { useEmployerStore } from "../store/employer";
import axios from "axios";

export default {
  name: "Job",
  setup() {
    const employerStore = useEmployerStore();
    const jobDialog = ref(false);
    const users = ref([]);
    const companyListDialog = ref(false);
    const selectedCompany = ref(null);
    const email = ref("");
    const password = ref("");
    const formData = ref({
      password: "",
      email: "",
      company_name: "",
    });
    const companyNameRules = [(v) => !!v || "Company Name is required"];
    const passRules = [(v) => !!v || "Password is required"];
    const emailRules = [
      (v) => !!v || "Email is required",
      (v) => /.+@.+\..+/.test(v) || "Enter a valid email address",
    ];
    const companyNames = ref([]);
    const submitForm = async () => {
      if (!formData.value.company_name) {
        return;
        window.Swal.fire({
          toast: true,
          position: "top-end",
          timer: 2000,
          showConfirmButton: false,
          icon: "error",
          title: "User not found",
        });
      }
      try {
        const response = await axios.post("/company/login", formData.value);
        if (response.data.status == true) {
          companyListDialog.value = false;
          employerStore.isLogIn();
          // window.location.href = "/findcv";
          if (employerStore.isloggedin) {
            const selectedRoute = employerStore.getPreviousRoute;
            console.log(selectedRoute);
            await fetchUserData();
            // if (selectedRoute == "/findcv") {
            //   window.location.href = "/findcv";
            //   employerStore.removePreviousRoute();
            // }
            if (selectedRoute == "/postjob") {
              // console.log('hello');
              if (hasPermission("Create Users") || hasrole("Company Admin")) {
                window.location.href = "/postjob";
                employerStore.removePreviousRoute();
              } else {
                if (hasrole("Company Admin")) {
                  window.location.href = "/postjob";
                  employerStore.removePreviousRoute();
                } else if (hasrole("Company Subadmin")) {
                  if (hasPermission("Create Users")) {
                    window.location.href = "/add-user";
                    employerStore.removePreviousRoute();
                  } else if (hasPermission("Change Plan")) {
                    window.location.href = "/company/plan";
                    employerStore.removePreviousRoute();
                  } else if (hasPermission("View Users")) {
                    window.location.href = "/users";
                    employerStore.removePreviousRoute();
                  } else if (hasPermission("Post Job")) {
                    window.location.href = "/postjob";
                    employerStore.removePreviousRoute();
                  } else if (hasPermission("Edit Job")) {
                    window.location.href = "/posted-jobs";
                    employerStore.removePreviousRoute();
                  } else if (hasPermission("Buy Subscription")) {
                    window.location.href = "/product";
                    employerStore.removePreviousRoute();
                  } else if (hasPermission("Change Profile")) {
                    window.location.href = "/company/profile";
                    employerStore.removePreviousRoute();
                  }
                }
                employerStore.removePreviousRoute();
                alert(`You don't have permissions for this action`);
              }
            }
            if (selectedRoute == "/company/plan") {
              if (hasPermission("Change Plan") || hasrole("Company Admin")) {
                window.location.href = "/company/plan";
                employerStore.removePreviousRoute();
              } else {
                if (hasrole("Company Admin")) {
                  window.location.href = "/postjob";
                  employerStore.removePreviousRoute();
                } else if (hasrole("Company Subadmin")) {
                  if (hasPermission("Create Users")) {
                    window.location.href = "/add-user";
                    employerStore.removePreviousRoute();
                  } else if (hasPermission("Change Plan")) {
                    window.location.href = "/company/plan";
                    employerStore.removePreviousRoute();
                  } else if (hasPermission("View Users")) {
                    window.location.href = "/users";
                    employerStore.removePreviousRoute();
                  } else if (hasPermission("Post Job")) {
                    window.location.href = "/postjob";
                    employerStore.removePreviousRoute();
                  } else if (hasPermission("Edit Job")) {
                    window.location.href = "/posted-jobs";
                    employerStore.removePreviousRoute();
                  } else if (hasPermission("Buy Subscription")) {
                    window.location.href = "/product";
                    employerStore.removePreviousRoute();
                  } else if (hasPermission("Change Profile")) {
                    window.location.href = "/company/profile";
                    employerStore.removePreviousRoute();
                  }
                }
                employerStore.removePreviousRoute();
                alert(`You don't have permissions for this action`);
              }
            }
            // } else if (!selectedRoute) {
            //   window.location.href = "/findcv";
            //   employerStore.removePreviousRoute();
            // }
            // employerStore.removePreviousRoute();
            else if (!selectedRoute) {
              if (hasrole("Company Admin")) {
                window.location.href = "/postjob";
                employerStore.removePreviousRoute();
              } else if (hasrole("Company Subadmin")) {
                if (hasPermission("Create Users")) {
                  window.location.href = "/add-user";
                  employerStore.removePreviousRoute();
                } else if (hasPermission("Change Plan")) {
                  window.location.href = "/company/plan";
                  employerStore.removePreviousRoute();
                } else if (hasPermission("View Users")) {
                  window.location.href = "/users";
                  employerStore.removePreviousRoute();
                } else if (hasPermission("Post Job")) {
                  window.location.href = "/postjob";
                  employerStore.removePreviousRoute();
                } else if (hasPermission("Edit Job")) {
                  window.location.href = "/posted-jobs";
                  employerStore.removePreviousRoute();
                } else if (hasPermission("Buy Subscription")) {
                  window.location.href = "/product";
                  employerStore.removePreviousRoute();
                } else if (hasPermission("Change Profile")) {
                  window.location.href = "/company/profile";
                  employerStore.removePreviousRoute();
                }
              }
            }
          }
        }
      } catch (err) {
        console.error(err);
        window.Swal.fire({
          toast: true,
          position: "top-end",
          timer: 2000,
          showConfirmButton: false,
          icon: "error",
          title: "Verify Your Mail",
        });
      }
    };
    const showCompanyListDialog = async () => {
      try {
        const response = await axios.get("/company/names", {
          params: {
            email: formData.value.email,
          },
        });
        console.log(formData.value.email);
        if (response.data.status == true) {
          companyNames.value = response.data.companyNames;
          companyListDialog.value = true;
        }
      } catch (err) {
        console.error(err);
      }
    };
    const closeCompanyListDialog = () => {
      companyListDialog.value = false;
    };
    const signup = async () => {
      window.location.href = "/company/register";
    };
    const fetchUserData = async () => {
      try {
        const response = await axios.get("/user/data");
        users.value = response.data;
      } catch (error) {
        console.error("Error fetching user data:", error);
      }
    };
    const hasPermission = (permission) => {
      if (users.value && users.value.permissions) {
        return users.value.permissions.includes(permission);
      }
      return false;
    };
    const hasrole = (role) => {
      if (users.value && users.value.roles) {
        return users.value.roles.includes(role);
      }
      return false;
    };
    watch(selectedCompany, () => {
      if (selectedCompany.value) {
        formData.value.company_name = selectedCompany.value.company_name;
        submitForm();
      }
    });
    return {
      password,
      email,
      submitForm,
      companyNameRules,
      emailRules,
      formData,
      passRules,
      companyNames,
      showCompanyListDialog,
      closeCompanyListDialog,
      companyListDialog,
      signup,
      selectedCompany,
      employerStore,
      fetchUserData,
      users,
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
  background-color: #1967d2;
  font-size: 17px;
  line-height: 20px;
  font-weight: 400;
  padding: 11px 0;
  height: 100%;
  border-radius: 15px;
  color: #fff;
}
.v-list-item--density-default.v-list-item--one-line .v-list-item-title {
  text-transform: capitalize;
}
.which_company .v-list .v-list-item {
  color: #1967d2;
  background-color: #e2eaf8;
  font-size: 15px;
  line-height: 20px;
  border-radius: 8px;
  font-weight: 400;
  margin-bottom: 5px;
}
.which_company .v-list .v-list-item:hover {
  color: #e2eaf8;
  background-color: #1967d2;
  padding-left: 20px;
}
.form_log_reg .v-card {
  border-radius: 15px;
}
</style>
