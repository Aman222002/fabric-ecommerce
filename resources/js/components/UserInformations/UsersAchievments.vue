
<template>
    <div>
        <v-card-title>
            Achievements</v-card-title>
        <v-row v-for="(achievement, index) in achievements" :key="index">
            <v-row></v-row>
            <v-col cols="12" md="3">

                <v-text-field v-model="achievement.certification_name" label="Certification Name"
                    variant="outlined"></v-text-field>
            </v-col>
            <v-col cols="12" md="3">
                <v-text-field v-model="achievement.company_name" label="Company Name" variant="outlined"
                    :rules="[v => !!v || 'Company Name is required']"></v-text-field>
            </v-col>
            <v-col cols="12" md="3">
                <v-text-field v-model="achievement.certificate_number" label="Certificate Number" variant="outlined"
                    :rules="[v => !!v || 'Certificate Number is required']"></v-text-field>
            </v-col>
            <v-col cols="12" md="3">
                <v-text-field v-model="achievement.expiry_date" label="Expiry Date" variant="outlined"
                    :rules="[v => !!v || 'Expiry Date is required']"></v-text-field>
            </v-col>
            <v-col cols="12" md="12">
                <v-file-input v-model="achievement.certificate_file_path" label="Certificate File"></v-file-input>
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
import { ref, computed } from 'vue';
import { useMyStore } from '../../store';
export default {
    name: 'UsersAchievments',
    setup() {
        const store = useMyStore();
        const achievements = ref(store.achievements);
        console.log(achievements, 'here`s the data');

        const getRules = (index, field) => {
            return computed(() => [v => !!v || `${field} is required`]);
        };



        return {
            achievements,
            getRules,
            store,
            addAchievement: store.addAchievement,
            removeAchievement: store.removeAchievement


        };
    },
};
</script>

<style scoped>
/* Add your custom styles here if needed */
</style>
