<template>
  <div class="about_us_page">
    <div class="popular_job_categories">
      <div class="sec-title text-center">
        <h2>About Us</h2>
        <v-breadcrumbs :items="items">
          <template v-slot:prepend> </template>
        </v-breadcrumbs>
      </div>
    </div>
    <div class="about_superio">
      <v-container fluid>
        <v-card class="mx-auto my-8" elevation="16">
          <v-card-item>
            <v-card-title> About Job Search</v-card-title>
          </v-card-item>

          <v-card-text>
            <p class="text-justify">
              Far much that one rank beheld bluebird after outside ignobly
              allegedly more when oh arrogantly vehement irresistibly fussy
              penguin insect additionally wow absolutely crud meretriciously
              hastily dalmatian a glowered inset one echidna cassowary some
              parrot and much as goodness some froze the sullen much connected
              bat wonderfully on instantaneously eel valiantly petted this along
              across highhandedly much.
            </p>

            <p class="text-justify">
              Repeatedly dreamed alas opossum but dramatically despite
              expeditiously that jeepers loosely yikes that as or eel underneath
              kept and slept compactly far purred sure abidingly up above
              fitting to strident wiped set waywardly far the and pangolin horse
              approving paid chuckled cassowary oh above a much opposite far
              much hypnotically more therefore wasp less that hey apart well
              like while superbly orca and far hence one.Far much that one rank
              beheld bluebird after outside ignobly allegedly more when oh
              arrogantly vehement irresistibly fussy.
            </p>
          </v-card-text>
        </v-card>
      </v-container>
    </div>
    <div class="sec-title text-center your_dream_jobs">
      <h2>Your Dream Jobs Are Waiting</h2>

      <div class="search_and_apply">
        <v-btn class="load_more" to="#" @click="searchJob">Search Job</v-btn>
        <v-btn class="load_more" to="#" @click="searchJob">Apply Job Now</v-btn>
      </div>
    </div>

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
              <v-img cover :src="`assest/${recentNews.img}`"> </v-img>
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
      <div class="sec-title site_title text-center">
        <h2>Partners Logo</h2>
      </div>
      <v-container class="w-75">
        <v-sheet class="mx-auto">
          <v-slide-group class="pa-4" selected-class="bg-success" show-arrows>
            <v-slide-group-item
           
              v-for="brandLogoItem in brandLogo" :key="brandLogoItem.id"
            >
              <div class="brand_logo_slide">
                <v-img
                  aspect-ratio="16/9"
                  :src="`/storage/assets/${brandLogoItem.partner_logo}`"
                ></v-img>
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
  name: "About",
  setup() {
    const items = [
      {
        title: "Home",
        disabled: false,
        href: "/",
      },
      {
        title: "About",
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
      window.location.href = "/job-search";
    };
    const brandLogo = ref([]);

    const partnerData = () => {
      try {
        axios.get("partner/data").then((response) => {
          brandLogo.value = response.data.data;
        });
      } catch (error) {
        console.log(error);
      }
    };
    onMounted(() => {
      partnerData();
    });
    return {
      items: [
        {
          title: "Dashboard",
          disabled: false,
          href: "breadcrumbs_dashboard",
        },
        {
          title: "Link 1",
          disabled: false,
          href: "breadcrumbs_link_1",
        },
        {
          title: "Link 2",
          disabled: true,
          href: "breadcrumbs_link_2",
        },
      ],
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
