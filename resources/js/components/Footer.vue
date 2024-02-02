
<template>
    <v-footer color="primary" app style="margin-top: auto;" class="v-footer">
      <v-row>
        <v-col md="4" sm="12">
          <h3 class="white--text company-name">{{ appName }}</h3>
        </v-col>
        <v-col v-for="(item, index) in footerItems" :key="index" class="text-center footer-item" style="cursor: pointer;">
          <v-icon size="24" class="white--text">{{ item.icon }}</v-icon>
          <div class="white--text">{{ item.text }}</div>
        </v-col>
        <v-col md="4" sm="12" style="float: right;">
          <h4 class="white--text">Contact Us</h4>
          <p class="white--text contact-info">{{ contactInfo.address }}</p>
          <p class="white--text contact-info">Email: {{ contactInfo.email }}</p>
          <p class="white--text contact-info">Phone: {{ contactInfo.phone }}</p>
        </v-col>
      
      </v-row>
    </v-footer>
  </template>
    
    <script>
    import { ref } from 'vue';
    
    export default {
      name: "CompanyFooter",
      setup() {
        const appName = ref('Job Search Portal');
        const footerItems = ref([
          { icon: 'mdi-map-marker', text: 'Location' },
          { icon: 'mdi-account-group', text: 'Team' },
          { icon: 'mdi-email', text: 'Contact' },
          {icon:'mdi-facebook', text:'Facebook'},
          {icon:'mdi-youtube', text:'YouTube'},
          {icon:'mdi-twitter', text:'Twitter'},
  
        ]);
         const contactInfo = ref({
        address: '123 Main Market Bilaspur',
        email: '@e.com',
        phone: '(+91) 98765-43210',
      });
    
        return {
          footerItems,
          contactInfo,
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
  </style>
  
    
  
  