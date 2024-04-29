<template>
  <div v-if="recentNews && recentNews.title" class="single_blog_page">
    <v-card class="mx-auto py-12">
      <v-card-item>
        <v-card-title>{{ recentNews.title }}</v-card-title>
        <div class="px-4">
          <v-chip-group>
            <v-chip> {{ recentNews.published_by }}</v-chip>
            <v-chip>{{ formatCreatedAt(recentNews.created_at) }}</v-chip>
            <!-- <v-chip>Comment</v-chip> -->
          </v-chip-group>
        </div>
      </v-card-item>

      <v-img
        :src="`/storage/assets/${recentNews.featured_image}`"
        height="450"
        cover
      ></v-img>
      <v-container fluid>
        <v-card>
          <v-card-text class="pb-0">
            <div v-html="recentNews.content"></div>
          </v-card-text>
        </v-card>
      </v-container>
      <!-- <v-container>
        <div class="d-flex py-3 justify-space-between">
          <v-list-item density="compact">
            <v-list-item-title>Previous Post</v-list-item-title>
            <v-list-item-subtitle>Given Set was without from god divide rule
              Hath</v-list-item-subtitle>
          </v-list-item>
          <v-list-item density="compact">
            <v-list-item-title>Next Post</v-list-item-title>
            <v-list-item-subtitle>Tree earth fowl given moveth deep lesser
              After</v-list-item-subtitle>
          </v-list-item>
        </div>
        <v-divider class="mx-4 mb-1"></v-divider>

        <v-list lines="one">
          <v-list-item title="Oscar Cafeo" prepend-avatar="https://randomuser.me/api/portraits/women/8.jpg">
            <v-list-item-subtitle>Beautiful courses After</v-list-item-subtitle>
            <v-list-item-subtitle>Far much that one rank beheld bluebird after outside ignobly
              allegedly more when oh arrogantly vehement tantaneously eel
              valiantly petted this along across highhandedly
              much.</v-list-item-subtitle>
          </v-list-item>
          <v-list-item title="Alex Morgan" prepend-avatar="https://randomuser.me/api/portraits/women/8.jpg">
            <v-list-item-subtitle> Beautiful courses</v-list-item-subtitle>
            <v-list-item-subtitle>Far much that one rank beheld bluebird after outside ignobly
              allegedly more when oh arrogantly vehement tantaneously eel
              valiantly petted this along across highhandedly
              much.</v-list-item-subtitle>
          </v-list-item>
        </v-list>
        <v-card class="mx-auto">
          <v-form>
            <v-text-field v-model="YourName" :rules="YourName" label="Your Name"></v-text-field>

            <v-text-field v-model="YourEmail" :rules="YourEmail" label="Your Email"></v-text-field>
            <v-text-field v-model="Subject" :rules="Subject" label="Subject"></v-text-field>

            <v-textarea label="massage" model-value="Wright you massage here." name="input-7-1" variant="filled"
              auto-grow></v-textarea>
            <v-btn class="mt-2 form_fild_btn" type="submit" block>Submit</v-btn>
          </v-form>
        </v-card>
      </v-container> -->
    </v-card>
  </div>
</template>

<script>
import axios from "axios";
import { ref, onMounted } from "vue";
export default {
  props: {
    data: {
      type: Number,
      default: () => {
        0;
      },
    },
  },
  setup(props) {
    // console.log(props.data);
    const blogId = props.data;
    const recentNews = ref([]);
    const formatCreatedAt = (createdAt) => {
      const options = { day: "numeric", month: "long", year: "numeric" };
      return new Date(createdAt).toLocaleDateString(undefined, options);
    };
    const fetchBlog = () => {
      axios
        .get(`/fetch/single/blog/${blogId}`)
        .then((response) => {
          console.log(response.data.data);
          recentNews.value = response.data.data;
        })
        .catch((err) => {
          console.log(err);
        });
    };
    onMounted(() => {
      fetchBlog();
    });
    return {
      recentNews,
      blogId,
      formatCreatedAt,
    };
  },
};
</script>
<style>
.single_blog_page .v-card .v-card-item__content {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.single_blog_page .v-card .v-slide-group span.v-chip span.v-chip__underlay {
  background: transparent;
}

.single_blog_page .v-card .v-slide-group span.v-chip .v-chip__content {
  gap: 8px;
}

.single_blog_page .v-card .v-card-item {
  margin: 25px;
}

.single_blog_page .v-card .v-card {
  padding: 4%;
  width: 70%;
  margin: 20px auto;
}

.single_blog_page .v-card ul.requirement {
  list-style: disc;
}

.single_blog_page .v-card .v-list {
  display: flex;
  flex-wrap: wrap;
}

.single_blog_page .v-card .v-list .v-list-item {
  width: 50%;
}
</style>