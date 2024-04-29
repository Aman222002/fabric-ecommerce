<template>
  <v-app id="app">
    <navbar-component></navbar-component>
    <v-main>
      <home-component></home-component>
    </v-main>
    <footer-component></footer-component>
  </v-app>
</template>
<script>
export default {
  name: "default-layout",
};
</script>