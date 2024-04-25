<template>
  <p style="text-align: center; font-size: 20px; margin-top: 20px">My Jobs</p>
  <DxDataGrid :show-borders="true" :data-source="dataSource" ref="dataGridRef" @editing-start="logEvent"
    @saving="saveEvent">
    <DxSearchPanel :visible="true" :placeholder="'Search'" :width="300" />
    <DxEditing :allow-adding="true" :allow-updating="true" :allow-deleting="true" :use-icons="true" mode="popup" />
    <DxToolbar>
      <DxGridItem template="dropDown2" :location="'before'" />
      <DxGridItem name="searchPanel" :location="'after'"></DxGridItem>
    </DxToolbar>
    <DxLoadPanel :enabled="true" />
    <DxSearchPanel :visible="true" />
    <DxColumn caption="Action" :allow-editing="false" cell-template="customButtonTemplate" :visible="noeditcolumn">
</DxColumn>
    <DxColumn data-field="title" data-type="string"> </DxColumn>
    <DxColumn data-field="location" data-type="string"></DxColumn>
    <DxColumn data-field="vacancy" data-type="string"> </DxColumn>
    <DxColumn data-field="salary" edit-cell-template="salarytemplate"> </DxColumn>
    <DxColumn data-field="description" data-type="string"> </DxColumn>
    <DxColumn data-field="company_website" data-type="url"> </DxColumn>
    <DxColumn caption="Select Category" edit-cell-template="categorydropdown" :visible="showcolumn">
    </DxColumn>
    <template #salarytemplate="{ data }">
      <div>
        <v-select v-model="salaryType" :items="['fixed', 'range']" label="Salary Type" density="compact"
          variant="outlined"></v-select>
        <template v-if="shouldDisplayRangeInput(data)">
          <v-text-field variant="outlined" v-model="minSalary" label="Minimum Salary" placeholder="Minimum Salary"
            density="compact" style="margin-top: 10px;"></v-text-field>
          <v-text-field variant="outlined" v-model="maxSalary" label="Maximum Salary" placeholder="Maximum Salary"
            density="compact" style="margin-top: 10px;"></v-text-field>
        </template>
        <template v-else>
          <v-text-field variant="outlined" v-model="salary" label="Salary" placeholder="Salary"
            density="compact"></v-text-field>
        </template>
      </div>
    </template>

    <template #categorydropdown>
      <DxDropDownBox :accept-custom-value="true" label="Select Category" data-type="dropdown" labelMode="floating"
        v-model:value="selectedCategory" v-model:opened="datadropdown" @value-change="selectCategory">
        <DxList :data-source="categories" selection-mode="single" @item-click="selectCategory" />
      </DxDropDownBox>
    </template>
    <DxColumn caption="Select JobType" cell-template="jobtypedropdown" edit-cell-template="jobtypedropdown"
      :visible="showcolumn">
    </DxColumn>

    <template #jobtypedropdown>
      <DxDropDownBox :accept-custom-value="true" label="Select JobType" labelMode="floating"
        v-model:value="selectedJobType" v-model:opened="jobtypedropdown">
        <DxList :data-source="jobTypes" selection-mode="single" @item-click="selectJobType" />
      </DxDropDownBox>
    </template>
    <DxColumn caption="Select Skill" cell-template="skilldropdown" edit-cell-template="skilldropdown"
      :visible="showcolumn">
    </DxColumn>

    <template #skilldropdown>
      <DxDropDownBox :accept-custom-value="true" label="Select skill" labelMode="floating" v-model:value="selectedSkill"
        v-model:opened="skilldropdown">
        <DxList :data-source="jobSkills" selection-mode="single" @item-click="selectSkill" />
      </DxDropDownBox>
    </template>
    <DxColumn caption="Select Experience" cell-template="experiencedropdown" edit-cell-template="experiencedropdown"
      :visible="showcolumn">
    </DxColumn>

    <template #experiencedropdown>
      <DxDropDownBox :accept-custom-value="true" label="Select skill" labelMode="floating"
        v-model:value="selectedExperience" v-model:opened="experiencedropdown">
        <DxList :data-source="experienceOptions" selection-mode="single" @item-click="selectExperience" />
      </DxDropDownBox>
    </template>
    <DxColumn caption="Qualification" data-field="qualifications" data-type="string" :visible="showcolumn"></DxColumn>
    <template #dropDown2>
      <DxDropDownBox :accept-custom-value="true" @value-change="selectStatus" label="Select status" labelMode="floating"
        v-model:value="selectedStatus" v-model:opened="DropDown2">
        <DxList :data-source="items" selection-mode="single" @item-click="selectStatus">
        </DxList>
      </DxDropDownBox>
    </template>
    <template #customButtonTemplate="{ data }">
      <v-menu>
        <template v-slot:activator="{ props }">
          <v-btn height="30" color="primary" v-bind="props">
            <v-icon>mdi-menu-down</v-icon>
          </v-btn>
        </template>
        <v-card>
          <v-list v-for="item in jobActions" :key="item.text">
            <template v-if="selectedStatus === 'Draft'">
              <v-list-item class="dropdown" @click="duplicateJob(data.row.data.id, item.text)">
                {{ item.text }}
              </v-list-item>
            </template>
            <template v-else>
              <v-list-item v-if="item.text !== 'Post Job'" class="dropdown"
                @click="duplicateJob(data.row.data.id, item.text)">
                {{ item.text }}
              </v-list-item>
            </template>
          </v-list>
        </v-card>
      </v-menu>
    </template>
    <DxMasterDetail :enabled="true" template="masterTemplate" />

    <template #masterTemplate="{ data: cellInfo }">
      <masterTemplate :application-info="cellInfo.data" />
    </template>
  </DxDataGrid>
</template>

<script>
import axios from "axios";
import dxGridStore from "../composition/dxGridStore";
import masterTemplate from "./MasterdetailApplicant.vue";
import { ref, onMounted } from "vue";
export default {
  name: "JobCrud",
  components: {
    masterTemplate,
  },
  setup() {
    const loadUrl = `/post/jobs/`;
    const deleteUrl = `/post/delete`;
    const updateURL = `/post/jobs`;
    const dataGridRef = ref(null);
    const DropDown2 = ref(false);
    const showcolumn = ref(false);
    const noeditcolumn = ref(true);
    const salary = ref("");
    const salaryType = ref("fixed");
    const minSalary = ref("");
    const maxSalary = ref("");
    const job = ref({
      title: "",
      category: "",
      jobType: "",
      vacancy: "",
      salaryType: "fixed",
      minSalary: "",
      maxSalary: "",
      location: "",
      description: "",
      qualifications: "",
      experience: "",
      companywebsite: "",
      jobSkill: "",
    });

    const dialog = ref(false);
    const categories = ref([]);
    const allCategories = ref([]);
    const allJobType = ref([]);
    const allSkills = ref([]);
    const params = ref({});
    const job_Id = ref();
    const selectedStatus = ref("All");
    const selectedCategory = ref("");
    const selectedJobType = ref("");
    const selectedSkill = ref("");
    const selectedExperience = ref("");
    const datadropdown = ref(false);
    const jobtypedropdown = ref(false);
    const skilldropdown = ref(false);
    const experiencedropdown = ref(false);
    const selectStatus = (e) => {
      const value = e.itemData.text;
      params.value = { type: value };
      selectedStatus.value = value;
      DropDown2.value = false;
      refreshTable(dataGridRef);
    };
    const selectCategory = (e) => {
      let value = e.itemData;
      selectedCategory.value = value;
      const foundCategory = allCategories.value.find(item => item.name === selectedCategory.value);
      if (foundCategory) {
        value = foundCategory.id;
      } else {
        null;
      }
      // console.log(value);
      params.value = { ...params.value, category_id: value };
      datadropdown.value = false;
      // refreshTable(dataGridRef);
    };
    const selectJobType = (e) => {
      let value = e.itemData;
      selectedJobType.value = value;
      const foundJobType = allJobType.value.find(item => item.name === selectedJobType.value);
      if (foundJobType) {
        value = foundJobType.id;
      } else {
        null;
      }
      params.value = { ...params.value, job_type_id: value };
      jobtypedropdown.value = false;
    };
    const selectSkill = (e) => {
      let value = e.itemData;
      selectedSkill.value = value;
      const foundSkill = allSkills.value.find(item => item.skill_name === selectedSkill.value);
      // console.log(foundSkill);
      if (foundSkill) {
        value = foundSkill.id;
      } else {
        null;
      }
      params.value = { ...params.value, skill_id: value };
      skilldropdown.value = false;
    };
    const selectExperience = (e) => {
      const value = e.itemData;
      selectedExperience.value = value;

      params.value = { ...params.value, experience: value };
      experiencedropdown.value = false;
    };
    const items = ref([
      {
        text: "All",
        value: 1,
      },
      {
        text: "Published",
        value: 2,
      },
      {
        text: "Expired",
        value: 3,
      },
      {
        text: "Draft",
        value: 4,
      },
    ]);
    const jobActions = ref([
      {
        text: "Duplicate",
      },
      {
        text: "Post Job",
      },
    ]);
    const fetchJobs = (value) => {
      console.log(value);
      params.value = { type: value };
      console.log(params.value);
      refreshTable(dataGridRef);
      DropDown2.value = false;
    };
    const logEvent = (e) => {
      // console.log(e);
      job_Id.value = e.data.id;
      // console.log(job_Id.value);
      selectedExperience.value = e.data.experience;
      const categoryId = e.data.category_id;
      const skillId = e.data.skill_id;
      const JobTypeId = e.data.job_type_id;
      // console.log(categoryId);
      // console.log(allCategories.value);
      const foundCategory = allCategories.value.find(item => item.id === categoryId);
      if (foundCategory) {
        selectedCategory.value = foundCategory.name;
      } else {
        null;
      }
      if (e.data.salary.includes("-")) {
        const [min, max] = e.data.salary.split("-");
        salaryType.value = "range";
        minSalary.value = min.trim();
        maxSalary.value = max.trim();
      } else {
        salary.value = e.data.salary;
        salaryType.value = "fixed";
      }
      const foundSkill = allSkills.value.find(item => item.id === skillId);
      // console.log(foundSkill);
      if (foundSkill) {
        selectedSkill.value = foundSkill.skill_name;
      } else {
        null;
      }
      const foundJobType = allJobType.value.find(item => item.id === JobTypeId);
      if (foundJobType) {
        selectedJobType.value = foundJobType.name;
      } else {
        null;
      }
    };
    const saveEvent = (e) => {
      if (salaryType.value === 'range') {
    salary.value = `${minSalary.value}-${maxSalary.value}`;
    
  } 
  params.value.salary = salary.value;
  console.log(params.value.salary);
      if (e.changes == 0) {
        if (params.value.category_id || params.value.skill_id || params.value.job_type_id  || params.value.salary) {
         
      console.log(params.value);
          axios.post(`/post/jobs/${job_Id.value}`, {
            params: params.value,
         
          }).then((response) => {
            const keys = Object.keys(params.value);
            for (let i = 1; i < keys.length; i++) {
              delete params.value[keys[i]];
            }
            // console.log(params.value);
            refreshTable(dataGridRef);
          })

        };
      }
    }
    const duplicateJob = (id, value) => {
      // console.log('hello');
      try {
        axios.post("/jobs/draft/", {
          params: {
            id: id,
            type: value,
          },
        }).then((response) => {
          if (response.data.status === true) {
            window.Swal.fire({
              toast: true,
              position: 'top-end',
              timer: 2000,
              showConfirmButton: false,
              icon: 'success',
              title: 'Added',
            });
            refreshTable(dataGridRef);
          }
        }).catch((error) => {
          console.log(error);
          if (error.response.status == '402') {
            window.Swal.fire({
              toast: true,
              position: 'top-end',
              timer: 2000,
              showConfirmButton: false,
              icon: 'error',
              title: `You don't have a active plan buy a plan or renew your plan`,
            });
          }
          else if (error.response.status == '403') {
            window.Swal.fire({
              toast: true,
              position: 'top-end',
              timer: 2000,
              showConfirmButton: false,
              icon: 'error',
              title: `You have posted number of allowed post can't post more`,
            });
          }
          else if (error.response.status == '406') {
            window.Swal.fire({
              toast: true,
              position: 'top-end',
              timer: 2000,
              showConfirmButton: false,
              icon: 'error',
              title: `You already posted this job`,
            });
          }
        });
        console.log(response);
      } catch (err) { }
    };
    const postJob = (id) => {
      const response = axios.post(`/jobs/draft/${id}`);
      console.log(response);
    };
    const { dataSource, refreshTable } = dxGridStore(
      loadUrl,
      params,
      null,
      updateURL,
      deleteUrl
    );

    const checkItem = async (id) => {
      try {
        const response = await axios.post(`/jobs/application/${id}`);
        // console.log(response.data);
      } catch (error) {
        console.error("Error duplicating item:", error);
      }
    };
    const fetchCategories = () => {
      try {
        axios.get("/categories").then((response) => {
          categories.value = response.data.map((category) => category.name);
          allCategories.value = response.data;
          // console.log("categories", categories.value);
        });
      } catch (error) {
        console.error("Error fetching categories:", error);
      }
    };
    // const selectCategory = (selectedCategory) => {
    //   job.category = selectedCategory.name;
    // };

    const jobTypes = ref([]);
    const fetchJobTypes = async () => {
      try {
        axios.get("/jobtypes").then((response) => {
          jobTypes.value = response.data.map((job) => job.name);
          allJobType.value = response.data;
          // console.log("jobtype", jobTypes.value);
        });
      } catch (error) {
        console.error("Error fetching job types:", error);
      }
    };
    const jobSkills = ref([]);
    const fetchJobSkill = async () => {
      try {
        axios.get("/skill").then((response) => {
          jobSkills.value = response.data.map((skill) => skill.skill_name);
          allSkills.value = response.data;
        });
      } catch (error) {
        console.error("Error fetching job types:", error);
      }
    };
    // const selectJobSkill = (selectedJobSkill) => {
    //   job.jobSkill = selectedJobSkill.name;
    // };
    // const selectJobType = (selectedJobType) => {
    //   job.jobType = selectedJobType.name;
    // };
    const deletejob = (e) => {
      console.log(e.id);
      window.Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          axios
            .delete(`/post/delete/${e.id}`)
            .then((response) => {
              console.log(response.data);
              dialog.value = false;
              refreshTable(dataGridRef);
            })
            .catch((error) => {
              console.error("Error deleting job:", error);
            });
          refreshTable(dataGridRef);
        }
      });
    };
    const updateSalaryType = (newValue) => {
      salaryType.value = newValue;
    };
    const shouldDisplayRangeInput = (data) => {

      const salaryContainsRange = data.row.data.salary.includes("-");
      if (salaryContainsRange) {

        salaryType.value = "range";
      } else {

        salaryType.value = "fixed";
      }
      return salaryContainsRange;
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
    return {
      dataSource,
      showcolumn,
      noeditcolumn,
      refreshTable,
      dialog,
      job,
      categories,
      jobSkills,
      jobTypes,
      experienceOptions,
      fetchCategories,
      selectSkill,
      selectJobType,
      fetchJobTypes,
      fetchJobSkill,
      deletejob,
      selectStatus,
      selectedStatus,
      checkItem,
      items,
      params,
      fetchJobs,
      duplicateJob,
      postJob,
      dataGridRef, updateSalaryType,
      DropDown2,
      jobActions,
      logEvent,
      selectedCategory,
      selectCategory,
      datadropdown,
      selectExperience,
      selectedSkill,
      selectedJobType,
      selectedExperience,
      jobtypedropdown,
      skilldropdown,
      experiencedropdown,
      allCategories,
      allSkills,
      allJobType,
      salary, maxSalary, minSalary, salaryType, shouldDisplayRangeInput,
      saveEvent,
      job_Id
    };
  },
};
</script>

<style scoped>
.dropdown {
  cursor: pointer;
  font-family: "Kanit", sans-serif;
  color: #0a0c0c;
}

.dropdown:hover {
  color: white;
  background-color: #1976d2;
}

.v-list-item--density-default:not(.v-list-item--nav).v-list-item--one-line {
  padding-inline: 8px;
}

.v-list-item--density-default.v-list-item--one-line {
  min-height: 48px;
}

.border {
  border: 2px dashed #1976d2;
}
</style>
