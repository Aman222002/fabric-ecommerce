<template>
  <div class="popular_job_categories">
    <div class="sec-title text-center">
      <h2>Popular Job Categories</h2>
     
    </div>
    <v-container class="w-75 mb-6">
      <v-row align="center" justify="center">
        <v-col
          cols="12"
          class="popular_col mb-0"
          sm="12"
          md="6"
          lg="4"
          xl="4"
          v-for="(category, index) in categories"
          :key="index"
          v-model="job.category"
        >
          <v-card class="mx-auto" prepend-icon="mdi-briefcase">
            <template v-slot:title>
              <a id="categoryName" @click="findJob(category.name)">
                {{ category.name }}</a
              >
           
            </template>
          </v-card>
    
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>
<script>
import { ref, onMounted } from "vue";
import axios from "axios";
export default {
  name: "popularJobCategories",
  setup() {
    const job = ref({
      category: "",
    });
    const categories = ref([]);
    const findJob = (name) => {
      console.log(name);
      var newName = name.trim();
      window.location.href =
        "/find-job?category=" + encodeURIComponent(newName);
      // window.location.href = "/jobs-detail?category=" + name;
    };
    const fetchCategories = async () => {
      try {
        axios.get("/categories").then((response) => {
          categories.value = response.data;

          // console.log(response.data);
        });
      } catch (error) {
        console.error("Error fetching categories:", error);
      }
    };

    onMounted(() => {
      fetchCategories();
    });

    return {
      job,
      categories,
      findJob,
    };
  },
};
</script>
