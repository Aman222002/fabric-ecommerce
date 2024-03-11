
<template>
    <p style="text-align: center; font-size: 20px; margin-top: 20px;">Draft Jobs</p>
  
   
    <DxDataGrid
      id="grid"
      :show-borders="true"
      :data-source="dataSource"
      :repaint-changes-only="true"
    >
      <DxEditing   mode="row" :use-icons="true">
        
        </DxEditing>
      <DxSearchPanel :visible="true" />
      <DxScrolling mode="virtual" row-rendering-mode="virtual" />
      <DxColumn data-field="title" data-type="string"> </DxColumn>
      <DxColumn data-field="location" data-type="string"></DxColumn>
        <DxColumn data-field="vacancy" data-type="string">
         </DxColumn>
         <DxColumn data-field="salary" data-type="string">
         </DxColumn>
         <DxColumn data-field="description" data-type="string">
         </DxColumn>
        
       
       <DxColumn caption="Post Job" cell-template="customButtonTemplate">
      </DxColumn>
      <DxColumn caption="Action" cell-template="buttondropdown"> </DxColumn>
       <template #customButtonTemplate="{data}">
        <DxButton @click="checkItem(data.row.data.id)" text="Post Job"></DxButton>
        </template>
        <template #buttondropdown="{ data:rowData}">
          <div>
        <DxButton icon="edit" @click="edit(rowData.data)" style="background-color: green; color: white;" />
        <DxButton icon="trash" @click="deletejob(rowData.data) " style="background-color: red; color: white; margin-left: 3px;"/>
      </div>
    </template>
    <DxPaging :page-size="pageSize" />
    <DxPager
      :visible="true"
      :allowed-page-sizes="[10, 15, 20]"
      :display-mode="'compact'"
      :show-page-size-selector="true"
      :show-navigation-buttons="true"
      :show-info="true"
    />
    <DxSummary>
      <DxTotalItem column="id" summary-type="count" />
    </DxSummary>
             
    </DxDataGrid>
    <v-dialog max-width="500" v-model="dialog">
    <v-card title="Dialog">
      <v-card-text>
     
        <v-text-field
            variant="outlined"
          v-model="job.title"
            label="Title"
            placeholder=" Enter Job Title"
        
            density="compact"
          ></v-text-field>
      
          <v-select
            variant="outlined"
            v-model="job.category"
            :items="categories"
            item-title="name"
            item-value="id"
            label="Select Category"
           
            density="compact"
          ></v-select>
     
       
          <v-select
            variant="outlined"
            :items="jobTypes"
            v-model="job.jobType"
            item-title="name"
            item-value="id"
            label="Select JobType"
           
            density="compact"
          ></v-select>
      
          <v-select
            variant="outlined"
            v-model="job.jobSkill"
            :items="jobSkills"
            item-title="skill_name"
            item-value="id"
            label="Select Skills"
          
            density="compact"
          ></v-select>
       
          <v-text-field
            variant="outlined"
            v-model="job.vacancy"
            type="number"
            min="1"
            label="Vacancy"
           
            placeholder="Vacancy"
            density="compact"
          ></v-text-field>
       
          <v-text-field
            variant="outlined"
            v-model="job.salary"
            label="Salary"
            placeholder="Salary"
           
            density="compact"
          ></v-text-field>
      
          <v-text-field
            variant="outlined"
            v-model="job.location"
            label="Location"
            placeholder="Location"
            
            density="compact"
          ></v-text-field>
       
          <v-textarea
            variant="outlined"
            v-model="job.description"
            label="Description"
            placeholder="Description"
          
            density="compact"
          ></v-textarea>
      
          <v-text-field
            variant="outlined"
            v-model="job.qualifications"
            label="Qualifications"
            placeholder="Qualifications"
            
            density="compact"
          ></v-text-field>
       
          <v-select
            variant="outlined"
            :items="experienceOptions"
            v-model="job.experience"
            label="Experience"
            placeholder="Select Experience"
            density="compact"
          
          ></v-select>
    
          <v-text-field
            variant="outlined"
            v-model="job.companywebsite"
            label=" Company Website"
            placeholder="Website"
            density="compact"
            
          ></v-text-field>
        
      </v-card-text>

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn
          text="Update"
          @click="update(job.id)"
          
        ></v-btn>
        <v-btn
          text="Close Dialog"
          @click="dialog = false"
          
        ></v-btn>
      </v-card-actions>
    </v-card>
</v-dialog>
  </template>
      <script >
     
      import axios from "axios";
  import DxButton from "devextreme-vue/button";
  import dxGridStore from "../composition/dxGridStore";
  import { ref, onMounted } from "vue";
  import {
    DxPaging,
  
    DxToolbarItem,
} from 'devextreme-vue/data-grid';
  export default {
    name: "draftjob",
    components: {
      DxButton,
      DxPaging, DxToolbarItem,
    },
    setup() {
    
      const dialog=ref(false);
      const loadUrl = `/draft/jobs`;
      const pageSize = ref(10);
    
      const { dataSource } = dxGridStore(loadUrl, null,null,null, null);
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
   
      const checkItem = async (id) => {
        try {
          const response = await axios.post(`/draftjobs/${id}`);
          console.log(response.data); 
          window.location.reload();
        } catch (error) {
          console.error('Error duplicating item:', error);
        }
      };
      const edit=async(name)=>{
      
      console.log(name);
      job.value = name;
      console.log(job.value);
      dialog.value=true;
  
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
const update = (id) => {
console.log(id)
axios.post(`/post/jobs/${id}`,job.value).then((response) => {
    
    console.log(response.data);
    dialog.value=false;
    window.location.reload();
    
});
};
const deletejob = (e) => {
  console.log(e.id)
  axios.delete(`/post/delete/${e.id}`).then((response) => {
      
      console.log(response.data);
      dialog.value=false;
      window.location.reload();
      
  });

};

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

     
      return {
        dataSource, 
        checkItem,
        selectCategory,
      selectJobType,
      selectJobSkill,
      categories,
      jobTypes,
      jobSkills,
      update,
      experienceOptions,
      dialog,
      job,
      edit,
      deletejob,
      pageSize,
      };
    },
  };
  </script>