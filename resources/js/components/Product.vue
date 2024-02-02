<template>
  <v-container fluid>
    <div class="text-center">
      <p class="centered-heading" style="font-family: sans-serif; font-size: 30px;">How JobPath <span
          style="color: red;">helps you hire</span></p>
      <p style="margin-top: 10px;">How JobPath helps you hire
        Indeed helps you connect with talent, on desktop and mobile, <br>so you can make more quality hires faster.</p>
    </div>
    <div class="text-center">
      <p class="centered-heading" style="font-family: sans-serif; font-size: 30px;">Post A <span
          style="color: red;">Job</span></p>
      <p style="margin-top: 10px;">Quick & Easy Job Posting − Get Quality Applies</p>
    </div>
    <v-container>
      <v-row row="12">
        <v-col cols="4" v-for="plan in plans">
          <v-card class="mx-auto" max-width="400" max-height="440">
            <v-card-title class="headline bg-light-blue-lighten-5">{{ plan.name }}</v-card-title>
            <v-card-title>Price ${{ plan.price }}</v-card-title>
            <v-card-title>Duration {{ plan.duration }}</v-card-title>
            <v-card-title>Posts {{ plan.Posts_Allowed }}</v-card-title>
            <v-card-subtitle>For All Cities</v-card-subtitle>
            <v-card-text>
              Boost on Job Search Page, Job Branding <br>
              <br>
              <v-row row="5">
                <v-col cols="3">
                  <b>Quant.</b>
                </v-col>
                <v-col cols="4">
                  <v-text-field type="number" size="10" min="1" max="10"></v-text-field>
                </v-col>
              </v-row>
              <v-card-actions>
                <v-btn class="bg-primary mr-4 mt-1">Buy Now</v-btn>
                <v-btn class="bg-success mt-1" @click="additem">Add to Cart</v-btn>
              </v-card-actions>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
    <div class="text-center">
      <p class="centered-heading" style="font-family: sans-serif; font-size: 30px;">KEY <span style="color: red;">
          BENEFITS</span></p>
      <p style="margin-top: 10px;">Why Choose Naukri Job Posting?</p>
    </div>
    <div class="aa">
      <v-row justify="center" align="center" class="mt-5">
        <v-col cols="12" md="4">
          <v-card>
            <v-img src="/storage/assest/31.webp" alt="Cinque Terre" style="height: 140px;"></v-img>
            <v-card-title style="font-size: 30px;">2 Minutes to Post</v-card-title>
            <v-card-text style="font-style: 20px; margin-top: 10px;">
              Quick and easy to post job posting with<br> highly optimised job posting form
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="12" md="4">
          <v-card>
            <v-img src="/storage/assest/32.png" alt="Cinque Terre" style="height: 140px;"></v-img>
            <v-card-title style="font-size: 30px;">Attract Audience</v-card-title>
            <v-card-text style="font-style: 20px; margin-top: 10px;">
              Reach to over 9.6 crore talented <br> jobseekers
            </v-card-text>
          </v-card>
        </v-col>

        <v-col cols="12" md="4">
          <v-card>
            <v-img src="/storage/assest/33.webp" alt="Cinque Terre" style="height: 140px;"></v-img>
            <v-card-title style="font-size: 30px;">30 days visibility</v-card-title>
            <v-card-text style="font-style: 20px; margin-top: 10px;">
              Get quality applies guaranteed with 30 days visibility of your job ads.
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </div>
  </v-container>
</template>
<script>
import axios from "axios";
import { ref, onMounted } from "vue";
import { useUsersStore } from "../store/user"
export default {
  name: "Product",
  setup() {
    const plans = ref({});
    const usersStore = useUsersStore();
    const additem = () => {
      user
    }
    const fetchPlans = () => {
      axios.get(`/admin/get/plans`).then((response) => {
        plans.value = response.data.data;
      }).catch((error) => {
        console.log(error);
      })
    };
    onMounted(() => {
      fetchPlans();
    });
    return {
      plans,
      usersStore
    }
  }
};
</script>

<style scoped></style>
