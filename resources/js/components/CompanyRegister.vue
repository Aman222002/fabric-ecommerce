<template>
  <v-container class="my-8">
    <v-card class="pa-6 registration-form">
      <h1 class="mb-4 form-title">
        Company Registration Form:
      </h1>

      <v-form @submit.prevent="submitForm" class="custom-form">

        <v-text-field v-model="company.username" label="User Name" required class="custom-input"></v-text-field>
        <v-text-field v-model="company.useremail" label="User Email" required class="custom-input"></v-text-field>
        <v-text-field v-model="company.password" label="User Password" type="password" required class="custom-input"></v-text-field>
        <v-text-field v-model="company.confirmpassword" label="Confirm Password" type="password" required class="custom-input"></v-text-field>

    
        <v-divider class="mt-6"></v-divider>
        <h1 class="mb-4 form-title">
        Company Details:
      </h1>

        <v-text-field v-model="company.company_name" label="Company Name" required class="custom-input"></v-text-field>
        <v-text-field v-model="company.company_email" label="Company Email" required class="custom-input"></v-text-field>
        <v-text-field v-model="company.registration_number" label="Registration Number" class="custom-input"></v-text-field>
        <v-text-field v-model="company.company_address" label="Company Address" required class="custom-input"></v-text-field>
        <v-text-field v-model="company.phone_number" label="Phone Number" required class="custom-input"></v-text-field>
        <v-textarea v-model="company.description" label="Description" class="custom-input"></v-textarea>
        <v-select v-model="company.status" :items="['active', 'inactive']" label="Status" class="custom-input"></v-select>

        <v-btn type="submit" color="primary" class="custom-button">Register Company</v-btn>
      </v-form>
    </v-card>
  </v-container>
</template>

<script>
import { ref } from 'vue';

export default {
  name: "CompanyRegister",
  setup() {
    const company = ref({
      username: '',
      useremail: '',
      password: '',
      confirmpassword: '',
      company_name: '',
      company_email: '',
      registration_number: '',
      company_address: '',
      phone_number: '',
      description: '',
      status: '1',
    });

    const submitForm = () => {
      console.log('Company Data:', company.value);
      axios.post('/companyregister', company.value)
                    .then((data) => {
                        console.log(data);
                        
                    })
    };
    return {
      company,
      submitForm,
    };
  },
};
</script>
<style scoped>
.registration-form {
  max-width: 600px;
  margin: auto;
}

.form-title {
  font-size: xx-large;
  margin-top: 20px;
}

.custom-form {
  display: flex;
  flex-direction: column;
}

.custom-input {
  margin-bottom: 20px;
}

.custom-button {
  margin-top: 20px;
}
</style>
