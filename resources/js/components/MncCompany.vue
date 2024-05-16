<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <v-card class="mt-5" style="background-color: #0146a6; color: #fff">
          <v-card-title class="text-center"
            >Welcome to MNCs Company</v-card-title
          >
          <v-card-subtitle class="text-center"
            >Explore Opportunities with Global Leaders</v-card-subtitle
          >
          <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="4">
                  <v-img
                    class="image-with-transition"
                    src="/storage/assets/mncs.png"
                    alt="MNCs Image"
                    height="300"
                  ></v-img>
                </v-col>
                <v-col cols="4">
                  <v-img
                    class="image-with-transition"
                    src="/storage/assets/google.jfif"
                    alt="MNCs Image"
                    height="300"
                  ></v-img>
                </v-col>
                <v-col cols="4">
                  <v-img
                    class="image-with-transition"
                    src="/storage/assets/ibm.jfif"
                    alt="MNCs Image"
                    height="300"
                  ></v-img>
                </v-col>
                <v-col cols="4">
                  <v-img
                    class="image-with-transition"
                    src="/storage/assets/microsoft.jfif"
                    alt="MNCs Image"
                    height="300"
                  ></v-img>
                </v-col>
                <v-col cols="4">
                  <v-img
                    class="image-with-transition"
                    src="/storage/assets/infosis.jfif"
                    alt="MNCs Image"
                    height="300"
                  ></v-img>
                </v-col>
                <v-col cols="4">
                  <v-img
                    class="image-with-transition"
                    src="/storage/assets/deloitte.jfif"
                    alt="MNCs Image"
                    height="300"
                  ></v-img>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <v-row class="mt-5">
      <v-col cols="12" md="4" v-for="company in companies" :key="company.id">
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
import { ref, onMounted } from "vue";
export default {
  name: "MncCompany",
  setup() {
    const companies = ref([]);
    const fetchData = async () => {
      try {
        const response = await fetch("api/companies");
        const data = await response.json();
        companies.value = data;
      } catch (error) {
        console.error("Error fetching data:", error);
      }
    };
    onMounted(() => {
      fetchData();
    });

    return {
      companies,
    };
  },
};
</script>
<!-- 
<style scoped>
.company-card:hover {
    background-color: red;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
}

.image-with-transition {
    transition: transform 0.3s ease-in-out;
}

.image-with-transition:hover {
    transform: scale(1.1);
}
</style>
   -->