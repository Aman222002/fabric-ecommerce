<template>
  <v-container>
    <div>
      <div style="text-align: center">
        <h1 style="margin-top: 30px">Fill your Personal Details</h1>
      </div>
      <div>
        <v-stepper v-model="e1" style="position: relative">
          <template v-slot:default="{ prev }">
            <v-stepper-header
              style="position: sticky; top: 0; background-color: white"
            >
              <template
                v-for="currentStep in steps"
                :key="`${currentStep}-step`"
              >
                <v-stepper-item
                  :complete="e1 > currentStep"
                  :step="stepHeaders[currentStep - 1]"
                  :value="currentStep"
                  editable
                >
                  <template v-slot:title>
                    {{ stepTitles[currentStep - 1] }}
                  </template>
                </v-stepper-item>
                <v-divider
                  v-if="currentStep !== steps"
                  :key="currentStep"
                ></v-divider>
              </template>
            </v-stepper-header>
            <v-stepper-window>
              <v-stepper-window-item
                v-for="currentStep in steps"
                :key="`${currentStep}-content`"
                :value="currentStep"
              >
                <v-card
                  :color="stepBackgrounds[currentStep - 1]"
                  :height="currentStep === e1 ? 'auto' : '100px'"
                >
                  <v-form @submit.prevent="goToNext(id)" ref="myForm">
                    <template v-if="currentStep === 1">
                      <v-row>
                        <v-col cols="6"> <users-details></users-details></v-col>
                        <v-col cols="6"> <user-address></user-address></v-col>
                      </v-row>
                    </template>
                    <template v-if="currentStep === 2">
                      <div class="flex-container-1">
                        <users-qualifications></users-qualifications>
                        <user-skills></user-skills>
                      </div>
                    </template>
                    <template v-if="currentStep === 3">
                      <div style="display: flex">
                        <v-switch
                          v-model="isExperience"
                          label="Do you have experience?"
                          dense
                          color="success"
                        ></v-switch>
                      </div>
                      <div
                        class="flex-container-1"
                        v-if="isExperience"
                        style="
                          position: relative;
                          height: 100vh;
                          overflow-y: auto;
                        "
                      >
                        <work-experience></work-experience>
                        <users-achievments></users-achievments>
                      </div>
                    </template>
                    <template v-if="currentStep === 4">
                      <div>
                        <user-profile></user-profile>
                      </div>
                    </template>
                    <v-stepper-actions
                      :disabled="disabled"
                      @click:prev="prev"
                      @click:next="goToNext()"
                      color="#006400"
                    ></v-stepper-actions>
                    <v-select
                      v-if="currentStep === 4"
                      v-model="selectedTemplate"
                      :items="['Template1', 'Template2', 'Template3']"
                      label="Select Template"
                      density="compact"
                      variant="outlined"
                    ></v-select>
                    <iframe
                      v-if="selectedTemplate && currentStep === 4"
                      :src="getTemplatePreview(selectedTemplate)"
                      width="400"
                      height="300"
                      frameborder="0"
                    ></iframe>
                    <v-btn v-if="currentStep === 4" @click="downloadcv()"
                      >Generate CV</v-btn
                    >
                  </v-form>
                </v-card>
              </v-stepper-window-item>
            </v-stepper-window>
          </template>
        </v-stepper>
      </div>
    </div>
  </v-container>
</template>

<script >
import axios from "axios";
import { ref, computed, onMounted } from "vue";
import { Form, Field, ErrorMessage } from "vee-validate";
import * as yup from "yup";
import UsersDetails from "./UserInformations/UsersDetails.vue";
import UsersAchievments from "./UserInformations/UsersAchievments.vue";
import UserAddress from "./UserInformations/UserAddress.vue";
import UserSkills from "./UserInformations/UserSkills.vue";
import WorkExperience from "./UserInformations/WorkExperience.vue";
import UserProfile from "./UserInformations/UserProfile.vue";
import UsersQualifications from "./UserInformations/UsersQualifications.vue";
import { useMyStore } from "../store";

export default {
  name: "ResumeComponent",
  components: {
    Form,
    Field,
    ErrorMessage,
    UsersDetails,
    UserSkills,
    UsersQualifications,
    UserProfile,
    WorkExperience,
    UserAddress,
    UsersAchievments,
  },
  setup() {
    const store = useMyStore();
    const currentStep = ref(0);
    let valid = true;
    const maxSteps = ref(4);
    const e1 = ref(1);
    const steps = ref(4);
    const stepHeaders = ref(["Step 1", "Step 2", "Step 3", "Step 4"]);
    const stepTitles = ref([
      "Personal Details",
      "Education Details",
      "Work Experience",
      "Hobbies",
    ]);
    const selectedTemplate = ref("");

    const stepBackgrounds = ref([]);
    const formData = ref({});
    const nameRules = ref([]);
    const myForm = ref(null);
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
        terms: yup.bool().required().equals([true]),
      }),
    ];

    const currentSchema = computed(() => {
      return schemas[currentStep.value];
    });
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
      return val;
    });
    const downloadcv = () => {
      if (!selectedTemplate.value) {
        return;
      }
      const url = `/generate-pdf?template=${selectedTemplate.value}`;
      window.location.href = url;
    };
    const getTemplatePreview = (template) => {
      return `/template-preview/${template}`;
    };

    const isExperience = ref(false);

    const onExperienceCheckboxChange = () => {
      isExperience.value = !isExperience.value;
    };
    onMounted(async () => {
      try {
        const response = await axios.get("/fetch-user-data");
        const { workExperienceExists, userAchievementsExists } = response.data;
        isExperience.value = workExperienceExists && userAchievementsExists;
      } catch (error) {
        console.error("Error fetching user data:", error);
      }
    });

    return {
      store,
      maxSteps: 4,
      e1,
      steps,
      stepHeaders,
      stepTitles,
      stepBackgrounds,
      formData,
      nameRules,
      valid,
      circularSteps,
      myForm,
      downloadcv,
      selectedTemplate,

      getTemplatePreview,
      isExperience,
      onExperienceCheckboxChange,
    };
  },
  computed: {
    disabled: function () {
      const val = this.e1 === 1 ? "prev" : false;
      return val;
    },
  },
  async mounted() {
    await this.store.getUserData();
  },
  methods: {
    async goToNext() {
      const formRefs = this.$refs.myForm;

      for (let i = 0; i < formRefs.length; i++) {
        const { valid } = await formRefs[i].validate();
        if (!valid) {
          return;
        }
      }
      const progressPercentage = 25 * this.e1;
      const data = {
        progressPercentage: progressPercentage,
      };
      this.store.userDetails.status = data.progressPercentage;

      try {
        await axios.post("/update-status", data);

        console.log(data.progressPercentage, "here");
        if (this.e1 === this.steps) {
          useMyStore().submitForm();
        } else {
          this.e1 = this.e1 < this.steps ? this.e1 + 1 : 1;
        }
      } catch (error) {
        console.error("Error updating database:", error);
      }
    },

    async updateSteps() {
      this.steps = this.steps.map(
        (step) => ((step - 2 + this.maxSteps - 1) % (this.maxSteps - 1)) + 2
      );
    },
    async prev() {
      this.e1 = this.e1 > 1 ? this.e1 - 1 : this.steps;
    },
    async next() {
      this.e1 = this.e1 < this.steps ? this.e1 + 1 : 1;
    },
  },
};
</script>
<style scoped>
.flex-container {
  display: flex;
  align-items: stretch;
  height: 50%;
  width: 100%;
}

.flex-container-1 {
  align-items: stretch;
  height: 60%;
  width: 100%;
}

.flex-container > div {
  text-align: center;
}

.custom-stepper {
  font-size: 40%;
}
</style>
