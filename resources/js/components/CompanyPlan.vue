<template>
  <v-container fluid>
    <v-row justify="center">
      <v-col cols="12">
        <v-card
          width="mx auto"
          v-if="currentplan.name !== 'No Plan' && plan_id !== ''"
        >
          <v-card-subtitle class="current_plan">
            <h2
              style="
                background-color: #0146a6;
                padding: 8px !important;
                color: #fff;
                display: flex;
              "
            >
              Current Plan : {{ currentplan.name }}
            </h2>
          </v-card-subtitle>
          <v-container>
            <v-row class="choose_your_popup_wor_on">
              <v-col cols="3">
                <v-card>
                  <v-card-title class="features_on" style="font-size: 20px"
                    >Features</v-card-title
                  >
                  <v-card-text>
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
                    <v-card
                      :class="{ 'plan-card': plan.Name === currentplan.name }"
                    >
                      <v-card-title class="btn_cts" style="font-size: 20px">{{
                        plan.Name
                      }}</v-card-title>
                      <v-card-text>
                        <v-list>
                          <v-list-item
                            v-for="(item, key) in plan.details"
                            :key="key"
                            :style="{
                              backgroundColor:
                                plan.Name === currentplan.name
                                  ? '#f0f0f0'
                                  : 'transparent',
                            }"
                          >
                            <v-list-item-title>{{ item }}</v-list-item-title>
                          </v-list-item>
                        </v-list>
                      </v-card-text>
                      <v-btn
                        v-if="plan.Name && plan.Name !== currentplan.name"
                        class="btn_cts"
                        @click="buyPlan(plan)"
                        >Buy Now</v-btn
                      >
                      <v-btn class="btn_cts" v-else disabled
                        >Current Plan</v-btn
                      >
                      <v-icon
                        v-if="plan.Name === currentplan.name"
                        style="
                          position: absolute;
                          top: 5px;
                          right: 8px;
                          color: green;
                          font-size: 34px;
                        "
                        >mdi-check-circle</v-icon
                      >
                    </v-card>
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
            <v-row no-gutters style="margin-top: 20px">
              <v-col cols="12" class="text-center mb-5">
                <template v-if="upgrade_plan > currentplan.id">
                  <span
                    :class="{
                      'subtitle-1': true,
                      'font-weight-bold': true,
                      'text-red': true,
                    }"
                  >
                    Your next plan will be added when this plan ends.
                  </span>
                </template>
                <template v-else>
                  <span
                    v-if="subscription_status === 'active'"
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
                    }}
                  </span>
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
                </template>
              </v-col>

              <v-col cols="12" class="d-flex justify-center align-center mb-5">
                <v-btn class="bg-error" @click="removeplan()"
                  >Remove Subscription</v-btn
                >
                <v-btn
                  @click="downloadInvoice()"
                  v-if="subscription_status === 'active'"
                  class="bg-primary"
                  style="margin-left: 20px"
                  >Download Invoice</v-btn
                >
              </v-col>
            </v-row>
          </v-container>
        </v-card>

        <!-- <v-card
          outlined
          class="pa-4"
          v-if="currentplan.name !== 'No Plan' && plan_id !== ''"
        >
          <v-row no-gutters class="packages_price">
            <v-col cols="12" class="text-center mb-5">
              <v-card-subtitle class="current_plan">
                <h2
                  style="
                    background-color: #0146a6;
                    padding: 8px !important;
                    color: #fff;
                  "
                >
                  Current Plan
                </h2>
              </v-card-subtitle>
              <v-card-title>{{ currentplan.name }}</v-card-title>
              <v-card-text>
                <v-list>
                  <v-list-item
                    v-for="(item, key) in currentplan.features"
                    :key="key"
                  >
                    <v-list-item-title
                      >{{ key }} <b>{{ item }}</b></v-list-item-title
                    >
                  </v-list-item>
                </v-list>
              </v-card-text>
            </v-col>

          
          </v-row>
          <v-row no-gutters>
            <v-col cols="12" class="text-center mb-5">
              <template v-if="upgrade_plan > currentplan.id">
                <span
                  :class="{
                    'subtitle-1': true,
                    'font-weight-bold': true,
                    'text-red': true,
                  }"
                >
                  Your next plan will be added when this plan ends.
                </span>
              </template>
              <template v-else>
                <span
                  v-if="subscription_status === 'active'"
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
                  }}
                </span>
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
              </template>
            </v-col>
            <v-col cols="12" class="d-flex justify-center align-center mb-5">
             
              <v-btn
                v-if="currentplan.name"
                class="btn_cts"
                @click="changeplan()"
                :disabled="disabledButton"
                >Change Plan</v-btn
              >
              <v-btn v-else class="btn_cts" @click="changeplan()"
                >Buy Plan</v-btn
              >
            </v-col>
            <v-col cols="12" class="d-flex justify-center align-center mb-5">
              <v-btn class="bg-error" @click="removeplan()"
                >Remove Subscription</v-btn
              >
              <v-btn
                @click="downloadInvoice()"
                v-if="subscription_status === 'active'"
                class="bg-primary"
                style="margin-left: 20px"
                >Download Invoice</v-btn
              >
            </v-col>
          </v-row>
          
        </v-card> -->

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
            <v-btn
              class="bg-error"
              v-if="subscription_status === 'cancelled'"
              @click="restoreplan()"
              >Restore Subscription</v-btn
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
              <v-card-title class="features_on" style="font-size: 20px"
                >Features</v-card-title
              >
              <v-card-text>
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
                  <v-card-title class="btn_cts" style="font-size: 20px">
                    {{ plan.Name }}
                  </v-card-title>
                  <v-card-text>
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
                    class="btn_cts"
                    @click="buyPlan(plan)"
                  >
                    Buy Now
                  </v-btn>
                  <v-btn class="btn_cts" v-else disabled> Current Plan </v-btn>
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
import { ref, onMounted, computed } from "vue";
import {Sweetalert} from '../utils/sweetalert';
export default {
  setup() {
    const currentplan = ref({
      name: "No Plan",
    });
    const subscription_status = ref();
    const changingPlan = ref(false);
    const changePlanModal = ref(false);
    const selectedPlanValue = ref([]);

    const features = ref([]);
    const userId = ref();
    const disabledButton = ref(false);
    const upgrade_status = ref();
    const upgrade_plan = ref("");
    const plan_id = ref("");
    const subscriptionDetail = ref({
      start_date: "",
      end_date: "",
      remainig_days: "",
    });
    const planName = ref([]);
    const plans = ref({});
    const gc_customer_id = ref(null);
    const removeplan = () => {
      Sweetalert.confirm('Are you sure?').then((result) => {
        if (result.isConfirmed) {
          try {
            axios
              .post(`/remove/subscription/${userId.value}`)
              .then((response) => {
                console.log(user.id);
              });
            window.location.reload();
          } catch (error) {
            console.log(error);
          }
        }
      });
    };
    const restoreplan = () => {
      window.Swal.fire({
        title: "Are you sure?",
        text: "Are you sure you want previous plan?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Restore it!",
      }).then((result) => {
        if (result.isConfirmed) {
          try {
            axios
              .post(`/restore/subscription/${userId.value}`)
              .then((response) => {
                console.log(userId.value);
              });
            window.location.reload();
          } catch (error) {
            console.log(error);
          }
        }
      });
    };
    const changeplan = () => {
      // changePlanModal.value = true;
      try {
        axios
          .get(`/get/plans`)
          .then((response) => {
            console.log(response.data.data);
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
          console.log(response);
          plan_id.value = response.data.data[0].plan_id;
          userId.value = response.data.data[0].id;
          gc_customer_id.value = response.data.data[0].gc_customer_id;
          subscription_status.value = response.data.data[0].subscription_status;
          upgrade_plan.value = response.data.data[0].upgrade_plan_id;
          console.log(upgrade_plan);
          upgrade_status.value = response.data.data[0].upgrade_status;
          console.log(upgrade_status.value);
          if (upgrade_status.value === "initiated") {
            disabledButton.value = true;
          }
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    };
    const hasGcCustomerId = computed(() => {
      return !!gc_customer_id.value;
    });
    const handleUpgradeStatusChange = () => {
      console.log("Upgrade status:", upgrade_status.value);
      disabledButton.value = upgrade_status.value === "initiated";
    };
    // const buyPlan = (id) =>
    const buyPlan = (plan) => {
      console.log(plan);
      const formData = new FormData();
      // formData.append("id", id);
      formData.append("plan_id", plan.id);
      formData.append("interval", plan.details.interval);
      formData.append("plan_price", plan.details.Price);
      formData.append("plan_name", plan.Name);
      axios
        // .post("/company/buy/plan", formData)
        .post("/stripe/create-subscription", formData)
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
      window.location.href = "/plans";
    };
    const getPlan = () => {
      try {
        axios.get(`/find/plan`).then((response) => {
          if (response.data.data) {
            currentplan.value = response.data.data;
            console.log(currentplan.value);
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
    const downloadInvoice = () => {
      axios
        .get(`/download/invoice/${userId.value}`)
        .then((response) => {
          const downloadUrl = response.data.download_url;
          window.open(downloadUrl, "_blank");
        })
        .catch((error) => {
          console.error("Error downloading invoice:", error);
        });
    };

    onMounted(async () => {
      await getPlan();
      await getUser();
      changeplan();
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
      upgrade_plan,
      subscription_status,
      plan_id,
      restoreplan,
      hasGcCustomerId,
      downloadInvoice,
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
  height: 490px;
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
.current_plan {
  opacity: 1 !important;
}
.features_on {
  background-color: #0146a6;
  color: #fff;
}
.packages_price .v-list-item-title {
  text-transform: capitalize;
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
  width: 100%;
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