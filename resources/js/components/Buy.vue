<!-- <template>
  <v-container fluid class="">
    <v-form ref="form" @submit.prevent="submitForm()" class="form_fild_com">
      <v-row v-if="!employerStore.isLoggedIN">
        <v-col sm="12" md="12" lg="12" xl="12" cols="12">
          <v-col cols="12">
            <h2 class="form_fild_title">Users Details:</h2>
          </v-col>
          <v-row>
            <v-col sm="12" md="12" lg="6" xl="6" cols="12">
              <v-text-field
                variant="outlined"
                v-model="user.user_name"
                label="Representative Name"
                :rules="nameRules"
                density="compact"
                outlined
              ></v-text-field>
            </v-col>
            <v-col sm="12" md="12" lg="6" xl="6" cols="12">
              <v-text-field
                variant="outlined"
                v-model="user.email"
                label="Representative Email"
                :rules="emailRules"
                density="compact"
                outlined
              ></v-text-field>
            </v-col>
            <v-col sm="12" md="12" lg="6" xl="6" cols="12">
              <v-text-field
                variant="outlined"
                v-model="user.password"
                label="Password"
                :rules="passwordRules"
                type="password"
                density="compact"
                outlined
              ></v-text-field>
            </v-col>
            <v-col sm="12" md="12" lg="6" xl="6" cols="12">
              <v-text-field
                variant="outlined"
                v-model="user.phone"
                label="Phone"
                :rules="phoneRules"
                type="phone"
                density="compact"
                outlined
              ></v-text-field>
            </v-col>
          </v-row>
        </v-col>
        <v-col sm="12" md="12" lg="12" xl="12" cols="12">
          <v-col cols="12">
            <h2 class="form_fild_title">Company Details:</h2>
          </v-col>
          <v-row>
            <v-col col="6">
              <v-text-field
                variant="outlined"
                v-model="company.company_name"
                label="Company Name"
                :rules="companyNameRules"
                density="compact"
                outlined
              ></v-text-field>
            </v-col>

            <v-col col="6">
              <v-text-field
                variant="outlined"
                v-model="company.company_email"
                label="Company Email"
                :rules="companyEmailRules"
                density="compact"
                outlined
              ></v-text-field>
            </v-col>
          </v-row>
        </v-col>
      </v-row>
      <v-row class="plan_details">
        <v-col cols="12">
          <h2 class="form_fild_title">Plan Details:</h2>
        </v-col>
        <v-col sm="12" md="12" lg="6" xl="6" cols="12">
          <v-text-field
            :disabled="isDisabled"
            variant="outlined"
            v-model="plan.name"
            label="Plan Name"
            density="compact"
            outlined
          ></v-text-field>
        </v-col>
        <v-col sm="12" md="12" lg="6" xl="6" cols="12">
          <v-text-field
            :disabled="isDisabled"
            variant="outlined"
            v-model="plan.price"
            label="Price"
            density="compact"
            outlined
          ></v-text-field>
        </v-col>
        <v-col cols="12" class="text-center">
          <v-btn
            v-if="currentPlanId == plan.id"
            :disabled="true"
            class="form_fild_btn"
            >Buyed
          </v-btn>
          <v-btn v-else type="submit" class="form_fild_btn">Buy Now</v-btn>
        </v-col>
      </v-row>
    </v-form>
  </v-container>
</template>
<script>
import axios from "axios";
import { useUsersStore } from "../store/user.js";
import { useEmployerStore } from "../store/employer.js";
import { ref, computed, onMounted } from "vue";
export default {
  props: {
    data: {
      type: Object,
      default: () => ({}),
    },
  },
  setup(props) {
    const plan = ref({});
    const form = ref(null);
    const isDisabled = true;
    plan.value = props.data;
    const currentPlanId = ref();
    const usersStore = useUsersStore();
    const employerStore = useEmployerStore();
    const user = ref({
      user_name: "",
      email: "",
      password: "",
      phone: "",
    });
    const company = ref({
      company_name: "",
      company_email: "",
      status: "1",
    });
    const nameRules = [(v) => !!v || "Name is required"];
    const companyNameRules = [
      (value) => {
        if (value && value.length < 3) {
          return "Name must be at least 3 characters long";
        }
      },
    ];
    const companyEmailRules = [
      (value) => {
        if (value && !/.+@.+\..+/.test(value)) {
          return "Enter a valid email";
        }
      },
    ];
    const emailRules = [
      (v) => !!v || "Email is required",
      (v) => /.+@.+\..+/.test(v) || "Enter a valid email",
    ];
    const passwordRules = [(v) => !!v || "Password is required"];
    const phoneRules = [
      (v) => !!v || "Phone number is required",
      (v) => /^[0-9]{10}$/.test(v) || "Enter a valid 10-digit phone number",
    ];
    const getUser = () => {
      axios
        .get(`/find/plan`)
        .then((response) => {
          currentPlanId.value = response.data.data.id;
          console.log(currentPlanId.value);
        })
        .catch((error) => {
          console.log(error);
        });
    };
    const submitForm = () => {
      form.value.validate().then((valid) => {
        if (!valid.valid) {
          const errors = JSON.parse(JSON.stringify(valid.errors));
          let errorField = form.value[errors[0].id];
          errorField = Array.isArray(errorField) ? errorField[0] : errorField;
          errorField.scrollIntoView({
            behavior: "smooth",
            block: "center",
            inline: "center",
          });
        } else {
          const formData = new FormData();
          for (let key in company.value) {
            {
              formData.append(key, company.value[key]);
            }
          }
          for (let key in user.value) {
            {
              formData.append(key, user.value[key]);
            }
          }
          for (let key in plan.value) {
            {
              formData.append(key, plan.value[key]);
            }
          }
          axios
            .post("/company/buy/plan", formData)
            .then((response) => {
              if (response.data.status == true) {
                window.Swal.fire({
                  icon: "success",
                  title: "Email Sent",
                  text: "We sent a mail to add subscription",
                  confirmButtonText: "OK",
                  cancelButtonColor: "#6e7d88",
                });
              }
            })
            .catch((error) => {
              console.error("Error:", error);
            });
        }
      });
    };
    onMounted(() => {
      getUser();
    });
    return {
      usersStore,
      company,
      getUser,
      user,
      nameRules,
      plan,
      emailRules,
      passwordRules,
      phoneRules,
      submitForm,
      companyEmailRules,
      companyNameRules,
      form,
      isDisabled,
      currentPlanId,
      employerStore,
    };
  },
};
</script> -->










<template>
  <v-container fluid>
    <v-form ref="form" @submit.prevent="submitForm" class="form_fild_com">
      <v-row v-if="!employerStore.isLoggedIN">
        <v-col cols="12">
          <h2 class="form_fild_title">Users Details:</h2>
        </v-col>
        <v-col sm="12" md="6">
          <v-text-field
            v-model="user.user_name"
            label="Representative Name"
            :rules="nameRules"
            outlined
          ></v-text-field>
        </v-col>
        <v-col sm="12" md="6">
          <v-text-field
            v-model="user.email"
            label="Representative Email"
            :rules="emailRules"
            outlined
          ></v-text-field>
        </v-col>
        <v-col sm="12" md="6">
          <v-text-field
            v-model="user.password"
            label="Password"
            :rules="passwordRules"
            type="password"
            outlined
          ></v-text-field>
        </v-col>
        <v-col sm="12" md="6">
          <v-text-field
            v-model="user.phone"
            label="Phone"
            :rules="phoneRules"
            type="tel"
            outlined
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row v-if="!employerStore.isLoggedIN">
        <v-col cols="12">
          <h2 class="form_fild_title">Company Details:</h2>
        </v-col>
        <v-col sm="12" md="6">
          <v-text-field
            v-model="company.company_name"
            label="Company Name"
            :rules="companyNameRules"
            outlined
          ></v-text-field>
        </v-col>
        <v-col sm="12" md="6">
          <v-text-field
            v-model="company.company_email"
            label="Company Email"
            :rules="companyEmailRules"
            outlined
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row class="plan_details">
        <v-col cols="12">
          <h2 class="form_fild_title">Plan Details:</h2>
        </v-col>
        <v-col sm="12" md="6">
          <v-text-field
            :disabled="isDisabled"
            v-model="plan.name"
            label="Plan Name"
            outlined
          ></v-text-field>
        </v-col>
        <v-col sm="12" md="6">
          <v-text-field
            :disabled="isDisabled"
            v-model="plan.price"
            label="Price"
            outlined
          ></v-text-field>
        </v-col>
        <v-col cols="12" class="text-center">
          <div id="card-element"></div>
          <div id="card-errors" role="alert"></div>
        </v-col>
        <v-col cols="12" class="text-center">
          <v-btn v-if="currentPlanId === plan.id" disabled class="form_fild_btn">
            Bought
          </v-btn>
          <v-btn v-else type="submit" class="form_fild_btn">Buy Now</v-btn>
        </v-col>
        <v-col cols="12" class="text-center">
          <div id="express-checkout-button"></div>
        </v-col>
        
      </v-row>
    </v-form>
  </v-container>
</template>

<script>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useUsersStore } from "../store/user.js";
import { useEmployerStore } from "../store/employer.js";
import { loadStripe } from "@stripe/stripe-js";

export default {
  props: {
    data: {
      type: Object,
      default: () => ({}),
    },
  },
  setup(props) {
    console.log(props)
    const stripePromise = loadStripe("pk_test_51PQilzP2XjMWHwbIIwELHxqWEdO6HUYoZoRTmkppI4HKkPjL1l7CdWPOVCnnLSMOFspxmBl9zteORsD9Kj2ZsodU00T8uoKDti");
    
    const form = ref(null);
    const isDisabled = true;
    const plan = ref(props.data);
    const currentPlanId = ref(null);
    const usersStore = useUsersStore();
    const employerStore = useEmployerStore();
  
    const user = ref({
      user_name: "",
      email: "",
      password: "",
      phone: "",
    });
    const company = ref({
      company_name: "",
      company_email: "",
      status: "1",
    });
    const nameRules = [(v) => !!v || "Name is required"];
    const companyNameRules = [
      (value) => {
        if (value && value.length < 3) {
          return "Name must be at least 3 characters long";
        }
      },
    ];
    const companyEmailRules = [
      (value) => {
        if (value && !/.+@.+\..+/.test(value)) {
          return "Enter a valid email";
        }
      },
    ];
    const emailRules = [
      (v) => !!v || "Email is required",
      (v) => /.+@.+\..+/.test(v) || "Enter a valid email",
    ];
    const passwordRules = [(v) => !!v || "Password is required"];
    const phoneRules = [
      (v) => !!v || "Phone number is required",
      (v) => /^[0-9]{10}$/.test(v) || "Enter a valid 10-digit phone number",
    ];

    const getUser = () => {
      axios
        .get(`/find/plan`)
        .then((response) => {
          currentPlanId.value = response.data.data.id;
        })
        .catch((error) => {
          console.log(error);
        });
    };
let stripe;
let cardElement; 

const setupStripeElements = async () => {
  stripe = await stripePromise;

  const elements = stripe.elements();
  cardElement = elements.create("card");

  cardElement.on("change", (event) => {
    const displayError = document.getElementById("card-errors");
    if (event.error) {
      displayError.textContent = event.error.message;
    } else {
      displayError.textContent = "";
    }
  });

  cardElement.mount("#card-element");
};

const submitForm = async () => {
  const valid = await form.value.validate();
  if (!valid) {
    return;
  }

  try {
    const { paymentMethod, error } = await stripe.createPaymentMethod({
      type: 'card',
      card: cardElement, // Use cardElement directly
    });

    if (error) {
      console.error("Payment method error:", error);
      return;
    }

    const { data } = await axios.post("/stripe/create-subscription", {
      plan_id: plan.value.id,
      payment_method_id: paymentMethod.id,
      plan_price:plan.value.price,
      interval:plan.value.interval_unit,
      plan_name:plan.value.name
    });

    if (data.success) {
      // Handle success
      window.Swal.fire({
        icon: "success",
        title: "Subscription Created",
        text: "Your subscription has been successfully created.",
        confirmButtonText: "OK",
        cancelButtonColor: "#6e7d88",
      });
    } else {
      // Handle failure
      console.error("Subscription creation failed:", data.error);
      window.Swal.fire({
        icon: "error",
        title: "Subscription Creation Failed",
        text: "Failed to create subscription. Please try again later.",
        confirmButtonText: "OK",
        cancelButtonColor: "#6e7d88",
      });
    }
  } catch (error) {
    console.error("Error:", error);
    window.Swal.fire({
      icon: "error",
      title: "Error",
      text: "An error occurred while processing your request. Please try again later.",
      confirmButtonText: "OK",
      cancelButtonColor: "#6e7d88",
    });
  }
};






    onMounted(() => {
      getUser();
      setupStripeElements();
    });

    return {
      usersStore,
      employerStore,
      user,
      company,
      plan,
      nameRules,
      emailRules,
      passwordRules,
      phoneRules,
      companyEmailRules,
      companyNameRules,
      form,
      submitForm,
      isDisabled,
      currentPlanId,
    };
  },
};
</script>
<style scoped>
#card-errors{
  color: rgb(226, 56, 56);
}
</style>



