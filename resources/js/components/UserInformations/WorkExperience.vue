<template>
    <v-container class="container-center">
        <v-card style="width:60%;height:10%">
            <v-form @submit.prevent="submitForm">
                <v-row>
                    <v-col cols="12" md="10">
                        <v-text-field v-model="company_name" label="Company Name" required></v-text-field>
                    </v-col>
                    <v-col cols="12" md="10">
                        <v-text-field v-model="position" label="Position" required></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="10">
                        <v-textarea v-model="description" label="Description"></v-textarea>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="10">
                        <v-date-picker v-model="start_date" label="Start Date" required></v-date-picker>
                    </v-col>
                    <v-col cols="12" md="10">
                        <v-date-picker v-model="expiry_date" label="End Date"></v-date-picker>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col>
                        <v-btn type="submit" color="primary">Save Experience</v-btn>
                    </v-col>
                </v-row>
            </v-form>

        </v-card>
    </v-container>
</template>
 
<script>
import { ref } from 'vue';
export default {
    name: 'WorkExperience',
    setup() {
        const company_name = ref('');
        const position = ref('');
        const description = ref('');
        const start_date = ref(null);
        const expiry_date = ref(null);

        const submitForm = () => {

            const formData = {
                company_name: company_name.value,
                position: position.value,
                description: description.value,
                start_date: start_date.value,
                expiry_date: expiry_date.value,
            };
            axios.post('/work_experience', formData)
                .then(response => {

                })
                .catch(error => {

                    if (error.response && error.response.status === 422) {

                        console.log(error.response.data);
                    } else {

                        console.error(error.message);
                    }
                });

            console.log(formData);

            company_name.value = '';
            position.value = '';
            description.value = '';
            start_date.value = null;
            expiry_date.value = null;
        };

        return {
            company_name,
            position,
            description,
            start_date,
            expiry_date,
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