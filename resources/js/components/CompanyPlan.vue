<template>
  <v-container fluid>
    <v-row justify="center">
      <v-col cols="6">
        <v-card
          outlined
          class="pa-4"
          v-if="currentplan.name !== 'No Plan' && plan_id !== ''"
        >
          <v-row no-gutters>
            <v-col cols="12" class="text-center mb-5">
              <v-card-subtitle>
                <h2
                  style="
                    background-color: #1976d2;
                    padding: 8px !important;
                    color: #fff;
                  "
                >
                  Current Plan
                </h2>
              </v-card-subtitle>
              <v-card-title>{{ currentplan.name }}</v-card-title>
            </v-col>
            <v-col cols="12" class="d-flex justify-center align-center mb-5">
              <v-btn
                v-if="upgrade_status == 'initiated'"
                class="bg-error mr-2"
                @click="cancelupgrade()"
                >Cancel Upgrade</v-btn
              >
              <v-btn
                v-if="currentplan.name"
                class="bg-primary"
                @click="changeplan()"
                :disabled="disabledButton"
                >Change Plan</v-btn
              >
              <v-btn v-else class="bg-primary" @click="changeplan()"
                >Buy Plan</v-btn
              >
            </v-col>
          </v-row>
          <v-row no-gutters>
            <v-col cols="12" class="text-center mb-5">
              <span
                v-if="subscription_status == 'active'"
                :class="{
                  'subtitle-1': true,
                  'font-weight-bold': true,
                  'text-red': subscriptionDetail.remainig_days < 5,
                  'text-green': subscriptionDetail.remainig_days >= 5,
                }"
              >
                {{
                  subscriptionDetail.remainig_days >= 0
                    ? "Your plan will expire in " +
                      subscriptionDetail.remainig_days +
                      " days"
                    : "You don't have an Active Plan"
                }}</span
              >
              <span
                v-else
                :class="{
                  'subtitle-1': true,
                  'font-weight-bold': true,
                  'text-red': true,
                }"
              >
                Your Plan will be Activated in 3 to 4 days
              </span>
            </v-col>
            <v-col cols="12" class="d-flex justify-center align-center mb-5">
              <v-btn class="bg-error" @click="removeplan()"
                >Remove Subscription</v-btn
              >
            </v-col>
          </v-row>
        </v-card>
        <v-card class="no-plan-card" outlined v-else>
          <v-card-title class="text-center">No Plan Selected</v-card-title>
          <v-card-text class="text-center">
            <v-icon size="64" color="ff8400">mdi-emoticon-sad-outline</v-icon>
            <p>You don't have any plan yet.</p>
            <p>
              Please consider subscribing to a plan to unlock premium features.
            </p>
          </v-card-text>
          <v-card-actions class="justify-center">
            <v-btn class="b_string_btn" @click="redirectToPlansPage()"
              >Subscribe Now</v-btn
            >
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
  <v-dialog
    v-model="changePlanModal"
    max-width="800px"
    class="choose_your_popup"
  >
    <v-card width="mx auto">
      <v-card-title class="headline">Choose Your Plan</v-card-title>
      <v-container>
        <v-row class="choose_your_popup_wor_on">
          <v-col cols="3">
            <v-card>
              <v-card-title style="font-size: 20px">Features</v-card-title>
              <v-card-text >
                <v-list dense>
                  <v-list-item v-for="feature in features" :key="feature">
                    <v-list-item-title>{{ feature }}</v-list-item-title>
                  </v-list-item>
                </v-list>
              </v-card-text>
            </v-card>
          </v-col>
          <v-col cols="9">
            <v-row class="choose_your_popup_wor_tw">
              <v-col cols="4" v-for="(plan, key) in plans" :key="key">
                <v-card>
                  <v-card-title class="bg-primary" style="font-size: 20px">
                    {{ plan.Name }}
                  </v-card-title>
                  <v-card-text >
                    <v-list>
                      <v-list-item
                        v-for="(item, key) in plan.details"
                        :key="key"
                      >
                        <v-list-item-title>{{ item }}</v-list-item-title>
                      </v-list-item>
                    </v-list>
                  </v-card-text>
                  <v-btn
                    v-if="plan.Name"
                    class="bg-primary"
                    @click="buyPlan(plan.id)"
                  >
                    Buy Now
                  </v-btn>
                  <v-btn v-else class="bg-secondary" disabled>
                    Current Plan
                  </v-btn>
                </v-card>
              </v-col>
            </v-row>
          </v-col>
        </v-row>
      </v-container>
    </v-card>
  </v-dialog>
</template>

<script>
import axios from "axios";
import { ref, onMounted } from "vue";
export default {
  setup() {
    const currentplan = ref({
      name: "No Plan",
    });
    const subscription_status = ref();
    const changingPlan = ref(false);
    const changePlanModal = ref(false);
    const selectedPlanValue = ref([]);
    // const plan_id = ref('');
    const features = ref([]);
    const userId = ref();
    const disabledButton = ref(false);
    const upgrade_status = ref();
    const plan_id = ref("");
    const subscriptionDetail = ref({
      start_date: "",
      end_date: "",
      remainig_days: "",
    });
    const planName = ref([]);
    const plans = ref({});
    const removeplan = () => {
      console.log(userId.value);
      try {
        axios.post(`/remove/subscription/${userId.value}`).then((response) => {
          console.log(user.id);
          window.location.reload();
        });
      } catch (error) {
        console.log(error);
      }
    };
    const changeplan = () => {
      changePlanModal.value = true;
      try {
        axios
          .get(`/get/plans`)
          .then((response) => {
            // console.log(response.data.data);
            const Plans = response.data.data.map((item) => {
              const { id, Name, ...filteredItem } = item;
              return { id, Name, details: filteredItem };
            });
            plans.value = Plans;
            features.value = Object.keys(response.data.data[0]);
            features.value.splice(0, 1);
            features.value.splice(0, 1);
          })
          .catch((error) => {
            console.log(error);
          });
      } catch (error) {
        console.log(error);
      }
    };
    const getUser = () => {
      axios
        .get("/get/comapny-admin")
        .then((response) => {
          plan_id.value = response.data.data[0].plan_id;
          userId.value = response.data.data[0].id;
          subscription_status.value = response.data.data[0].subscription_status;

          upgrade_status.value = response.data.data[0].upgrade_status;
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    };

    const handleUpgradeStatusChange = () => {
      if (upgrade_status.value === "initiated") {
        disabledButton.value = true;
      } else {
        disabledButton.value = false;
      }
    };
    const buyPlan = (id) => {
      const formData = new FormData();
      formData.append("id", id);
      axios
        .post("/company/buy/plan", formData)
        .then((response) => {
          console.log(response);
          if (response.data.status == true) {
            window.Swal.fire({
              icon: "success",
              title: "Success",
              text: "Your Subscription will be added Soon ",
              confirmButtonText: "OK",
            });
          }
          changePlanModal.value = false;
          changingPlan.value = true;
          window.location.reload();
        })
        .catch((error) => {
          console.error("Error:", error);
        });
      // window.location.reload();
    };
    const cancelupgrade = () => {
      try {
        axios.get(`/cancel/upgrade`).then((response) => {
          console.log(response.data);
          window.location.reload();
          // getUser();
        });
      } catch (error) {
        console.log(error);
      }
    };
    const redirectToPlansPage = () => {
      window.location.href = "/product";
    };
    const getPlan = () => {
      try {
        axios.get(`/find/plan`).then((response) => {
          if (response.data.data) {
            currentplan.value = response.data.data;
            subscriptionDetail.value.start_date = new Date(
              response.data.subscription.start_date
            ).toLocaleDateString();
            subscriptionDetail.value.end_date = new Date(
              response.data.subscription.end_date
            ).toLocaleDateString();
            const endDate = new Date(subscriptionDetail.value.end_date);
            const today = new Date();
            const differenceInTime = endDate.getTime() - today.getTime();
            const differenceInDays = Math.ceil(
              differenceInTime / (1000 * 3600 * 24)
            );
            subscriptionDetail.value.remainig_days = differenceInDays;
          }
        });
      } catch (error) {
        console.log(error);
      }
    };
    onMounted(async () => {
      await getPlan();
      await getUser();
      setTimeout(() => {
        handleUpgradeStatusChange();
      }, 1200);
    });
    return {
      userId,
      currentplan,
      plans,
      subscriptionDetail,
      planName,
      getPlan,
      changeplan,
      changePlanModal,
      selectedPlanValue,
      buyPlan,
      removeplan,
      cancelupgrade,
      redirectToPlansPage,
      features,
      changingPlan,
      getUser,
      upgrade_status,
      disabledButton,
      handleUpgradeStatusChange,
      subscription_status,
      plan_id,
    };
  },
};
</script>

<style scoped>
.text-red {
  color: red;
}

.text-green {
  color: green;
}

.v-card-text {
  padding: 0rem;
}

.no-plan-card {
  max-width: 400px;
  margin: auto;
  padding: 20px;
}

.choose_your_popup .v-card .v-card-title {
  text-align: center;
}

.choose_your_popup .v-row .v-col-4 button.v-btn {
  margin: 0 auto;
  text-align: center;
  display: table;
}

.choose_your_popup .v-row .v-col-4 .v-card,
.choose_your_popup .v-row .v-col-3 .v-card {
  height: 450px;
}

.choose_your_popup
  .v-row
  .v-col-3
  .v-card
  .v-list-item__content
  .v-list-item-title {
  text-transform: capitalize;
  font-weight: 600;
  font-size: 15px;
}

@media screen and (max-width: 980px) {
  .choose_your_popup .v-row.choose_your_popup_wor_on {
    flex-wrap: unset;
  }

  .choose_your_popup .v-row .v-col-3 {
    flex: 198px;
    max-width: 198px;
  }

  .choose_your_popup .v-row .v-col-9 {
    overflow-y: auto;
    overflow-x: auto;
  }

  .choose_your_popup .v-row .v-col-4 {
    margin-right: 20px;
  }

  .choose_your_popup .v-row .v-col-4,
  .choose_your_popup .v-row .v-col-4 .v-card {
    flex: 198px;
    max-width: 198px;
    width: 189px;
  }

  .choose_your_popup .v-row .v-col-9 .v-row {
    flex-wrap: unset;
  }

  .choose_your_popup .v-row .v-col-9 .v-row {
    flex-wrap: unset;
    width: 630px !important;
  }
}
</style>