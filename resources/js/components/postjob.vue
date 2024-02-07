
<template>
  <div>
    <v-form @submit.prevent="saveJob" id="createJobForm" name="createJobForm" ref="form">
      
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
              :rules="rules.title"
            ></v-text-field>
           

            <v-select  variant="outlined" v-model="job.category"  :items="categories"
                      item-title="name" item-value="id" label="Select Category" :rules="rules.category"
                    ></v-select>

                    <v-select  variant="outlined" v-model="job.jobType"  :items="jobTypes"
                      item-title="name" item-value="id" label="Select JobType" :rules="rules.jobType"
                    ></v-select>

                    <v-select  variant="outlined" v-model="job.jobSkill"  :items="jobSkills"
                      item-title="skill_name" item-value="id" label="Select Skills" :rules="rules.jobSkill" 
                    ></v-select>

                    <v-select  variant="outlined" v-model="job.jobSkill"  :items="jobSkills"
                      item-title="skill_name" item-value="id" label="Select Skills" :rules="rules.jobSkill"
                    ></v-select>

            <v-text-field
            variant="outlined"
              v-model="job.vacancy"
              type="number"
              min="1"
              label="Vacancy"
              :rules="rules.vacancy"
            
              placeholder="Vacancy"
            ></v-text-field>
            <v-text-field
            variant="outlined"
              v-model="job.salary"
              label="Salary"
              placeholder="Salary"
              :rules="rules.salary"
            ></v-text-field>
            <v-text-field
            variant="outlined"
              v-model="job.location"
              label="Location"
              placeholder="Location"
              :rules="rules.location"
            ></v-text-field>
            <v-textarea
            variant="outlined"
              v-model="job.description"
              label="Description"
              placeholder="Description"
              :rules="rules.description"
            ></v-textarea>
            <v-text-field
            variant="outlined"
              v-model="job.qualifications"
              label="Qualifications"
              placeholder="Qualifications"
              :rules="rules.qualifications"
            ></v-text-field>
            <v-select
            variant="outlined"
              v-model="job.experience"
              :items="experienceOptions"
              label="Experience"
              placeholder="Select Experience"
              :rules="rules.experience"
            ></v-select>
            <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3><br>
            <v-text-field
            variant="outlined"
              v-model="job.companywebsite"
              label="Website"
              placeholder="Website"
              :rules="rules.companywebsite"
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
    const form =ref(null);
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
      jobSkill:"",
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
    }
    
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
    const jobSkills = ref([]);
    const fetchJobSkill =async () =>{
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
          inline: "center"
        });
      }else{
        try{
          axios.post('/post',job.value).then((response)=>{
            console.log(response.data);
            if (response.data.status === true) {
              window.Swal.fire({
              icon: 'success',
              title: 'Job Posted ',
              text: 'Job Posted successfully ',
              confirmButtonText: 'OK',
            })
              window.location.href = '/company/profile';
            }
          })
        }catch(err){
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
      rules
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
