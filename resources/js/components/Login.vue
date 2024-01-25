<!-- <template>
    <v-container fluid>
        <v-card class="mt-5 mx-auto" max-width="400">
            <v-card-title class="text-center">Log in</v-card-title>
            <v-card-text>
                <v-form @submit.prevent="login">
                    <v-text-field v-model="formData.email" id="email" label="Email" type="email" :rules="emailRules"
                        required></v-text-field>
                    <v-text-field v-model="formData.password" id="password" label="Password" type="password"
                        :rules="passwordRules" required></v-text-field>
                    <v-checkbox v-model="rememberMe" label="Remember Me"></v-checkbox>
                    <v-btn type="submit" color="primary" class="mt-3">Login</v-btn>
                </v-form>
                <v-card-actions>
                    <div class="text-hint">Already have an account? <a href="/registration">Sign up</a></div>
                </v-card-actions>
            </v-card-text>
        </v-card>
    </v-container>
</template>
<script>
import { ref } from 'vue';
export default {
    name: "Login",
    setup() {
        const valid = ref(false);
        const rememberMe = ref(false);
        const formData = ref({
            email: '',
            password: '',
        });
        const emailRules = [
            v => !!v || 'E-mail is required',
            v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
        ];

        const passwordRules = [
            v => !!v || 'Password is required',
            v => (v && v.length >= 6) || 'Password must be at least 6 characters',
        ];

        const login = async () => {
            if (valid.value) {
                axios.post('/registration', formData.value)
                    .then(data => {
                        if (data.status) {
                            alert('Login successful');
                            window.location.href = './Mncs';
                        } else {
                            alert('Login  failed');
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        alert('An error occurred during registration');
                    });
            }
        };
        return {
            valid,
            formData,
            rememberMe,
            emailRules,
            passwordRules,
            login,
        };
    },
};
</script>
   -->

<template>
    <v-container fluid class="div1">

        <div class="register-form">
            <v-col cols="12" sm="6" md="6">
                <v-col class="mt-5"
                    style="background-color:#9a6a4f; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                    <v-card-title class="text-center">Login</v-card-title>
                    <v-card-text>
                        <v-form ref="form" @submit.prevent="submitForm">
                            <v-text-field v-model="formData.email" id="email" label="Email" type="email" :rules="emailRules"
                                required variant="outlined"></v-text-field>
                            <v-text-field v-model="formData.password" id="password" label="Password" type="password"
                                :rules="passwordRules" required variant="outlined"></v-text-field>
                            <v-btn type="submit" color="primary" class="mt-3">Submit</v-btn>
                        </v-form>
                    </v-card-text>
                    <v-card-actions>
                        <div class="text-hint">Don't have an account? <a href="/registration">Register</a>
                        </div>
                    </v-card-actions>

                </v-col>
            </v-col>
        </div>
    </v-container>
</template>
  
<script>

export default {
    name: 'Login',
    data() {
        return {
            formData: {
                email: '',
                password: '',
            },

            emailRules: [
                v => !!v || 'E-mail is required',
                v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
            ],
            passwordRules: [
                v => !!v || 'Password is required',
                v => (v && v.length >= 6) || 'Password must be at least 6 characters',
            ],
        };
    },
    methods: {
        async submitForm() {
            try {
                const response = await window.axios.post('/login', this.formData);
                const data = response.data;

                if (data.status === true) {
                    alert('Login successful');

                    window.location.href = './resume';
                } else {
                    alert('Login failed');
                }
            } catch (error) {
                console.error(error);
                alert('An error occurred during login');
            }
        },
    },
};
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
  