<template>
    <v-container>
      <v-row justify="center">
        <v-col cols="12" sm="8" md="4">
          <v-card class="custom-card elevation-12">
            <v-card-title class="custom-title pa-4" primary>
              Confirmation
            </v-card-title>
            <v-card-text class="mt-6">
              <v-alert class=" pa-3" :value="success" type="success" outlined icon="mdi-check-circle-outline">
                Verification successful. Please login.
              </v-alert>
            </v-card-text>
            <v-card-actions>
              <v-btn color="white" style="background-color:  #0146a6;" @click="login">Login</v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  
  const success = ref(true);
  
  const login = () => {
    window.location.href="/company/login";
  };
  </script>
  
  <style scoped>
  .custom-title {
    background-color: #0146a6 !important;
    color: #fff !important;
    padding: 16px;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
  }
  
  .custom-card {
    border-radius: 8px;
  }
  
  .custom-card .v-card-actions {
    justify-content: center;
  }
  
  .custom-card .v-btn {
    color: #fff;
  }
  .v-container {
    margin-top: 50px;
    height: 290px;
   
  }
  @media only screen and (max-width: 600px) {
    .custom-card {
      width: 90%;
    }
  }
  </style>
  