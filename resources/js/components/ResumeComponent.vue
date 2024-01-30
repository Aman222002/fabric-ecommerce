<!-- 
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
                            <template v-for="currentStep in steps" :key="`${currentStep}-step`">
                                <v-stepper-item :complete="e1 > currentStep" :step="stepHeaders[currentStep - 1]"
                                    :value="currentStep" editable>
                                    <template v-slot:title>
                                        {{ stepTitles[currentStep - 1] }}
                                    </template>
                                </v-stepper-item>
                                <v-divider v-if="currentStep !== steps" :key="currentStep"></v-divider>
                            </template>
                        </v-stepper-header>
                        <v-stepper-window>
                            <v-stepper-window-item v-for="currentStep in steps" :key="`${currentStep}-content`"
                                :value="currentStep">
                                <v-card :color="stepBackgrounds[currentStep - 1]"
                                    :height="currentStep === e1 ? 'auto' : '100px'">
                                    <v-form @submit.prevent="goToNext()" ref="myForm">
                                        <template v-if="currentStep === 1">
                                            <div class="flex-container">
                                                <div style="flex-grow: 1"> <users-details :form-data="formData"
                                                        :name-rules="nameRules"></users-details></div>
                                                <div style="flex-grow: 1"> <user-address :form-data="formData"
                                                        :name-rules="nameRules"></user-address></div>
                                            </div>

                                        </template>
                                        <template v-if="currentStep === 2">

                                            <div>
                                                <users-qualifications :form-data="formData"
                                                    :name-rules="nameRules"></users-qualifications>
                                                <hr style="width:100%;text-align:left;margin-left:0">
                                                <user-skills :form-data="formData" :name-rules="nameRules"></user-skills>

                                            </div>

                                        </template>
                                        <template v-if="currentStep === 3">
                                            <div>
                                                <work-experience :form-data="formData"
                                                    :name-rules="nameRules"></work-experience>
                                                <hr style="width:100%;text-align:left;margin-left:0">
                                                <users-achievments :form-data="formData"
                                                    :name-rules="nameRules"></users-achievments>
                                            </div>
                                        </template>
                                        <template v-if="currentStep === 4">

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
<script >

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
        const currentStep = ref(0);
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


        function prev() {
            if (currentStep.value <= 0) {
                return;
            }

            currentStep.value--;
        }

        const disabled = computed(() => {
            const val = e1.value === 1 ? "prev" : false;
            console.log("val", val, e1.value, steps.value);
            return val;
        });

        return {
            maxSteps: 4,
            e1,
            steps,
            stepHeaders,
            stepTitles,
            stepBackgrounds,
            formData,
            nameRules,
            circularSteps,
            myForm,

        };

    },
    computed: {
        disabled: function () {
            const val = this.e1.value === 1 ? "prev" : false;
            return val;
        }
    },
    methods: {
        async goToNext() {

            console.log("data", this.$errors, this.$validators)

            const { valid } = await this.$refs['myForm'][0].validate();

            console.log("Is Form valid", valid)
            if (!valid) {

                return false;
            } else {

                if (this.e1 === this.steps) {

                    useMyStore().submitForm();
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
 -->


<template>
    <div>
        <div style="text-align: center;">
            <h1>Fill your Personal Details</h1>
        </div>

        <form @submit="nextStep" :validation-schema="currentSchema">
            <template v-if="currentStep === 0">
                <user-address></user-address>

            </template>
            <template v-if="currentStep === 1">

                <users-qualifications></users-qualifications>
            </template>
            <template v-if="currentStep === 2">
                <users-qualifications></users-qualifications>
            </template>
            <template v-if="currentStep === 3">
                <label for="terms">Agree to terms and conditions</label>
                <Field name="terms" type="checkbox" id="terms" :value="true" />
            </template>

            <button v-if="currentStep !== 0" type="button" @click.prevent="prevStep">
                Previous
            </button>

            <button v-if="currentStep !== 3" type="button" @click.prevent="nextStep">
                Next
            </button>

            <button v-if="currentStep === 3" type="submit">
                Finish
            </button>

        </form>
    </div>
</template>
<script setup lang="ts">
import { ref, computed } from 'vue';
import { Form, Field, ErrorMessage } from 'vee-validate';
import * as yup from 'yup';

import UserAddress from './UserInformations/UserAddress.vue';
import UsersQualifications from './UserInformations/UsersQualifications.vue';

const currentStep = ref(0);
const schemas = [
    yup.object({
        address1: yup.string().required(),
        address2: yup.string().required(),
        city: yup.string().required(),
        country: yup.string().required(),
        Zip_code: yup.number().required(),
        state: yup.string().required(),


    }),
    yup.object({
        education_type: yup.string().required(),
        school_university: yup.string().required(),
        starting_year: yup.string().required(),
        passing_year: yup.string().required(),

    }),
    yup.object({
        address: yup.string().required(),
        postalCode: yup
            .string()
            .required()
            .matches(/^[0-9]+$/, 'Must be numeric'),
    }),
    yup.object({
        terms: yup.bool().required().equals([true]),
    }),
];

const currentSchema = computed(() => {
    return schemas[currentStep.value];
});

function nextStep(values: any) {


    if (currentStep.value < 4) {

        currentStep.value++;
    }
}


function prevStep() {
    if (currentStep.value <= 0) {
        return;
    }

    currentStep.value--;
}
</script>
  
<style></style>

   