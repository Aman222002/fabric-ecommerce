<template>
   
    <div class="full-screen-image-container">
    
      <v-img
        src="/storage/assest/22.webp"
        contain
        class="mb-4 full-screen-image"
      ></v-img>
     
    </div>
    <div style="text-align: center; font-size: xx-large; font-weight:50px; margin-top:0; font-weight: bolder;">
    <p class="centered-heading" style="font-family: sans-serif; font-size: 60px;">Our  <span style="color: red;">Services</span></p>
    <p style="margin-top: 10px;">How Indeed helps you hire
Indeed helps you connect with talent, on desktop and mobile, <br>so you can make more quality hires faster.</p>
    </div> 
    <div class="aa">
    <v-row justify="center" align="center" class="mt-5">
      <v-col cols="12" md="4">
        <v-card>
            <v-img src="/storage/assest/23.png" alt="Cinque Terre" style="height: 140px;"></v-img>
          <v-card-title style="font-size: 30px;">Create your free account</v-card-title>
          <v-card-text style="font-style: 20px; margin-top: 10px;">
            All you need is your email address to create an account<br> and start building your job post.
          </v-card-text>
        </v-card>
      </v-col>

      <v-col cols="12" md="4">
        <v-card>
            <v-img src="/storage/assest/24.png" alt="Cinque Terre" style="height: 140px;"></v-img>
          <v-card-title style="font-size: 30px;">Build your
job post</v-card-title>
          <v-card-text style="font-style: 20px; margin-top: 10px;">
            Then just add a title, description and location to your job post,<br> and you're ready to go.
          </v-card-text>
        </v-card>
      </v-col>

      <v-col cols="12" md="4">
        <v-card>
            <v-img src="/storage/assest/25.png" alt="Cinque Terre" style="height: 140px;"></v-img>
          <v-card-title style="font-size: 30px;">Post
your job</v-card-title> 
          <v-card-text style="font-style: 20px; margin-top: 10px;"  >
            After you post your job, use our state-of-the-art <br>tools to help you find dream talent.
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
</div>
<div style="text-align: center; font-size: xx-large; font-weight:50px; margin-top:0; font-weight: bolder;">
    <p class="centered-heading" style="font-family: sans-serif; font-size: 60px;">Save time<span style="color: red;"> and effort</span></p>

    <p style="font-size: 20px;">Finding the best fit for the job shouldn’t be a full-time job. Indeed’s simple and powerful tools let you source, screen and hire faster.</p>
</div>
<div class="full-screen-image-container" style="margin-top: 50px;">
      <v-img
        src="/storage/assest/26.png"
        contain
        class="mb-4 full-screen-image"  
      ></v-img>
    </div>
    <div class="ff">
  <v-btn color="primary" style="height: 40px;">
    <a href="/job" style="color: inherit; text-decoration: none;">Get Started</a>
  </v-btn>
  <p style="font-size: 20px;">
    You control your posts 24/7 – edit, add, pause, or close them whenever you want. Learn more about posting.
  </p>
</div>
  </template>
  
  <script>
  export default {
    name: "CompanyPage"
  };
  </script>
  
  <style scoped>
  .full-screen-image-container {
    width: 100vw;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  
  .full-screen-image {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain; 
    opacity: 0.8;
  }
  .aa{ 
    margin-top: 30px;
    border-style: solid;
  border-color: rgb(12, 11, 11);
  }
  .bb{
    margin-top: 80px;
    text-align: center;
    margin-bottom: 40px;
  }
  .ff{
    margin-left: 40px;
    margin-top: 60px;
  }
  
  </style>
  