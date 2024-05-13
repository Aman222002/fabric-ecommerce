<template>
  <div class="brand_Logo" v-if="brandLogo.length > 0">
    <v-container class="w-75">
      <v-sheet class="mx-auto">
        <!-- Add v-if directive to conditionally render the slider -->
        <v-slide-group v-if="brandLogo.length > 0" class="pa-4" selected-class="bg-success" show-arrows>
          <v-slide-group-item v-for="brandLogoItem in brandLogo" :key="brandLogoItem.id">
            <div class="brand_logo_slide">
              <a :href="brandLogoItem.website_link" target="_blank">
                <v-img aspect-ratio="16/9" :src="`/storage/assets/${brandLogoItem.partner_logo}`"></v-img>
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
  name: "brandLogo",
  setup() {
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
