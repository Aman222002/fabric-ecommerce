
<template>
    <div>
        <v-card-title class="text-left">
            Work Experience
        </v-card-title>
        <v-row v-for="(experience, index) in workExperiences" :key="index">

            <v-col cols="12" md="3">
                <v-text-field v-model="experience.company_name" label="Company Name" required variant="outlined"
                    :rules="[v => !!v || 'Company Name is required']"></v-text-field>
            </v-col>
            <v-col cols="12" md="3">
                <v-text-field v-model="experience.position" label="Position" required variant="outlined"
                    :rules="[v => !!v || 'Position is required']"></v-text-field>
            </v-col>

            <v-col cols="12" md="3">
                <v-text-field v-model="experience.start_date" @click="openDatePicker" placeholder="Starting Date" required
                    :rules="[v => !!v || 'Starting Date is required']" />
                <v-date-picker v-if="isDatePickerOpen" v-model="experience.start_date"
                    @update:picker-date="toggleDatePicker">
                    <template #actions>
                        <v-btn text @click="cancelDate">Cancel</v-btn>
                        <v-btn text @click="selectDate">OK</v-btn>
                    </template>
                </v-date-picker>
            </v-col>
            <v-col cols="12" md="3">
                <v-text-field v-model="experience.expiry_date" label="End Date"></v-text-field>
            </v-col>

            <v-col cols="12" md="50">
                <v-textarea v-model="experience.description" label="Description" variant="outlined"
                    :rules="[v => !!v || 'Description is required']"></v-textarea>
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
        const experience = ref({
            // start_date: null,
        });

        const isDatePickerOpen = ref(false);
        const isDatePickerOpen2 = ref(false);


        const openDatePicker = () => {
            isDatePickerOpen.value = true;
        };
        const openDatePicker2 = () => {
            isDatePickerOpen2.value = true;
        };


        const toggleDatePicker2 = () => {
            isDatePickerOpen2.value = !isDatePickerOpen2.value;
        };

        const toggleDatePicker = () => {
            isDatePickerOpen.value = !isDatePickerOpen.value;
        };

        const selectDate = () => {

            console.log('Selected Date:', experience.value.start_date);
            isDatePickerOpen.value = false;
        };
        const selectDate2 = () => {

            console.log('Selected Date:', experience.value.end_date);
            isDatePickerOpen2.value = false;
        };

        const cancelDate = () => {
            experience.value.start_date = null;
            isDatePickerOpen.value = false;
        };
        const cancelDate2 = () => {
            experience.value.end_date = null;
            isDatePickerOpen2.value = false;
        };


        return {

            openDatePicker,
            openDatePicker2,
            toggleDatePicker,
            toggleDatePicker2,
            selectDate,
            cancelDate,
            selectDate2,
            cancelDate2,

            isDatePickerOpen,
            isDatePickerOpen2,

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
  