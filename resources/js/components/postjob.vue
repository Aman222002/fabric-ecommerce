
<template>
  <v-container>
    <v-form
      @submit.prevent="saveJob"
      name="createJobForm"
      ref="form"
      class="custom-form"
      style="margin-left: 10%;"
    >
      <v-row style="margin-top: 20px">
        <v-col cols="10">
          <p class="mb-4 form-title" style="text-align: center; font-size: 20px;"> Post Detail:</p>
        </v-col>
        <v-col cols="4" sm="5">
          <v-text-field
            variant="outlined"
            v-model="job.title"
            label="Title"
            placeholder=" Enter Job Title"
            :rules="rules.title"
            density="compact"
          ></v-text-field>
        </v-col>
        <v-col cols="4" sm="5">
          <v-select
            variant="outlined"
            v-model="job.category"
            :items="categories"
            item-title="name"
            item-value="id"
            label="Select Category"
            :rules="rules.category"
            density="compact"
          ></v-select>
        </v-col>
        <v-col cols="4" sm="5">
          <v-select
            variant="outlined"
            v-model="job.jobType"
            :items="jobTypes"
            item-title="name"
            item-value="id"
            label="Select JobType"
            :rules="rules.jobType"
            density="compact"
          ></v-select>
        </v-col>
        <v-col cols="4" sm="5">
          <v-select
            variant="outlined"
            v-model="job.jobSkill"
            :items="jobSkills"
            item-title="skill_name"
            item-value="id"
            label="Select Skills"
            :rules="rules.jobSkill"
            density="compact"
          ></v-select>
        </v-col>
        <v-col cols="4" sm="5">
          <v-text-field
            variant="outlined"
            v-model="job.vacancy"
            type="number"
            min="1"
            label="Vacancy"
            :rules="rules.vacancy"
            placeholder="Vacancy"
            density="compact"
          ></v-text-field>
        </v-col>
        <v-col cols="4" sm="5">
          <v-text-field
            variant="outlined"
            v-model="job.salary"
            label="Salary"
            placeholder="Salary"
            :rules="rules.salary"
            density="compact"
          ></v-text-field>
        </v-col>
        <v-col cols="4" sm="5">
          <v-text-field
            variant="outlined"
            v-model="job.location"
            label="Location"
            placeholder="Location"
            :rules="rules.location"
            density="compact"
          ></v-text-field>
        </v-col>
        <v-col cols="12" sm="10">
          <v-textarea
            variant="outlined"
            v-model="job.description"
            label="Description"
            placeholder="Description"
            :rules="rules.description"
            density="compact"
          ></v-textarea>
        </v-col>
        <v-col cols="4" sm="5">
          <v-text-field
            variant="outlined"
            v-model="job.qualifications"
            label="Qualifications"
            placeholder="Qualifications"
            :rules="rules.qualifications"
            density="compact"
          ></v-text-field>
        </v-col>
        <v-col cols="4" sm="5">
          <v-select
            variant="outlined"
            v-model="job.experience"
            :items="experienceOptions"
            label="Experience"
            placeholder="Select Experience"
            density="compact"
            :rules="rules.experience"
          ></v-select>
        </v-col>
        <v-col cols="4" sm="5">
          <v-text-field
            variant="outlined"
            v-model="job.companywebsite"
            label=" Company Website"
            placeholder="Website"
            density="compact"
            :rules="rules.companywebsite"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row >
        <v-col cols="10" class="text-center">
          <v-btn type="submit" color="primary" class="custom-button"
            >Save Job</v-btn
          >
        </v-col>
      </v-row>
    </v-form>
  
  
  </v-container>
</template>
  
  <script>
import { ref, onMounted } from "vue";
import axios from "axios";
export default {
  name: "Postjob",
  setup() {
    const form = ref(null);
    const job = ref({
      title: "",
      category: "",
      jobType: "",
      vacancy: "",
      salary: "",
      location: "",
      description: "",
      qualifications: "",
      experience: "",
      companywebsite: "",
      jobSkill: "",
    });
    const rules = {
      title: [(v) => !!v || "Title is required"],
      category: [(v) => !!v || "Category is required"],
      jobType: [(v) => !!v || "Job Type is required"],
      vacancy: [(v) => !!v || "Vacancy is required"],
      salary: [(v) => !!v || "Salary is required"],
      location: [(v) => !!v || "Location is required"],
      description: [(v) => !!v || "Description is required"],
      qualifications: [(v) => !!v || "Qualifications are required"],
      experience: [(v) => !!v || "Experience is required"],
      companywebsite: [(v) => !!v || "Company Website is required"],
      jobSkill: [(v) => !!v || "Job Skill is required"],
    };

    const categories = ref([]);

    const fetchCategories = async () => {
      try {
        axios.get("/categories").then((response) => {
          categories.value = response.data;
          console.log(response.data);
        });
      } catch (error) {
        console.error("Error fetching categories:", error);
      }
    };
    const selectCategory = (selectedCategory) => {
      job.category = selectedCategory.name;
    };

    const jobTypes = ref([]);
    const fetchJobTypes = async () => {
      try {
        axios.get("/jobtypes").then((response) => {
          jobTypes.value = response.data;
        });
      } catch (error) {
        console.error("Error fetching job types:", error);
      }
    };
    const jobSkills = ref([]);
    const fetchJobSkill = async () => {
      try {
        axios.get("/skill").then((response) => {
          jobSkills.value = response.data;
        });
      } catch (error) {
        console.error("Error fetching job types:", error);
      }
    };
    const selectJobSkill = (selectedJobSkill) => {
      job.jobSkill = selectedJobSkill.name;
    };
    const selectJobType = (selectedJobType) => {
      job.jobType = selectedJobType.name;
    };
    onMounted(() => {
      fetchCategories();
      fetchJobTypes();
      fetchJobSkill();
    });

    const experienceOptions = ref([
      "Fresher",
      "1 Year",
      "2 Years",
      "3 Years",
      "4 Years",
      "5 Years",
      "6 Years",
      "7 Years",
      "8 Years",
      "9 Years",
      "10 Years",
      "10+ Years",
    ]);

    const saveJob = () => {
      form.value.validate().then((valid) => {
        if (!valid.valid) {
          const errors = JSON.parse(JSON.stringify(valid.errors));

          let errorField = form.value[errors[0].id];

          errorField = Array.isArray(errorField) ? errorField[0] : errorField;
          errorField.scrollIntoView({
            behavior: "smooth",
            block: "center",
            inline: "center",
          });
        } else {
          try {
            axios.post("/post", job.value).then((response) => {
              console.log(response.data);
              if (response.data.status === true) {
                window.Swal.fire({
                  icon: "success",
                  title: "Job Posted ",
                  text: "Job Posted successfully ",
                  confirmButtonText: "OK",
                });
                window.location.href = "/company/profile";
              }
            });
          } catch (err) {
            console.log(err);
          }
        }
      });
    };
    return {
      job,
      categories,
      jobTypes,
      experienceOptions,
      selectCategory,
      selectJobType,
      selectJobSkill,
      saveJob,
      jobSkills,
      form,
      rules,
    };
  },
};
</script>
  
<style scoped>
#createJobForm {
  max-width: 600px;
  margin: 0 auto;
}
.card-form {
  padding: 20px;
}
.v-text-field,
.v-select,
.v-textarea {
  margin-bottom: 20px;
}

.border-top {
  border-top: 1px solid #ccc;
}

.fs-4 {
  font-size: 1.5rem;
}
.mt-5 {
  margin-top: 20px;
}
.pt-5 {
  padding-top: 20px;
}

.v-card-actions {
  text-align: right;
}
.custom-card {
  width: auto;
}
.v-text-field,
  .v-select,
  .v-textarea {
    margin-bottom: 0; 
  }
  .custom-card {
    width: auto;
  }
</style>
