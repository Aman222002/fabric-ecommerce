<template>
  <div class="home">
    <!-- <img alt="Vue logo" src="../assets/logo.png"> -->
    <HomePage />
    <PopularJobCategories />
    <FeaturedJob />
    <!-- <Testimonials /> -->
    <BrandLogo />
    <MillionsOfJob />
    <RecentNews />
  </div>
</template>

<script>
// @ is an alias to /src
import HomePage from "./HomePage.vue";
import PopularJobCategories from "./popularJobCategories.vue";
import FeaturedJob from "./featuredJob.vue";
// import Testimonials from "./TestimonialsCom.vue";
import BrandLogo from "./brandLogo.vue";
import MillionsOfJob from "./millionsOfJob.vue";
import RecentNews from "./recentNews.vue";

export default {
  name: "HomeView",
  components: {
    HomePage,
    PopularJobCategories,
    FeaturedJob,
    // Testimonials,
    BrandLogo,
    MillionsOfJob,
    RecentNews,
  },
};
</script>
