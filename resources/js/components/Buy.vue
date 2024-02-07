<template>
    <v-container>
        <v-card>
            <v-form ref="form" @submit.prevent="submitForm()" class="custom-form">
                <v-row v-if="!usersStore.isLoggedIN">
                    <v-col cols="12">
                        <h3>User Detail:</h3>
                    </v-col>
                    <v-col cols="3" sm="3">
                        <v-text-field variant="outlined" v-model="company.name" label="Representative Name"
                            :rules="nameRules" outlined></v-text-field>
                    </v-col>
                    <v-col cols="3" sm="3">
                        <v-text-field variant="outlined" v-model="company.email" label="Representative Email"
                            :rules="emailRules" outlined></v-text-field>
                    </v-col>
                    <v-col cols="3" sm="3">
                        <v-text-field variant="outlined" v-model="company.password" label="Password" :rules="passwordRules"
                            type="password" outlined></v-text-field>
                    </v-col>
                    <v-col cols="3" sm="3">
                        <v-text-field variant="outlined" v-model="company.phone" label="Phone" :rules="phoneRules"
                            type="phone" outlined></v-text-field>
                    </v-col>
                </v-row>
                <v-row v-if="!usersStore.isLoggedIN">
                    <v-col cols="12" sm="12">
                        <h3>Company Details:</h3>
                    </v-col>
                    <v-col cols="3" sm="3">
                        <v-text-field variant="outlined" v-model="company.company_name" label="Company Name"
                            :rules="companyNameRules" outlined></v-text-field>
                    </v-col>
                    <v-col cols="3" sm="3">
                        <v-text-field variant="outlined" v-model="company.company_email" label="Company Email"
                            :rules="companyEmailRules" outlined></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12">
                        <h3 class="form-title">Plan:</h3>
                    </v-col>
                    <v-col cols="6" sm="6">
                        <v-text-field variant="outlined" label="Plan Name" outlined></v-text-field>
                    </v-col>
                    <v-col cols="6" sm="6">
                        <v-text-field variant="outlined" label="Price" outlined></v-text-field>
                    </v-col>
                </v-row>
                <v-row justify="center">
                    <v-col cols="12" class="text-center">
                        <v-btn type="submit" color="primary" class="custom-button">Buy Now</v-btn>
                    </v-col>
                </v-row>
            </v-form>
        </v-card>
    </v-container>
</template>
<script>
import axios from 'axios';
import { useUsersStore } from '../store/user.js';
import { ref, onMounted } from "vue";
export default {
    setup() {
        const usersStore = useUsersStore();
        const company = ref({
            name: "",
            email: "",
            password: "",
            phone: "",
            company_name: "",
            company_email: "",
            first_line_address: "",
            street: "",
            state: "",
            city: "",
            postal_code: "",
            phone_number: "",
            description: "",
            status: "1",
            logo: [],
        });
        const nameRules = [(v) => !!v || "Name is required"];
        const companyNameRules = [(v) => (v && v.length >= 3 && v.length <= 15) || "Company name must be between 3 and 15 characters"];
        const companyEmailRules = [(v) => /.+@.+\..+/.test(v) || "Enter a valid email"];
        const emailRules = [
            (v) => !!v || "Email is required",
            (v) => /.+@.+\..+/.test(v) || "Enter a valid email",
        ];
        const passwordRules = [(v) => !!v || "Password is required"];
        const phoneRules = [
            (v) => !!v || "Phone number is required",
            (v) => /^[0-9]{10}$/.test(v) || "Enter a valid 10-digit phone number",
        ];
        const stateRules = [(v) => !!v || "State is required"];
        const cityRules = [(v) => !!v || "city is required"];
        const postalCodeRules = [
            (v) => !!v || "Postal code is required",
            (v) => /^[0-9]{6}$/.test(v) || "Enter a valid 6-digit postal code",
        ];
        const submitForm = () => {
            form.value.validate().then((valid) => {
                if (!valid.valid) {
                    const errors = JSON.parse(JSON.stringify(valid.errors));
                    let errorField = form.value[errors[0].id];
                    errorField = Array.isArray(errorField) ? errorField[0] : errorField;
                    errorField.scrollIntoView({
                        behavior: "smooth",
                        block: "center",
                        inline: "center"
                    });

                } else {
                    const formData = new FormData();
                    for (let key in company.value) {
                        {
                            formData.append(key, company.value[key]);
                            console.log(key, company.value[key]);
                        }
                    }
                    for (let key in plan.value) {
                        {
                            formData.append(key, company.value[key]);
                            console.log(key, company.value[key]);
                        }
                    }
                    axios
                        .post("/company/post", formData, {
                            headers: {
                                "Content-Type": "multipart/form-data",
                            },
                        })
                        .then((response) => {
                            console.log(response);
                            if (response.data.status == true) {
                                window.Swal.fire({
                                    icon: "success",
                                    title: "Company Registered",
                                    text: "Your company has been successfully registered!",
                                    confirmButtonText: "OK",
                                });
                                window.location.href = "/job";
                            }
                        })
                        .catch((error) => {
                            console.error("Error:", error);
                        });
                }
            });
        };
        onMounted(() => {
            axios.get(`/get/plan/`).then((response) => {

            }).catch((err) => {

            })
        });
        return {
            usersStore, company, nameRules,
            emailRules,
            passwordRules,
            postalCodeRules,
            phoneRules,
            cityRules,
            stateRules,
            submitForm,
            companyEmailRules,
            companyNameRules,
        }
    }
}
</script>
<style>
.v-col-sm-12 {
    padding-left: 12px;
    padding-top: 0px;
    padding-bottom: 0px;
}
</style>