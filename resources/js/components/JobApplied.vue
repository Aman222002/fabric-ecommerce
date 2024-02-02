<template>
    <div style="text-align: center; margin-top: 20px;">
        <h1>Jobs <span style="color: red;">Applied</span></h1>
    </div>
    <v-btn color="success" style="margin-top: 20px;"><a href="/company/post" style="text-decoration: none;">Apply For New Job</a></v-btn>
      <v-table>
        <thead>
          <tr style="font-size: 30px;">
          
            <th class="text-left">Job Title</th>
            <th class="text-left">Location</th>
            <th class="text-left">Salary</th>
            <th class="text-left">Applied At</th>
            <th class="text-left">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="jobApplications in jobApplication" :key="jobApplications.job.id" style="font-size: 23px;">
           
            <td>{{ jobApplications.job.title }}</td>
            <td>{{ jobApplications.job.location }}</td>
            <td>{{ jobApplications.job.salary }}</td>
            <td>{{ jobApplications.job.created_at }}</td>
            <td>
                <v-btn @click="deleteItem(jobApplications.job.id)" color="error">Delete</v-btn>
            </td>
          </tr>
        </tbody>
      </v-table>
    </template>
    <script>

    import { onMounted, ref } from 'vue';
      
      export default {
        name: 'JobApplied',
        props:{
            data:{
                type:Array,
                default: ()=>{[]},
            }
        },
        setup(props) {
            console.log(props.data);
          const jobApplication = ref([]);
          jobApplication.value=props.data;

          const deleteItem = (id) => {
      
    };
              return {
            jobApplication,
            deleteItem,
          };
        
        },
      };
      </script>