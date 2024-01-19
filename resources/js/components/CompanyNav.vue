<template>
    <v-app-bar app>
      <v-container>
        <v-row align="center" justify="space-between">
          <v-col class="nav-links">
           
            <a href="/job" class="nav-link">Post a Job</a>
            <a href="/findcv" class="nav-link">Find CVs</a>
            <a href="/product" class="nav-link">Products</a>
            <a href="/" class="nav-link">Resources</a>
          </v-col>
          
        </v-row>
      </v-container>
    </v-app-bar>
  </template>
  
  <script>
  export default {
    name: "CompanyNav"
  };
  </script>
  
  <style scoped>
  .nav-links {
    display: flex;
    align-items: center;
  }
  
  .nav-link,
  .btn-dashboard {
    text-decoration: none;
    color: inherit;
    margin-right: 20px;
    cursor: pointer;
    font-weight: bold;
    transition: color 0.3s ease-in-out;
  }
  
  .btn-dashboard {
    border-radius: 4px;
    margin-left: 10px;
    transition: background 0.3s ease-in-out;
  }
  
  .outlined {
    border: 1px solid transparent;
  }
  
  .btn-dashboard:hover {
    background: linear-gradient(45deg, #ca82e9, #8b8488);
  }
  
  .v-app-bar {
    background-color: #add8e6;
    border-bottom: 1px solid #161414;
  }
  
  
  .nav-link:hover {
    color: #ca82e9; 
  }
  </style>
  