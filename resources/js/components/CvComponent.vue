
<template>
    <div>
        <v-card class="mb-4">
            <v-card-text>
                <v-select v-model="steps" :items="[2, 3, 4, 5, 6, 7]" label="steps"></v-select>
            </v-card-text>
        </v-card>
        <v-stepper v-model="e1">
            <template v-slot:default="{ prev, next }">
                <v-stepper-header>
                    <template v-for="n in steps" :key="`${n}-step`">
                        <v-stepper-item :complete="e1 > n" :step="stepHeaders[n - 1]" :value="n" editable>
                            <template v-slot:title>
                                <v-row justify="center">
                                    <v-col>
                                        <span>{{ stepTitles[n - 1] }}</span>
                                    </v-col>
                                </v-row>
                            </template>
                        </v-stepper-item>
                        <v-divider v-if="n !== steps" :key="n"></v-divider>
                    </template>
                </v-stepper-header>

                <v-stepper-window>
                    <v-stepper-window-item v-for="n in steps" :key="`${n}-content`" :value="n">
                        <v-card :color="stepBackgrounds[n - 1]" :height="n === e1 ? 'auto' : '400px'">
                            <v-container style="height: 300px; width: 80%;">
                                <v-card style="height: 250px; width: 80%;">
                                    <v-form @submit.prevent="next">
                                        <v-row v-if="n === 1">
                                            <v-card-title class="headline mb-2">General Information</v-card-title>
                                            <v-col>
                                                <v-label> <v-icon>mdi-account</v-icon>Name</v-label>
                                                <v-text-field v-model="formData.name" label="Name"
                                                    :rules="nameRules"></v-text-field>
                                            </v-col>
                                            <v-col>

                                                <v-label><v-icon>mdi-email</v-icon>Email</v-label>
                                                <v-text-field v-model="formData.email" label="Email"
                                                    :rules="emailRules"></v-text-field>
                                            </v-col>
                                            <v-col>
                                                <v-label><v-icon>mdi-phone</v-icon> Phone no</v-label>
                                                <v-text-field v-model="formData.phone" label="Phone"
                                                    :rules="phoneRules"></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row v-if="n === 2">
                                            <v-card-title class="headline mb-2">Users Qualifications</v-card-title>
                                            <!-- <v-col>
                                                <v-label>
                                                    <v-icon>mdi-school</v-icon> Education
                                                </v-label>
                                                <v-text-field v-model="formData.education"
                                                    :rules="educationRules"></v-text-field>
                                            </v-col> -->
                                            <v-col>
                                                <v-label><v-icon>mdi-school</v-icon>Degree</v-label>
                                                <v-select v-model="formData.degree" :items="degreeOptions"
                                                    label="Degree"></v-select>
                                            </v-col>
                                            <v-row v-if="formData.degree === 'Other'">
                                                <v-col>
                                                    <v-label>Specify Other Degree</v-label>
                                                    <v-text-field v-model="formData.otherDegree"
                                                        label="Other Degree"></v-text-field>
                                                </v-col>
                                            </v-row>
                                        </v-row>
                                    </v-form>
                                </v-card>
                            </v-container>
                        </v-card>
                    </v-stepper-window-item>
                </v-stepper-window>
                <v-stepper-actions :disabled="disabled" @click:prev="prev" @click:next="next"
                    color="success"></v-stepper-actions>
            </template>
        </v-stepper>
    </div>
</template>
  
<script>
export default {
    data() {
        return {
            e1: 1,
            steps: 2,
            stepHeaders: ["Step 1", "Step 2", "Step 3", "Step 4", "Step 5"],
            stepTitles: ["General Information", "Users Qualifications", "Skills", "Address", "Additional Information", "Experience"],
            stepBackgrounds: ["#1E90FF", "#1E90FF", "#1E90FF", "#1E90FF", "#1E90FF", "#1E90FF",],
            formData: {
                name: "",
                email: "",
                phone: "",
                education: "",
                degree: null,
                otherDegree: "",
                certifications: "",
                workExperience: "",
            },
            degreeOptions: [
                "Bachelor's Degree",
                "Master's Degree",
                "Ph.D.",
                "Other",
                // Add more degree options as needed
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
        disabled() {
            return this.e1 === 1 ? "prev" : this.e1 === this.steps ? "next" : undefined;
        },
        degreeOptionsWithAdditional() {
            return [...this.degreeOptions, this.formData.degree === "Other" ? this.formData.otherDegree : ""];
        },
    },

    methods: {
        prev() {
            if (this.e1 > 1) {
                this.e1 -= 1;
            }
        },

        next() {
            if (this.e1 < this.steps) {
                this.e1 += 1;
            }
        },
    },
};
</script>
  