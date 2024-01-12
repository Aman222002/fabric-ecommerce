<template>
    <v-app>
        <v-container>
            <v-row justify="center">
                <v-col cols="12" sm="8" md="4">
                    <v-card class="mt-5">
                        <v-card-title class="text-center">Log in</v-card-title>

                        <v-card-text>
                            <v-form @submit.prevent="login">

                                <v-text-field v-model="email" label="Email" type="email"
                                    :rules="[rules.required, rules.email]"></v-text-field>
                                <v-text-field v-model="password" label="Password" type="password"
                                    :rules="[rules.required, rules.password]"></v-text-field>

                                <v-row>
                                    <v-col>
                                        <v-checkbox v-model="rememberMe" label="Remember Me"></v-checkbox>
                                    </v-col>
                                </v-row>

                                <v-btn type="submit" color="primary" class="mt-3">Login</v-btn>
                            </v-form>
                            <v-card-actions>
                                <div class="text-hint">Already have an account? <a href to="/Registration">sign
                                        up</a></div>
                            </v-card-actions>
                        </v-card-text>
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
            email: '',
            password: '',
            rememberMe: false,
            rules: {
                required: value => !!value || 'This field is required',
                email: value => /.+@.+\..+/.test(value) || 'Enter a valid email address',
                password: value => value.length >= 8 || 'Password must be at least 8 characters',
            },
        };
    },
    methods: {
        login() {
            // Add your login logic here
            console.log('Logging in with:', this.email, this.password, 'Remember Me:', this.rememberMe);
        },
        forgotPassword() {
            // Add your logic for handling forgot password
            console.log('Forgot Password clicked');
        },
    },
};
</script>

<style scoped>
.v-card {
    max-width: 400px;
    /* Adjust the maximum width of the card */
    margin: 0 auto;
    /* Center the card horizontally */
}

.text-center {
    text-align: center;
    /* Center-align the card title */
}

.v-text-field,
.v-checkbox,
.v-btn {
    width: 100%;
    /* Make form elements full-width */
    margin-bottom: 15px;
    /* Add some bottom margin between form elements */
}

.text-hint {
    text-align: center;
    /* Center-align the "Already have an account?" text */
}

/* Add your custom styles here */
</style>
