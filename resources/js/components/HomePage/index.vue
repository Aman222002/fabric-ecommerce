<template>
  <div class="home">
    <!-- <img alt="Vue logo" src="../assets/logo.png"> -->
    <HomePage />
    <popularJobCategories />
    <featuredJob />
    <!-- <Testimonials /> -->
    <brandLogo />
    <millionsOfJob />
    <recentNews id="blogs" />
  </div>
</template>

<script>
// @ is an alias to /src
import HomePage from "./HomePage.vue";
import popularJobCategories from "./popularJobCategories.vue";
import featuredJob from "./featuredJob.vue";
// import Testimonials from "./TestimonialsCom.vue";
import brandLogo from "./brandLogo.vue";
import millionsOfJob from "./millionsOfJob.vue";
import recentNews from "./recentNews.vue";

export default {
  name: "HomeView",
  components: {
    HomePage,
    popularJobCategories,
    featuredJob,
    brandLogo,
    millionsOfJob,
    recentNews,
  },
};
</script>
