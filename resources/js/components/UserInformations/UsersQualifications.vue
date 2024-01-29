
   
<template>
    <div>
        <v-card-title class="pl-0">
            Education Details
        </v-card-title>

        <v-row v-for="(education, index) in educationDetails" :key="index">
            <v-col md="3">
                <v-select v-model="educationDetails[index].education_type" :items="educationTypes" required
                    :rules="[v => !!v || 'Education Type is required']" label="Education Type"></v-select>
            </v-col>
            <v-col md="3">
                <v-text-field v-model="educationDetails[index].school_university" label="School/University" required
                    :rules="[v => !!v || 'School/University is required']" variant="outlined"></v-text-field>
            </v-col>
            <v-col md="2">
                <v-select v-model="educationDetails[index].starting_year" label="Starting Year" :items="yearOptions"
                    required :rules="[v => !!v || 'Starting Year is required']" variant="outlined"></v-select>
            </v-col>
            <v-col md="2">
                <v-select v-model="educationDetails[index].passing_year" label="Passing Year" :items="yearOptions" required
                    :rules="[v => !!v || 'Passing Year is required']" variant="outlined"></v-select>
            </v-col>
            <v-col v-if="index > 0" md="2">
                <v-btn @click="removeEducationEntry(index)" color="red" class="custom-button">Remove</v-btn>
            </v-col>
            <v-col md="2" class="flex-end" v-else>
                <v-btn @click="addEducationEntry" color="blue" class="custom-button">Add More</v-btn>
            </v-col>
        </v-row>
    </div>
</template>
  
<script>
import { ref } from 'vue';
import { useMyStore } from '../../store';
export default {
    name: 'UsersQualifications',
    setup() {
        const store = useMyStore();
        const educationDetails = ref(store.educationDetails);
        const educationTypes = ref(['High School', 'College', 'University']);
        const yearOptions = ref([2022, 2023, 2024]);
        const highest_education_path = ref(null);

        const still_pursuing = ref(false);



        const submitForm = () => {

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

                })
                .catch(error => {

                    if (error.response && error.response.status === 422) {

                        console.log(error.response.data);
                    } else {
                        s
                        console.error(error.message);
                    }
                });
        }
        return {
            educationDetails,
            educationTypes,
            yearOptions,
            addEducationEntry: store.addEducationEntry,
            removeEducationEntry: store.removeEducationEntry,
            highest_education_path,
            still_pursuing,

        };
    },
};
</script>
<style scoped>
.custom-button {
    height: 50px;

    width: 150px;

}
</style>
