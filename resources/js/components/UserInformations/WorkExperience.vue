
<template>
    <div>
        <v-card-title class="text-left">
            Work Experience
        </v-card-title>
        <v-row v-for="(experience, index) in workExperiences" :key="index">

            <v-col cols="12" md="3">
                <v-text-field v-model="experience.company_name" label="Company Name" required
                    variant="outlined"></v-text-field>
            </v-col>
            <v-col cols="12" md="3">
                <v-text-field v-model="experience.position" label="Position" required variant="outlined"></v-text-field>
            </v-col>
            <v-col cols="12" md="3">
                <v-text-field v-model="experience.start_date" label="Start Date" required></v-text-field>
            </v-col>
            <v-col cols="12" md="3">
                <v-text-field v-model="experience.expiry_date" label="End Date"></v-text-field>
            </v-col>

            <v-col cols="12" md="50">
                <v-textarea v-model="experience.description" label="Description" variant="outlined"></v-textarea>
            </v-col>

            <v-col v-if="index > 0" cols="2">
                <v-btn @click="removeWorkExperience(index)" color="red">Remove</v-btn>
            </v-col>
            <v-col cols="12" md="2" v-else>
                <v-btn @click="addWorkExperience" color="blue">Add More</v-btn>
            </v-col>
        </v-row>


    </div>
</template>
  
<script>
import { ref } from 'vue';
import { useMyStore } from '@/store';

export default {
    name: 'WorkExperience',
    setup() {
        const store = useMyStore();
        const workExperiences = ref(store.experience);

        // const addWorkExperience = () => {
        //     workExperiences.value.push({
        //         company_name: '',
        //         position: '',
        //         description: '',
        //         start_date: null,
        //         expiry_date: null,
        //     });
        // };
        // const removeWorkExperience = () => {

        //     if (workExperiences.value.length > 1) {
        //         workExperiences.value.splice(-1, 1);
        //     }
        // };


        // const submitForm = () => {

        //     workExperiences.value.forEach((experience) => {
        //         const formData = {
        //             company_name: experience.company_name,
        //             position: experience.position,
        //             description: experience.description,
        //             start_date: experience.start_date,
        //             expiry_date: experience.expiry_date,
        //         };

        //         axios.post('/work_experience', formData)
        //             .then(response => {

        //             })
        //             .catch(error => {

        //                 console.error(error.message);
        //             });
        //     });


        //     workExperiences.value = [
        //         {
        //             company_name: '',
        //             position: '',
        //             description: '',
        //             start_date: null,
        //             expiry_date: null,
        //         },
        //     ];
        // };

        return {
            workExperiences,
            addWorkExperience: store.addWorkExperience,
            removeWorkExperience: store.removeWorkExperience,
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
  