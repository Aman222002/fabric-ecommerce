<!-- 
<template>
    <div>
        <v-card-title>
            Education Details
        </v-card-title>
        <v-row v-for="(education, index) in educationDetails" :key="index">
            <v-col cols="13" md="3">
                <v-select v-model="education.education_type" :items="educationTypes" label="Education Type"
                    required></v-select>
            </v-col>
            <v-col cols="13" md="3">
                <v-text-field v-model="education.school_university" label="School/University"
                    variant="outlined"></v-text-field>
            </v-col>
            <v-col cols="12" md="2">
                <v-select v-model="education.starting_year" label="Starting Year" :items="yearOptions"
                    @change="updatePassingYearOptions(index)" variant="outlined"></v-select>
            </v-col>
            <v-col cols="12" md="2">
                <v-select v-model="education.passing_year" label="Passing Year" :items="yearOptions"
                    variant="outlined"></v-select>
            </v-col>
            <v-col cols="12" md="2">
                <v-btn @click="addEducationEntry" color="blue" class="custom-button">Add More</v-btn>
            </v-col>
        </v-row>
        <v-col v-if="educationDetails.length > 1" cols="2">
            <v-btn @click="removeEducationEntry(index)" color="red" class="custom-button">Remove</v-btn>
        </v-col>

        <v-row>
            <v-col cols="12" md="10">
                <v-col v-for="(education, index) in educationDetails" :key="index">

                    {{ education.education_type }}
                    {{ education.school_university }}
                    {{ education.starting_year }}
                    {{ education.passing_year }}
                </v-col>
            </v-col>
        </v-row>

        <v-col cols="11" md="12">
            <div style="position: relative;text-align: center;">
                <DropZone :maxFiles="Number(10000000000)" :uploadOnDrop="true" :multipleUpload="true" :parallelUpload="3"
                    v-model="highest_education_path" />
                <h2>Upload your degree here </h2>
            </div>
            <v-checkbox v-if="shouldShowStillPursuing(index)" v-model="still_pursuing" label="Still Pursuing"></v-checkbox>
        </v-col>
    </div>
</template>
  
<script>
import { ref } from 'vue';
import { useMyStore } from '@/store';
export default {
    setup() {

        const myStore = useMyStore();
        const educationDetails = ref(myStore.educationDetails);

        const addEducationEntry = () => {
            educationDetails.addEducationEntry();
        };

        const removeEducationEntry = (index) => {
            educationDetails.removeEducationEntry(index);
        };

        const updatePassingYearOptions = (index) => {
            educationDetails.updatePassingYearOptions(index);
        };

        return {
            educationDetails,
            addEducationEntry,
            removeEducationEntry,
            updatePassingYearOptions,
        };
    },
    methods: {

        submitForm() {

            const formData = {
                education_type: myStore.education_type,
                school_unversity: myStore.school_unversity,
                starting_year: myStore.starting_year,
                passing_year: myStore.passing_year.value,
                highest_education_path: myStore.highest_education_path,
                still_pursuing: myStore.still_pursuing.value,
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
    }
};
</script>
<style scoped>
.custom-button {
    height: 50px;

    width: 150px;
    
}
</style>
   -->

   
<template>
    <div>
        <v-card-title class="pl-0">
            Education Details
        </v-card-title>

        <v-row v-for="(education, index) in educationDetails" :key="index">
            <v-col md="3">
                <v-select v-model="educationDetails[index].education_type" :items="educationTypes" label="Education Type"
                    required></v-select>
            </v-col>
            <v-col md="3">
                <v-text-field v-model="educationDetails[index].school_university" label="School/University"
                    variant="outlined"></v-text-field>
            </v-col>
            <v-col md="2">
                <v-select v-model="educationDetails[index].starting_year" label="Starting Year" :items="yearOptions"
                    @change="updatePassingYearOptions(index)" variant="outlined"></v-select>
            </v-col>
            <v-col md="2">
                <v-select v-model="educationDetails[index].passing_year" label="Passing Year" :items="yearOptions"
                    variant="outlined"></v-select>
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
    setup() {
        const store = useMyStore();
        const educationDetails = ref(store.educationDetails);
        const educationTypes = ref(['High School', 'College', 'University']);
        const yearOptions = ref([2022, 2023, 2024]);
        const highest_education_path = ref(null);

        const still_pursuing = ref(false);
        const passingYearOptions = ref([]);

        // const addEducationEntry = () => {
        //     educationDetails.value.push({
        //         education_type: '',
        //         school_university: '',
        //         starting_year: '',
        //         passing_year: '',
        //     });
        // };

        // const removeEducationEntry = (index) => {
        //     if (educationDetails.value.length > 1) {
        //         educationDetails.value.splice(-1, 1);
        //     }
        // };
        const updatePassingYearOptions = (index) => {
            const selectedStartingYear = educationDetails.value[index].starting_year;

            educationDetails.value[index].passing_year = null;


            educationDetails.value[index].passing_year_options = yearOptions.filter(year => year >= selectedStartingYear);
        };

        const getPassingYearOptions = (education) => {

            return education.passing_year_options || [];
        };
        const shouldShowStillPursuing = (index) => {
            const shouldShowStillPursuing = (index) => {
                const education = educationDetails.value[index];


                return education && education.still_pursuing;
            };
        };

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
            updatePassingYearOptions,
            getPassingYearOptions,
            shouldShowStillPursuing,
        };
    },
};
</script>
<style scoped>
.custom-button {
    height: 50px;
    /* Adjust the height as needed */
    width: 150px;
    /* Adjust the width as needed */
}
</style>