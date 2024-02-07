<template>
  <v-container fluid class="div1">
    <div class="register-form">
      <v-col cols="12" sm="6" md="6">
        <v-col class="mt-5"
          style="background-color:#ece5e1; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
          <v-card-title class="text-center">Login</v-card-title>
          <v-card-text>
            <v-form ref="form" @submit.prevent="submitForm">
              <v-text-field v-model="formData.email" id="email" label="Email" type="email" :rules="emailRules" required
                variant="outlined"></v-text-field>
              <v-text-field v-model="formData.password" id="password" label="Password" type="password"
                :rules="passwordRules" required variant="outlined"></v-text-field>
              <v-btn type="submit" color="primary" class="mt-3">Submit</v-btn>
            </v-form>
          </v-card-text>

          <div style="text-align: center; margin-top: 30px;">
            <h5 class="new-client-text">Don't have an Account?</h5>
            <a href="/registration" class="register-link" style="margin-top: 30px;">Register Now</a>
          </div>

        </v-col>
      </v-col>
    </div>
  </v-container>
</template>
  
<script>
import { ref } from 'vue';
import { useUsersStore } from '../store/user';
import axios from 'axios';

export default {
  name: 'Login',
  setup() {
    const usersStore = useUsersStore();
    const formData = ref({
      email: '',
      password: '',
    });

    const emailRules = [
      v => !!v || 'E-mail is required',
      v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
    ];

    const passwordRules = [
      v => !!v || 'Password is required',
      v => (v && v.length >= 6) || 'Password must be at least 6 characters',
    ];

    const submitForm = async () => {
      try {
        const response = await axios.post('/login', formData.value);
        const data = response.data;

        if (data.status === true) {
          console.log(data.data.roles[0].name);
          alert('Login successful');

          if (data.data.roles[0].name == 'Admin') {
            window.location.href = './admin/dashboard';
          } else if (data.data.roles[0].name == 'Company Admin') {
            window.location.href = '/job';

          } else {
            usersStore.isLogIn();
            window.location.href = '/resume';
          }
        } else {
          alert('Login failed');
        }
      } catch (error) {
        console.error(error);
        alert('An error occurred during login');
      }
    };

    return {
      formData,
      emailRules,
      passwordRules,
      submitForm,
    };
  },
};
</script>
  
<style scoped>
.register-form {

  background-size: cover;
  padding: 15vh;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  background-repeat: no-repeat;
  background-position: center;
  color: "#006400";
}
</style>
  