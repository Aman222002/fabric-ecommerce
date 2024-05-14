<template>
  <div class="millions_of_jobs">
    <v-container class="w-75 mb-6">
      <v-row align="center" justify="center">
        <v-col
          cols="12"
          class="millions_of_jobs_col"
          sm="12"
          md="6"
          lg="6"
          xl="6"
        >
          <v-img
            aspect-ratio="16/9"
            src="/assest/img/millions-of-jobs/image-2.webp"
          />
        </v-col>
        <v-col
          cols="12"
          class="millions_of_jobs_col"
          sm="12"
          md="12"
          lg="6"
          xl="6"
        >
          <div class="inner-column">
            <div class="sec-title">
              <h2>Millions of Jobs. Find the one that suits you.</h2>
              <div class="text">
                Search all the open positions on the web. Get your own
                personalized salary estimate. Read reviews on over 600,000
                companies worldwide.
              </div>
            </div>
            <ul class="list-style-one">
              <li>
                <v-icon>mdi-check</v-icon>Bring to the table win-win survival
              </li>
              <li>
                <v-icon>mdi-check</v-icon>Capitalize on low hanging fruit to
                identify
              </li>
              <li>
                <v-icon>mdi-check</v-icon>But I must explain to you how all this
              </li>
            </ul>
            <a class="theme-btn" href="/login">
              <span class="btn-title">Get Started</span>
            </a>
          </div>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>
<script>
export default {
  name: "millionsOfJob",
};
</script>

