
<template>
    <div>
        <v-card-title class="pl-0">
         Education Details
        </v-card-title>
        <v-row v-for="(education, index) in educationDetails" :key="index">
            <v-col md="3">
                <v-select v-model="education.education_type" :items="availableEducationTypes"
                    :name="'education_type_' + index" :rules="[v => !!v || 'Education Type is required']"
                    label="Education Type"></v-select>
            </v-col>
            <v-col md="3">
                <v-text-field v-model="education.school_university" :name="'school_university_' + index"
                    label="School/University" variant="outlined"></v-text-field>
            </v-col>
            <v-col md="2">
                <v-select v-model="education.starting_year" :name="'starting_year_' + index"
                    :items="yearOptions" label="Starting Year" required
                    :rules="[v => !!v || 'Starting Year is required']" variant="outlined"></v-select>      
            </v-col>
            <v-col md="2">
                <v-select v-model="education.passing_year" :name="'passing_year_' + index"
                :items="getPassingYearOptions(education.starting_year)"  label="Passing Year" required :rules="[v => !!v || 'Passing Year is required']"
                    variant="outlined"></v-select>
            </v-col>
            <v-col v-if="index > 0" md="2">
                <v-btn @click="removeEducationEntry(index)" color="red" class="custom-button">Remove</v-btn>
            </v-col>
            <v-col md="2" v-else>
                <v-btn @click="addEducationEntry" color="blue" class="custom-button">Add More</v-btn>
            </v-col>
        </v-row>
    </div>
    <hr style="width:100%;text-align:left;margin-left:0">
</template>
<script>
import axios from 'axios';
import { ref,computed } from 'vue';
import { useMyStore } from '../../store';
export default {
    name: 'UsersQualifications',
    setup() {
        const store = useMyStore();
        const educationDetails = ref(store.educationDetails ?? []);
        const educationTypes = ref(['High School', 'College', 'University']);
      
        const currentYear = new Date().getFullYear(); 
const startYear = 1970; 
const endYear = 2030; 
const yearOptions = ref(Array.from({length: endYear - startYear + 1}, (_, i) => startYear + i));
// const removeEducationEntry = async (index) => {
//     console.log('Before removal - educationDetails:', educationDetails.value);
//     console.log('Removing index:', index);
//     const education = educationDetails.value[index];
//     const educationId = education.id;
//     if (!education.education_type && !education.school_university && !education.starting_year && !education.passing_year) {
//         console.warn('Cannot remove empty education entry');
//         store.removeEducationEntry(index);
//         return;
//     }
//     try {
//         store.removeEducationEntry(educationId);
//         const updatedEducationDetails = [
//             ...educationDetails.value.slice(0, index),
//             ...educationDetails.value.slice(index + 1)
//         ];
//         educationDetails.value = updatedEducationDetails;


        
//         await axios.post(`/removedEducation/${educationId}`);
//         store.removeEducationEntry(index);
//         console.log('After removal - educationDetails:', educationDetails.value);
//     } catch (error) {
//         console.error('Error deleting education detail:', error);
//     }
// };
const removeEducationEntry = async (index) => {
    console.log('Before removal - educationDetails:', educationDetails.value);
    console.log('Removing index:', index);
    const education = educationDetails.value[index];
    const educationId = education.id;
    if (!education.education_type && !education.school_university && !education.starting_year && !education.passing_year) {
        console.warn('Cannot remove empty education entry');
        return;
    }
    try {
        store.removeEducationEntry(index);
        await axios.post(`/removedEducation/${educationId}`);
        const updatedEducationDetails = educationDetails.value.filter(edu => edu.id !== educationId);
        educationDetails.value = updatedEducationDetails;
        console.log('After removal - educationDetails:', educationDetails.value);
    } catch (error) {
        console.error('Error deleting education detail:', error);
    }
};

        const addEducationEntry = () => {
            educationDetails.value.push({
                education_type: '',
                school_university: '',
                starting_year: '',
                passing_year: '',
            });
        };
        const getPassingYearOptions = (startingYear) => {
    return yearOptions.value.filter(year => year > startingYear || year === '');
};
const availableEducationTypes = computed(() => {
        const selectedTypes = educationDetails.value.map(education => education.education_type);
        return educationTypes.value.filter(type => !selectedTypes.includes(type));
    });
        
        return {
            educationTypes,
            removeEducationEntry,
            availableEducationTypes,
            educationDetails,
            yearOptions,
            addEducationEntry,currentYear,getPassingYearOptions
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

