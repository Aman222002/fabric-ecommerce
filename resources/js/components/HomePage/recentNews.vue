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
              height="200"
              :src="`/storage/assets/${recentNews.featured_image}`"
            >
            </v-img>
            <div class="Cmt_time">
              <v-card-subtitle class="pt-4">
                {{ formatCreatedAt(recentNews.created_at) }}
              </v-card-subtitle>
              <v-card-subtitle class="pt-4">
                <v-icon>{{ icon }}</v-icon
                >{{ comment }}
              </v-card-subtitle>
            </div>
            <v-card-item>
              <v-card-title>{{ recentNews.title }}</v-card-title>
            </v-card-item>
            <v-card-text>
              <!-- <div v-html="recentNews.content">
              </div> -->
              <div>
                {{ recentNews.contentText
                }}<span
                  v-if="recentNews.contentText"
                  class="read-more"
                  @click="openDetailPage(recentNews.id)"
                >
                  Read More
                </span>
              </div>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import axios from "axios";
export default {
  setup() {
    const icon = ref("mdi-circle-small");
    const comment = ref("comment");
    const recentNews = ref([]);
    const formatCreatedAt = (createdAt) => {
      const options = { day: "numeric", month: "long", year: "numeric" };
      return new Date(createdAt).toLocaleDateString(undefined, options);
    };
    const openDetailPage = (id) => {
      window.location.href = `/view/blog/single/${id}`;
      // axios.get(`view/blog/single/${id}`).then((response) => {
      // }).catch((error) => {
      //   console.log(error);
      // })
    };
    const fecthBlog = () => {
      axios
        .get("get/blog")
        .then((response) => {
          console.log(response.data.data);
          recentNews.value = response.data.data.map((blog) => {
            const paragraphRegex = /<p[^>]*>(.*?)<\/p>/gi;
            const paragraphs = blog.content.match(paragraphRegex);
            const contentText = paragraphs
              ? paragraphs
                  .map((p) => p.replace(/<[^>]+>/g, ""))
                  .join(" ")
                  .split(/\s+/)
                  .slice(0, 24)
                  .join(" ")
              : "";
            return {
              ...blog,
              contentText,
            };
          });
        })
        .catch((err) => {
          console.log(err);
        });
    };
    onMounted(() => {
      fecthBlog();
    });
    return {
      recentNews,
      fecthBlog,
      formatCreatedAt,
      icon,
      comment,
      openDetailPage,
    };
  },
};
</script>
<style>
/* recent_news_articles only */
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

.read-more {
  color: #1967d2;
  cursor: pointer;
}

.recent_news_articles .v-card .v-img {
  margin-top: 15px;
}
</style>
