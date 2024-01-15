<template>
    <v-container>
        <form @submit.prevent="submitForm" class="cv-form">
            <div v-if="currentStep === 1">
                <label for="name">Name:</label>
                <input v-model="form.name" type="text" id="name" required />
            </div>
            <div v-if="currentStep === 2">
                <label for="email">Email:</label>
                <input v-model="form.email" type="email" id="email" required />
            </div>
            <div v-if="currentStep === 3">
                <label for="education">Highest Education:</label>
                <select v-model="form.highest_education" id="education" required>
                    <option value="">Select Education Level</option>
                    <option value="High School">High School</option>
                    <option value="Bachelor's Degree">Bachelor's Degree</option>
                    <option value="Master's Degree">Master's Degree</option>
                </select>
            </div>
            <div v-if="currentStep === 4">
                <label for="university">University:</label>
                <input v-model="form.university" type="text" id="university" required />
            </div>

            <div v-if="currentStep === 5">
                <label for="startYear">Starting Year:</label>
                <select v-model="form.starting_year" id="startYear" required>
                    <option value="">Select Starting Year</option>
                    <option v-for="year in getYearRange()" :key="year" :value="year">{{ year }}</option>
                </select>
            </div>
            <div v-if="currentStep === 6">
                <label for="passingYear">Passing Year:</label>
                <select v-model="form.passing_year" id="passingYear" required>
                    <option value="">Select Passing Year</option>
                    <option v-for="year in getYearRange()" :key="year" :value="year">{{ year }}</option>
                </select>
            </div>
            <div v-if="currentStep === 7">
                <label for="skills">Skills:</label>
                <select v-model="form.skills" id="skills" required>
                    <option value="">Select Skills</option>
                    <option value="JavaScript">JavaScript</option>
                    <option value="Vue.js">Vue.js</option>
                    <option value="HTML">HTML</option>
                </select>
            </div>
            <div v-if="currentStep === 8">
                <label for="address">Address:</label>
                <textarea v-model="form.address" id="address" required></textarea>
            </div>
            <div v-if="currentStep === 9">
                <label for="upload_image">Upload Image:</label>
                <input type="file" id="image" accept="image/*" @change="handleImageUpload" />
            </div>
            <div>
                <button v-if="currentStep > 1" @click.prevent="prevStep">Previous</button>
                <button v-if="currentStep < totalSteps" @click.prevent="nextStep">Next</button>
                <button type="submit" :disabled="isSubmitting">
                    {{ isSubmitting ? 'Submitting...' : 'Submit' }}
                </button>
            </div>
        </form>
    </v-container>
</template>
<script>
import { ref } from 'vue';
export default {
    name: 'CvComponent',
    setup() {
        const form = ref({
            name: '',
            email: '',
            highest_education: '',
            university: '',
            starting_year: '',
            passing_year: '',
            skills: '',
            address: '',
            upload_image: null,
        });
        const isSubmitting = ref(false);
        const currentStep = ref(1);
        const totalSteps = 9;
        const submitForm = () => {
            isSubmitting.value = true;
            // window.axios.post('/cv', form.value)
            //     .then(response => {
            //         console.log('Form submitted successfully:', response.data);
            //         alert('CV submitted successfully!');
            //         form.value = {
            //             name: '',
            //             email: '',
            //             highest_education: '',
            //             university: '',
            //             starting_year: '',
            //             passing_year: '',
            //             skills: '',
            //             address: '',
            //             upload_image: null,
            //         };
            //         if (currentStep.value < totalSteps) {
            //             currentStep.value += 1;
            //         }
            //     })
            //      .catch(error => {
            //          console.error('Error submitting CV:', error);
            //      alert('An error occurred during CV submission. Please try again.');
            //     })
            //     .finally(() => {
            //         isSubmitting.value = false;
            //     });
        };
        const getYearRange = () => {
            const currentYear = new Date().getFullYear();
            return Array.from({ length: 10 }, (_, index) => currentYear + index);
        };
        const handleImageUpload = (event) => {
            const file = event.target.files[0];
            if (file) {
                form.value.image = file;
            }
        };
        const nextStep = () => {
            if (currentStep < totalSteps) {
                currentStep.value += 1;
            }
        };
        const prevStep = () => {
            if (currentStep > 1) {
                currentStep.value -= 1;
            }
        };
        return {
            isSubmitting,
            currentStep,
            totalSteps,
            nextStep,
            prevStep,
            form,
            getYearRange,
            submitForm,
            getYearRange,
            handleImageUpload,
        };
    },
};

</script>

<style scoped>
.cv-form {
    max-width: 400px;
    margin: auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
}

label {
    display: block;
    margin-bottom: 8px;
}

input,
select,
textarea {
    width: 100%;
    padding: 8px;
    margin-bottom: 12px;
    box-sizing: border-box;
}

button {
    background-color: #4caf50;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}
</style>



  