
<template>
    <v-form @submit.prevent="submitForm">
        <v-row>
            <v-col>
                <v-select v-model="formData.education" :items="educationLevels" label="Highest Education" chips multiple
                    :rules="[v => !!v || 'Education is required']"></v-select>
            </v-col>
        </v-row>
        <v-row v-if="formData.education.length">
            <v-col v-if="formData.education.includes('10th')">
                <v-select v-model="formData.year10th" :items="yearOptions" label="Year of 10th passing"
                    :rules="[v => !!v || 'Year of 10th passing is required']"></v-select>
                <v-text-field v-model="formData.school10th" label="School for 10th"
                    :rules="[v => !!v || 'School for 10th is required']"></v-text-field>
            </v-col>
            <v-col v-if="formData.education.includes('12th')">
                <v-select v-model="formData.year12th" :items="yearOptions" label="Year of 12th passing"
                    :rules="[v => !!v || 'School for 12th is required']"></v-select>
                <v-text-field v-model="formData.school12th" label="School for 12th"></v-text-field>
            </v-col>
            <v-col v-if="formData.education.includes('Graduation')">
                <v-select v-model="formData.yearGraduation" :items="yearOptions"
                    label="Year of Graduation passing"></v-select>
                <v-text-field v-model="formData.schoolGraduation" label="Unversity for Graduation"
                    :rules="[v => !!v || 'unversity name is required']"></v-text-field>
            </v-col>
            <v-col v-if="formData.education.includes('PostGraduation')">
                <v-select v-model="formData.yearPGraduation" :items="yearOptions" label="Year of Post Graduation passing"
                    :rules="[v => !!v || 'Year of Post Graduation passing is required']"></v-select>
                <v-text-field v-model="formData.schoolPGraduation" label="Unversity for Post Graduation"
                    :rules="[v => !!v || 'University for Post Graduation is required']"></v-text-field>
            </v-col>
        </v-row>
        <div>
            <v-btn @click="addAnotherCourse" color="primary">Add Another Course</v-btn>
            <v-col v-for="(course, index) in formData.additionalCourses" :key="index">
                <v-select v-model="course.education" :items="educationCourse" label="Course" chips multiple
                    :rules="[v => !!v || 'Course is required']"></v-select>
                <v-select v-model="course.passingYear" :items="yearOptions" label="Year of Passing"
                    :rules="[v => !!v || 'Year of Passing is required']"></v-select>
            </v-col>
        </div>
    </v-form>
</template>
<script>
import { ref } from 'vue';
import { useDropzone } from 'vue3-dropzone';
export default {
    name: 'UsersQualifications',
    data() {
        return {
            formData: {
                additionalCourses: [],
                education: [],
                year10th: '',
                year12th: '',
                school10th: '',
                school12th: '',
                schoolGraduation: '',
                schoolPGraduation: '',
                yearGraduation: '',
                yearPGraduation: '',
            },
            educationLevels: ['10th', 'Higher Secondary (+2)', 'Graduation', 'Post Graduation',],
            educationLevels: ['10th', '12th', 'Graduation', 'Post Graduation',],
            yearOptions: ['2020', '2019', '2018', '2017', '2016',],
            educationCourse: ['diploma',]
        };
    },
    methods: {
        submitForm() {

            console.log('Form submitted:', this.formData);
        },
        addAnotherCourse() {
            this.formData.additionalCourses.push({
                education: [],
                passingYear: '',
                school: '',
            });
        },
    },
};
</script>
  
<style scoped>
/* Add your custom styles if needed */
</style>
  