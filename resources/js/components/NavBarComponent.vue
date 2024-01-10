<template>
    <v-app-bar color="gray">
      <v-row align="center" justify="space-between">
        <v-col>
          <v-btn text to="/">Home</v-btn>
          <v-btn text to="/product">Products</v-btn>
          <v-btn text to="/about">About us</v-btn>
          <v-btn text to="/contact">Contact</v-btn>
        </v-col>
        
         
          
          <v-btn to="/dashboard" outlined class="btn-dashboard">
            Dashboard
          </v-btn> 
          <v-btn text to="/login" style="margin-right: 10px;" class="btn-login">Login</v-btn>  
          <v-btn @click="logout" outlined class="btn-logout">Logout</v-btn>
        
      </v-row>
    </v-app-bar>
</template>
  
  <script>
export default {
  methods: {
    logout() {},
  },
};
</script>
  <style scoped>
.btn-dashboard,
.btn-logout,
.btn-login {
  border-radius: 4px;
  float: right;
}

.btn-dashboard:hover,
.btn-login:hover,
.btn-logout:hover {
  background: linear-gradient(45deg, #67307e, #f14cad);
  color: #fff;
}
</style>
  