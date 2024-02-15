<template>
  <v-footer color="primary"  style="margin-top: auto;" class="v-footer" >
    <v-avatar size="100" style="margin-left: 30%;">
      <img src="/storage/assest/26.png" alt="Logo" class="logo" />
    </v-avatar>
    <v-row>
      <v-col md="6" sm="12" style="margin-top: 20px; margin-left: 20px;">
        <p class="white--text company-name" style="font-size: 60px;">{{ appName }}</p>
        <p style="font-size:15px;"> Limited Jobs| Registered | Company No: 11127036</p>
      </v-col> </v-row> 

 
  </v-footer>
</template>

<script>
import { ref } from 'vue';

export default {
  name: "CompanyFooter",
  setup() {
    const appName = ref('JOBS');

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
