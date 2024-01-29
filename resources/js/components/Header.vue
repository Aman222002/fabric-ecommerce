<template>
  <v-app-bar app>
    <v-container>
      <v-row align="center" justify="space-between">
        <v-col class="nav-links">
          <a href="/home" class="nav-link">Home</a>
          <!-- <a href="/login" class="nav-link">Login</a> -->
          <!-- <a href="/" class="nav-link">Find CVs</a>
          <a href="/product" class="nav-link">Products</a>
          <a href="/" class="nav-link">Resources</a> -->
        </v-col>
        <v-col class="nav-links">
          <a href="/login" class="btn-dashboard outlined">
            Login
          </a>
          <a href="/registration" class="btn-dashboard outlined">
            Registration
          </a>
          <a href="/job" class="nav-link" style="float: right;">Login as Company</a>
        </v-col>
      </v-row>
    </v-container>
  </v-app-bar>
</template>

<script>
export default {
  name: "Header"
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
}

.btn-dashboard {
  border-radius: 4px;
  margin-left: 10px;
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
</style>
