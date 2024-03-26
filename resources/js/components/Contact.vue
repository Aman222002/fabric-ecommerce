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
            <template v-slot:title> Contact details </template>
            <!-- <v-card-text>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
              eiusmod tempor</v-card-text
            > -->
          </v-card>
          <div class="content">

            <v-card class="mx-auto" prepend-icon="mdi-cellphone-basic">
              <template v-slot:title> PHONE :</template>

              <v-card-text>{{ contactDetails.contact }}</v-card-text>
            </v-card>


            <v-card class="mx-auto" prepend-icon="mdi-mail">
              <template v-slot:title> EMAIL :</template>

              <v-card-text>{{ contactDetails.email }}</v-card-text>
            </v-card>



            <v-card class="mx-auto" prepend-icon="mdi-map-marker">
              <template v-slot:title> ADDRESS :</template>

              <v-card-text> {{ contactDetails.address }}</v-card-text>
            </v-card>
          </div>
        </v-col>

        <v-col sm="12" md="7" lg="7" xl="7" cols="12">
          <v-form fast-fail @submit.prevent="sendEmail()" ref="form">
            <v-text-field v-model="fullName" :rules="fullNameRules" label="Full Name"></v-text-field>
            <v-text-field v-model="Email" :rules="emailRules" label="Email"></v-text-field>
            <v-text-field v-model="Subject" :rules="subjectRules" label="Subject"></v-text-field>
            <v-textarea label="Message" v-model="Message" :rules="messageRules" name="input-7-1" variant="filled"
              auto-grow></v-textarea>
            <v-btn class="mt-2" block type="submit">Send Now!</v-btn>
          </v-form>
        </v-col>
      </v-row>
    </div>
  </section>
</template>
<script>
import { ref, onMounted } from "vue";
import axios from "axios";

export default {
  name: "Contact",
  setup() {
    const contactDetails = ref({});
    const fullName = ref('');
    const form = ref(null);
    const Email = ref('');
    const Subject = ref('');
    const Message = ref('');
    const fullNameRules = [
      value => !!value || 'Full Name is required',
      value => (value && value.length <= 50) || 'Max 50 characters'
    ];
    const emailRules = [
      value => !!value || 'Email is required',
      value => /.+@.+\..+/.test(value) || 'Email must be valid'
    ];
    const subjectRules = [
      value => !!value || 'Subject is required'
    ];
    const messageRules = [
      value => !!value || 'Message is required'
    ];
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
          const response = await axios.post('/send-email', {
            fullName: fullName.value,
            Email: Email.value,
            Subject: Subject.value,
            Message: Message.value,
            recipientEmail: contactDetails.value.email
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
      fetchData, contactDetails, fullName, Email, Subject, Message, sendEmail,
      fullNameRules,
      emailRules,
      subjectRules,
      messageRules, form
    };
  }
}
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