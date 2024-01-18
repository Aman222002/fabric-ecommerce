<template>
    <v-table>
      <thead>
        <tr>
          <th class="text-left">Id</th>
          <th class="text-left">Company Name</th>
          <th class="text-left">Job Title</th>
          <th class="text-left">Vacancy</th>
          <th class="text-left">Salary</th>
          <th class="text-left">Created At</th>
          <th class="text-left">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="job in jobs" :key="job.id">
          <td>{{ job.id }}</td>
          <td>{{ job.company_name }}</td>
          <td>{{ job.title }}</td>
          <td>{{ job.vacancy }}</td>
          <td>{{ job.salary }}</td>
          <td>{{ job.created_at }}</td>
          <td>
            <v-btn @click="openEditDialog(job.id)" color="primary">Edit</v-btn>
            <v-btn @click="deleteItem(job.id)" color="error">Delete</v-btn>
          </td>
        </tr>
      </tbody>
    </v-table>
    <v-dialog v-model="editDialog" max-width="500">
    <v-card>
      <v-card-title>Edit Job</v-card-title>
      <v-card-text>
        <v-text-field v-model="editedJob.title" label="Job Title"></v-text-field>
        <v-text-field v-model="editedJob.vacancy" label="Vacancy"></v-text-field>
        <v-text-field v-model="editedJob.experience" label="Experience"></v-text-field>
        <v-text-field
              v-model="editedJob.salary"
              label="Salary"
              placeholder="Salary"
            ></v-text-field>
      </v-card-text>
      <v-card-actions>
        <v-btn @click="saveEditedJob(editedJob.id)">Save</v-btn>
        <v-btn @click="closeEditDialog">Close</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>

  </template>
  
  <script>

import { onMounted, ref } from 'vue';
  
  export default {
    name: 'JobCrud',
    setup() {
     
      const jobs = ref([]);
      const editDialog = ref(false);
    const editedJob = ref({
      title: "",
      vacancy: "",
      experience: "",
      salary: "",
    });
    
       const fetchJobs= () =>{
        try{
            axios.get('/post/jobs').then((response)=>{
                jobs.value= response.data.data;
            })
        }catch(err){
            console.log(err);
        }
       }
      const openEditDialog = (id) => {
        console.log(id)
        try {
        axios.get(`/post/edit/${id}`).then((response) => {
            if (response.data.status) {
                editedJob.value = response.data.data;
                console.log(response.data);
            } else {
                console.log(' request was not successful:', response.data.message);  
            }
        });
    } catch (err) {
        console.log(err);
    }
    editDialog.value = true;
};
    const saveEditedJob = (id) => {
      try{
         axios.post(`/post/jobs/${id}`, editedJob.value).then((response)=>{
          window.location.reload();
         })
      }catch(err){
        console.log(err);
      }
      closeEditDialog();
    };
    const closeEditDialog = () => {
      editDialog.value = false;
      editedJob.value = {}; 
    };

    const deleteItem = (id) => {
      try{
         axios.post(`/post/delete/${id}`).then((response)=>{
          window.location.reload();
         })
      }catch(err){
        console.log(err);
      }
    };
      onMounted(() => {
      fetchJobs();

    });
      return {
        jobs,
        editDialog,
      editedJob,
      openEditDialog,
      saveEditedJob,
      closeEditDialog,
      deleteItem,
      
      };
    },
  };
  </script>
  