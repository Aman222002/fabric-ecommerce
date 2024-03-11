<template>
  <v-footer
    color="primary"
    style="margin-top: auto; text-align: center"
    class="v-footer"
  >
    <v-row>
      <v-col md="12" sm="12">
        <p class="white--text company-name" style="font-size: 30px">
          {{ appName }}
        </p>
        <p style="font-size: 15px">
          Limited Jobs| Registered | Company No: 11127036
        </p>
      </v-col>
    </v-row>
  </v-footer>
</template>

<script>
import { ref } from "vue";

export default {
  name: "CompanyFooter",
  setup() {
    const appName = ref("JOBS");

    return {
      appName,
    };
  },
};
</script>

<style scoped>
.company-name {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 10px;
}

.footer-item {
  margin-top: 10px;
}

.contact-info {
  font-size: 14px;
}

.second-row {
  margin-top: 40px;
}
</style>
