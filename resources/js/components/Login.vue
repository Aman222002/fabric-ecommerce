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
        <v-row class="center-form">
            <v-col cols="12" sm="8" md="4">
                <v-card class="mt-5"
                    style="background-color:#ADD8E6; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                    <v-card-title class="text-center">Login </v-card-title>
                    <v-card-text>
                        <v-form ref="form" @submit.prevent="submitForm">
                            <v-text-field v-model="formData.email" id="email" label="Email" type="email" :rules="emailRules"
                                required></v-text-field>
                            <v-text-field v-model="formData.password" id="password" label="Password" type="password"
                                :rules="passwordRules" required></v-text-field>
                            <v-checkbox v-model="rememberMe" label="Remember Me"></v-checkbox>
                            <v-btn type="submit" color="primary" class="mt-3">Submit</v-btn>
                        </v-form>
                    </v-card-text>
                    <v-card-actions>
                        <div class="text-hint">Already have an account? <a href="/login">Login In</a></div>
                    </v-card-actions>
                </v-card>
            </v-col>
            <v-col cols="12" sm="8" md="4">
                <v-card class="mt-5"
                    style="background-color:red; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
<script>
export default {
    name: 'Login',
    data() {
        return {
            valid: false,
            response: {},
            formData: {
                email: '',
                password: '',
                rememberMe: '',

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
        submitForm() {
            if (this.$refs.form.validate()) {
                window.axios.post('/login', this.formData)
                    .then((data) => {
                        // console.log(data);
                        // alert("success");
                        if (data.status = true) {
                            alert("Login successful");
                            window.location.href = './generate_cv';
                        } else {
                            alert("Login  failed");
                        }
                    })
                    .catch((error) => {
                        console.error(error);
                        alert("An error occurred during login");
                    })

            }
        },
    },
}
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
</style>