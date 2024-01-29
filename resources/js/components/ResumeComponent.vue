
<template>
    <div>
        <div>
            <div style="text-align: center;">
                <h1>Fill your Personal Details</h1>
            </div>
            <div>
                <v-stepper v-model="e1">
                    <template v-slot:default="{ prev }">
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
                                <v-card :color="stepBackgrounds[n - 1]" :height="n === e1 ? 'auto' : '100px'">
                                    <v-form @submit.prevent="goToNext()" ref="myForm">
                                        <template v-if="n === 1">
                                            <div class="flex-container">
                                                <div style="flex-grow: 1"> <users-details :form-data="formData"
                                                        :name-rules="nameRules"></users-details></div>
                                                <div style="flex-grow: 1"> <user-address :form-data="formData"
                                                        :name-rules="nameRules"></user-address></div>
                                            </div>
                                        </template>
                                        <template v-if="n === 2">
                                            <div>
                                                <users-qualifications :form-data="formData"
                                                    :name-rules="nameRules"></users-qualifications>
                                                <hr style="width:100%;text-align:left;margin-left:0">
                                                <user-skills :form-data="formData" :name-rules="nameRules"></user-skills>

                                            </div>
                                        </template>
                                        <template v-if="n === 3">
                                            <div>
                                                <work-experience :form-data="formData"
                                                    :name-rules="nameRules"></work-experience>
                                                <hr style="width:100%;text-align:left;margin-left:0">
                                                <users-achievments :form-data="formData"
                                                    :name-rules="nameRules"></users-achievments>
                                            </div>
                                        </template>
                                        <template v-if="n === 4">
                                            <div>
                                                <user-profile :form-data="formData" :name-rules="nameRules"></user-profile>
                                            </div>
                                        </template>
                                        <v-stepper-actions :disabled="disabled" @click:prev="prev" @click:next="goToNext()"
                                            color="#006400" style="font-size: 20%;"></v-stepper-actions>
                                    </v-form>
                                </v-card>
                            </v-stepper-window-item>
                        </v-stepper-window>
                    </template>
                </v-stepper>
            </div>
        </div>
    </div>
</template>
<script>
import { ref, computed } from 'vue';
import UsersDetails from './UserInformations/UsersDetails.vue';
import UsersAchievments from './UserInformations/UsersAchievments.vue';
import UserAddress from './UserInformations/UserAddress.vue';
import UserSkills from './UserInformations/UserSkills.vue';
import WorkExperience from './UserInformations/WorkExperience.vue';
import UserProfile from './UserInformations/UserProfile.vue';
import UsersQualifications from './UserInformations/UsersQualifications.vue';
import { useMyStore } from '../store';

export default {
    name: 'ResumeComponent',
    components: {
        UsersDetails,
        UserSkills,
        UsersQualifications,
        UserProfile,
        WorkExperience,
        UserAddress,
        UsersAchievments
    },
    setup() {
        const maxSteps = ref(4);
        const e1 = ref(1);
        const steps = ref(4);
        const stepHeaders = ref(["Step 1", "Step 2", "Step 3", "Step 4"]);
        const stepTitles = ref(["Personal Details", "Education Details", "Work Experience", "Hobbies"]);
        const stepBackgrounds = ref([]);
        const formData = ref({});
        const nameRules = ref([]);
        const myForm = ref(null);

        const circularSteps = computed(() => {
            const circularSteps = [];
            for (let i = 2; i <= maxSteps.value; i++) {
                circularSteps.push(i);
            }
            return circularSteps;
        });

        const disabled = computed(() => {
            const val = e1.value === 1 ? "prev" : false;
            console.log("val", val, e1.value, steps.value);
            return val;
        });

        const degreeOptionsWithAdditional = computed(() => {
            return [...degreeOptions, formData.value.degree === "Other" ? formData.value.otherDegree : ""];
        });



        return {
            maxSteps,
            e1,
            steps,
            stepHeaders,
            stepTitles,
            stepBackgrounds,
            formData,
            nameRules,
            circularSteps,
            disabled,
            myForm,
            degreeOptionsWithAdditional,
        };


    },
    methods: {
        async goToNext() {

            const { valid } = await this.$refs['myForm'][0].validate();

            if (!valid) {
                return false;
            } else {

                if (this.e1 === this.steps) {
                    const submittedData = {
                        userDetails: this.formData.users,
                        educationDetails: this.formData.educationDetails,
                        fields: this.formData.fields,
                        address: this.formData.address,
                        achievements: this.formData.achievements,
                        workExperiences: this.formData.workExperiences,
                    };

                    useMyStore().submitForm(submittedData);
                } else {
                    this.e1 = this.e1 < this.steps ? this.e1 + 1 : 1;
                }
            }
        },
        async updateSteps() {
            this.steps = this.steps.map((step) => ((step - 2 + this.maxSteps - 1) % (this.maxSteps - 1)) + 2);

        },
        async prev() {
            this.e1 = this.e1 > 1 ? this.e1 - 1 : this.steps;
        },
        async next() {
            this.e1 = this.e1 < this.steps ? this.e1 + 1 : 1;
        },
    }
};
</script>
<style scoped>
.flex-container {
    display: flex;
    align-items: stretch;

}

.flex-container>div {

    text-align: center;
    line-height: 75px;
    font-size: 30px;
}

.custom-stepper {
    font-size: 40%;

}
</style>

