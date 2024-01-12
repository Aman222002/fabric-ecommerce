<template>
    <v-app-bar>
      <v-container>
        <v-row align="center" justify="space-between">
          <v-col>
            <v-btn to="/">
              <a href="/home">Home</a>
            </v-btn>
            <v-btn text to="/">
                <a href="/Job">Post a Job</a></v-btn>
            <v-btn text to="/">Find CVs</v-btn>
            <v-btn text to="/">
              <a href="/product">Products</a></v-btn>
           
            <v-btn text to="/">Resources</v-btn>
        
         

          <v-btn to="/" outlined class="btn-dashboard" style="float: right;">
            <a href="/Login">Login</a>
          </v-btn>
          <v-btn to="/" outlined class="btn-dashboard" style="float: right;">
            <a href="/Registration"> Registration </a>
          </v-btn>
        </v-col>
        </v-row>
      </v-container>
    </v-app-bar>

    <!-- Your main content goes here -->
</template>
  
<script>
export default {};
</script>

<style scoped>
.btn-dashboard {
  border-radius: 4px;
}

.btn-dashboard:hover {
  background: linear-gradient(45deg, #ca82e9, #8b8488);
  /* color: #632525; */
}

.v-app-bar {
  background-color: #add8e6;

  border-bottom: 1px solid #161414;
}
</style>