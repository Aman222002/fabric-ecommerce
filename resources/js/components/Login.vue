<template>
    <v-app>
      <v-container fluid>
        <v-row class="center-form">
          <v-col cols="12" sm="8" md="4" class="mx-auto"> 
            <v-card class="mt-5">
              <v-card-title class="text-center">Log in</v-card-title>
  
              <v-card-text>
                <v-form @submit.prevent="login">
  
                  <v-text-field v-model="email" label="Email" type="email" :rules="[rules.required, rules.email]"></v-text-field>
                  <v-text-field v-model="password" label="Password" type="password" :rules="[rules.required, rules.password]"></v-text-field>
  
                  <v-row>
                    <v-col>
                      <v-checkbox v-model="rememberMe" label="Remember Me"></v-checkbox>
                    </v-col>
                  </v-row>
  
                  <v-btn type="submit" color="primary" class="mt-3">Login</v-btn>
                </v-form>
                <v-card-actions>
                  <div class="text-hint">Already have an account? <router-link to="/Registration">Sign up</router-link></div>
                </v-card-actions>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-app>
  </template>
  
  <script>
  export default {
    data() {
      return {
        email: '',
        password: '',
        rememberMe: false,
        rules: {
          required: value => !!value || 'This field is required',
          email: value => /.+@.+\..+/.test(value) || 'Enter a valid email address',
          password: value => value.length >= 8 || 'Password must be at least 8 characters',
        },
      };
    },
    methods: {
      login() {
       
        console.log('Logging in with:', this.email, this.password, 'Remember Me:', this.rememberMe);
      },
      forgotPassword() {
        
        console.log('Forgot Password clicked');
      },
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
  