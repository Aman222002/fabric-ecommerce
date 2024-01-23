<template>
  <v-container>
    <v-row>
      <v-col cols="12" md="6">
        <v-text-field v-model="jobTitle" label="Job Title" outlined clearable></v-text-field>
      </v-col>
      <v-col cols="12" md="6">
        <v-text-field v-model="location" label="Location" outlined clearable></v-text-field>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <v-btn @click="searchJobs" color="primary">Search</v-btn>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
import { ref } from 'vue';

export default {
  name: "FindCv",
  setup() {
    const jobTitle = ref('');
    const location = ref('');
    const searchJobs = () => {
      console.log('Searching for:', jobTitle.value, 'in', location.value);
    };
    return {
      jobTitle,
      location,
      searchJobs,
    };
  },
};
</script>
