<template>
  <section class="contact contact_us_page">
    <div class="container">
      <div class="heading text-center">
        <h2>Contact <span> Us </span></h2>
        <p>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
          eiusmod tempor <br />incididunt ut labore et dolore magna aliqua.
        </p>
      </div>
      <v-row>
        <v-col sm="12" md="5" lg="5" xl="5" cols="12">
          <v-card class="mx-auto">
            <template v-slot:title> Contact detail :</template>

            <v-card-text>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
              eiusmod tempor</v-card-text
            >
          </v-card>

          <div class="content">
            <!-- Info-1 -->
            <v-card class="mx-auto" prepend-icon="mdi-cellphone-basic">
              <template v-slot:title> PHONE :</template>

              <v-card-text> 12457836913 , +12457836913</v-card-text>
            </v-card>
            <!-- Info-2 -->

            <v-card class="mx-auto" prepend-icon="mdi-mail">
              <template v-slot:title> EMAIL :</template>

              <v-card-text> example@info.com</v-card-text>
            </v-card>

            <!-- Info-3 -->

            <v-card class="mx-auto" prepend-icon="mdi-map-marker">
              <template v-slot:title> ADDRESS :</template>

              <v-card-text> 6743 last street , Abcd, Xyz</v-card-text>
            </v-card>
          </div>
        </v-col>

        <v-col sm="12" md="7" lg="7" xl="7" cols="12">
          <v-form fast-fail @submit.prevent>
            <v-text-field
              v-model="fullName"
              :rules="fullName"
              label="Full Name"
            ></v-text-field>
            <v-text-field
              v-model="Email"
              :rules="Email"
              label="Email"
            ></v-text-field>
            <v-text-field
              v-model="Subject"
              :rules="Subject"
              label="Subject"
            ></v-text-field>
            <v-textarea
              label="Message"
              name="input-7-1"
              variant="filled"
              auto-grow
            ></v-textarea>

            <v-btn class="mt-2" block>Send Now!</v-btn>
          </v-form>
        </v-col>
      </v-row>
    </div>
  </section>
</template>

<style>
.contact {
  padding: 130px 0;
}

.contact .heading h2 {
  font-size: 30px;
  font-weight: 700;
  margin: 0;
  padding: 0;
}

.contact .heading h2 span {
  color: #1967d2;
}

.contact .heading p {
  font-size: 15px;
  font-weight: 400;
  line-height: 1.7;
  color: #999999;
  margin: 20px 0 20px;
  padding: 0;
}

.contact .form-control {
  padding: 25px;
  font-size: 13px;
  margin-bottom: 10px;
  background: #f9f9f9;
  border: 0;
  border-radius: 10px;
}

.contact .title_contact h3 {
  font-size: 18px;
  font-weight: 600;
}

.contact .title_contact p {
  font-size: 14px;
  font-weight: 400;
  color: #999;
  line-height: 1.6;
  margin: 0 0 40px;
}

.contact .content .info {
  margin-top: 30px;
}
.contact .content .info h4 {
  font-size: 13px;
  line-height: 1.4;
}

.contact .content .info h4 span {
  font-size: 13px;
  font-weight: 300;
  color: #999999;
}
section.contact_us_page {
  width: 75%;
  margin: 25px auto;
  padding: 25px;
  background: #fff;
  border-radius: 10px;
}
section.contact_us_page form.v-form button.v-btn {
  min-width: 150px;
  margin: 0 auto;
  height: 100% !important;
  padding: 11px 13px;
  background: #1967d2;
  color: #fff;
  font-size: 19px;
}
section.contact_us_page .v-card {
  box-shadow: unset;
  border-bottom: 1px solid #1967d2;
}
section.contact_us_page .heading {
  background: #e2eaf8;
  padding: 20px 0;
  margin-bottom: 70px;
}
</style>