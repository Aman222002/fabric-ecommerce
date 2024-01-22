<template>
    <v-container class="container-center">
        <v-card style="width: 70%; height: 10%">
            <v-card-text>

                <v-form @submit.prevent="submitForm">
                    <v-row>
                        <v-col cols="12" md="10">
                            <v-select v-model="selectedSkill" :items="skills" item-title="skill_name" item-value="id"
                                label="Select Skill" required></v-select>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-btn type="submit" color="primary">Save Skill</v-btn>
                        </v-col>
                    </v-row>
                </v-form>
            </v-card-text>
        </v-card>
    </v-container>
</template>
  
<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';

export default {
    name: 'UserSkills',
    setup() {
        const selectedSkill = ref(null);
        const skills = ref([]);

        // Fetch skills from the backend on component mount
        onMounted(async () => {
            try {
                const response = await axios.get('/skills'); // Replace with your API endpoint
                skills.value = response.data.skills;
                console.log(skills.value, 'skills');
            } catch (error) {
                console.error('Error fetching skills:', error);
            }
        });

        const submitForm = () => {
            if (!selectedSkill.value) {

                return;
            }
            const userId = 1;
            const skillId = selectedSkill.value;

            axios.post('/user-skills', { user_id: userId, skill_id: skillId })
                .then(response => {
                    console.log(response.data.message);

                })
                .catch(error => {
                    console.error('Error saving skill:', error);

                });
        };

        return {
            selectedSkill,
            skills,
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
  