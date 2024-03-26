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


