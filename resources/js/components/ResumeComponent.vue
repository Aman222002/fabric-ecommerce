
<template>
    <h1 style="text-align: center;">Fill your Personal Details</h1>
    <v-container>
        <v-stepper v-model="e1">
            <template v-slot:default="{ prev, next }">
                <v-stepper-header>
                    <template v-for="n in steps" :key="`${n}-step`">
                        <v-stepper-item :complete="e1 > n" :step="stepHeaders[n - 1]" :value="n" editable>
                            <template v-slot:title>
                                {{ stepTitles[n - 1] }}
                            </template>
                        </v-stepper-item>
                        <v-divider v-if="n !== steps" :key="n"></v-divider>
                    </template>
                </v-stepper-header>
                <v-stepper-window>
                    <v-stepper-window-item v-for="n in steps" :key="`${n}-content`" :value="n">
                        <v-card :color="stepBackgrounds[n - 1]" :height="n === e1 ? 'auto' : '500px'">
                            <template v-slot:title>
                                <v-row justify="center">
                                    <v-col>
                                        <span>{{ stepTitles[n - 1] }}</span>
                                    </v-col>
                                </v-row>
                            </template>
                            <v-form @submit.prevent="next">
                                <v-container style="height:5%;width:80%">
                                    <v-card>
                                        <v-row v-if="n === 1">
                                            <users-details :form-data="formData" :name-rules="nameRules"></users-details>
                                        </v-row>
                                    </v-card>
                                </v-container>
                                <v-row v-if="n === 2">
                                    <v-container style="height:5%;width:80%">
                                        <v-card>
                                            <users-qualifications :form-data="formData"
                                                :name-rules="nameRules"></users-qualifications>
                                        </v-card>
                                    </v-container>
                                </v-row>
                                <v-row v-if="n === 3">
                                    <v-container style="height:10%;width:70%">
                                        <v-card>
                                            <Work-experience :form-data="formData"
                                                :name-rules="nameRules"></Work-experience>
                                        </v-card>
                                    </v-container>
                                </v-row>
                                <v-row v-if="n === 4">
                                    <v-container style="height:10%;width:80%">
                                        <v-card>
                                            <additional-informations :form-data="formData"
                                                :name-rules="nameRules"></additional-informations>
                                        </v-card>
                                    </v-container>
                                </v-row>
                            </v-form>
                        </v-card>
                    </v-stepper-window-item>
                </v-stepper-window>
                <v-stepper-actions :disabled="disabled" @click:prev="prev" @click:next="next"
                    color="#006400"></v-stepper-actions>
            </template>
        </v-stepper>

    </v-container>
</template>
<script>
import UsersDetails from './UserInformations/UsersDetails.vue';
import WorkExperience from './UserInformations/WorkExperience.vue';
import AdditionalInformations from './UserInformations/AdditionalInformations.vue';
import UsersQualifications from './UserInformations/UsersQualifications.vue';
export default {
    name: 'ResumeComponent',
    components: {
        UsersDetails,
        UsersQualifications,
        AdditionalInformations,
        WorkExperience,
    },
    data() {
        return {
            maxSteps: 4,
            e1: 1,
            steps: 4,
            stepHeaders: ["Step 1", "Step 2", "Step 3", "Step 4",],
            stepTitles: ["General Information", "Users Qualifications", "WorkExperience", "Additional Informations"],
            stepBackgrounds: ["#1E90FF", "#1E90FF", "#1E90FF", "#1E90FF", "#1E90FF", "#1E90FF",],
            formData: {
                name: "",
                email: "",
                phone: "",
                education: "",
                degree: null,
                otherDegree: "",
                startingYear: null,
                passingYear: null,
            },
            degreeOptions: [
                "Bachelor's Degree",
                "Master's Degree",
                "Ph.D.",
                "Other",
            ],
            educationRules: [(v) => !!v || "Education is required"],
            certificationsRules: [(v) => !!v || "Certifications are required"],
            workExperienceRules: [(v) => !!v || "Work Experience is required"],
            nameRules: [
                (v) => !!v || "Name is required",
                (v) => (v && v.length >= 3) || "Name must be at least 3 characters",
            ],
            emailRules: [
                (v) => !!v || "E-mail is required",
                (v) => /.+@.+\..+/.test(v) || "E-mail must be valid",
            ],
            phoneRules: [
                (v) => !!v || "Phone is required",
                (v) => (v && v.length >= 10) || "Phone must be at least 10 characters",
            ],
        };
    },
    computed: {
        circularSteps() {
            const circularSteps = [];
            for (let i = 2; i <= this.maxSteps; i++) {
                circularSteps.push(i);
            }
            return circularSteps;
        },
        disabled() {
            return this.e1 === 1 ? "prev" : this.e1 === this.steps ? "next" : undefined;
        },
        degreeOptionsWithAdditional() {
            return [...this.degreeOptions, this.formData.degree === "Other" ? this.formData.otherDegree : ""];
        },
    },
    methods: {
        updateSteps() {

            this.steps = this.steps.map((step) => ((step - 2 + this.maxSteps - 1) % (this.maxSteps - 1)) + 2);
        },

        prev() {
            this.e1 = this.e1 > 1 ? this.e1 - 1 : this.steps;
        },

        next() {
            this.e1 = this.e1 < this.steps ? this.e1 + 1 : 1;
        },

    },

};
</script>
