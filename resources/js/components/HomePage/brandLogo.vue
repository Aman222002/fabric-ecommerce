<template>
  <div class="brand_Logo">
    <v-container class="w-75">
      <v-sheet class="mx-auto">
        <v-slide-group
          v-model="model"
          class="pa-4"
          selected-class="bg-success"
          show-arrows
        >
          <v-slide-group-item
            v-for="brandLogo in brandLogo"
            :key="brandLogo.id"
          >
            <div class="brand_logo_slide">
              <v-img
                aspect-ratio="16/9"
                :src="`http://127.0.0.1:8000/${brandLogo.img}`"
              ></v-img>
            </div>
          </v-slide-group-item>
        </v-slide-group>
      </v-sheet>
    </v-container>
  </div>
</template>
<script>
export default {
  data: () => ({
    brandLogo: [
      {
        id: "1",
        img: "assest/img/brand-logo/1-1.webp",
      },
      {
        id: "2",
        img: "assest/img/brand-logo/1-2.webp",
      },
      {
        id: "3",
        img: "assest/img/brand-logo/1-3.webp",
      },
      {
        id: "4",
        img: "assest/img/brand-logo/1-4.webp",
      },
      {
        id: "5",
        img: "assest/img/brand-logo/1-5.webp",
      },
      {
        id: "6",
        img: "assest/img/brand-logo/1-1.webp",
      },
      {
        id: "7",
        img: "assest/img/brand-logo/1-2.webp",
      },
      {
        id: "8",
        img: "assest/img/brand-logo/1-3.webp",
      },
      {
        id: "9",
        img: "assest/img/brand-logo/1-4.webp",
      },
      {
        id: "10",
        img: "assest/img/brand-logo/1-5.webp",
      },
      {
        id: "11",
        img: "assest/img/brand-logo/1-1.webp",
      },
      {
        id: "12",
        img: "assest/img/brand-logo/1-2.webp",
      },
      {
        id: "13",
        img: "assest/img/brand-logo/1-3.webp",
      },
      {
        id: "14",
        img: "assest/img/brand-logo/1-4.webp",
      },
    ],
  }),
};
</script>

<style >
/* // brand Logo From only */
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
