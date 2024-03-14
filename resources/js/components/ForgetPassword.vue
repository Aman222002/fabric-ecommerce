<template>
    <v-container>
        <v-row justify="space-around" class="mt-6">
            <v-card class="elevation-12 mt-3" width="500">
                <v-col cols="12" sm="12">
                    <v-row>
                        <v-col cols="12" md="12">
                            <v-form ref="form" @submit.prevent="submitForm">
                                <h5 class="text-primary text-center mt-2 mb-2"
                                    style="font-size:18px; font-style: sans-serif;">
                                    Forgot
                                    Password?
                                </h5>
                                <p class="text-muted text-center mb-2">Reset password with JobPath</p>
                                <v-icon size="80px" icon="mdi-email" color="teal-darken-2" class="icon">
                                </v-icon>
                                <div class="alert border-0 text-center mb-2 ml-8 d-flex align-center justify-center">
                                    Enter your email and instructions will
                                    be sent to you!
                                </div>
                                <v-row align="center" justify="center">
                                    <v-col cols="12" sm="10">
                                        <v-text-field label="Email" v-model="formData.email" variant="outlined" dense
                                            density="compact" color="blue" :rules="emailRules" autocomplete="false"
                                            class="mt-8" style="font-size: 10px;" />
                                    </v-col>
                                    <v-col cols="10" sm="10">
                                        <v-btn type="submit" class="bg-primary mb-2 email-button" width="100%">
                                            Send Reset Link
                                        </v-btn>
                                    </v-col>
                                </v-row>
                            </v-form>
                        </v-col>
                    </v-row>
                </v-col>
            </v-card>
        </v-row>
        <div class="mt-10 text-center">
            <p class="mb-0">Enter registered email only</p>
        </div>
        <div class="mt-10 text-center">
            <p class="mb-0">Wait, I remember my password... <a href="/job" class="text-primary "> Click here
                </a> </p>
        </div>
    </v-container>
</template>
<script>
import { ref, onMounted } from "vue";
export default {
    name: "ForgetPassword",
    setup() {
        const formData = ref({
            email: "",
        })
        const emailRules = [
            (v) => !!v || "E-mail is required",
            (v) => /.+@.+\..+/.test(v) || "E-mail must be valid",
        ];
        const submitForm = async () => {
            try {
                // console.log(formData.value);
                const response = await axios.post("/get/forget/password/link", formData.value);
                console.log(response.data);
            } catch (error) {
                console.log(error);
            }
        }
        // const logPreviousPageUrl = () => {
        //     console.log("Previous page URL:", document.referrer);
        // }
        // Call the function when the component is mounted
        // onMounted(() => {
        //     logPreviousPageUrl();
        // });
        return {
            emailRules,
            submitForm,
            formData,
        };

    }
}
</script>
<style scoped>
.text-muted {
    --vz-text-opacity: 1;
    color: var(--vz-secondary-color) !important;
}

.v-col-sm-10 {
    width: 100%;
    padding: 0px;
    margin-bottom: 15px;
}

.alert {
    width: 86%;
    position: relative;
    color: #e8bc52;
    background-color: #fceecf;
    border-radius: 4px;
    height: 60px;
    margin-left: 80px;
}

.icon {
    margin-top: 25px;
    margin-bottom: 25px;
    margin-left: 195px;
}
</style>