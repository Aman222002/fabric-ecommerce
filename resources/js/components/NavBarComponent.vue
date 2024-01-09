<template>
    <v-app-bar color="gray">
      <v-row align="center" justify="space-between">
        <v-col>
          <v-btn text to="/">Home</v-btn>
          <v-btn text to="/products">Products</v-btn>
          <v-btn text to="/about">About us</v-btn>
          <v-btn text to="/contact">Contact</v-btn>
        </v-col>
        <v-col>
          <v-btn @click="logout" outlined class="btn-logout">Logout</v-btn>x
          <v-btn to="/dashboard" outlined class="btn-dashboard">
            Dashboard
          </v-btn>   
        </v-col>
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
.btn-logout {
  border-radius: 4px;
  float: right;
}

.btn-dashboard:hover,
.btn-logout:hover {
  background: linear-gradient(45deg, #67307e, #f14cad);
  color: #fff;
}
</style>
  