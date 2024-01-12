<template>
  <v-container>
    <v-row>
      <v-col cols="12" md="6">
        <v-text-field
          v-model="jobTitle"
          label="Job Title"
          outlined
          clearable
        ></v-text-field>
      </v-col>
      <v-col cols="12" md="6">
        <v-text-field
          v-model="location"
          label="Location"
          outlined
          clearable
        ></v-text-field>
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
export default {
  data() {
    return {
      jobTitle: '',
      location: '',
    };
  },
  methods: {
    searchJobs() {
      console.log('Searching for:', this.jobTitle, 'in', this.location);
    },
  },
};
</script>
