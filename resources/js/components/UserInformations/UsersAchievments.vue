
<template>
    <div>
        <v-card-title class="pl-0">
            Achievements</v-card-title>
        <v-row v-for="(achievement, index) in achievements" :key="index">
            <v-row></v-row>
            <v-col cols="12" md="3">
                <v-text-field v-model="achievements[index].certification_name" :name="'certification_name_' + index"
                    label="Certification Name" variant="outlined"></v-text-field>
            </v-col>
            <v-col cols="12" md="3">
                <v-text-field v-model="achievements[index].company_name" :name="'company_name_' + index"
                    label="Company Name" variant="outlined"
                    :rules="[v => !!v || 'Company Name is required']"></v-text-field>
            </v-col>
            <v-col cols="12" md="3">
                <v-text-field v-model="achievements[index].certificate_number" :name="'certificate_number_' + index"
                    label="Certificate Number" variant="outlined"
                    :rules="[v => !!v || 'Certificate Number is required']"></v-text-field>
            </v-col>
            <v-col cols="12" md="3">
                <h5 style="height:15px">expiry date</h5>
                <VueDatePicker format="yyy/MM/dd" calendar-class="my_calendar" input-class="textfield"
                    v-model="achievements[index].expiry_date" :name="'expiry_date_' + index"
                    :rules="index === 0 ? [] : [v => !!v || 'Expiry date  is required']" />
            </v-col>
            <v-col cols="12" md="12">
                <v-file-input v-model="achievements[index].certificate_file" :name="'certificate_file_' + index"
                    label="Certificate File" accept="application/pdf"></v-file-input>
            </v-col>
            <v-col v-if="index > 0" md="2">
                <v-btn @click="removeAchievement(index)" color="red" class="custom-button">Remove</v-btn>
            </v-col>
            <v-col md="2" class="flex-end" v-else>
                <v-btn @click="addAchievement" color="blue" class="custom-button">Add More</v-btn>
            </v-col>

        </v-row>
    </div>
</template>
<script>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { useMyStore } from '../../store';
export default {
    name: 'UsersAchievments',
    setup() {
        const store = useMyStore();
        const achievements = ref(store.achievements);
        const removeAchievement = async (index) => {
            const achievmentId = achievements.value[index].id;
            try {
                console.log(achievmentId, 'achievmentId')
                await axios.post(`/removedAchievment/${achievmentId}`);
                achievements.value.splice(index, 1);
            } catch (error) {
                console.error('Error deleting experience detail:', error);
            }
        };


        return {
            removeAchievement,
            achievements,
            // removeAchievement: store.removeAchievement,
            addAchievement: store.AddAchievement,

        };
    },
};
</script>

<style scoped>
/* Add your custom styles here if needed */
</style>
