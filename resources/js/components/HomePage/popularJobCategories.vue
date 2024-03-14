<template>
  <div class="popular_job_categories">
    <div class="sec-title text-center">
      <h2>Popular Job Categories</h2>
      <div class="text">2020 jobs live - 293 added today.</div>
    </div>
    <v-container class="w-75 mb-6">
      <v-row align="center" justify="center">
        <v-col
          cols="12"
          class="popular_col mb-5"
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
              <a id="categoryName" @click="findJob(category.name)"> {{ category.name }}</a>
            </template>
            <!-- <v-card-text> ({{ popularJob.subtitle }}) </v-card-text> -->
          </v-card>
          <!-- 
          <v-card class="mx-auto">
            <v-list-item>
              <v-card-title class="p-0"
                ><a href="#"> {{ popularJob.title }}</a>
              </v-card-title>
              <v-card-text class="pb-0">
                ({{ popularJob.subtitle }})
              </v-card-text>
            </v-list-item>
          </v-card> -->
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<!-- <script>
export default {
  data: () => ({
    popularJob: [
      {
        id: "1",
        title: "Accounting / Finance",
        subtitle: "2 open positions",
        icon: "mdi-account",
      },
      {
        id: "2",
        title: "Marketing",
        subtitle: "86 open positions",
        icon: "mdi-marker",
      },
      {
        id: "3",
        title: "Design",
        subtitle: "43 open positions",
        icon: "mdi-material-design",
      },
      {
        id: "4",
        title: "Development",
        subtitle: "43 open positions",
        icon: "mdi-code-braces",
      },
      {
        id: "5",
        title: "Human Resource",
        subtitle: "43 open positions",
        icon: "mdi-star-three-points",
      },
      {
        id: "6",
        title: "Automotive Jobs",
        subtitle: "43 open positions",
        icon: "mdi-account-supervisor",
      },
      {
        id: "6",
        title: "Customer Service",
        subtitle: "43 open positions",
        icon: "mdi-headphones",
      },
      {
        id: "7",
        title: "Health and Care",
        subtitle: "43 open positions",
        icon: "mdi-bottle-tonic-plus-outline",
      },
      {
        id: "8",
        title: "Project Management",
        subtitle: "43 open positions",
        icon: "mdi-paperclip",
      },
    ],
  }),
};
</script> -->
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
    const findJob = (name) =>{
      console.log(name);
      window.location.href = "/jobs-detail?category=" + name;
    }
    const fetchCategories = async () => {
      try {
        axios.get("/categories").then((response) => {
          categories.value = response.data;

          console.log(response.data);
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
