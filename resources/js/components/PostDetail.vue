
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
        <td><v-dialog width="500">
            <template v-slot:activator="{ props }">
              <v-btn v-bind="props" @click="checkItem(application.id)" color="success" style="margin-left: 10px;">View
                Details</v-btn>
              <!-- <v-btn v-bind="props" text="View Details" color="primary"> </v-btn> -->
            </template>
            <template v-slot:default="{ isActive }">
              <v-card title="User Details">
                <v-card-text>
                  <v-sheet width="300" class="mx-auto">
                    <v-form @submit.prevent>
                      <v-text-field v-model="firstName" :rules="rules" label="First name"></v-text-field>
                      <v-btn type="submit" block class="mt-2">Submit</v-btn>
                    </v-form>
                  </v-sheet>
                </v-card-text>

                <v-card-actions>
                  <v-spacer></v-spacer>

                  <v-btn text="Close Dialog" @click="isActive.value = false"></v-btn>
                </v-card-actions>
              </v-card>
            </template>
          </v-dialog></td>
      </tr>
    </tbody>
  </v-table>
</template>
  
<script>

import { ref } from 'vue';
import axios from 'axios';
export default {
  name: 'PostDetail',
  props: {
    data: {
      type: Object,
      default: () => { { } },
    }
  },
  setup(props) {
    const applications = ref([]);
    applications.value = props.data;
    const checkItem = (id) => {
      axios.post(`/jobs/application/${id}/markAsSeen`, { id: id })
    }
    return {
      applications,
      checkItem
    };
  },
};
</script>
  