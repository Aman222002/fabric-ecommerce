<template>
  <div class="full-screen-image-container">
  <v-img src="/storage/assest/22.webp" contain class="mb-4 full-screen-image" style="opacity: 0.8;"></v-img>
  <div class="overlay-text">
    <h2 class="centered-heading">Find your <span class="red-text">dream job</span></h2>
   
  </div>
  <p style="font-size: 18px;" class="para">Thounsands of jobs available.</p>
    <v-btn color="white"  style=" background-color: transparent;" class="btn">
      <a href="/login" style="color: inherit; text-decoration: none; ">Get Started</a>
    </v-btn> 
</div>
  <div class="aa">
    <v-row justify="center" align="center" class="mt-5">
      <v-col cols="12" md="4">
        <v-card>
          <v-img src="/storage/assest/23.png" alt="Cinque Terre" style="height: 140px;"></v-img>
          <v-card-title style="font-size: 30px;">Create your free account</v-card-title>
          <v-card-text style="font-style: 15px; margin-top: 10px;">
            All you need is your email address to create an account and start building your job post.
          </v-card-text>
        </v-card>
      </v-col>

      <v-col cols="12" md="4">
        <v-card>
          <v-img src="/storage/assest/24.png" alt="Cinque Terre" style="height: 140px;"></v-img>
          <v-card-title style="font-size: 30px;">Build your
            job post</v-card-title>
          <v-card-text style="font-style: 15px; margin-top: 10px;">
            Then just add a title, description and location to your job post, and you're ready to go.
          </v-card-text>
        </v-card>
      </v-col>

      <v-col cols="12" md="4">
        <v-card>
          <v-img src="/storage/assest/25.png" alt="Cinque Terre" style="height: 140px;"></v-img>
          <v-card-title style="font-size: 30px;">Post
            your job</v-card-title>
          <v-card-text style="font-style: 15px; margin-top: 10px;">
            After you post your job, use our state-of-the-art <br>tools to help you find dream talent.
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </div>
  <div style="text-align: center; font-weight:200;">
    <h1 class="centered-heading">Save time<span style="color: red;"> and
        effort</span></h1>

    <p>Finding the best fit for the job shouldn’t be a full-time job.<br> Indeed’s simple and
      powerful tools let you source, screen and hire faster.</p>
  </div>
  <div class="full-screen-image-container" style="margin-top: 50px;">
    <img src="/storage/assest/26.png" contain class="mb-4 full-screen-image" >
  </div>
  
  
</template>
  
<script>
export default {
  name: "CompanyPage"
};
</script>
  
<style scoped>
.full-screen-image{
 width: 100vw;
 
} 


.aa {

  border-style: solid;
  border-color: rgb(12, 11, 11);
}

.bb {
  margin-top: 80px;
  text-align: center;
  margin-bottom: 40px;
}

.ff {
  margin-left: 40px;
 
}
.full-screen-image-container {
  position: relative;

}

.overlay-text {
  position: absolute;
  top: 35%;
  left: 25%;
  transform: translate(-50%, -50%);
  text-align: center;
  font-weight: 500;
  color: white;
}
.btn {
  position: absolute;
  top: 55%;
  left: 9%;
  transform: translate(-50%, -50%);
  text-align: center;
  font-weight: 500;
  color: white;
}
.para {
  position: absolute;
  top: 45%;
  left: 180px;
  transform: translate(-50%, -50%);
  text-align: center;
  font-weight: 500;
  color: white;
}

.overlay-text .centered-heading {
  font-family: sans-serif;
  font-size: 60px;
  font-weight: bold;
  margin: 0;
}

.overlay-text .red-text {
  color: red;
}
</style>
  