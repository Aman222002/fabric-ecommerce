<template>
    <v-container fluid>
        <v-row justify="center">
            <v-col cols="12">
                <v-card outlined class="pa-4">
                    <v-row no-gutters>
                        <v-col cols="8">
                            <v-card-subtitle>
                                Current Plan
                            </v-card-subtitle>
                            <v-card-title>{{ currentplan.name }}</v-card-title>
                        </v-col>
                        <v-col cols="4" class="d-flex justify-end align-center">
                            <v-btn v-if="upgrade_status == 'initiated'" class="bg-error mr-2"
                                @click="cancelupgrade()">Cancel
                                Upgrade</v-btn>
                            <v-btn v-if="currentplan.name" class="bg-primary" @click="changeplan()"
                                :disabled="disabledButton">Change
                                Plan</v-btn>
                            <v-btn v-else class="bg-primary" @click="changeplan()">Buy
                                Plan</v-btn>
                        </v-col>
                    </v-row>
                    <v-row no-gutters>
                        <v-col>
                            <span
                                :class="{ 'subtitle-1': true, 'font-weight-bold': true, 'text-red': subscriptionDetail.remainig_days < 5, 'text-green': subscriptionDetail.remainig_days >= 5 }">
                                {{ subscriptionDetail.remainig_days >= 0 ? "Your plan will expire in " +
                                subscriptionDetail.remainig_days + " days" : "You don't have an Active Plan" }}</span>
                        </v-col>
                    </v-row>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
    <v-dialog v-model="changePlanModal" max-width="800px">
        <v-card width="mx auto">
            <v-card-title class="headline">Choose Your Plan</v-card-title>
            <!-- <v-container fluid>
                <v-row>
                    <v-col v-for="plan in plans" :key="plan.id" cols="12">
                        <v-card class="elevation-2 mb-6" v-if="plan.name !== currentplan.name">
                            <v-card-text class="pa-4">
                                <div class="d-flex justify-space-between align-center">
                                    <div>
                                        <v-icon color="primary" class="mr-2">mdi-bookmark-check</v-icon>
                                        <span class="subtitle-1 font-weight-bold">{{ plan.name }}</span>
                                    </div>
                                    <div>
                                        <span class="grey--text">Duration</span><br>
                                        <span class="subtitle-2 font-weight-bold">{{ plan.duration }}</span>
                                    </div>
                                    <div>
                                        <span class="grey--text">Posts Allowed</span><br>
                                        <span class="subtitle-2 font-weight-bold">{{ plan.Posts_Allowed }}</span>
                                    </div>
                                    <div>
                                        <span class="grey--text">Price</span><br>
                                        <span class="subtitle-2 font-weight-bold">${{ plan.price }}</span>
                                    </div>
                                    <div>
                                        <v-btn color="primary" @click="buyPlan(plan)" outlined>Buy Plan</v-btn>
                                    </div>
                                </div>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container> -->
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
                                        <v-list-item-title>{{ item }}</v-list-item-title>
                                    </v-list-item>
                                </v-list>
                            </v-card-text>
                            <v-btn v-if="plan.Name" class="bg-primary" height="40" width="273"
                                style="margin-top: -10px;" @click="buyPlan(plan.id)">
                                Buy Now
                            </v-btn>
                            <v-btn v-else class="bg-secondary" height="40" width="273" style="margin-top: -10px;"
                                disabled>
                                Current Plan
                            </v-btn>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-card>
    </v-dialog>
</template>

<script>
import axios from 'axios';
import { ref, onMounted } from "vue";
export default {
    setup() {
        const currentplan = ref({
            'name': 'No Plan',
        });
        const changingPlan = ref(false);
        const changePlanModal = ref(false);
        const selectedPlanValue = ref([]);
        const features = ref([]);
        const disabledButton = ref(false);
        const upgrade_status = ref();
        const subscriptionDetail = ref({
            'start_date': '',
            'end_date': '',
            'remainig_days': ''
        });
        const planName = ref([]);
        const plans = ref({});
        const removeplan = () => {
            try {
                axios.get(`remove/subscription/${user.id}`).then((response) => {
                    console.log(response.data);
                });
            } catch (error) {

            }
        };
        const changeplan = () => {
            changePlanModal.value = true;
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
        }
        const getUser = () => {
            axios
                .get("/get/comapny-admin")
                .then((response) => {
                    console.log(response.data.data[0].upgrade_status);
                    upgrade_status.value = response.data.data[0].upgrade_status;
                    console.log(upgrade_status.value);
                    // if (upgrade_status.value == 'initiated') {
                    //     disabledButton.value = true,
                    // }
                })
                .catch((error) => {
                    console.error("Error:", error);
                });
        };
        const handleUpgradeStatusChange = () => {
            console.log(upgrade_status.value);
            if (upgrade_status.value === 'initiated') {
                disabledButton.value = true;
            } else {
                disabledButton.value = false;
            }
        };
        console.log(disabledButton.value);
        const buyPlan = (id) => {
            const formData = new FormData();
            formData.append('id', id);
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
                    changingPlan.value = true;
                })
                .catch((error) => {
                    console.error("Error:", error);
                });
        }
        const cancelupgrade = () => {
            try {
                axios.get(`/cancel/upgrade`).then((response) => {
                    console.log(response.data);
                })
            } catch (error) {
                console.log(error);
            }
        }
        const getPlan = () => {
            try {
                axios.get(`/find/plan`).then((response) => {
                    currentplan.value = response.data.data;
                    console.log(response.data.data);
                    subscriptionDetail.value.start_date = new Date(response.data.subscription.start_date).toLocaleDateString();
                    subscriptionDetail.value.end_date = new Date(response.data.subscription.end_date).toLocaleDateString();
                    const endDate = new Date(subscriptionDetail.value.end_date);
                    const today = new Date();
                    const differenceInTime = endDate.getTime() - today.getTime();
                    const differenceInDays = Math.ceil(differenceInTime / (1000 * 3600 * 24));
                    subscriptionDetail.value.remainig_days = differenceInDays;
                    console.log(subscriptionDetail.value);
                })
            } catch (error) {
                console.log(error);
            }
        };
        onMounted(async () => {
            await getPlan();
            await getUser();
            setTimeout(() => {
                handleUpgradeStatusChange();
            }, 785);
        });
        return {
            currentplan,
            plans,
            subscriptionDetail,
            planName,
            getPlan,
            changeplan,
            changePlanModal,
            selectedPlanValue,
            buyPlan, removeplan, cancelupgrade,
            features, changingPlan, getUser, upgrade_status, disabledButton, handleUpgradeStatusChange
        };
    }
}
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
</style>