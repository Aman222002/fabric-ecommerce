
<template>
  <div>
    <v-form @submit.prevent="saveJob" id="createJobForm" name="createJobForm">
      
        <v-card class="border-0 shadow mb-4">
          <v-card-title>
            <h3 class="fs-4 mb-1">Job Details</h3>
          </v-card-title>
          <v-card-text class="card-form p-4">
            <v-text-field
            variant="outlined"
              v-model="job.title"
              label="Title"
              placeholder="Job Title"
            ></v-text-field>
           

            <v-select  variant="outlined" v-model="job.category"  :items="categories"
                      item-title="name" item-value="id" label="Select Category" 
                    ></v-select>

                    <v-select  variant="outlined" v-model="job.jobType"  :items="jobTypes"
                      item-title="name" item-value="id" label="Select JobType" 
                    ></v-select>

<<<<<<< Updated upstream
           
=======
                    <v-select  variant="outlined" v-model="job.jobSkill"  :items="jobSkills"
                      item-title="skill_name" item-value="id" label="Select Skills" :rules="rules.jobSkill" 
                    ></v-select>
>>>>>>> Stashed changes
            <v-text-field
            variant="outlined"
              v-model="job.vacancy"
              type="number"
              min="1"
              label="Vacancy"
              placeholder="Vacancy"
            ></v-text-field>
            <v-text-field
            variant="outlined"
              v-model="job.salary"
              label="Salary"
              placeholder="Salary"
            ></v-text-field>
            <v-text-field
            variant="outlined"
              v-model="job.location"
              label="Location"
              placeholder="Location"
            ></v-text-field>
            <v-textarea
            variant="outlined"
              v-model="job.description"
              label="Description"
              placeholder="Description"
            ></v-textarea>
            <v-text-field
            variant="outlined"
              v-model="job.qualifications"
              label="Qualifications"
              placeholder="Qualifications"
            ></v-text-field>
            <v-select
            variant="outlined"
              v-model="job.experience"
              :items="experienceOptions"
              label="Experience"
              placeholder="Select Experience"
            ></v-select>
            <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3><br>
            <v-text-field
            variant="outlined"
              v-model="job.companywebsite"
              label="Website"
              placeholder="Website"
            ></v-text-field>
          </v-card-text>
          <v-card-actions class="p-4">
            <v-btn type="submit" color="primary" style="background-color: white;">Save Job</v-btn>
          </v-card-actions>
        </v-card>
     
    </v-form>
  </div>
</template>
  
  <script>
import { ref, onMounted } from "vue";

export default {
  name: "Postjob",
  setup() {
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
    });
    const categories = ref([]);

    const fetchCategories = async () => {
      try {
        axios.get("/categories").then((response) => {
          categories.value = response.data;
          console.log(response.data)
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
    const selectJobType = (selectedJobType) => {
      job.jobType = selectedJobType.name;
    };
    onMounted(() => {
      fetchCategories();
      fetchJobTypes();
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
        try{
          axios.post('/post',job.value).then((response)=>{
            console.log(response.data);
            if (response.data.status === true) {
              window.location.href = '/crud';
            }
          })
        }catch(err){
          console.log(err);
        }
    };
    return {
      job,
      categories,
      jobTypes,
      experienceOptions,
      selectCategory,
      selectJobType,
      saveJob,
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
</style>
