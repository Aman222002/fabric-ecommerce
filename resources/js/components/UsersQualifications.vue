<template>
    <v-row>
        <v-col cols="2" md="3">
            <v-label><v-icon>mdi-school</v-icon>Degree</v-label>
            <v-select v-model="formData.degree" :items="degreeOptions" label="Degree" @change="handleDegreeChange"
                :rules="[v => !!v || 'Degree is required']">
            </v-select>
        </v-col>
        <!-- <v-col cols="12" md="2">
            <v-label><v-icon>mdi-school</v-icon>other's specialization</v-label>
            <v-text-field v-model="formData.gpa" label="other's specialization"></v-text-field>
        </v-col> -->
        <v-col cols="2" md="3">
            <v-label><v-icon>mdi-calendar-start</v-icon>Starting Year</v-label>
            <v-select v-model="formData.startingYear" :items="[2022, 2023, 2024, 2025]" label="Starting Year"
                :rules="[v => !!v || 'Starting Year is required']">
            </v-select>
        </v-col>

        <v-col cols="2" md="3">
            <v-label><v-icon>mdi-calendar-end</v-icon>Passing Year</v-label>
            <v-select v-model="formData.passingYear" :items="[2022, 2023, 2024, 2025]" label="Passing Year"
                :rules="[v => !!v || 'Passing Year is required']">
            </v-select>
        </v-col>
        <v-col cols="2" md="3">
            <v-label><v-icon>mdi-school</v-icon>Select University</v-label>
            <v-select v-model="formData.university" :items="universityOptions" label="University"
                :rules="[v => !!v || 'University is required']">
            </v-select>
        </v-col>
    </v-row>
</template>
  
<script>
import { ref } from 'vue';

export default {
    name: 'UsersQualifications',
    setup() {
        const formData = ref({
            degree: '',
            otherDegree: '',
            startingYear: '',
            passingYear: '',
            specialization: '',
            gpa: '',
            university: '',
        });

        const degreeOptions = ["Bachelor's Degree", "Master's Degree", "Ph.D.",];
        const universityOptions = ["University A", "University B", "University C"];

        const handleDegreeChange = () => {
            if (formData.degree !== 'Other') {
                formData.otherDegree = '';
            }
        };

        return {
            formData,
            degreeOptions,
            universityOptions,
            handleDegreeChange,
        };
    },
};
</script>
  
<style scoped>
.v-col {
    margin-bottom: 40px;
}

v-label {
    font-weight: bold;
}

v-text-field,
v-select {
    width: 100%;
}
</style>
  