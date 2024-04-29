<template>
  <div class="brand_Logo">
    <v-container class="w-75">
      <v-sheet class="mx-auto">
        <v-slide-group class="pa-4" selected-class="bg-success" show-arrows>
          <v-slide-group-item v-for="brandLogo in brandLogo" :key="brandLogo.id">
            <div class="brand_logo_slide">
              <!-- aspect-ratio="16/9" -->
              <a :href=brandLogo.website_link target="_blank">
                <v-img aspect-ratio="16/9" :src="`/storage/assest/img/brand-logo/${brandLogo.partner_logo}`"></v-img>
              </a>
            </div>
          </v-slide-group-item>
        </v-slide-group>
      </v-sheet>
    </v-container>
  </div>
</template>
<script>
import axios from "axios";
import { ref, onMounted } from "vue";
export default {
  setup() {
    const brandLogo = ref([]);
    const partnerData = () => {
      try {
        axios.get("partner/data").then((response) => {
          brandLogo.value = response.data.data;
          // console.log(brandLogo.value);
        });
      } catch (error) {
        console.log(error);
      }
    };
    onMounted(() => {
      partnerData();
    });

    return {
      brandLogo,
      partnerData,
    };
  },
};
</script>
<style>
.brand_Logo {
  padding: 49px 0;
  background: #fff;
}

.brand_logo_slide,
.brand_Logo .v-img {
  width: 137px;
}

.brand_Logo .v-img img {
  width: 100%;
  height: 100%;
  display: block !important;
  position: relative;
}

.brand_Logo .v-sheet {
  box-shadow: unset !important;
}

.brand_logo_slide {
  margin: 0 20px;
}
</style>
