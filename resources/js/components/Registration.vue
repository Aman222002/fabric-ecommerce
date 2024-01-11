
<template>
    <v-app>
        <v-container fluid class="div1">
            <v-row class="center-form">
                <v-col cols="12" sm="8" md="4">
                    <v-card class="mt-5"
                        style="background-color:#ADD8E6; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                        <v-card-title class="text-center">Find a job & grow your career</v-card-title>

                        <v-card-text>
                            <v-form ref="form" @submit.prevent="submitForm">

                                <v-text-field v-model="fullName" label="Full Name" :rules="nameRules"
                                    required></v-text-field>
                                <v-text-field v-model="email" label="Email" type="email" :rules="emailRules"
                                    required></v-text-field>
                                <v-text-field v-model="password" label="Password" type="password" :rules="passwordRules"
                                    required></v-text-field>
                                <vue-tel-input v-model="phone" mode="international" :rules="phoneRules"></vue-tel-input>
                                <br />
                                <v-select v-model="workStatus" :items="workStatusOptions" label="Work Status"
                                    :rules="workStatusRules" required></v-select>
                                <v-select v-model="highestEducation" :items="educationOptions" label="Highest Education"
                                    :rules="educationRules" required></v-select>
                                <v-file-input v-model="cv" label="Upload CV" accept=".pdf,.doc,.docx" @change="onFileChange"
                                    :rules="cvRules"></v-file-input>

                                <v-row>
                                    <v-col>
                                        <v-text-field v-model="cvFileName" label="File Name" readonly></v-text-field>
                                    </v-col>
                                </v-row>

                                <v-btn type="submit" color="primary" class="mt-3">Submit</v-btn>
                            </v-form>
                        </v-card-text>

                        <v-card-actions>
                            <div class="text-hint">Already have an account? <router-link to="/Registration">Sign
                                    up</router-link></div>
                        </v-card-actions>
                    </v-card>
                </v-col>
                <v-col cols="12" sm="8" md="4">
                    <v-card class="mt-5"
                        style="background-color:red; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                        <!-- ... (additional content) ... -->
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
            fullName: '',
            email: '',
            password: '',
            phone: '',
            country: '',
            workStatus: '',
            cv: null,
            educationOptions: ['12th', 'Diploma', 'Graduation', 'Post Graduation'],
            countries: ['Country 1', 'Country 2', 'Country 3'],
            workStatusOptions: ['experienced', 'Unemployed', 'fresher'],
            nameRules: [
                v => !!v || 'Full Name is required',
                v => (v && v.length >= 3) || 'Full Name must be at least 3 characters',
            ],
            emailRules: [
                v => !!v || 'E-mail is required',
                v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
            ],
            passwordRules: [
                v => !!v || 'Password is required',
                v => (v && v.length >= 6) || 'Password must be at least 6 characters',
            ],
            phoneRules: [
                v => !!v || 'Phone number is required',
                v => (v && v.length >= 10) || 'Phone number must be a valid 10-digit number',
            ],
            countryRules: [
                v => !!v || 'Country is required',
            ],
            educationRules: [
                v => !!v || 'Highest Education is required',
            ],
            workStatusRules: [
                v => !!v || 'Work Status is required',
            ],
            cvRules: [
                v => !!v || 'CV is required',
            ],
        };
    },
    computed: {
        cvFileName() {
            return this.cv ? this.cv.name : '';
        },
    },
    methods: {
        submitForm() {
            if (this.$refs.form.validate()) {
                // Handle form submission logic here
                console.log('Form submitted:', this.fullName, this.email, this.password, this.mobile, this.country, this.workStatus, this.highestEducation, this.cv);
                // You can use Axios to send the form data to your server
                // Example: axios.post('/api/register', { formData });
            }
        },
        onFileChange(event) {
            // Extract the File object from the event
            const file = event.target.files[0];

            // Update the cv data property
            this.cv = file;
        },
        // onFileChange(file) {
        //     this.cv = file;
        // },
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

/* Add more custom styles as needed */
</style>