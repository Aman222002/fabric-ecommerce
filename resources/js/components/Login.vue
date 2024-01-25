<template>
  <v-container fluid>
    <v-card class="mt-5 mx-auto" max-width="400">
      <v-card-title class="text-center">Log in</v-card-title>

      <v-card-text>
        <v-form @submit.prevent="login">
          <v-text-field v-model="email" label="Email" type="email" :rules="[rules.required, rules.email]"></v-text-field>
          <v-text-field v-model="password" label="Password" type="password" :rules="[rules.required, rules.password]"></v-text-field>

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
  name: "Login",
  setup() {
    const email = ref("");
    const password = ref("");
    const rememberMe = ref(false);

    const rules = {
      required: (value) => !!value || "This field is required",
      email: (value) => /.+@.+\..+/.test(value) || "Enter a valid email address",
      password: (value) => value.length >= 8 || "Password must be at least 8 characters",
    };

    const login = () => {
      console.log('Logging in with:', email.value, password.value, 'Remember Me:', rememberMe.value);
    };

    const forgotPassword = () => {
      console.log('Forgot Password clicked');
    };

    return {
      email,
      password,
      rememberMe,
      rules,
      login,
      forgotPassword,
    };
  },
};
</script>

<style scoped>
.center-form {
  justify-content: center;
  align-items: center;
  min-height: 100vh;
}

.v-card {
  max-width: 400px;
  margin: 0 auto;
}

.text-center {
  text-align: center;
}

.v-text-field,
.v-checkbox,
.v-btn {
  width: 100%;
  margin-bottom: 15px;
}

.text-hint {
  text-align: center;
}
</style>
