
<template>
    <div>
        <v-card-title>
            Achievements Details</v-card-title>
        <v-row v-for="(achievement, index) in achievements" :key="index">
            <v-row></v-row>
            <v-col cols="12" md="3">
                <v-text-field v-model="achievements.certification_name" label="Certification Name"
                    variant="outlined"></v-text-field>
            </v-col>
            <v-col cols="12" md="3">
                <v-text-field v-model="achievements.company_name" label="Company Name" variant="outlined"></v-text-field>
            </v-col>
            <v-col cols="12" md="3">
                <v-text-field v-model="achievements.certificate_number" label="Certificate Number"
                    variant="outlined"></v-text-field>
            </v-col>
            <v-col cols="12" md="3">
                <v-text-field v-model="achievements.expiry_date" label="Expiry Date" variant="outlined"></v-text-field>
            </v-col>
            <v-col cols="12" md="12">
                <v-file-input v-model="achievements.certificate_file_path" label="Certificate File"></v-file-input>
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
    setup() {
        const store = useMyStore();
        const achievements = ref(store.achievements);

        const getRules = (index, field) => {
            return computed(() => [v => !!v || `${field} is required`]);
        };

        // const formIsValid = computed(() => {
        //     return achievements.value.every((achievement, index) => {
        //         const rules = getRules(index);
        //         return rules.value.length === 0;
        //     });
        // });



        return {
            achievements,
            getRules,
            store,
            addAchievement: store.addAchievement,
            removeAchievement: store.removeAchievement
            // formIsValid,

        };
    },
};
</script>

<style scoped>
/* Add your custom styles here if needed */
</style>
