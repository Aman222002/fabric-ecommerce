<template>
    <v-container fluid class="ma-16">
        <v-row justify="space-around">
            <v-card width="1000" height="365" class="ml-0" :style="{ height: cardHeight }">
                <v-container>
                    <v-form ref="form" @submit.prevent="submitForm()">
                        <v-row v-if="!usersStore.isLoggedIN">
                            <v-col col="8">
                                <v-col cols="12">
                                    <h3>Users Details:</h3>
                                </v-col>
                                <v-row>
                                    <v-col col="6">
                                        <v-text-field variant="outlined" v-model="user.user_name"
                                            label="Representative Name" :rules="nameRules" density="compact"
                                            outlined></v-text-field>
                                    </v-col>
                                    <v-col cols="6" sm="6">
                                        <v-text-field variant="outlined" v-model="user.email" label="Representative Email"
                                            :rules="emailRules" density="compact" outlined></v-text-field>
                                    </v-col>
                                    <v-col cols="6" sm="6">
                                        <v-text-field variant="outlined" v-model="user.password" label="Password"
                                            :rules="passwordRules" type="password" density="compact"
                                            outlined></v-text-field>
                                    </v-col>
                                    <v-col cols="6" sm="6">
                                        <v-text-field variant="outlined" v-model="user.phone" label="Phone"
                                            :rules="phoneRules" type="phone" density="compact" outlined></v-text-field>
                                    </v-col>
                                </v-row>
                            </v-col>
                            <v-col col="4">
                                <v-col cols="12">
                                    <h3>Company Details:</h3>
                                </v-col>
                                <v-row>
                                    <v-col col="12">
                                        <v-text-field variant="outlined" v-model="company.company_name" label="Company Name"
                                            :rules="companyNameRules" density="compact" outlined></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col col="12" class="mt-3">
                                        <v-text-field variant="outlined" v-model="company.company_email"
                                            label="Company Email" :rules="companyEmailRules" density="compact"
                                            outlined></v-text-field>
                                    </v-col>
                                </v-row>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <h3>Plan Details:</h3>
                            </v-col>
                            <v-col cols="6" sm="6">
                                <v-text-field variant="outlined" v-model="plan.name" label="Plan Name" density="compact"
                                    outlined></v-text-field>
                            </v-col>
                            <v-col cols="6" sm="6">
                                <v-text-field variant="outlined" v-model="plan.price" label="Price" density="compact"
                                    outlined></v-text-field>
                            </v-col>
                        </v-row>
                        <v-btn type="submit" color="primary" class="button">Buy Now</v-btn>
                    </v-form>
                </v-container>
            </v-card>
        </v-row>
    </v-container>
</template>
<script>
import axios from 'axios';
import { useUsersStore } from '../store/user.js';
import { ref, computed, onMounted } from "vue";
export default {
    props: {
        data: {
            type: Object,
            default: () => ({}),
        }
    },
    setup(props) {
        const plan = ref({});
        console.log(props.data);
        const form = ref(null);
        console.log(props.data);
        plan.value = props.data;
        const usersStore = useUsersStore();
        const cardHeight = computed(() => {
            return usersStore.isLoggedIN ? '175px' : '386px';
        });
        const user = ref({
            user_name: '',
            email: '',
            password: '',
            phone: '',
        });
        const company = ref({
            company_name: "",
            company_email: "",
            status: "1",
        });
        const nameRules = [(v) => !!v || "Name is required"];
        const companyNameRules = [(value) => {
            if (value && value.length < 3) {
                return 'Name must be at least 3 characters long';
            }
        }]
        const companyEmailRules = [(value) => {
            if (value && !(/.+@.+\..+/.test(value))) {
                return "Enter a valid email";
            }
        }]
        const emailRules = [
            (v) => !!v || "Email is required",
            (v) => /.+@.+\..+/.test(v) || "Enter a valid email",
        ];
        const passwordRules = [(v) => !!v || "Password is required"];
        const phoneRules = [
            (v) => !!v || "Phone number is required",
            (v) => /^[0-9]{10}$/.test(v) || "Enter a valid 10-digit phone number",
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
                    for (let key in user.value) {
                        {
                            formData.append(key, user.value[key]);
                            console.log(key, user.value[key]);
                        }
                    }
                    for (let key in plan.value) {
                        {
                            formData.append(key, plan.value[key]);
                            console.log(key, plan.value[key]);
                        }
                    }
                    axios
                        .post("/company/buy/plan", formData)
                        .then((response) => {
                            console.log(response);
                            if (response.data.status == true) {
                                window.Swal.fire({
                                    icon: "success",
                                    title: "Email Sent",
                                    text: "We sent a mail to add subscription",
                                    confirmButtonText: "OK",
                                });
                            }
                        })
                        .catch((error) => {
                            console.error("Error:", error);
                        });
                }
            });
        };
        return {
            usersStore, company, user, nameRules,
            plan,
            emailRules,
            passwordRules,
            phoneRules,
            submitForm,
            companyEmailRules,
            companyNameRules,
            form, cardHeight
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

.button {
    margin-left: 440px;
    margin-bottom: 50px;
}

.v-row+.v-row {
    margin-top: 0px;
}
</style>