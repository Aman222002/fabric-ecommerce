<template>
    <v-container>
        <v-card-title class="headline mb-2">Your's Personal Interests</v-card-title>
        <v-row>

            <v-col cols="20" sm="6">
                <v-text-field v-model="formData.hobbies" :rules="[v => !!v || 'Hobbies are required']" label="Hobbies"
                    placeholder="Enter your hobbies..." variant="outlined"></v-text-field>
            </v-col>
            <v-col cols="24" sm="6">
                <v-text-field v-model="formData.prizes" label="Prizes and Achievments" placeholder="Enter your prizes."
                    variant="outlined"></v-text-field>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="24" sm="6">
                <v-text-field v-model="formData.strengths" :rules="[v => !!v || 'Strengths are required']" label="Strengths"
                    placeholder="Enter your strengths..." variant="outlined"></v-text-field>
            </v-col>
            <v-col cols="24" sm="6">
                <v-text-field v-model="formData.weaknesses" label="Weaknesses" placeholder="Enter your weaknesses..."
                    variant="outlined"></v-text-field>
            </v-col>
        </v-row>
    </v-container>
</template>
<script>
import { ref } from 'vue';

export default {
    name: 'AdditionalInformations',
    setup() {
        const formData = ref({
            // Existing data properties
            hobbies: '',
            activities: '',
            honors: '',
            prizes: '',
            strengths: '',
            weaknesses: '',
        });

        const submitForm = () => {
            // Handle form submission logic here
            if (validateForm()) {
                console.log('Form submitted:', formData.value);
            }
        };

        const validateForm = () => {
            if (
                !formData.value.hobbies ||
                !formData.value.activities ||
                !formData.value.honors ||
                !formData.value.prizes ||
                !formData.value.strengths ||
                !formData.value.weaknesses
            ) {
                // Display error message or take necessary action
                console.error('All fields are required');
                return false;
            }

            // Additional validation logic can be added based on your requirements

            return true;
        };

        return {
            formData,
            submitForm,
        };
    },
};
</script>
  
<style scoped>
/* Add your custom styles if needed */
</style>
  
