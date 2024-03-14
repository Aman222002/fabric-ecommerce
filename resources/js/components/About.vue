<template>
  <div class="popular_job_categories">
    <div class="sec-title text-center">
      <h2>about</h2>
    </div>
  </div>
  <v-container class="w-75">
    <v-card class="mx-auto my-8" elevation="16">
      <v-card-item>
        <v-card-title> Card title </v-card-title>
      </v-card-item>

      <v-card-text>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
        tempor incididunt ut labore et dolore magna aliqua.
      </v-card-text>
    </v-card>
  </v-container>
  <div class="sec-title text-center your_dream_jobs">
    <h2>Your Dream Jobs Are Waiting</h2>
    <p>Over 1 million interactions, 50,000 success stories Make yours now.</p>
    <div class="search_and_apply">
      <v-btn size="x-large" class="load_more" to="#">Search Job</v-btn>
      <v-btn size="x-large" class="load_more" to="#">Apply Job Now</v-btn>
    </div>
  </div>

  <!-- How It Works? -->
  <div class="recent_news_articles how_it_works">
    <v-container class="w-75 mb-6">
      <div class="sec-title text-center">
        <h2>How It Works?</h2>
        <div class="text">Job for anyone, anywhere</div>
      </div>
      <v-row align="center" justify="center">
        <v-col
          cols="12"
          class="recent_news_col"
          sm="12"
          md="6"
          lg="4"
          xl="4"
          v-for="recentNews in recentNews"
          :key="recentNews.id"
        >
          <v-card class="mx-auto my-4">
            <template>
              <v-progress-linear color="deep-purple" height="4" indeterminate>
              </v-progress-linear>
            </template>
            <v-img cover height="250" :src="`${recentNews.img}`"> </v-img>
            <v-card-item>
              <v-card-title>{{ recentNews.title }}</v-card-title>
            </v-card-item>
            <v-card-text>
              <div>
                {{ recentNews.text }}
              </div>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
  <!-- brand_Logo -->
  <div class="brand_Logo">
    <v-container class="w-75">
      <v-sheet class="mx-auto">
        <v-slide-group
          v-model="model"
          class="pa-4"
          selected-class="bg-success"
          show-arrows
        >
          <v-slide-group-item
            v-for="brandLogo in brandLogo"
            :key="brandLogo.id"
          >
            <div class="brand_logo_slide">
              <v-img
                aspect-ratio="16/9"
                :src="`http://192.168.1.7:8080/${brandLogo.img}`"
              ></v-img>
            </div>
          </v-slide-group-item>
        </v-slide-group>
      </v-sheet>
    </v-container>
  </div>
</template>

<script>
export default {
  setup() {
    const items = [
      {
        title: "Home",
        disabled: false,
        href: "/",
      },
      {
        title: "Find Jobs",
        disabled: true,
      },
    ];
    return {
      items,
    };
  },
  data: () => ({
    brandLogo: [
      {
        id: "1",
        img: "assets/img/brand-logo/1-1.webp",
      },
      {
        id: "2",
        img: "assets/img/brand-logo/1-2.webp",
      },
      {
        id: "3",
        img: "assets/img/brand-logo/1-3.webp",
      },
      {
        id: "4",
        img: "assets/img/brand-logo/1-4.webp",
      },
      {
        id: "5",
        img: "assets/img/brand-logo/1-5.webp",
      },
      {
        id: "6",
        img: "assets/img/brand-logo/1-1.webp",
      },
      {
        id: "7",
        img: "assets/img/brand-logo/1-2.webp",
      },
      {
        id: "8",
        img: "assets/img/brand-logo/1-3.webp",
      },
      {
        id: "9",
        img: "assets/img/brand-logo/1-4.webp",
      },
      {
        id: "10",
        img: "assets/img/brand-logo/1-5.webp",
      },
      {
        id: "11",
        img: "assets/img/brand-logo/1-1.webp",
      },
      {
        id: "12",
        img: "assets/img/brand-logo/1-2.webp",
      },
      {
        id: "13",
        img: "assets/img/brand-logo/1-3.webp",
      },
      {
        id: "14",
        img: "assets/img/brand-logo/1-4.webp",
      },
    ],
    recentNews: [
      {
        id: "1",
        img: "https://cdn.vuetifyjs.com/images/cards/cooking.png",
        title: "Cafe Badilico",
        // date: "August 31, 2021 ",
        // icon: "mdi-circle-small",
        // comment: "comment",
        text: "Small plates, salads & sandwiches - an intimate setting with 12 indoor seats plus patio seating.",
      },
      {
        id: "2",
        img: "https://cdn.vuetifyjs.com/images/cards/cooking.png",
        title: "Cafe Badilico",
        // date: "August 31, 2021 ",
        // icon: "mdi-circle-small",
        // comment: "comment",
        text: "Small plates, salads & sandwiches - an intimate setting with 12 indoor seats plus patio seating.",
      },
      {
        id: "3",
        img: "https://cdn.vuetifyjs.com/images/cards/cooking.png",
        title: "Cafe Badilico",
        // date: "August 31, 2021 ",
        // icon: "mdi-circle-small",
        // comment: "comment",
        text: "Small plates, salads & sandwiches - an intimate setting with 12 indoor seats plus patio seating.",
      },
    ],
  }),
};
</script>


<style>
.how_it_works .v-card-item,
.how_it_works .v-card-text {
  text-align: center;
}
.search_and_apply {
  display: flex;
  justify-content: center;
  margin: 15px 0;
  gap: 20px;
}
.search_and_apply a {
  font-size: 19px;
  line-height: 20px;
  border-radius: 8px;
  font-weight: 400;
  padding: 15px 28px;
  background-color: #1967d2;
  text-decoration: unset;
  display: table;
  color: #fff;
}
.search_and_apply a.load_more:nth-child(2) {
  background-color: #f9ab00;
}
.your_dream_jobs {
  background-image: url(/assest/img/about/1.jpg);
  color: #fff;
  padding: 5% 0;
}
</style>