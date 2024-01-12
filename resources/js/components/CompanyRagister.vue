<template>
    <v-container>
      <v-form @submit.prevent="submitForm">
        <v-row>
          <v-col cols="12" md="6">
            <v-text-field v-model="company.name" label="Company Name" required></v-text-field>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field v-model="company.email" label="Email" required></v-text-field>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field v-model="company.phone_number" label="Phone Number" required></v-text-field>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field v-model="company.address" label="Address" required></v-text-field>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field v-model="company.registration_number" label="Registration Number"></v-text-field>
          </v-col>
          <v-col cols="12">
            <v-textarea v-model="company.description" label="Description"></v-textarea>
          </v-col>
          <v-col cols="12" md="6">
            <v-select v-model="company.status" :items="['active', 'inactive']" label="Status"></v-select>
          </v-col>
          <v-col cols="12">
            <v-btn type="submit" color="primary">Register Company</v-btn>
          </v-col>
        </v-row>
      </v-form>
    </v-container>
  </template>
  
  <script>
  export default {
    data() {
      return {
        company: {
          name: '',
          email: '',
          phone_number: '',
          address: '',
          registration_number: '',
          description: '',
          status: 'active',
        },
      };
    },
    methods: {
      submitForm() {
     
        console.log('Company Data:', this.company);
       
        this.company = {
          name: '',
          email: '',
          phone_number: '',
          address: '',
          registration_number: '',
          description: '',
          status: 'active',
        };
      },
    },
  };
  </script>
  <style scoped>
  </style>
  