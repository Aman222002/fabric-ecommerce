<template>
    <v-container class="container-center">
        <v-card style="width:60%;height:10%">
            <v-card>
                <v-form @submit.prevent="submitForm">
                    <v-col cols="12" md="10">
                        <v-select v-model="education_type" :items="educationTypes" label="Education Type"
                            required></v-select>
                    </v-col>
                    <v-col cols="12" md="10">
                        <v-text-field v-model="school_unversity" label="School/University"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="10">
                        <v-text-field v-model="starting_year" label="Starting Year"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="10">
                        <v-text-field v-model="passing_year" label="Passing Year"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="10">
                        <v-file-input v-model="highest_education_path" label="Upload Degree"
                            accept=".pdf, .doc, .docx"></v-file-input>
                    </v-col>
                    <v-col cols="10" md="10">
                        <v-checkbox v-model="still_pursuing" label="Still Pursuing"></v-checkbox>
                    </v-col>

                    <v-btn type="submit" class="mx-auto">Save Qualification</v-btn>
                </v-form>
            </v-card>
        </v-card>
    </v-container>
</template>
  
<script>
import { ref } from 'vue';

export default {
    name: "UsersQualifications",
    setup() {
        const educationTypes = ['High School', 'College', 'University']; // Add more if needed
        const education_type = ref("");
        const school_unversity = ref("");
        const starting_year = ref(null);
        const passing_year = ref(null);
        const highest_education_path = ref(null);
        const still_pursuing = ref(false);

        const submitForm = () => {
            // Implement form submission logic
            const formData = {
                education_type: education_type.value,
                school_unversity: school_unversity.value,
                starting_year: starting_year.value,
                passing_year: passing_year.value,
                highest_education_path: highest_education_path.value,
                still_pursuing: still_pursuing.value,
            };
            axios.post('/users-qualifications', formData)
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
            educationTypes,
            education_type,
            school_unversity,
            starting_year,
            passing_year,
            highest_education_path,
            still_pursuing,
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