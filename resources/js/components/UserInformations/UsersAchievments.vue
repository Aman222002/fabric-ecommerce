<template>
    <v-container class="container-center">
        <v-card style="width: 70%; height: 10%">
            <v-form @submit.prevent="submitForm">
                <v-row>
                    <v-col cols="12" md="6">
                        <v-text-field v-model="certification_name" :rules="certificationNameRules"
                            label="Certification Name"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field v-model="company_name" :rules="companyNameRules" label="Company Name"></v-text-field>
                    </v-col>
                </v-row>
                <v-col cols="12" md="12">
                    <v-text-field v-model="certificate_number" :rules="certificateNumberRules"
                        label="Certificate Number"></v-text-field>
                </v-col>
                <v-col cols="12" md="10">
                    <v-date-picker v-model="expiry_date" :rules="expiryDateRules" label="Expiry Date"></v-date-picker>
                </v-col>
                <v-col cols="12" md="10">
                    <v-file-input v-model="certificate_file_path" label="Certificate File"></v-file-input>
                </v-col>
                <v-btn type="submit" color="primary">Submit</v-btn>
            </v-form>
        </v-card>
    </v-container>
</template>
  
<script>
import { ref, computed } from 'vue';

export default {
    setup() {
        const certification_name = ref('');
        const company_name = ref('');
        const certificate_number = ref('');
        const expiry_date = ref(null);
        const certificate_file_path = ref(null);

        const certificationNameRules = computed(() => [v => !!v || 'Certification Name is required']);
        const companyNameRules = computed(() => [v => !!v || 'Company Name is required']);
        const certificateNumberRules = computed(() => [v => !!v || 'Certificate Number is required']);
        const expiryDateRules = computed(() => [v => !!v || 'Expiry Date is required']);

        const formIsValid = computed(() =>
            certificationNameRules.value.length === 0 &&
            companyNameRules.value.length === 0 &&
            certificateNumberRules.value.length === 0 &&
            expiryDateRules.value.length === 0
        );

        const submitForm = () => {
            if (formIsValid.value) {
                const formData = {
                    certificationName: certification_name.value,
                    companyName: company_name.value,
                    certificateNumber: certificate_number.value,
                    expiryDate: expiry_date.value,
                    certificateFile: certificate_file_path.value,
                };
                axios.post('/users-achievments', formData)
                    .then(response => {
                        // Handle successful response
                    })
                    .catch(error => {
                        // Handle validation errors or other errors
                        if (error.response && error.response.status === 422) {
                            // Handle validation errors, e.g., display them to the user
                            console.log(error.response.data); // Log validation errors
                        } else {
                            // Handle other errors
                            console.error(error.message);
                        }
                    });


                resetForm();
            }
        };

        const resetForm = () => {
            certification_name.value = '';
            company_name.value = '';
            certificate_number.value = '';
            expiry_date.value = null;
            certificate_file_path.value = null;
        };

        return {
            certification_name,
            company_name,
            certificate_number,
            expiry_date,
            certificate_file_path,
            certificationNameRules,
            companyNameRules,
            certificateNumberRules,
            expiryDateRules,
            formIsValid,
            submitForm,
            resetForm,
        };
    },
};
</script>
  
<style scoped>
/* Add your custom styles here if needed */
</style>
  