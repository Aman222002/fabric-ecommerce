<template>
  <div class="testimonials_from">
    <v-container>
      <div class="sec-title text-center">
        <h2>Testimonials From Our Customers</h2>
        <!-- <div class="text">
          Lorem ipsum dolor sit amet elit, sed do eiusmod tempor
        </div> -->
      </div>
    </v-container>
    <div class="testimonials_slider">
      <splide :options="options">
        <splide-slide
          v-for="testimonials in testimonials"
          :key="testimonials.id"
        >
          <v-card
            color="grey-lighten-1 v-col-4"
            :class="[, selectedClass]"
            @click="toggle"
            max-width="100%"
          >
            <v-card-text>
              <p class="text-h4 text--primary">{{ testimonials.title }}</p>
              <div class="text--primary">
                {{ testimonials.text }}
              </div>
              <div class="testimonials_fot">
                <!-- <div class="testimonials_fot_img">
                  <v-img
                    aspect-ratio="16/9"
                    :src="`http://127.0.0.1:8000/${brandLogo.img}`"
                  ></v-img>
                </div> -->
                <div class="testimonials_fot_text">
                  <p class="text-h4 text--primary">
                    {{ testimonials.userName }}
                  </p>
                  <p>{{ testimonials.designation }}</p>
                </div>
              </div>
            </v-card-text>
          </v-card>
        </splide-slide>

        <splide-slide>
          <v-card
            color="grey-lighten-1 v-col-4"
            :class="[, selectedClass]"
            @click="toggle"
            max-width="100%"
          >
            <v-card-text>
              <p class="text-h4 text--primary">Awesome Design 2</p>
              <div class="text--primary">
                Without JobHunt i’d be homeless, they found me a job and got me
                sorted out quickly with everything! Can’t quite… The Mitech team
                works really hard to ensure high level of quality
              </div>
              <div class="testimonials_fot">
                <div class="testimonials_fot_img">
                  <v-img
                    aspect-ratio="16/9"
                    src="../../../public/assest/img/featured-Jobs/1-1.webp"
                  ></v-img>
                </div>
                <div class="testimonials_fot_text">
                  <p class="text-h4 text--primary">Gabriel Nolan</p>
                  <p>Web Developer</p>
                </div>
              </div>
            </v-card-text>
          </v-card>
        </splide-slide>
        <splide-slide>
          <v-card
            color="grey-lighten-1 v-col-4"
            :class="[, selectedClass]"
            @click="toggle"
            max-width="100%"
          >
            <v-card-text>
              <p class="text-h4 text--primary">Awesome Design 3</p>
              <div class="text--primary">
                Without JobHunt i’d be homeless, they found me a job and got me
                sorted out quickly with everything! Can’t quite… The Mitech team
                works really hard to ensure high level of quality
              </div>
              <div class="testimonials_fot">
                <div class="testimonials_fot_img">
                  <v-img
                    aspect-ratio="16/9"
                    src="../../../public/assest/img/featured-Jobs/1-1.webp"
                  ></v-img>
                </div>
                <div class="testimonials_fot_text">
                  <p class="text-h4 text--primary">Gabriel Nolan</p>
                  <p>Web Developer</p>
                </div>
              </div>
            </v-card-text>
          </v-card>
        </splide-slide>
        <splide-slide>
          <v-card
            color="grey-lighten-1 v-col-4"
            :class="[, selectedClass]"
            @click="toggle"
            max-width="100%"
          >
            <v-card-text>
              <p class="text-h4 text--primary">Awesome Design 4</p>
              <div class="text--primary">
                Without JobHunt i’d be homeless, they found me a job and got me
                sorted out quickly with everything! Can’t quite… The Mitech team
                works really hard to ensure high level of quality
              </div>
              <div class="testimonials_fot">
                <div class="testimonials_fot_img">
                  <v-img
                    aspect-ratio="16/9"
                    src="../../../public/assest/img/featured-Jobs/1-1.webp"
                  ></v-img>
                </div>
                <div class="testimonials_fot_text">
                  <p class="text-h4 text--primary">Gabriel Nolan</p>
                  <p>Web Developer</p>
                </div>
              </div>
            </v-card-text>
          </v-card>
        </splide-slide>
        <splide-slide>
          <v-card
            color="grey-lighten-1 v-col-4"
            :class="[, selectedClass]"
            @click="toggle"
            max-width="100%"
          >
            <v-card-text>
              <p class="text-h4 text--primary">Awesome Design 5</p>
              <div class="text--primary">
                Without JobHunt i’d be homeless, they found me a job and got me
                sorted out quickly with everything! Can’t quite… The Mitech team
                works really hard to ensure high level of quality
              </div>
              <div class="testimonials_fot">
                <div class="testimonials_fot_img">
                  <v-img
                    aspect-ratio="16/9"
                    src="../../../public/assest/img/featured-Jobs/1-1.webp"
                  ></v-img>
                </div>
                <div class="testimonials_fot_text">
                  <p class="text-h4 text--primary">Gabriel Nolan</p>
                  <p>Web Developer</p>
                </div>
              </div>
            </v-card-text>
          </v-card>
        </splide-slide>
        <splide-slide>
          <v-card
            color="grey-lighten-1 v-col-4"
            :class="[, selectedClass]"
            @click="toggle"
            max-width="100%"
          >
            <v-card-text>
              <p class="text-h4 text--primary">Awesome Design 6</p>
              <div class="text--primary">
                Without JobHunt i’d be homeless, they found me a job and got me
                sorted out quickly with everything! Can’t quite… The Mitech team
                works really hard to ensure high level of quality
              </div>
              <div class="testimonials_fot">
                <div class="testimonials_fot_img">
                  <v-img
                    aspect-ratio="16/9"
                    src="../../../public/assest/img/featured-Jobs/1-1.webp"
                  ></v-img>
                </div>
                <div class="testimonials_fot_text">
                  <p class="text-h4 text--primary">Gabriel Nolan</p>
                  <p>Web Developer</p>
                </div>
              </div>
            </v-card-text>
          </v-card>
        </splide-slide>
        <splide-slide>
          <v-card
            color="grey-lighten-1 v-col-4"
            :class="[, selectedClass]"
            @click="toggle"
            max-width="100%"
          >
            <v-card-text>
              <p class="text-h4 text--primary">Awesome Design 7</p>
              <div class="text--primary">
                Without JobHunt i’d be homeless, they found me a job and got me
                sorted out quickly with everything! Can’t quite… The Mitech team
                works really hard to ensure high level of quality
              </div>
              <div class="testimonials_fot">
                <div class="testimonials_fot_img">
                  <v-img
                    aspect-ratio="16/9"
                    src="../../../public/assest/img/featured-Jobs/1-1.webp"
                  ></v-img>
                </div>
                <div class="testimonials_fot_text">
                  <p class="text-h4 text--primary">Gabriel Nolan</p>
                  <p>Web Developer</p>
                </div>
              </div>
            </v-card-text>
          </v-card>
        </splide-slide>
      </splide>
    </div>
  </div>
</template>
<script>
import "@splidejs/splide/dist/css/themes/splide-default.min.css";
// or
import "@splidejs/splide/dist/css/themes/splide-sea-green.min.css";
// or
import "@splidejs/splide/dist/css/themes/splide-skyblue.min.css";
// var screenSet = screen.width < 767;
export default {
  data() {
    return {
      testimonials: [
        {
          id: "1",
          img: "assest/img/brand-logo/1-1.webp",
          title: "Awesome Design 1",
          text: "Without JobHunt i’d be homeless, they found me a job and got me sorted out quickly with everything! Can’t quite… The Mitech team works really hard to ensure high level of quality",
          userName: "Gabriel Nolan",
          designation: "Web Developer",
        },
        {
          id: "2",
          img: "assest/img/brand-logo/1-1.webp",
          title: "Awesome Design 1",
          text: "Without JobHunt i’d be homeless, they found me a job and got me sorted out quickly with everything! Can’t quite… The Mitech team works really hard to ensure high level of quality",
          userName: "Gabriel Nolan",
          designation: "Web Developer",
        },
        {
          id: "3",
          img: "assest/img/brand-logo/1-1.webp",
          title: "Awesome Design 1",
          text: "Without JobHunt i’d be homeless, they found me a job and got me sorted out quickly with everything! Can’t quite… The Mitech team works really hard to ensure high level of quality",
          userName: "Gabriel Nolan",
          designation: "Web Developer",
        },
        {
          id: "4",
          img: "assest/img/brand-logo/1-1.webp",
          title: "Awesome Design 1",
          text: "Without JobHunt i’d be homeless, they found me a job and got me sorted out quickly with everything! Can’t quite… The Mitech team works really hard to ensure high level of quality",
          userName: "Gabriel Nolan",
          designation: "Web Developer",
        },
        {
          id: "5",
          img: "assest/img/brand-logo/1-1.webp",
          title: "Awesome Design 1",
          text: "Without JobHunt i’d be homeless, they found me a job and got me sorted out quickly with everything! Can’t quite… The Mitech team works really hard to ensure high level of quality",
          userName: "Gabriel Nolan",
          designation: "Web Developer",
        },
        {
          id: "6",
          img: "assest/img/brand-logo/1-1.webp",
          title: "Awesome Design 1",
          text: "Without JobHunt i’d be homeless, they found me a job and got me sorted out quickly with everything! Can’t quite… The Mitech team works really hard to ensure high level of quality",
          userName: "Gabriel Nolan",
          designation: "Web Developer",
        },
        {
          id: "7",
          img: "assest/img/brand-logo/1-1.webp",
          title: "Awesome Design 1",
          text: "Without JobHunt i’d be homeless, they found me a job and got me sorted out quickly with everything! Can’t quite… The Mitech team works really hard to ensure high level of quality",
          userName: "Gabriel Nolan",
          designation: "Web Developer",
        },
      ],

      options: {
        updateOnMove: true,
        type: "loop",
        perPage: 3,
        perMove: 1,
        focus: "center",
        breakpoints: {
          1360: {
            perPage: 2,
          },
          740: {
            perPage: 1,
          },
        },
      },
    };
  },
};
</script>


<style >
/* // Testimonials From only */
.testimonials_from {
  padding: 115px 0 85px;
  background: #f0f5f7;
}
.testimonials_from .sec-title {
  margin-bottom: 50px;
}
.testimonials_from .sec-title h2 {
  position: relative;
  display: block;
  font-size: 30px;
  line-height: 1.2em;
  color: #202124;
  font-weight: 500;
}
.testimonials_from .sec-title .text {
  position: relative;
  margin-top: 15px;
  font-size: 15px;
  line-height: 26px;
  color: #696969;
  font-weight: 400;
}

.testimonials_from ul.splide__list {
  align-items: center;
}
.testimonials_slider .v-card-text {
  background: #fff;
  padding: 45px;
}

.testimonials_fot {
  display: flex;
  margin-top: 35px;
}
.testimonials_fot .testimonials_fot_img,
.testimonials_fot_img .v-responsive {
  width: 70px;
}
.testimonials_fot .testimonials_fot_img img {
  width: 100%;
}
.testimonials_fot_text {
  padding-left: 15px;
}
.testimonials_slider .v-sheet {
  box-shadow: unset !important;
}
.testimonials_slider .v-slide-group {
  background: #f0f5f7;
}
.testimonials_slider .splide__arrow svg {
  fill: #1967d2;
}
.testimonials_slider .splide__pagination__page:hover {
  background: #1967d2;
}

.testimonials_slider ul.splide__list li.splide__slide .v-card {
  max-width: 90% !important;
  margin: 0 auto;
}
.testimonials_slider ul.splide__list li.is-active .v-card .v-card-text {
  padding: 55px;
}
.testimonials_slider ul.splide__list li.is-active .v-card {
  max-width: 100% !important;
}
</style>
