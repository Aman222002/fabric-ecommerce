<template>
  <div class="about_us_page">
    <div class="popular_job_categories">
      <div class="sec-title text-center">
        <h2>About Us</h2>
      </div>
    </div>

    <v-container class="w-75 about_superio">
      <v-card class="mx-auto my-8" elevation="16">
        <v-card-item>
          <v-card-title> About Job Search</v-card-title>
        </v-card-item>

        <v-card-text>
          <p>
            Far much that one rank beheld bluebird after outside ignobly
            allegedly more when oh arrogantly vehement irresistibly fussy
            penguin insect additionally wow absolutely crud meretriciously
            hastily dalmatian a glowered inset one echidna cassowary some parrot
            and much as goodness some froze the sullen much connected bat
            wonderfully on instantaneously eel valiantly petted this along
            across highhandedly much.
          </p>

          <p>
            Repeatedly dreamed alas opossum but dramatically despite
            expeditiously that jeepers loosely yikes that as or eel underneath
            kept and slept compactly far purred sure abidingly up above fitting
            to strident wiped set waywardly far the and pangolin horse approving
            paid chuckled cassowary oh above a much opposite far much
            hypnotically more therefore wasp less that hey apart well like while
            superbly orca and far hence one.Far much that one rank beheld
            bluebird after outside ignobly allegedly more when oh arrogantly
            vehement irresistibly fussy.
          </p>
        </v-card-text>
      </v-card>
    </v-container>
    <div class="sec-title text-center your_dream_jobs">
      <h2>Your Dream Jobs Are Waiting</h2>
      <p>Over 1 million interactions, 50,000 success stories Make yours now.</p>
      <div class="search_and_apply">
        <v-btn size="x-large" class="load_more" to="#" @click="searchJob">Search Job</v-btn>
        <v-btn size="x-large" class="load_more" to="#" @click="searchJob">Apply Job Now</v-btn>
      </div>
    </div>


    <div class="recent_news_articles how_it_works">
      <v-container class="w-75 mb-6">
        <div class="sec-title text-center">
          <h2>How It Works?</h2>
          <div class="text">Job for anyone, anywhere</div>
        </div>
        <v-row align="center" justify="center">
          <v-col cols="12" class="recent_news_col" sm="12" md="6" lg="4" xl="4" v-for="recentNews in recentNews"
            :key="recentNews.id">
            <v-card class="mx-auto my-4">
              <template>
                <v-progress-linear color="deep-purple" height="4" indeterminate>
                </v-progress-linear>
              </template>
              <v-img cover :src="`http://127.0.0.1:8000/assest/${recentNews.img}`">
              </v-img>
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

    <div class="brand_Logo">
      <v-container class="w-75">
        <v-sheet class="mx-auto">
          <v-slide-group class="pa-4" selected-class="bg-success" show-arrows>
            <v-slide-group-item v-for="brandLogo in brandLogo" :key="brandLogo.id">
              <div class="brand_logo_slide">
                <v-img aspect-ratio="16/9" :src="`/storage/assest/img/brand-logo/${brandLogo.partner_logo}`"></v-img>
              </div>
            </v-slide-group-item>
          </v-slide-group>
        </v-sheet>
      </v-container>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { ref, onMounted } from "vue";
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
    const recentNews = ref([
      {
        id: "1",
        img: "img/about/work-1.webp",
        title: "Free Resume Assessments",
        text: "Employers on average spend 31 seconds scanning resumes to identify potential matches.",
      },
      {
        id: "2",
        img: "img/about/work-2.webp",
        title: "Job Fit Scoring",
        text: "Employers on average spend 31 seconds scanning resumes to identify potential matches.",
      },
      {
        id: "3",
        img: "img/about/work-3.webp",
        title: "Help Every Step of the Way",
        text: "Employers on average spend 31 seconds scanning resumes to identify potential matches.",
      },
    ]);
    const searchJob = () => {

      window.location.href = "/jobs-detail";
    };
    const brandLogo = ref([]);

    const partnerData = () => {
      try {
        axios.get('partner/data').then((response) => {
          brandLogo.value = response.data.data;

        })
      } catch (error) {
        console.log(error);
      }
    }
    onMounted(() => {
      partnerData();

    })
    return {
      items,
      value: 1151.71,
      brandLogo,
      partnerData,
      searchJob,
      recentNews,
      myOption: {
        duration: 3000,
        characterWidth: 12,

        decimals: 2,
        thousandsSeparatorFlag: true,
        //
      },
    };
  },
};
</script>
