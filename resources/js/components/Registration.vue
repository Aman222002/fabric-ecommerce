<template>
    <v-container>
        <div class="register-form">
            <v-col cols="12" sm="8" md="6">
                <v-col class="mt-5"
                    style="background-color:#9a6a4f; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                    <v-card-title class="text-center">Find a job & grow your career</v-card-title>
                    <v-form ref="form" @submit.prevent="submitForm">
                        <v-text-field v-model="formData.name" id="fullName" label="Full Name" :rules="nameRules" required
                            variant="outlined"> </v-text-field>
                        <v-text-field v-model="formData.email" id="email" label="Email" type="email" :rules="emailRules"
                            required variant="outlined"></v-text-field>
                        <v-text-field v-model="formData.password" id="password" label="Password" type="password"
                            :rules="passwordRules" required variant="outlined"></v-text-field>

                        <v-text-field v-model="formData.phone" id="phone" label="phone" type="phone" :rules="phoneRules"
                            required variant="outlined"></v-text-field>
                        <br />
                        <v-btn type="submit" color="primary" class="mt-3">Submit</v-btn>
                    </v-form>
                    <v-card-actions>
                        <div class="text-hint">Already have an account? <a href="/login">Login In</a></div>
                    </v-card-actions>

                    <v-col cols="12" sm="8" md="4">
                        <v-card class="mt-5"
                            style="background-color:red; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                        </v-card>
                    </v-col>
                </v-col>
            </v-col>
        </div>
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
    methods: {
        submitForm() {
            if (this.$refs.form.validate()) {
                console.log(this.formData.phone);
                window.axios.post('/registration', this.formData)
                    .then((data) => {
                        if (data.status = true) {
                            alert("Registration successful");
                            window.location.href = './login';
                        } else {
                            alert("Registration failed");
                        }
                    })
                    .catch((error) => {
                        console.error(error);
                        alert("An error occurred during registration");
                    })

            }
        },
    },
}
</script>

<style scoped>
.register-form {
    background-image: url('/storage/assets/p.jpg');
    background-size: cover;
    padding: 5vh;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    background-repeat: no-repeat;
    background-position: center;
    color: "#006400";

}
</style> 

