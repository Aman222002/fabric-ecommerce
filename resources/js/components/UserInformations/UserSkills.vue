
<template>
    <v-card-title class="pl-0">
        Add your skills
    </v-card-title>
    <v-row>
        <v-col cols="12" md="12">
            <v-select v-model="selectedSkills" :items="skills" item-title="skill_name" item-value="id"
                label="Select Multiple Skills" chips multiple></v-select>
        </v-col>
    </v-row>
</template>
  
<script>
import { ref, onMounted } from 'vue';

export default {
    name: 'UserSkills',
    setup() {


        const selectedSkill = ref(null);
        const selectedSkills = ref([]);
        const skills = ref([]);

        onMounted(async () => {
            try {
                const response = await axios.get('/skills');
                skills.value = response.data.skills;
                console.log(skills.value, 'skills');
            } catch (error) {
                console.error('Error fetching skills:', error);
            }
        });

        const addSkill = () => {
            if (selectedSkill.value && !selectedSkills.value.find(skill => skill.id === selectedSkill.value.id)) {
                selectedSkills.value.push(selectedSkill.value);
                selectedSkill.value = null;
            }
        };

        const submitForm = () => {
            const userId = 1;
            const skillIds = selectedSkills.value.map(skill => skill.id);

            axios.post('/user-skills', { user_id: userId, skill_ids: skillIds })
                .then(response => {
                    console.log(response.data.message);
                    // Optionally, reset the form or navigate to another page
                })
                .catch(error => {
                    console.error('Error saving skills:', error);
                });
        };

        return {
            selectedSkill,
            selectedSkills,
            skills,
            addSkill,
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
  