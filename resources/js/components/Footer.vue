<template>
  <v-footer color="primary" style="margin-top: auto" class="v-footer">
    <v-row>
      <v-col md="12" sm="12">
        <p class="white--text company-name" style="font-size: 60px">
          {{ appName }}
        </p>
        <p style="font-size: 15px">
          BBSTEM Limited | Registered in England and Wales | Company No:
          11127036
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
    const appName = ref("𝘽𝘽𝙎𝙏𝙀𝙈");

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
