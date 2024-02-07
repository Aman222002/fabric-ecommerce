
<template>

  <div style="text-align: center; font-size: 30px; margin-top: 20px;">Applicants</div>
  
    <v-table>
      <thead>
        <tr>
          <th class="text-left">Name</th>
          <th class="text-left">Email</th>
          <th class="text-left">Applied Date</th>
          <th class="text-left">Post Name</th>
         
        </tr>
      </thead>
      <tbody>
        <tr v-for="application in applications" :key="application.id">
         
          <td>{{ application.user.name }}</td>
          <td>{{ application.user.email }}</td>
          <td>{{ application.applied_date }}</td>
          <td>{{ application.job.title }}</td>
        </tr>
      </tbody>
    </v-table>
   

  </template>
  
  <script>

import { ref } from 'vue';
  
  export default {
    name: 'PostDetail',
    props:{
            data:{
                type:Object,
                default: ()=>{{}},
            }
        },
    setup(props) {
      const applications = ref([]);
      applications.value = props.data;
      return {
        applications
      };
    },
  };
  </script>
  