<template>
    <v-container>
        <v-row justify="center">
            <v-col cols="12" sm="8" md="6">
                <v-card class="elevation-2 mt-4">
                    <v-toolbar color="primary" dark flat>
                        <v-toolbar-title class="text-center">Reset Password</v-toolbar-title>
                    </v-toolbar>
                    <v-card-text>
                        <v-form @submit.prevent="resetPassword">
                            <v-text-field class="mb-3" v-model="formData.password" label="New Password" variant="outlined"
                                density="compact" :rules="newRules" type="password" required></v-text-field>
                            <v-text-field class="mb-3" v-model="formData.confirmPassword" label="Confirm Password"
                                variant="outlined" density="compact" :rules="confirmRules" type="password"
                                required></v-text-field>
                            <v-btn type="submit" color="primary" class="mr-4">Reset Password</v-btn>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
  
<script>
import { ref } from 'vue';
import axios from 'axios';
import {Sweetalert} from '../utils/sweetalert';
export default {
    name: 'ResetPassword',
    props: {
        data: {
            type: Object,
            default: () => ({}),
        },
    },
    setup(props) {
        const newRules = ref([
            value => !!value || 'Password is required',
            value => (value && value.length >= 8) || 'Password must be at least 8 characters',
        ]);
        const confirmRules = ref([
            value => !!value || 'Confirm Password is required',
            value => (value === formData.value.password) || 'Passwords do not match',
        ]);
        const formData = ref({
            email: '',
            password: '',
            confirmPassword: '',
            user_id: '',
            reset_token: '',
        });
        formData.value.user_id = props.data.id;
        formData.value.reset_token = props.data.token;
        const resetPassword = async () => {
            try {
                console.log(formData.value);
                const response = await axios.post("/reset/new/password/", formData.value);
                // console.log(response.data);
                if (response.data.status) {
                  
                    Sweetalert.success('User Password updated successfully!')
                    window.location.href = "/login";
                }
            } catch (error) {
                console.log(error);
            }
        }
        return {
            formData,
            resetPassword,
            newRules,
            confirmRules,
            props
        };
    }
};
</script>
  