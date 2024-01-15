<template>
    <v-container fluid class="div1">
      <v-row class="center-form">
        <v-col cols="12" sm="8" md="4">
          <v-card class="mt-5" style="background-color:#ADD8E6; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
            <v-card-title class="text-center">Find a job & grow your career</v-card-title>
            <v-card-text>
              <v-form ref="form" @submit.prevent="submitForm">
                <v-text-field v-model="formData.name" id="fullName" label="Full Name" :rules="nameRules" required></v-text-field>
                <v-text-field v-model="formData.email" id="email" label="Email" type="email" :rules="emailRules" required></v-text-field>
                <v-text-field v-model="formData.password" id="password" label="Password" type="password" :rules="passwordRules" required></v-text-field>
                <v-text-field v-model="formData.phone" id="phone" label="phone" type="phone" :rules="phoneRules" required></v-text-field>
                <br />
                <v-btn type="submit" color="primary" class="mt-3">Submit</v-btn>
              </v-form>
            </v-card-text>
  
            <v-card-actions>
              <div class="text-hint">Already have an account? <router-link to="/login">Login In</router-link></div>
            </v-card-actions>
          </v-card>
        </v-col>
        <v-col cols="12" sm="8" md="4">
          <v-card class="mt-5" style="background-color:red; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);"></v-card>
        </v-col>
      </v-row>
    </v-container>
  </template>
  
  <script>
  import { ref } from 'vue';
  
  export default {
    name: 'Registration',
    setup() {
      const valid = ref(false);
      const response = ref({});
      const formData = ref({
        name: '',
        email: '',
        password: '',
        phone: '',
      });
  
      const nameRules = [
        v => !!v || 'Full Name is required',
        v => (v && v.length >= 3) || 'Full Name must be at least 3 characters',
      ];
      const emailRules = [
        v => !!v || 'E-mail is required',
        v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
      ];
      const passwordRules = [
        v => !!v || 'Password is required',
        v => (v && v.length >= 6) || 'Password must be at least 6 characters',
      ];
      const phoneRules = [
        v => !!v || 'Phone number is required',
        v => (v && v.length >= 10) || 'Phone number must be a valid 10-digit number',
      ];
  
      const submitForm = () => {
        if (this.$refs.form.validate()) {
          console.log(formData.value.phone);
          window.axios.post('/registration', formData.value)
            .then((data) => {
              console.log(data);
              alert('success');
            });
        }
      };
  
      return {
        valid,
        response,
        formData,
        nameRules,
        emailRules,
        passwordRules,
        phoneRules,
        submitForm,
      };
    },
  };
  </script>
  
  <style scoped>
  .div1 {
    text-align: center;
  }
  
  .text-center {
    text-align: center;
  }
  
  .center-form {
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  
  .text-hint {
    text-align: center;
    color: #757575;
  }
  </style>
  