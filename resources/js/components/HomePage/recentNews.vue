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
            <v-img
              cover
              height="250"
              :src="`http://127.0.0.1:8000/${recentNews.img}`"
            >
            </v-img>
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
        img: "assest/img/RecentNewsArticles/1.webp",
        title: "Attract Sales And Profits",
        date: "August 31, 2021 ",
        icon: "mdi-circle-small",
        comment: "comment",
        text: "A job ravenously while Far much that one rank beheld after outside",
      },
      {
        id: "2",
        img: "assest/img/RecentNewsArticles/2.webp",
        title: "5 Tips For Your Job Interviews",
        date: "August 31, 2021 ",
        icon: "mdi-circle-small",
        comment: "comment",
        text: "A job ravenously while Far much that one rank beheld after outside",
      },
      {
        id: "3",
        img: "assest/img/RecentNewsArticles/3.webp",
        title: "Overworked Newspaper Editor",
        date: "August 31, 2021 ",
        icon: "mdi-circle-small",
        comment: "comment",
        text: "A job ravenously while Far much that one rank beheld after outside",
      },
    ],
  }),
};
</script>

