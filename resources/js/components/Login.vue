
<template>
  <v-container fluid class="div1">

    <div class="register-form">
      <v-col cols="12" sm="6" md="6">
        <v-col class="mt-5"
          style="background-color:#9a6a4f; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
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
          <v-card-actions>
            <div class="text-hint">Don't have an account? <a href="/registration">Register</a>
            </div>
          </v-card-actions>
        </v-col>
      </v-col>
    </div>
  </v-container>
</template>

<script>
export default {
  name: 'Login',
  data() {
    return {
      formData: {
        email: '',
        password: '',
      },
      emailRules: [
        v => !!v || 'E-mail is required',
        v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
      ],
      passwordRules: [
        v => !!v || 'Password is required',
        v => (v && v.length >= 6) || 'Password must be at least 6 characters',
      ],
    };
  },
  methods: {
    async submitForm() {
      try {
        const response = await window.axios.post('/login/check', this.formData);
        const data = response.data;
        console.log(data.data);
        if (data.status === true) {
          console.log(data.data.roles[0].name);
          alert('Login successful');
          if (data.data.roles[0].name == 'Admin') {
            window.location.href = './admin/dashboard';
          }
          else {
            window.location.href = './resume';
          }
        } else {
          alert('Login failed');
        }
      } catch (error) {
        console.error(error);
        alert('An error occurred during login');
      }
    },
  },
};
</script>

<style scoped>
.register-form {
  /* background-image: url('/storage/assets/p.jpg'); */
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
