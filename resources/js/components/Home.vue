<template>
    <v-container>
        <v-card class="job-search-card">
            <v-card-title class="text-center">
                <h1>Find your dream job</h1>
                <h2>5 Lakh +jobs for you to explore</h2>
            </v-card-title>
            <v-card-text>
                <v-row>
                    <v-col cols="12" md="6">
                        <v-select v-model="skills" :items="skillsOptions" label="Select Skills" outlined
                            clearable></v-select>
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-select v-model="experience" :items="experienceOptions" label="Experience" outlined
                            clearable></v-select>
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-select v-model="location" :items="locationOptions" label="Location" outlined
                            clearable></v-select>
                    </v-col>
                </v-row>
                <v-row class="text-center">
                    <v-col>
                        <v-btn @click="searchJobs" color="primary" class="search-button">Search</v-btn>
                        <v-row v-if="validationError">
                            <p class="error-message">All fields are required.</p>
                        </v-row>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
        <v-card>
            <v-btn @click="openComponent('Mncs')">MNCs</v-btn>
            <!-- <v-btn @click="openComponent('Internship')">Internship</v-btn> -->
            <component :is="activeComponent" />
        </v-card>
    </v-container>
</template>
<script>
import { defineComponent } from 'vue';
import Mncs from '@/components/Mncs.vue';
// import Internship from '@/components/Internship.vue';
import { ref } from 'vue';
export default defineComponent({
    components: {
        Mncs,
        // Internship,
    },
    name: 'Home',
    setup() {
        const validationError = ref(false);
        const skills = ref(null);
        const experience = ref(null);
        const location = ref(null);
        const skillsOptions = [
            'JavaScript',
            'Python',
            'Java',
            'C++',
            'React',
            'Vue.js',
            'Node.js',
        ];
        const experienceOptions = [
            '0-1 years',
            '1-3 years',
            '3-5 years',
            '5-10 years',
            '10+ years',
        ];
        const locationOptions = [
            'Delhi',
            'Haryana',
            'Banglore',
            'Noida',
        ];
        const searchJobs = () => {
            if (validateFields()) {
                validationError.value = false;
                console.log('Searching for:', skills.value, 'in', location.value, experience.value);
            } else {
                validationError.value = true;
            }
        };
        const validateFields = () => {
            return skills.value !== null && experience.value !== null && location.value !== null;
        };
        const activeComponent = ref(null);

        const openComponent = (componentName) => {
            activeComponent.value = componentName;
        };

        return {
            activeComponent,
            openComponent,
            skills,
            experience,
            experienceOptions,
            skillsOptions,
            locationOptions,
            location,
            searchJobs,
            validationError,
        };
    },
});
</script>
<style scoped>
.job-search-card {
    margin: auto;
    height: 10%;
    padding: 70px;
    background-color: cadetblue;
}

.error-message {
    color: crimson;
    font-size: large;
}

.container {
    text-align: center;
}

.header {
    text-align: center;
    margin-bottom: 20px;
}

h1 {
    font-size: 50px;
    margin-bottom: 10px;
}

h2 {
    font-size: 18px;
    margin-bottom: 20px;
}

.search-button {
    background-color: black;
    font-size: 20px;
    padding: 30px 40px;
}
</style>
  