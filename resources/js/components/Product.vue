<template>
  <v-container fluid>
    <div>
      <v-img
        src="/storage/assest/4.jpg"
        aspect-ratio="2.5" 
        class="mx-auto"
      >
      </v-img>
    </div>
    <div class="text-center">
      <p class="centered-heading" style="font-family: sans-serif; font-size: 30px;">How Indeed <span style="color: red;">helps you hire</span></p>
      <p style="margin-top: 10px;">How Indeed helps you hire
Indeed helps you connect with talent, on desktop and mobile, <br>so you can make more quality hires faster.</p>
    </div>
    <div class="text-center">
      <p class="centered-heading" style="font-family: sans-serif; font-size: 30px;">Post A <span style="color: red;">Job</span></p>
      <p style="margin-top: 10px;">Quick & Easy Job Posting − Get Quality Applies</p>
    </div>
    <div class="rr">
      <v-card class="mx-auto" max-width="300" style="height: 300px;"> 
        <v-card-title class="headline">Advanced Job Posting</v-card-title>
        <v-card-subtitle>For All Cities</v-card-subtitle>
        <v-card-text>
          Boost on Job Search Page, Job Branding <br>
<br>
          Total: ₹1650
        </v-card-text>
        <v-card-actions>
          <v-btn color="primary">Buy Now</v-btn><br><br>
          <v-btn color="Secondary">Add to Cart</v-btn>
        </v-card-actions>
      </v-card>
      <div class="vertical-line"></div>
      <v-card class="mx-auto" max-width="300" style="height: 300px;"> 
        <v-card-title class="headline">Basic Job Posting</v-card-title>
        <v-card-subtitle>For All Cities</v-card-subtitle>
        <v-card-text>
          Boost on Job Search Page, Job Branding<br>
          <br>
         
          
            Total: ₹1000
        </v-card-text>
        <v-card-actions>
          <v-btn color="primary">Apply Now</v-btn>
        </v-card-actions>
      </v-card>
    </div>
    <div class="text-center">
      <p class="centered-heading" style="font-family: sans-serif; font-size: 30px;">KEY <span style="color: red;"> BENEFITS</span></p>
      <p style="margin-top: 10px;">Why Choose Naukri Job Posting?</p>
    </div>
<div class="aa">
    <v-row justify="center" align="center" class="mt-5">
      <v-col cols="12" md="4">
        <v-card>
            <v-img src="/storage/assest/31.webp" alt="Cinque Terre" style="height: 140px;"></v-img>
          <v-card-title style="font-size: 30px;">2 Minutes to Post</v-card-title>
          <v-card-text style="font-style: 20px; margin-top: 10px;">
            Quick and easy to post job posting with<br> highly optimised job posting form
          </v-card-text>
        </v-card>
      </v-col>
    
      <v-col cols="12" md="4">
        <v-card>
            <v-img src="/storage/assest/32.png" alt="Cinque Terre" style="height: 140px;"></v-img>
          <v-card-title style="font-size: 30px;">Attract Audience</v-card-title>
          <v-card-text style="font-style: 20px; margin-top: 10px;">
            Reach to over 9.6 crore talented <br> jobseekers
          </v-card-text>
        </v-card>
      </v-col>
     
      <v-col cols="12" md="4">
        <v-card>
            <v-img src="/storage/assest/33.webp" alt="Cinque Terre" style="height: 140px;"></v-img>
          <v-card-title style="font-size: 30px;">30 days visibility</v-card-title> 
          <v-card-text style="font-style: 20px; margin-top: 10px;"  >
            Get quality applies guaranteed with 30 days visibility of your job ads.
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
</div>
  </v-container>
</template>

<script>
export default {
  name: "Product",
};
</script>

<style scoped>
.rr{
  margin-top: 30px;
  border: 1px groove;
 
  border-color: rgb(248, 131, 131);
  display: flex;
  justify-content: space-between;
  
}


.vertical-line {
  border-left: 1px solid rgb(248, 131, 131);
  height: 300px; 
  margin: 0 20px;
}
.aa{ 
    margin-top: 30px;
   border: 1px groove;
  border-color: rgb(245, 154, 154);
  }
</style>
