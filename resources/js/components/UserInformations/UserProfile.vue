<template>
    <v-container class="container-center">
        <v-card style="width:70%;height:10%">
            <v-card-text>
                <v-form @submit.prevent="submitForm">
                    <v-row>
                        <v-col cols="12">
                            <v-textarea v-model="hobbies" label="Hobbies"></v-textarea>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <v-textarea v-model="strengths" label="Strengths"></v-textarea>
                        </v-col>
                    </v-row>
                    <v-col>
                        <v-btn type="submit" color="primary">Save Profile</v-btn>
                    </v-col>
                </v-form>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script>
import { ref, onMounted } from 'vue';
export default {
    name: 'UserProfile',
    setup() {
        const hobbies = ref('');
        const strengths = ref('');
        const submitForm = () => {
            const formData = {
                hobbies: hobbies.value,
                strengths: strengths.value,

            };
            axios.post('/user-profile', formData)
                .then(response => {
                    // Handle successful response
                })
                .catch(error => {
                    // Handle validation errors or other errors
                    if (error.response && error.response.status === 422) {
                        // Handle validation errors, e.g., display them to the user
                        console.log(error.response.data); // Log validation errors
                    } else {
                        // Handle other errors
                        console.error(error.message);
                    }
                });
        }

        return {
            hobbies,
            strengths,
            submitForm,
        };
    },
};
</script>
 
<style scoped>
.container-center {
    display: flex;
    justify-content: center;
    align-items: center;

}
</style>
userprofile