<template>
  <v-container fluid>
    <div class="text-center">
      <p class="centered-heading" style="font-family: sans-serif; font-size: 30px">
        How JobPath <span style="color: red">helps you hire</span>
      </p>
      <p style="margin-top: 10px">
        How JobPath helps you hire Indeed helps you connect with talent,
        on desktop and mobile, <br />so you can make more quality hires
        faster.
      </p>
    </div>
    <div class="text-center">
      <p class="centered-heading" style="font-family: sans-serif; font-size: 30px">
        Post A <span style="color: red">Job</span>
      </p>
      <p style="margin-top: 10px">
        Quick & Easy Job Posting − Get Quality Applies
      </p>
    </div>
    <v-container fluid>
      <div class="text-center">
        <p class="centered-heading" style="font-family: sans-serif; font-size: 30px">
          Choose Your Plan
        </p>
      </div>
      <v-container>
        <v-row>
          <v-col cols="3">
            <v-card height="430">
              <v-card-title style="font-size: 20px">Features</v-card-title>
              <v-card-text class="border-right border-left">
                <v-list dense>
                  <v-list-item v-for="feature in features" :key="feature">
                    <v-list-item-title>{{ feature }}</v-list-item-title>
                  </v-list-item>
                </v-list>
              </v-card-text>
            </v-card>
          </v-col>
          <v-col cols="3" v-for="(plan, key) in  plans " :key="key">
            <v-card height="430">
              <v-card-title class="bg-primary" style="font-size: 20px">{{ plan.Name }}</v-card-title>
              <v-card-text class="border-right border-left">
                <v-list>
                  <v-list-item v-for="(item, key) in plan.details" :key="key">
                    <v-list-item-title>{{ key }}={{ item }}</v-list-item-title>
                  </v-list-item>
                </v-list>
              </v-card-text>
              <v-btn class="bg-primary" height="40" width="273" style="margin-top: -100px;"
                @click="buySubs(plan.id)">Buy
                Now</v-btn>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-container>
    <div class="text-center">
      <p class="centered-heading" style="font-family: sans-serif; font-size: 30px">
        KEY <span style="color: red"> BENEFITS</span>
      </p>
      <p style="margin-top: 10px">Why Choose Naukri Job Posting?</p>
    </div>
    <div class="aa">
      <v-row justify="center" align="center" class="mt-5">
        <v-col cols="12" md="4">
          <v-card>
            <v-img src="/storage/assest/31.webp" alt="Cinque Terre" style="height: 140px"></v-img>
            <v-card-title style="font-size: 30px">2 Minutes to Post</v-card-title>
            <v-card-text style="font-style: 20px; margin-top: 10px">
              Quick and easy to post job posting with<br />
              highly optimised job posting form
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="12" md="4">
          <v-card>
            <v-img src="/storage/assest/32.png" alt="Cinque Terre" style="height: 140px"></v-img>
            <v-card-title style="font-size: 30px">Attract Audience</v-card-title>
            <v-card-text style="font-style: 20px; margin-top: 10px">
              Reach to over 9.6 crore talented <br />
              jobseekers
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="12" md="4">
          <v-card>
            <v-img src="/storage/assest/33.webp" alt="Cinque Terre" style="height: 140px"></v-img>
            <v-card-title style="font-size: 30px">30 days visibility</v-card-title>
            <v-card-text style="font-style: 20px; margin-top: 10px">
              Get quality applies guaranteed with 30 days
              visibility of your job ads.
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
import { useUsersStore } from "../store/user";
export default {
  name: "Product",
  setup() {
    const plans = ref([]);
    const plan = ref([]);
    const features = ref([]);
    const usersStore = useUsersStore();
    const additem = (item, quant) => {
      usersStore.addToCart(item, quant);
    };
    const buySubs = (id) => {
      window.location.href = `/company/buy/plans/view/${id}`;
    };
    const fetchPlans = () => {
      axios
        .get(`/get/plans`)
        .then((response) => {
          console.log(response.data.data)
          const Plans = response.data.data.map((item) => {
            const { id, Name, ...filteredItem } = item;
            return { id, Name, details: filteredItem };
          });
          plans.value = Plans;
          console.log(plans.value);
          console.log(plan.value);
          features.value = Object.keys(response.data.data[0]);
          features.value.splice(0, 1);
          features.value.splice(0, 1);
        })
        .catch((error) => {
          console.log(error);
        });
    };
    onMounted(() => {
      fetchPlans();
    });
    return {
      plans,
      usersStore,
      additem,
      features,
      buySubs,
      plan
    };
  },
};
</script>

<style>
.border-right {
  border-right: 1px solid #ccc;
}

.border-left {
  border-left: 1px solid #ccc;
}

.v-list-item__content {
  align-self: center;
  grid-area: content;
  overflow: visible;
}

.v-list-item-title {
  width: fit-content;
  overflow: visible;
}
</style>
