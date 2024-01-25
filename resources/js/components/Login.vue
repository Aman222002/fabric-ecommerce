<template>
  <v-container fluid>
    <v-card class="mt-5 mx-auto" max-width="400">
      <v-card-title class="text-center">Log in</v-card-title>

      <v-card-text>
        <v-form @submit.prevent="submitForm()">
          <v-text-field v-model="formData.email" label="Email" type="email" :rules="emailRules"></v-text-field>
          <v-text-field v-model="formData.password" label="Password" type="password"
            :rules="passwordRules"></v-text-field>

          <v-checkbox v-model="rememberMe" label="Remember Me"></v-checkbox>

          <v-btn type="submit" color="primary" class="mt-3">Login</v-btn>
        </v-form>

        <v-card-actions>
          <div class="text-hint">Already have an account?</div>
        </v-card-actions>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
import { ref } from 'vue';

export default {
  name: 'Login',
  setup() {
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
        const response = await window.axios.post('/login/check', formData.value);
        const data = response.data;
        console.log(data.data);

        if (data.status === true) {
          console.log(data.data.roles[0].name);
          alert('Login successful');

          if (data.data.roles[0].name == 'Admin') {
            window.location.href = './admin/dashboard';
          } else {
            window.location.href = './resume';
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
  padding: 5vh;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  background-repeat: no-repeat;
  background-position: center;
  color: "#006400";
}
</style>
