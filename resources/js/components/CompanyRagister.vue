<template>
  <v-container>
    <v-text-display-4 class="mb-4" style="font-size: xx-large; margin-top: 20px">
      Company Registration Form:
    </v-text-display-4>
    <br />

    <v-form @submit.prevent="submitForm">
      
      <v-text-field v-model="company.username" label="User Name" required></v-text-field>
      <v-text-field v-model="company.useremail" label="User Email" required></v-text-field>
      <v-text-field v-model="company.password" label="User Password" required></v-text-field>
      <v-text-field v-model="company.confirmpassword" label="Confirm Password" required></v-text-field>

      
      <v-text-display-4 class="mb-4" style="font-size: xx-large; margin-top: 20px">
        Company Details:
      </v-text-display-4>
      <br />

      <v-text-field v-model="company.name" label="Company Name" required></v-text-field>
      <v-text-field v-model="company.email" label="Email" required></v-text-field>
      <v-text-field v-model="company.phone_number" label="Phone Number" required></v-text-field>
      <v-text-field v-model="company.address" label="Address" required></v-text-field>
      <v-text-field v-model="company.registration_number" label="Registration Number"></v-text-field>
      <v-textarea v-model="company.description" label="Description"></v-textarea>
      <v-select v-model="company.status" :items="['active', 'inactive']" label="Status"></v-select>

      <v-btn type="submit" color="primary">Register Company</v-btn>
    </v-form>
  </v-container>
</template>

<script>
import { ref } from 'vue';

export default {
  setup() {
    const company = ref({
      username: '',
      useremail: '',
      password: '',
      confirmpassword: '',
      name: '',
      email: '',
      phone_number: '',
      address: '',
      registration_number: '',
      description: '',
      status: 'active',
    });

    const submitForm = () => {
      console.log('Company Data:', company.value);

      company.value = {
        username: '',
        useremail: '',
        password: '',
        confirmpassword: '',
        name: '',
        email: '',
        phone_number: '',
        address: '',
        registration_number: '',
        description: '',
        status: 'active',
      };
    };

    return {
      company,
      submitForm,
    };
  },
};
</script>

<style scoped>
  
</style>
