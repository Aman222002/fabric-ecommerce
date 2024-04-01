<template>
    <div>
        <v-card-title class="pl-0">
            Education Details
        </v-card-title>
        <v-row v-for="(education, index) in educationDetails" :key="index">
            <v-col md="3">
                <v-select v-model="educationDetails[index].education_type" :items="educationTypes"
                    :name="'education_type_' + index" :rules="[v => !!v || 'Education Type is required']"
                    label="Education Type"></v-select>
            </v-col>
            <v-col md="3">
                <v-text-field v-model="educationDetails[index].school_university" :name="'school_university_' + index"
                    label="School/University" variant="outlined"></v-text-field>
            </v-col>

            <v-col md="2">
                <v-select v-model="educationDetails[index].starting_year" :name="'starting_year_' + index"
                    :items="yearOptions" label="Starting Year" required
                    :rules="[v => !!v || 'Starting Year is required']" variant="outlined"></v-select>
            </v-col>
            <v-col md="2">
                <v-select v-model="educationDetails[index].passing_year" :name="'passing_year_' + index"
                    :items="yearOptions" label="Passing Year" required :rules="[v => !!v || 'Passing Year is required']"
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
import { ref, onMounted } from 'vue';
import { useMyStore } from '../../store';
export default {
    name: 'UsersQualifications',
    setup() {
        const store = useMyStore();
        const educationDetails = ref(store.educationDetails ?? []);
        console.log(educationDetails.value);
        const educationTypes = ref(['High School', 'College', 'University']);
        const still_pursuing = ref(false);
        const yearOptions = ref([2022, 2023, 2024]);
        const removeEducationEntry = (index) => {
            store.removeEducationEntry;
            const educationId = educationDetails.value[index].id;
            try {
                console.log(educationId, 'education id')
                axios.post(`/removedEducation/${educationId}`);
                educationDetails.value.splice(index, 1);
            } catch (error) {
                console.error('Error deleting education detail:', error);
            }
        };
        return {
            educationTypes,
            removeEducationEntry,
            educationDetails,
            addEducationEntry: store.addEducationEntry,
            // removeEducationEntry: store.removeEducationEntry,
            still_pursuing,
            yearOptions,

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
