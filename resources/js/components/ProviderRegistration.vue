
<template>
    <v-form @submit.prevent="registerCustomer">

        <v-container class="custom-container">
            <v-card>
                <v-img src="/resources/js/assets/1.jpg" alt="Registration Image"></v-img>
                <v-card-title class="headline">
                    <v-icon>mdi-account</v-icon> Provider Registration</v-card-title>
                <v-card-text>
                    <v-row>
                        <v-card-title class="label-icon"> <v-icon icon=mdi-home></v-icon></v-card-title>
                        <v-col cols="12" md="6">
                            <v-text-field v-model="name" label="Business Name"
                                :rules="[v => !!v || 'Business Name is required']" maxlength="100"
                                class="custom-text-field"></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-card-title class="label-icon"><v-icon>mdi-account</v-icon></v-card-title>
                        <v-col cols="12" md="6">
                            <v-text-field v-model="name" label="Name" :rules="[v => !!v || 'Name is required']"
                                maxlength="100" class="custom-text-field"></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-card-title><v-icon>mdi-email</v-icon></v-card-title>
                        <v-col cols="12" md="6">
                            <v-text-field v-model="email" label="Email"
                                :rules="[v => !!v || 'Email is required', v => /.+@.+\..+/.test(v) || 'Email must be valid']"
                                maxlength="100" class="custom-text-field"></v-text-field>

                        </v-col>
                    </v-row>

                    <v-row>
                        <v-card-title><v-icon>mdi-lock</v-icon></v-card-title>
                        <v-col cols="12" md="6">
                            <v-text-field v-model="password" label="Password" type="password"
                                :rules="[v => !!v || 'Password is required']" maxlength="100"
                                class="custom-text-field"></v-text-field>

                        </v-col>
                    </v-row>
                    <v-row>
                        <v-card-title>
                            <v-icon>mdi-lock-check</v-icon>
                        </v-card-title>
                        <v-col cols="12" md="6">
                            <v-text-field v-model="confirmPassword" label="Confirm Password" type="password"
                                :rules="[v => !!v || 'Confirm Password is required', v => v === password || 'Passwords must match']"
                                maxlength="100" class="custom-text-field"></v-text-field>

                        </v-col>
                    </v-row>
                    <v-row>
                        <v-checkbox v-model="acceptTerms" label="I accept the terms and conditions"></v-checkbox>
                    </v-row>
                </v-card-text>

                <v-card-actions>
                    <v-btn type="submit" color="blue" :disabled="!acceptTerms">Register</v-btn>
                </v-card-actions>
                <v-card-actions>
                    <div class="text-hint">Already have an account? <a href to="/Login">Login</a></div>
                </v-card-actions>
            </v-card>
        </v-container>

    </v-form>
</template>
  
<script>
export default {
    data() {
        return {
            name: '',
            email: '',
            password: '',
            confirmPassword: '',
            acceptTerms: false,
        };
    },
    methods: {
        registerCustomer() {
            // Validate form before submission
            if (this.$refs.form.validate() && this.acceptTerms) {
                // Registration logic when form is valid
                console.log('User registered:', this.name, this.email, this.password);
            }

            // Customer registration logic
            console.log('Customer registered:', this.formFields);
        },
    },
};
</script>

<style scoped>
.flex-container {
    display: flex;
}

.background-image {
    /* Set the background image and configure other properties */
    background-image: url('@/assets/background-image.jpg');
    background-size: cover;
    background-position: center center;
    background-repeat: no-repeat;
    min-height: 100%;
    /* Ensure the container takes at least the full height of the viewport */
    flex: 1;
    /* Take the remaining space in the flex container */
}

/* 
.registration-form {
    padding: 20px;
    /* Optional padding for the registration form */
/* max-width: 900px; */
/* Adjust the maximum width of the registration form */


.background-image {
    /* Set the background image and configure other properties */
    background-image: url('@/assets/background-image.jpg');
    background-size: cover;
    background-position: center center;
    background-repeat: no-repeat;
    width: 100%;
    height: 100%;
    /* Ensure the container takes at least the full height of the viewport */
    display: flex;
    flex-direction: column;
    align-items: center;
}

.headline {
    text-align: center;
}

.custom-text-field {
    width: 150%;
    /* Your custom styles for the text fields */
    border-color: #ff0000;
    /* Example: Red border for illustration */
}

.custom-container {
    max-width: 500px;
    color: red;
    border-color: #ff0000;

    /* Adjust the desired maximum width */
    margin: auto;
    /* Center the container horizontally */
}

.text-hint {
    font-size: 14px;
    margin-top: 10px;
    text-align: center;
    color: red;
}

.v-text-field {
    margin-bottom: 16px;

    /* Adjust the bottom margin as needed */
}
</style>
  