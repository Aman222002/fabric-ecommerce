<template>
  <v-container class="my-8">
    <v-row align="center" justify="center">
      <v-col cols="12" sm="8" md="6" lg="4">
      <v-form ref="form" @submit.prevent="submitForm" class="custom-form">
        <div class="custom-col left-side">
          <h3 class="mb-4 form-title">User Detail:</h3>
          <v-text-field variant="outlined" v-model="company.name" label="Representative Name" :rules="nameRules" required outlined style="margin-bottom: 10px; margin-top: 5px; max-width: 140%;"></v-text-field>
          <v-text-field variant="outlined" v-model="company.email" label=" Representative Email" :rules="emailRules" required outlined style="margin-bottom: 10px;max-width: 140%;"></v-text-field>
          <v-text-field variant="outlined" v-model="company.password" label=" Password" :rules="passwordRules" type="password" required outlined style="margin-top: 10px;max-width: 140%;"></v-text-field>
          <v-text-field variant="outlined" v-model="company.phone" label="Phone" type="phone" required outlined style="margin-top: 10px;max-width: 140%;"></v-text-field><br>
        </div>
        <div class="custom-col right-side">
          <div class="company-details">
            <h3 class="mb-4 form-title">Company Details:</h3>
            <v-text-field variant="outlined" v-model="company.company_name" label="Company Name" required outlined style="margin-bottom: 10px; max-width: 140%;"></v-text-field>
            <v-text-field variant="outlined" v-model="company.company_email" label="Company Email" required outlined style="margin-bottom: 10px; max-width: 140%;"></v-text-field>
            <v-text-field variant="outlined" v-model="company.phone_number" label="Phone Number" required outlined style="margin-bottom: 10px; max-width: 140%;"></v-text-field>
            <v-textarea variant="outlined" v-model="company.description" label="Description" outlined style="margin-bottom: 10px; max-width: 140%;"></v-textarea>
          </div>
        </div>

        <div class="custom-col left-side">
          <h3 class="mb-4 form-title">Company Address:</h3>
          <v-text-field variant="outlined" v-model="company.first_line_address" label="First_Line_Address" outlined style="max-width: 140%;"></v-text-field>
          <v-text-field variant="outlined" v-model="company.street" label="Street" outlined style="max-width: 140%;"></v-text-field>
          <v-text-field variant="outlined" v-model="company.city" label="City" outlined style="max-width: 140%;"></v-text-field>
          <v-text-field variant="outlined" v-model="company.state" label="State" outlined style="max-width: 140%;"></v-text-field>
          <v-text-field variant="outlined" v-model="company.postal_code" label="Postal Code" outlined style="max-width: 140%;"></v-text-field>
        </div>

      
        <v-btn type="submit" color="primary" class="custom-button">Register Company</v-btn>

      </v-form>
    </v-col>
    </v-row>
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
      first_line_address: '',
      street: '',
      state: '',
      city: '',
      postal_code:'',
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


/* Optional: Add some margin or padding if needed */
.v-row.center {
  margin: auto;
}

.v-col.center {
  text-align: center;
}
</style>


