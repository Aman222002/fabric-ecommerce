<template>

  <div style="text-align: center; font-size: 30px; margin-top: 20px;">Applicants</div>
  
  <v-table>
    <thead>
      <tr>
        <th class="text-left">Name</th>
        <th class="text-left">Email</th>
        <th class="text-left">Applied Date</th>
        <th class="text-left">Post Name</th>
        <th class="text-left">Action</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="application in applications" :key="application.id">
        <td>{{ application.user.name }}</td>
        <td>{{ application.user.email }}</td>
        <td>{{ application.applied_date }}</td>
        <td>{{ application.job.title }}</td>
        <td> 
          <v-btn @click="view(application)" color="success">View</v-btn>
        </td>
      </tr>
    </tbody>
  </v-table>

  <v-dialog v-model="modalOpen" max-width="70%" max-height="auto">
    <v-card>
      <v-card-title>
        Applicant Details
      </v-card-title>
      <v-card-text>
        <div v-if="selectedApplication">
          <div style="font-size: 25px;" >Name:<span style="margin-left: 70%; font-size: 20px;">{{ selectedApplication.user.name }}</span> </div>
          <div style="font-size: 25px;">Email: <span style="margin-left: 70%; font-size: 20px;">{{ selectedApplication.user.email }}</span></div>
          <div style="font-size: 25px;">Post Name:<span style="margin-left: 65%; font-size: 20px;">{{selectedApplication.job.title }}</span></div><br>
          <div class="qualifications-table">
            <p style="font-size: 25px;">User Qualification:</p>
            <table>
              <thead>
                <tr>
                  <th>Education Type</th>
                  <th>Starting Year</th>
                  <th>Passing Year</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="qualification in selectedApplication.user.qualifications" :key="qualification.id">
                  <td>{{ qualification.education_type }}</td>
                  <td>{{ qualification.starting_year }}</td>
                  <td>{{ qualification.passing_year }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="qualifications-table" >
            <p style="font-size: 25px;">User Experience:</p>
            <table>
              <thead>
                <tr>
                  <th>Company Name</th>
                  <th>Position</th>
                  <th>Starting-date</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="experiences in selectedApplication.user.experience" :key="experiences.id">
                  <td>{{ experiences.company_name }}</td>
                  <td>{{ experiences.position }}</td>
                  <td>{{ experiences.start_date }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="qualifications-table" >
            <p style="font-size: 25px;">User Address:</p>
            <table>
              <thead>
                <tr>
                  <th>address1</th>
                  <th>City</th>
                  <th>State</th>
                  <th>Pin Code</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="addresses in selectedApplication.user.address" :key="addresses.id">
                  <td>{{ addresses.address1 }}</td>
                  <td>{{ addresses.city }}</td>
                  <td>{{ addresses.state }}</td>
                  <td>{{ addresses.zip_code }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </v-card-text>
      <v-card-actions>
        <v-btn color="primary" @click="modalOpen = false">Close</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>

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
    const modalOpen = ref(false);
    const selectedApplication = ref(null);
    const view =(application)=> {
      selectedApplication.value = application;
      modalOpen.value = true;
    }
    return {
      applications,
      view,
      modalOpen,
      selectedApplication,
    };
  },
};
</script>

<style scoped>

.qualifications-table {
  margin-top: 20px;
  width: 100%;
  overflow-x: auto;
}

.qualifications-table table {
  width: 100%;
  border-collapse: collapse;
}

.qualifications-table th, .qualifications-table td {
  padding: 8px;
  border: 1px solid #ddd;
}

.qualifications-table th {
  background-color: #f2f2f2;
}
</style>
<!-- <template>
  
  <DxDataGrid id="grid" :show-borders="true" :data-source="dataSource" :repaint-changes-only="true">
    <DxEditing :allow-deleting="true" mode="row" />
            <DxSearchPanel :visible="true" />
            <DxScrolling mode="virtual" row-rendering-mode="virtual" />
          
            <DxScrolling mode="virtual" row-rendering-mode="virtual" />
            <DxColumn data-field="name" data-type="string">
               
            </DxColumn>
            <DxColumn data-field="email" data-type="string">   
            </DxColumn>
        </DxDataGrid>
        
</template>
    <script>

import dxGridStore from '../composition/dxGridStore';
export default {
  name: "Postdetail",
  props: {
    data: {
      type: Number,
      default: ()=>0,
    },
  },
  setup(props) {
    console.log(props.data)
    const loadUrl= `/jobs/application`;
        const { dataSource } = dxGridStore(loadUrl,null, null, null);
    return {
      dataSource,
    };
  
  },
};
</script> -->
