<template>
  <div class="home_page">
    <div class="banner">
      <v-img
        aspect-ratio="16/9"
        cover
        src="/assest/img/banner/bg-banner.svg"
      ></v-img>
    </div>
    <div class="banner_st">
      <v-row no-gutters>
        <v-col class="banner_left" sm="12" md="8" lg="7" xl="7">
          <div class="title-box">
            <h3>
              There Are <span class="colored">93,178</span> Postings Here For
              you!
            </h3>
            <div class="text">
              Find Jobs, Employment &amp; Career Opportunities
            </div>
          </div>
          <form class="job_search_form">
            <v-row no-gutters>
              <v-col cols="12" sm="12" md="5" lg="5" xl="5">
                <v-sheet>
                  <v-text-field
                    label="Job title, keywords, or company"
                    placeholder="Job title, keywords, or company"
                    prepend-inner-icon="mdi-magnify"
                    v-model="jobTitle"
                  ></v-text-field>
                </v-sheet>
              </v-col>
              <p class="line"></p>
              <v-col cols="12" sm="12" md="4" lg="4" xl="4">
                <v-sheet>
                  <v-text-field
                    label="City or postcode"
                    v-model="location"
                    placeholder="City or postcode"
                    prepend-inner-icon="mdi-map-marker-outline"
                  ></v-text-field>
                </v-sheet>
              </v-col>
              <!-- <v-col cols="12" sm="12" md="2" lg="2" xl="2">
                <v-sheet>
                  <v-btn type="submit" block class="mt-2 " @click="signup"
                    >Submit</v-btn
                  ></v-sheet
                >
              </v-col> -->
              <v-col cols="12" sm="12" md="2" lg="2" xl="2">
                <v-sheet>
                  <a
                    href="http://127.0.0.1:8000/jobs-detail"
                    class="mt-2 btn_search"
                    type="submit"
                    block
                    >Submit</a
                  >
                  <!-- <v-btn class="mt-2 btn_search" @click="redirectToJobsDetail" block>Submit</v-btn> -->
                </v-sheet>
              </v-col>
            </v-row>
          </form>
          <div class="popular_searches">
            <span>Popular Searches : </span><a href="#">Designer</a>,
            <a href="#">Developer</a>, <a href="#">Web</a>,<a href="#"> IOS</a>,
            <a href="#">PHP</a>, <a href="#">Senior</a>,<a href="#"> Engineer</a
            >,
          </div>
        </v-col>
        <div class="banner_right">
          <v-img
            class="bnt_img"
            aspect-ratio="16/9"
            cover
            src="/assest/img/banner/jov-search.svg"
          ></v-img>
        </div>
      </v-row>
    </div>
  </div>
</template>
<script>
import { ref } from "vue";
export default {
  name: "HomePage",
  setup() {
    const jobTitle = ref("");
    const location = ref("");
    const redirectToJobsDetail = () => {
      window.location.href =
        "/jobs-detail?jobTitle=" +
        jobTitle.value +
        "&location=" +
        location.value;
    };
    return {
      redirectToJobsDetail,
      jobTitle,
      location,
    };
  },
};
</script>



