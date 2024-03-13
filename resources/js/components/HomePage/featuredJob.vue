<template>
  <div class="featured_jobs">
    <div class="sec-title text-center">
      <h2>Featured Jobs</h2>
      <div class="text">
        Know your worth and find the job that qualify your life
      </div>
    </div>

    <v-container class="w-75 mb-6">
      <v-row align="center" justify="center">
        <v-col
          cols="12"
          class="featured_jobs_col mb-5"
          sm="12"
          md="12"
          lg="6"
          xl="6"
          v-for="featuredJob in featuredJob"
          :key="featuredJob.id"
        >
          <v-card class="mx-auto company_info">
            <div class="company_logo">
              <v-img
                :src="`http://127.0.0.1:8000/${featuredJob.companyLogo}`"
              ></v-img>
            </div>
            <v-card class="job_info">
              <v-card-title
                ><a href="#"> {{ featuredJob.title }}</a>
              </v-card-title>
              <ul class="company_seat">
                <li>
                  <v-icon>mdi-compare</v-icon>{{ featuredJob.companyName }}
                </li>
                <li>
                  <v-icon>mdi-map-marker-outline </v-icon
                  >{{ featuredJob.location }}
                </li>
                <li>
                  <v-icon>mdi-clock-time-two-outline</v-icon
                  >{{ featuredJob.time }}
                </li>
                <li><v-icon>mdi-cash</v-icon>{{ featuredJob.price }}</li>
              </ul>
              <ul class="company_time">
                <li>{{ featuredJob.companyTime }}</li>
                <li>{{ featuredJob.companyStates }}</li>
                <li>{{ featuredJob.projectDuration }}</li>
              </ul>
            </v-card>
            <a href="#" class="bookmark_fr">
              <v-icon>mdi-bookmark-outline</v-icon>
            </a>
          </v-card>
        </v-col>
        <v-btn size="x-large" class="load_more" to="#">Load More Listing</v-btn>
      </v-row>
    </v-container>
  </div>
</template>
<script>
export default {
  data: () => ({
    featuredJob: [
      {
        id: "1",
        companyLogo: "assest/img/featured-Jobs/1-2.webp",
        title: "Recruiting Coordinator",
        companyName: "Catalyst",
        location: "London, UK",
        time: "12:09",
        price: "1500$",
        companyTime: "Part Time",
        companyStates: "Private",
        projectDuration: "Urgent",
      },
      {
        id: "2",
        companyLogo: "assest/img/featured-Jobs/1-1.webp",
        title: "Software Engineer (Android), Libraries",
        companyName: "Segment",
        location: "London, UK",
        time: "12:09",
        price: "1500$",
        companyTime: "Full Time",
        companyStates: "Private",
        projectDuration: "Urgent",
      },
    ],
  }),
};
</script>

