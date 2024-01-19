<template>
    <v-container>
        <v-card>
            <v-card-title class="headline mb-2">Fill your Skills and Work Experience</v-card-title>
            <v-card-text>
                <v-form @submit.prevent="submitSkillsForm">
                    <v-row>
                        <v-col cols="12" sm="10">
                            <v-text-field v-model="skill" label="Skill" variant="outlined"></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="10">
                            <v-btn @click="addSkill" color="#006400">Add Skills</v-btn>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col v-for="(s, index) in skills" :key="index" cols="12">
                            {{ s }}
                        </v-col>
                    </v-row>
                </v-form>

                <v-row>
                    <v-col cols="12" sm="10">
                        <v-text-field v-model="workExperience" label="Work Experience" variant="outlined"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-btn @click="addWorkExperience" color="#006400">Add Work</v-btn>
                    </v-col>
                </v-row>

                <v-row>
                    <v-col v-for="(exp, index) in workExperiences" :key="index" cols="12">
                        {{ exp }}
                    </v-col>
                </v-row>
                <v-row>

                </v-row>

            </v-card-text>
        </v-card>
    </v-container>
</template>
<script>
import { ref } from 'vue';
export default {
    name: 'WorkExperience',
    setup() {
        const skill = ref('');
        const skills = ref([]);

        const workExperience = ref('');
        const workExperiences = ref([]);

        const addSkill = () => {
            if (skill.value.trim() !== '') {
                skills.value.push(skill.value.trim());
                skill.value = '';
            }
        };

        const submitSkillsForm = () => {
            // Handle submission logic for skills form
            console.log('Skills submitted:', skills.value);
        };

        const addWorkExperience = () => {
            if (workExperience.value.trim() !== '') {
                workExperiences.value.push(workExperience.value.trim());
                workExperience.value = '';
            }
        };

        const submitWorkExperienceForm = () => {
            // Handle submission logic for work experience form
            console.log('Work Experience submitted:', workExperiences.value);
        };

        return {
            skill,
            skills,
            addSkill,
            submitSkillsForm,
            workExperience,
            workExperiences,
            addWorkExperience,
            submitWorkExperienceForm,
        };
    },
};
</script>
  
<style scoped>
/* Add styles if needed */
</style>
  