<template>
    <v-footer
      class="custom-footer"
    >
      <div class="pt-0">
        Phasellus feugiat arcu sapien, et iaculis ipsum elementum sit amet. Mauris cursus commodo interdum. Praesent ut risus eget metus luctus accumsan id ultrices nunc. Sed at orci sed massa consectetur dignissim a sit amet dui. Duis commodo vitae velit et faucibus. Morbi vehicula lacinia malesuada. Nulla placerat augue vel ipsum ultrices, cursus iaculis dui sollicitudin. Vestibulum eu ipsum vel diam elementum tempor vel ut orci. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
      </div>
  
      <v-divider></v-divider>
      <div class="social-icons">
      <v-icon class="mr-2">mdi-facebook</v-icon>
      <v-icon class="mr-2">mdi-youtube</v-icon>
      <v-icon>mdi-twitter</v-icon>
    </div>
    </v-footer>
  </template>
  
  <script>
  export default {
    name: "CompanyFooter"
  };
  </script>
  
  <style scoped>
  .custom-footer {
    background-color: #262d31; 
    color: #ffffff; 
    /* position: fixed; */
    bottom: 0;
    width: 100%;
  }
  </style>
  