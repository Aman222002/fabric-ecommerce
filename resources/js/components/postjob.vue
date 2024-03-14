
<template>
  <v-container>
    <v-form
      @submit.prevent="saveJob"
      name="createJobForm"
      ref="form"
      class="custom-form form_fild_com"
    >
      <v-row>
        <v-col cols="12">
          <h2 class="mb-4 form_fild_title">Post Detail:</h2>
        </v-col>
        <v-col sm="12" md="6" lg="6" xl="6" cols="12">
          <v-text-field
            variant="outlined"
            v-model="job.title"
            label="Title"
            placeholder=" Enter Job Title"
            :rules="rules.title"
            density="compact"
          ></v-text-field>
        </v-col>
        <v-col sm="12" md="6" lg="6" xl="6" cols="12">
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
        <v-col sm="12" md="6" lg="6" xl="6" cols="12">
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
        <v-col sm="12" md="6" lg="6" xl="6" cols="12">
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
        <v-col sm="12" md="6" lg="6" xl="6" cols="12">
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
        <v-col sm="12" md="6" lg="6" xl="6" cols="12">
          <v-text-field
            variant="outlined"
            v-model="job.salary"
            label="Salary"
            placeholder="Salary"
            :rules="rules.salary"
            density="compact"
          ></v-text-field>
        </v-col>
        <v-col sm="12" md="6" lg="6" xl="6" cols="12">
          <v-text-field
            variant="outlined"
            v-model="job.location"
            label="Location"
            placeholder="Location"
            :rules="rules.location"
            density="compact"
          ></v-text-field>
        </v-col>
        <v-col sm="12" md="6" lg="6" xl="6" cols="12">
          <v-text-field
            variant="outlined"
            v-model="job.qualifications"
            label="Qualifications"
            placeholder="Qualifications"
            :rules="rules.qualifications"
            density="compact"
          ></v-text-field>
        </v-col>
        <v-col sm="12" md="6" lg="6" xl="6" cols="12">
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
        <v-col sm="12" md="6" lg="6" xl="6" cols="12">
          <v-text-field
            variant="outlined"
            type="url"
            required
            v-model="job.companywebsite"
            label=" Company Website"
            :rules="companywebsite"
            placeholder="Website"
            density="compact"
          ></v-text-field>
        </v-col>
        <v-col sm="12" md="12" lg="12" xl="12" cols="12">
          <v-textarea
            variant="outlined"
            v-model="job.description"
            label="Description"
            placeholder="Description"
            :rules="rules.description"
            density="compact"
          ></v-textarea>
        </v-col>
        <v-col cols="12" class="text-center">
          <v-btn type="submit" class="custom-button form_fild_btn"
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
    const form = ref();
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
      jobSkill: [(v) => !!v || "Job Skill is required"],
    };
    const companywebsite = [
      (v) => !!v || "URL is required",
      (v) =>
        /^(https?:\/\/)?([\da-z.-]+)\.([a-z.]{2,6})([/\w .-]*)*\/?$/.test(v) ||
        "Invalid URL",
    ];
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
            axios
              .post("/post", job.value)
              .then((response) => {
                if (response.data.status === true) {
                  window.Swal.fire({
                    toast: true,
                    position: "top-end",
                    timer: 2000,
                    showConfirmButton: false,
                    icon: "success",
                    title: "Job posted successfully!",
                  });
                }
                form.value.reset();
              })
              .catch((error) => {
                console.log(error);
                if (error.response.status == "402") {
                  window.Swal.fire({
                    toast: true,
                    position: "top-end",
                    timer: 2000,
                    showConfirmButton: false,
                    icon: "error",
                    title: `You don't have a active plan buy a plan or renew your plan`,
                  });
                } else if ((error.response.status = "403")) {
                  window.Swal.fire({
                    toast: true,
                    position: "top-end",
                    timer: 2000,
                    showConfirmButton: false,
                    icon: "error",
                    title: `You have posted number of allowed post can't post more`,
                  });
                }
              });
          } catch (err) {
            window.Swal.fire({
              toast: true,
              position: "top-end",
              timer: 2000,
              showConfirmButton: false,
              icon: "error",
              title: `Something went Wrong`,
            });
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
      companywebsite,
    };
  },
};
</script>
  
