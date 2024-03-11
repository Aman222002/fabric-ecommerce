<template>
  <p style="text-align: center; font-size: 20px; margin-top: 20px">My Jobs</p>
  <DxDataGrid
    :show-borders="true"
    :data-source="dataSource"
    ref="dataGridRef"
    @editing-start="logEvent(e)"
  >
    <DxSearchPanel :visible="true" :placeholder="'Search'" :width="300" />
    <DxEditing
      :allow-adding="true"
      :allow-updating="true"
      :allow-deleting="true"
      :use-icons="true"
      mode="popup"
    />
    <DxToolbar>
      <DxGridItem template="dropDown2" :location="'before'" />
      <DxGridItem name="searchPanel" :location="'after'"></DxGridItem>
    </DxToolbar>
    <DxLoadPanel :enabled="true" />
    <DxSearchPanel :visible="true" />
    <DxColumn
      caption="Action"
      :allow-editing="false"
      cell-template="customButtonTemplate"
      :visible="noeditcolumn"
    >
    </DxColumn>
    <DxColumn data-field="title" data-type="string"> </DxColumn>
    <DxColumn data-field="location" data-type="string"></DxColumn>
    <DxColumn data-field="vacancy" data-type="string"> </DxColumn>
    <DxColumn data-field="salary" data-type="string"> </DxColumn>
    <DxColumn data-field="description" data-type="string"> </DxColumn>
    <DxColumn data-field="company_website" data-type="url"> </DxColumn>
    <DxColumn
      caption="Select Category"
      cell-template="categorydropdown"
      edit-cell-template="categorydropdown"
      :visible="showcolumn"
    >
    </DxColumn>
    <template #categorydropdown="{ data: rowData }">
      <DxDropDownBox
        label="Select Category"
        data-type="dropdown"
        labelMode="floating"
      >
        <DxList
          :data-source="categories"
          selection-mode="single"
          @item-click="selectStatus"
        />
      </DxDropDownBox>
    </template>
    <DxColumn
      caption="Select JobType"
      cell-template="jobtypedropdown"
      edit-cell-template="jobtypedropdown"
      :visible="showcolumn"
    >
    </DxColumn>

    <template #jobtypedropdown="{ data: rowData }">
      <DxDropDownBox label="Select JobType" labelMode="floating">
        <DxList
          :data-source="jobTypes"
          selection-mode="single"
          @item-click="selectStatus"
        />
      </DxDropDownBox>
    </template>
    <DxColumn
      caption="Select Skill"
      cell-template="skilldropdown"
      edit-cell-template="skilldropdown"
      :visible="showcolumn"
    >
    </DxColumn>

    <template #skilldropdown="{ data: rowData }">
      <DxDropDownBox label="Select skill" labelMode="floating">
        <DxList
          :data-source="jobSkills"
          selection-mode="single"
          @item-click="selectStatus"
        />
      </DxDropDownBox>
    </template>
    <DxColumn
      caption="Select Experience"
      cell-template="experiencedropdown"
      edit-cell-template="experiencedropdown"
      :visible="showcolumn"
    >
    </DxColumn>

    <template #experiencedropdown="{ data: rowData }">
      <DxDropDownBox label="Select skill" labelMode="floating">
        <DxList
          :data-source="experienceOptions"
          selection-mode="single"
          @item-click="selectStatus"
        />
      </DxDropDownBox>
    </template>
    <DxColumn
      caption="Qualification"
      data-field="qualifications"
      data-type="string"
      :visible="showcolumn"
    ></DxColumn>
    <template #dropDown2>
      <DxDropDownBox
        :accept-custom-value="true"
        @value-change="selectStatus"
        label="Select status"
        labelMode="floating"
        v-model:value="selectedStatus"
        v-model:opened="DropDown2"
      >
        <DxList
          :data-source="items"
          selection-mode="single"
          @item-click="selectStatus"
        >
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
          <v-list>
            <v-list-item
              :v-for="item in jobActions"
              class="dropdown"
              @click="duplicateJob(data.row.data.id, item.text)"
              >{{ item.text }}</v-list-item
            >
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
    const job = ref({
      id: "",
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
    const dialog = ref(false);
    const categories = ref([]);
    const params = ref({});
    const selectedStatus = ref("Published");
    const selectStatus = (e) => {
      const value = e.itemData.text;
      params.value = { type: value };
      selectedStatus.value = value;
      DropDown2.value = false;
      refreshTable(dataGridRef);
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
    const logEvent = (e) => {};
    const duplicateJob = (id, value) => {
      try {
        axios
          .post("/jobs/draft/", {
            params: {
              id: id,
              type: value,
            },
          })
          .then((response) => {
            if (response.data.status === true) {
              window.Swal.fire({
                toast: true,
                position: "top-end",
                timer: 2000,
                showConfirmButton: false,
                icon: "success",
                title: "Job have been added to draft successfully!",
              });
            }
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
            } else if (error.response.status == "403") {
              window.Swal.fire({
                toast: true,
                position: "top-end",
                timer: 2000,
                showConfirmButton: false,
                icon: "error",
                title: `You have posted number of allowed post can't post more`,
              });
            } else if (error.response.status == "406") {
              window.Swal.fire({
                toast: true,
                position: "top-end",
                timer: 2000,
                showConfirmButton: false,
                icon: "error",
                title: `You already posted this job`,
              });
            }
          });
        console.log(response);
      } catch (err) {}
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
    console.log("datasource", dataSource);
    const edit = async (data) => {
      console.log(data);
      const transformedData = {
        id: data.id,
        title: data.title,
        category_id: data.category_id,
        job_type_id: data.job_type_id,
        vacancy: data.vacancy,
        salary: data.salary,
        location: data.location,
        description: data.description,
        qualifications: data.qualifications,
        experience: data.experience,
        company_website: data.company_website,
        created_at: data.created_at,
        job_skill: data.skill_id,
      };
      console.log(transformedData);
      job.value = transformedData;
      console.log(job.value);
      dialog.value = true;
    };
    const checkItem = async (id) => {
      try {
        const response = await axios.post(`/jobs/application/${id}`);
        console.log(response.data);
      } catch (error) {
        console.error("Error duplicating item:", error);
      }
    };
    const fetchCategories = () => {
      try {
        axios.get("/categories").then((response) => {
          categories.value = response.data.map((category) => category.name);
          console.log("categories", categories.value);
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
          jobTypes.value = response.data.map((job) => job.name);
          console.log("jobtype", jobTypes.value);
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
    const update = (id) => {
      axios.post(`/post/jobs/${id}`, job.value).then((response) => {
        console.log(response.data);
        dialog.value = false;
        window.location.reload();
      });
    };
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
      edit,
      dialog,
      job,
      categories,
      jobSkills,
      jobTypes,
      experienceOptions,
      fetchCategories,
      selectCategory,
      selectJobSkill,
      selectJobType,
      fetchJobTypes,
      fetchJobSkill,
      update,
      deletejob,
      selectStatus,
      selectedStatus,
      checkItem,
      items,
      params,
      fetchJobs,
      duplicateJob,
      postJob,
      dataGridRef,
      DropDown2,
      jobActions,
      logEvent,
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
\
