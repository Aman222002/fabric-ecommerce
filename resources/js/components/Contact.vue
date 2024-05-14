<template>
  <div class="contact_page_us_form">
    <iframe
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d9581880.713102693!2d-15.001137513347569!3d54.10341835529073!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x25a3b1142c791a9%3A0xc4f8a0433288257a!2sUnited%20Kingdom!5e0!3m2!1sen!2sin!4v1714739395333!5m2!1sen!2sin"
      width="100%"
      height="450"
      style="border: 0"
      allowfullscreen=""
      loading="lazy"
      referrerpolicy="no-referrer-when-downgrade"
    ></iframe>
  </div>
  <div class="contact_page_us">
    <section class="contact_us_page">
      <div class="container">
        <v-row>
          <v-col sm="12" md="12" lg="12" xl="12" cols="12">
            <div class="content">
              <div class="heading text-center">
                <h2>Contact <span> Us </span></h2>
              </div>
              <v-row>
                <v-col sm="12" md="4" lg="4" xl="4" cols="12">
                  <v-card class="mx-auto text-center">
                    <v-icon>mdi-phone</v-icon>
                    <!-- <v-img src="img/contact/letter.svg" /> -->
                    <v-card-text class="pa-0 my-3 titel_1"> PHONE </v-card-text>
                    <v-card-text class="pa-0">{{
                      contactDetails.contact
                    }}</v-card-text>
                  </v-card>
                </v-col>
                <v-col sm="12" md="4" lg="4" xl="4" cols="12">
                  <v-card class="mx-auto text-center">
                    <v-icon>mdi-email-outline</v-icon>
                    <v-card-text class="pa-0 my-3 titel_1"> EMAIL </v-card-text>
                    <v-card-text class="pa-0">{{
                      contactDetails.email
                    }}</v-card-text>
                  </v-card>
                </v-col>
                <v-col sm="12" md="4" lg="4" xl="4" cols="12">
                  <v-card class="mx-auto text-center">
                    <v-icon>mdi-map-marker</v-icon>
                    <v-card-text class="pa-0 my-3 titel_1">
                      ADDRESS
                    </v-card-text>
                    <v-card-text class="pa-0">
                      {{ contactDetails.address }}</v-card-text
                    >
                  </v-card>
                </v-col>
              </v-row>
            </div>
          </v-col>

          <v-col
            sm="12"
            md="12"
            lg="12"
            xl="12"
            cols="12"
            class="mx-auto form_contact"
          >
            <v-form fast-fail @submit.prevent="sendEmail()" ref="form">
              <v-row>
                <v-col sm="12" md="4" lg="4" xl="4" cols="12">
                  <v-text-field
                    v-model="fullName"
                    :rules="fullNameRules"
                    label="Full Name"
                    variant="outlined"
                  ></v-text-field
                ></v-col>
                <v-col sm="12" md="4" lg="4" xl="4" cols="12">
                  <v-text-field
                    v-model="Email"
                    :rules="emailRules"
                    label="Email"
                    variant="outlined"
                  ></v-text-field>
                </v-col>
                <v-col sm="12" md="4" lg="4" xl="4" cols="12">
                  <v-text-field
                    v-model="Subject"
                    :rules="subjectRules"
                    label="Subject"
                    variant="outlined"
                  ></v-text-field>
                </v-col>
              </v-row>
              <v-col sm="12" md="12" lg="12" xl="12" cols="12" class="pa-0">
                <v-textarea
                  label="Message"
                  v-model="Message"
                  :rules="messageRules"
                  name="input-7-1"
                  auto-grow
                  variant="outlined"
                ></v-textarea>
              </v-col>

              <v-btn class="mt-2" block type="submit">Send Now!</v-btn>
            </v-form>
          </v-col>
        </v-row>
      </div>
    </section>
  </div>
</template>
<script>
import { ref, onMounted } from "vue";
import axios from "axios";

export default {
  name: "Contact",
  setup() {
    const contactDetails = ref({});
    const fullName = ref("");
    const form = ref(null);
    const Email = ref("");
    const Subject = ref("");
    const Message = ref("");
    const fullNameRules = [
      (value) => !!value || "Full Name is required",
      (value) => (value && value.length <= 50) || "Max 50 characters",
    ];
    const emailRules = [
      (value) => !!value || "Email is required",
      (value) => /.+@.+\..+/.test(value) || "Email must be valid",
    ];
    const subjectRules = [(value) => !!value || "Subject is required"];
    const messageRules = [(value) => !!value || "Message is required"];
    const fetchData = () => {
      try {
        axios.get("contact/data").then((response) => {
          contactDetails.value = response.data.data[0];
        });
      } catch (error) {
        console.log(error);
      }
    };
    onMounted(() => {
      fetchData();
    });
    const sendEmail = async () => {
      try {
        const valid = await form.value.validate();
        if (!valid.valid) {
          const errors = JSON.parse(JSON.stringify(valid.errors));
          let errorField = form.value[errors[0].id];
          errorField = Array.isArray(errorField) ? errorField[0] : errorField;
          errorField.scrollIntoView({
            behavior: "smooth",
            block: "center",
            inline: "center",
          });
        } else {
          const response = await axios.post("/send-email", {
            fullName: fullName.value,
            Email: Email.value,
            Subject: Subject.value,
            Message: Message.value,
            recipientEmail: contactDetails.value.email,
          });
          window.Swal.fire({
            icon: "success",
            title: " Email sent to Admin",

            confirmButtonText: "OK",
          });

          console.log(response.data.message);
        }
      } catch (error) {
        console.error(error);
      }
    };

    return {
      fetchData,
      contactDetails,
      fullName,
      Email,
      Subject,
      Message,
      sendEmail,
      fullNameRules,
      emailRules,
      subjectRules,
      messageRules,
      form,
    };
  },
};
</script>
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
  color: #0146a6;
}

.contact .heading p {
  font-size: 15px;
  font-weight: 400;
  line-height: 1.7;
  color: #000;
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
  position: relative;
}

section.contact_us_page form.v-form button.v-btn {
  text-align: center;
  color: #e2eaf8;
  background-color: #0146a6;
  font-size: 19px;
  line-height: 20px;
  border-radius: 8px;
  font-weight: 400;
  padding: 10px 35px;
  min-width: 220px;
  margin: 0 auto;
  height: 48px;
  text-transform: capitalize;
}

section.contact_us_page .v-card {
  box-shadow: unset;
  padding: 25px;
}

section.contact_us_page .heading {
  background: #e2eaf8;
  padding: 20px 0;
  margin-bottom: 25px;
}
section.contact_us_page .v-card .v-card-text.titel_1 {
  font-size: 15px;
  font-weight: 600;
}
section.contact_us_page .content .v-card i.mdi {
  font-size: 35px;
  color: #0146a6;
}

@media screen and (min-width: 1500px) {
  section.contact_us_page .content .v-card i.mdi {
    font-size: 30px;
  }
  section.contact_us_page .v-card {
    padding: 20px;
  }
}
</style>