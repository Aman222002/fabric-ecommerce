<template>
  <div class="choose_your_plan">
    <v-container>
      <div class="section_titme">
        <p
          class="centered-heading"
          style="font-family: sans-serif; font-size: 30px"
        >
          How JobPath <span style="color: #1967d2">helps you hire!</span>
        </p>
        <p style="margin-top: 10px">
          How JobPath helps you hire Indeed helps you connect with talent, on
          desktop and mobile, <br />so you can make more quality hires faster.
        </p>
      </div>
      <div class="text-center mt-3 mb-5">
        <p class="centered_heading">Choose Your Plan</p>
      </div>
      <v-row class="packages_price">
        <!-- <v-col cols="3">
          <v-card>
            <v-card-title style="font-size: 20px">Features</v-card-title>
            <v-card-text class="border-right border-left">
              <v-list dense>
                <v-list-item v-for="feature in features" :key="feature">
                  <v-list-item-title>{{ feature }}</v-list-item-title>
                </v-list-item>
              </v-list>
            </v-card-text>
          </v-card>
        </v-col> -->
        <v-col
          cols="3"
          sm="12"
          md="5"
          lg="3"
          xl="3"
          v-for="(plan, key) in plans"
          :key="key"
          class="plan_choose"
        >
          <v-card>
            <v-card-title style="font-size: 20px">{{ plan.Name }}</v-card-title>
            <v-card-text class="border-right border-left">
              <v-list>
                <v-list-item v-for="(item, key) in plan.details" :key="key">
                  <v-list-item-title
                    >{{ key }} <b>{{ item }}</b></v-list-item-title
                  >
                </v-list-item>
              </v-list>
              <v-btn class="bg-primary" @click="buySubs(plan.id)"
                >Buy Now</v-btn
              >
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
    <v-container>
      <div class="section_titme">
        <p
          class="centered-heading"
          style="font-family: sans-serif; font-size: 30px"
        >
          KEY <span style="color: #1967d2"> BENEFITS!</span>
        </p>
        <p style="margin-top: 10px">Why Choose Naukri Job Posting?</p>
      </div>
      <div class="plan_infor">
        <v-row justify="center" align="center" class="mt-5">
          <v-col cols="12" sm="12" md="6" lg="4" xl="4">
            <v-card>
              <v-img
                src="/storage/assest/31.webp"
                alt="Cinque Terre"
                style="height: 140px"
              ></v-img>
              <v-card-title style="font-size: 30px"
                >2 Minutes to Post</v-card-title
              >
              <v-card-text style="font-style: 20px; margin-top: 10px">
                Quick and easy to post job posting with<br />
                highly optimised job posting form
              </v-card-text>
            </v-card>
          </v-col>
          <v-col cols="12" sm="12" md="6" lg="4" xl="4">
            <v-card>
              <v-img
                src="/storage/assest/32.png"
                alt="Cinque Terre"
                style="height: 140px"
              ></v-img>
              <v-card-title style="font-size: 30px"
                >Attract Audience</v-card-title
              >
              <v-card-text style="font-style: 20px; margin-top: 10px">
                Reach to over 9.6 crore talented <br />
                jobseekers
              </v-card-text>
            </v-card>
          </v-col>
          <v-col cols="12" sm="12" md="6" lg="4" xl="4">
            <v-card>
              <v-img
                src="/storage/assest/33.webp"
                alt="Cinque Terre"
                style="height: 140px"
              ></v-img>
              <v-card-title style="font-size: 30px">
                30 days visibility
              </v-card-title>
              <v-card-text style="font-style: 20px; margin-top: 10px">
                Get quality applies guaranteed with 30 days visibility of your
                job ads.
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
      </div>
    </v-container>
  </div>
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
    const currentPlanId = ref();
    const usersStore = useUsersStore();
    const additem = (item, quant) => {
      usersStore.addToCart(item, quant);
    };
    const buySubs = (id) => {
      window.location.href = `/company/buy/plans/view/${id}`;
    };
    const getCurrentPlan = () => {
      axios
        .get(`/find/plan`)
        .then((response) => {
          // console.log(response.data);
          currentPlanId.value = response.data.data.id;
          // console.log(currentPlanId.value);
        })
        .catch((error) => {
          console.log(error);
        });
    };
    const fetchPlans = () => {
      axios
        .get(`/get/plans`)
        .then((response) => {
          // console.log(response.data.data)
          const Plans = response.data.data.map((item) => {
            const { id, Name, ...filteredItem } = item;
            return { id, Name, details: filteredItem };
          });
          plans.value = Plans;
          // console.log(plans.value);
          // console.log(plan.value);
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
      getCurrentPlan();
    });
    return {
      plans,
      usersStore,
      additem,
      features,
      buySubs,
      plan,
      getCurrentPlan,
      currentPlanId,
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
.choose_your_plan .packages_price {
  justify-content: center;
}

.choose_your_plan .packages_price .plan_choose {
  background: #1967d2;
  margin: 12px;
  border-radius: 10px;
}
.choose_your_plan .packages_price .v-theme--light {
  width: 95%;
  margin: 0 auto;
  border-radius: 15px;
  margin-bottom: 15px;
}
.choose_your_plan .packages_price .v-card-title {
  text-align: center;
  background: #1967d2;
  color: #fff;
  text-transform: uppercase;
  padding: 15px 0;
}
.choose_your_plan p.centered_heading {
  font-size: 35px;
  display: table;
  text-align: center;
  margin: 0 auto;
  margin-top: 15px;
  margin-bottom: 25px;
}
.choose_your_plan .packages_price .v-list-item-title {
  text-transform: capitalize;
}
.choose_your_plan .plan_infor .v-card {
  padding: 35px 20px;
  text-align: center;
  border-left: 2px solid #1967d2;
}
.choose_your_plan .packages_price .v-card-text {
  padding: 15px 0;
  text-align: center;
}

@media screen and (min-width: 1280px) {
  .choose_your_plan .packages_price .plan_choose:nth-child(2) {
    padding: 0;
    margin: 0 12px;
  }
}
</style>
