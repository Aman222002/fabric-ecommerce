<template>
  <div class="job_alerts">
    <div class="sec-title text-center">
      <h2>Job Alerts!</h2>
      <div class="text">
        Know your worth and find the job that qualify your life
      </div>
    </div>

    <v-container class="w-75 mb-6">
      <v-row align="center" justify="center">
        <v-table fixed-header class="job_alerts_table w-100">
          <thead>
            <tr>
              <th class="text-left">Title</th>
              <th class="text-left">Criteria</th>
              <th class="text-left">Created</th>
              <th class="text-left">Action</th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="featuredJob in featuredJob" :key="featuredJob.id">
              <td>
                <v-card class="mx-auto my-2 company_info">
                  <div class="company_logo">
                    <v-img
                      :src="`http://127.0.0.1:8000/${featuredJob.companyLogo}`"
                    ></v-img>
                  </div>
                  <div class="job_info">
                    <v-card-title
                      ><a href="#"> {{ featuredJob.title }}</a>
                    </v-card-title>
                    <ul class="company_seat">
                      <li>
                        <v-icon>mdi-compare</v-icon
                        >{{ featuredJob.companyName }}
                      </li>
                      <li>
                        <v-icon>mdi-map-marker-outline </v-icon
                        >{{ featuredJob.location }}
                      </li>
                      <li>
                        <v-icon>mdi-clock-time-two-outline</v-icon
                        >{{ featuredJob.time }}
                      </li>
                      <li><v-icon>mdi-cash</v-icon>{{ featuredJob.price }}</li>
                    </ul>
                    <ul class="company_time">
                      <li>{{ featuredJob.companyTime }}</li>
                      <li>{{ featuredJob.companyStates }}</li>
                      <li>{{ featuredJob.projectDuration }}</li>
                    </ul>
                  </div>
                </v-card>
              </td>
              <td>{{ featuredJob.post_title }}</td>
              <td>{{ featuredJob.date_post }}</td>
              <td>
                <v-btn><v-icon>mdi-eye-outline</v-icon></v-btn>
                <v-btn><v-icon>mdi-delete-outline</v-icon></v-btn>
              </td>
            </tr>
          </tbody>
        </v-table>
        <v-btn size="x-large" class="form_fild_btn" to="#"
          >Load More Listing</v-btn
        >
      </v-row>
    </v-container>
  </div>
</template>
<script>
export default {
  data: () => ({
    featuredJob: [
      {
        id: "1",
        companyLogo: "assest/img/job-alerts/1-1.webp",
        title: "Software Engineer (Android), Libraries",
        companyName: "Segment",
        location: "London, UK",
        time: "12:09",
        price: "1500$",
        companyTime: "Full Time",
        companyStates: "Private",
        projectDuration: "Urgent",
        post_title: "Human Resources, Junior",
        date_post: "Nov 12, 2021",
      },
      {
        id: "2",
        companyLogo: "assest/img/job-alerts/1-2.webp",
        title: "Recruiting Coordinator",
        companyName: "Catalyst",
        location: "London, UK",
        time: "12:09",
        price: "1500$",
        companyTime: "Part Time",
        companyStates: "Private",
        projectDuration: "Urgent",
        post_title: "Human Resources, Junior",
        date_post: "Nov 12, 2021",
      },
      {
        id: "2",
        companyLogo: "assest/img/job-alerts/1-3.webp",
        title: "Recruiting Coordinator",
        companyName: "Catalyst",
        location: "London, UK",
        time: "12:09",
        price: "1500$",
        companyTime: "Part Time",
        companyStates: "Private",
        projectDuration: "Urgent",
        post_title: "Human Resources, Junior",
        date_post: "Nov 12, 2021",
      },
      {
        id: "2",
        companyLogo: "assest/img/job-alerts/1-4.webp",
        title: "Recruiting Coordinator",
        companyName: "Catalyst",
        location: "London, UK",
        time: "12:09",
        price: "1500$",
        companyTime: "Part Time",
        companyStates: "Private",
        projectDuration: "Urgent",
        post_title: "Human Resources, Junior",
        date_post: "Nov 12, 2021",
      },
    ],
  }),
};
</script>

<style >
/* // featured jobs only */
.job_alerts {
  padding: 65px 0 85px;
}
.job_alerts .sec-title {
  margin-bottom: 50px;
}
.job_alerts .sec-title h2 {
  position: relative;
  display: block;
  font-size: 30px;
  line-height: 1.2em;
  color: #202124;
  font-weight: 500;
}
.job_alerts .sec-title .text {
  position: relative;
  margin-top: 15px;
  font-size: 15px;
  line-height: 26px;
  color: #696969;
  font-weight: 400;
}
.job_alerts a.load_more {
  font-size: 19px;
  line-height: 20px;
  border-radius: 8px;
  font-weight: 400;
  padding: 15px 28px;
  background-color: #1967d2;
  text-decoration: unset;
  display: table;
  color: #fff;
}
.job_alerts .company_info {
  padding: 15px;
  width: 100%;
  display: flex;
}
.company_logo,
.company_logo .v-responsive {
  width: 60px;
  height: 100%;
}
.company_logo img {
  display: block !important;
  width: 100%;
  height: 100%;
  position: relative;
}
.job_info .v-card-title {
  padding-top: 0;
}
.job_info ul {
  display: flex;
  justify-content: flex-start;
  flex-direction: row;
  flex-wrap: wrap;
  padding-left: 13px;
}
.job_info ul li {
  font-size: 15px;
  margin-right: 15px;
}
.job_info ul li i {
  font-size: 19px;
}
.job_info ul.company_time {
  margin-top: 8px;
}
.job_info ul.company_time li {
  position: relative;
  font-size: 13px;
  line-height: 15px;
  margin-right: 15px;
  padding: 5px 20px;
  border-radius: 50px;
  margin-bottom: 10px;
  background: rgba(25, 103, 210, 0.15);
  color: #1967db;
}
.job_info ul.company_time li:nth-child(2) {
  background: #93faae;
  color: #34a853;
}
.job_info ul.company_time li:nth-child(3) {
  background: #fddb91;
  color: #ffae00;
}

.job_info .v-card-title a {
  color: #202124;
  text-decoration: unset;
}
.job_alerts_table button.v-btn {
  background: #1967d212;
  border-radius: 8px;
  font-size: 16px;
  color: #1967d2;
  text-align: center;
  transition: all 0.3s ease;
}
.job_alerts_table .form_fild_btn {
  margin-top: 15px;
}
</style>


