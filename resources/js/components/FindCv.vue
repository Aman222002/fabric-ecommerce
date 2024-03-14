<template>
  <form class="job_search_form">
    <v-row no-gutters>
      <v-col cols="12">
        <h3>Find candidates:</h3>
      </v-col>
      <v-col sm="12" md="12" lg="5" xl="5">
        <v-sheet>
          <v-text-field
            v-model="jobTitle"
            label="Job title, keywords, or company"
            placeholder="Job title, keywords, or company"
            prepend-inner-icon="mdi-magnify"
            outlined
            clearable
          ></v-text-field>
        </v-sheet>
      </v-col>
      <p class="line"></p>
      <v-col sm="12" md="12" lg="4" xl="4">
        <v-sheet>
          <v-text-field
            v-model="location"
            label="City or postcode"
            placeholder="City or postcode"
            prepend-inner-icon="mdi-map-marker-outline"
            outlined
            clearable
          ></v-text-field>
        </v-sheet>
      </v-col>
      <v-col sm="12" md="4" lg="2" xl="2">
        <v-sheet>
          <v-btn @click="searchJobs" block class="mt-2">Search</v-btn>
        </v-sheet>
      </v-col>
    </v-row>
  </form>

  <!-- <v-row>
    <v-col cols="12" md="6"> </v-col>
    <v-col cols="12" md="6"> </v-col>
  </v-row>
  <v-row>
    <v-col>
      <v-btn @click="searchJobs" color="primary">Search</v-btn>
    </v-col>
  </v-row> -->
</template>
<script>
import { ref } from "vue";

export default {
  name: "FindCv",
  setup() {
    const jobTitle = ref("");
    const location = ref("");
    const searchJobs = () => {
      console.log("Searching for:", jobTitle.value, "in", location.value);
    };
    return {
      jobTitle,
      location,
      searchJobs,
    };
  },
};
</script>

<style>
form.job_search_form .v-field__overlay {
  background: transparent;
}

form.job_search_form .v-sheet {
  position: relative;
}
</style>
