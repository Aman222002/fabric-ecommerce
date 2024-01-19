<template>
  
  <v-container class="my-8">
    <v-card class="pa-6 registration-form">
      <v-form ref="form" @submit.prevent="submitForm" class="custom-form">
        <v-row>
          <!-- Left Side: User Detail -->
          <v-col cols="12" md="6" class="custom-col left-side">
            <h1 class="mb-4 form-title">User Detail:</h1>
            <v-text-field v-model="company.name" label="User Name" :rules="nameRules" required outlined></v-text-field>
            <v-text-field v-model="company.email" label="User Email" :rules="emailRules" required outlined></v-text-field>
            <v-text-field v-model="company.password" label="User Password" :rules="passwordRules" type="password" required outlined></v-text-field>
            <v-text-field v-model="company.phone" label="Phone" type="phone" required outlined></v-text-field>
          </v-col>

          <!-- Right Side: Company Details -->
          <v-col cols="12" md="6" class="custom-col right-side">
            <div class="company-details">
              <h1 class="mb-4 form-title">Company Details:</h1>
              <v-text-field v-model="company.company_name" label="Company Name" required outlined></v-text-field>
              <v-text-field v-model="company.company_email" label="Company Email" required outlined></v-text-field>
              <v-text-field v-model="company.registration_number" label="Registration Number" outlined></v-text-field>
              <v-text-field v-model="company.company_address" label="Company Address" required outlined></v-text-field>
              <v-text-field v-model="company.phone_number" label="Phone Number" required outlined></v-text-field>
              <v-textarea v-model="company.description" label="Description" outlined></v-textarea>
              <v-select v-model="company.status" :items="['0', '1']" label="Status" outlined></v-select>
            </div>
          </v-col>
        </v-row>

        <!-- Submit Button -->
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
      name: '',
      email: '',
      password: '',
      phone: '',
      company_name: '',
      company_email: '',
      registration_number: '',
      company_address: '',
      phone_number: '',
      description: '',
      status: '1',
    });
    const nameRules = [v => !!v || 'Name is required'];
    const emailRules = [v => !!v || 'Email is required', v => /.+@.+\..+/.test(v) || 'Enter a valid email'];
    const passwordRules = [v => !!v || 'Password is required'];

    const submitForm = () => {
      console.log('Company Data:', company.value);
      axios.post('/company/post', company.value)
        .then((response) => {
          console.log(response);
          if (response.data.status == true) {
            window.location.href = '/job';
          }
        })
        .catch((error) => {
          console.error('Error:', error);
        });
    };

    return {
      company,
      submitForm,
      nameRules,
      emailRules,
      passwordRules,
    };
  },
};
</script>

<style scoped>
.registration-form {
  max-width: 1000px;
  margin: auto;
}

.custom-col {
  width: 48%;
}

.left-side {
  border-right: 2px solid #ec9898;
  padding-right: 20px;
  max-height: 600px; /* Increased max-height for better readability */ 
  overflow-y: auto;
}

.right-side {
  padding-left: 20px;
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
  width: 100%;
}

.custom-button {
  margin-top: 20px;
  width: 100%;
}

.company-details {
  padding-left: 20px;
}
</style>
