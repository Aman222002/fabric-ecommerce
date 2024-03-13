<template>
  <div class="recent_news_articles">
    <v-container class="w-75 mb-6">
      <div class="sec-title text-center">
        <h2>Recent News Articles</h2>
        <div class="text">
          Lorem ipsum dolor sit amet elit, sed do eiusmod tempor
        </div>
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
            <div class="Cmt_time">
              <v-card-subtitle class="pt-4">
                {{ recentNews.date }}
              </v-card-subtitle>
              <v-card-subtitle class="pt-4">
                <v-icon>{{ recentNews.icon }}</v-icon
                >{{ recentNews.comment }}
              </v-card-subtitle>
            </div>

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
</template>

<script>
export default {
  data: () => ({
    recentNews: [
      {
        id: "1",
        img: "https://cdn.vuetifyjs.com/images/cards/cooking.png",
        title: "Cafe Badilico",
        date: "August 31, 2021 ",
        icon: "mdi-circle-small",
        comment: "comment",
        text: "Small plates, salads & sandwiches - an intimate setting with 12               indoor seats plus patio seating.",
      },
      {
        id: "2",
        img: "https://cdn.vuetifyjs.com/images/cards/cooking.png",
        title: "Cafe Badilico",
        date: "August 31, 2021 ",
        icon: "mdi-circle-small",
        comment: "comment",
        text: "Small plates, salads & sandwiches - an intimate setting with 12               indoor seats plus patio seating.",
      },
      {
        id: "3",
        img: "https://cdn.vuetifyjs.com/images/cards/cooking.png",
        title: "Cafe Badilico",
        date: "August 31, 2021 ",
        icon: "mdi-circle-small",
        comment: "comment",
        text: "Small plates, salads & sandwiches - an intimate setting with 12               indoor seats plus patio seating.",
      },
    ],
  }),
};
</script>
<style >
/* // recent_news_articlesonly */
.recent_news_articles {
  padding: 65px 0 0;
  background: #fff;
}

.recent_news_articles .sec-title h2 {
  position: relative;
  display: block;
  font-weight: 500;
  font-size: 40px;
  line-height: 1.2em;
  color: #202124;
}
.recent_news_articles .sec-title .text {
  position: relative;
  margin-top: 15px;
  font-size: 15px;
  line-height: 26px;
  color: #696969;
  font-weight: 400;
}

.featured_jobs .company_info {
  padding: 15px;
  width: 100%;
  display: flex;
}
.Cmt_time {
  display: flex;
}
.recent_news_articles .v-card .v-img {
  margin-top: 15px;
}
</style>
