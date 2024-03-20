<template>
  <div class="single_blog_page">
    <v-card :loading="loading" class="mx-auto my-12">
      <v-card-item>
        <v-card-title
          >Attract Sales And Profits toward the sunshine - and shadows will fall
          behind you.</v-card-title
        >
        <!-- <v-card-subtitle>
          <span class="me-1">Local Favorite</span>
        </v-card-subtitle> -->
        <div class="px-4">
          <v-chip-group v-model="selection">
            <v-chip>
              <v-avatar>
                <v-img
                  alt="John"
                  src="https://cdn.vuetifyjs.com/images/john.jpg"
                ></v-img> </v-avatar
              >Alison Dawn</v-chip
            >
            <v-chip>August 31, 2021</v-chip>
            <v-chip>12 Comment</v-chip>
          </v-chip-group>
        </div>
      </v-card-item>

      <v-img
        src="http://127.0.0.1:8000/assest/img/RecentNewsArticles/1.webp"
        cover
      ></v-img>
      <v-container class="w-50">
        <v-card-title>Course Description</v-card-title>
        <v-card-text>
          <div>
            Aliquam hendrerit sollicitudin purus, quis rutrum mi accumsan nec.
            Quisque bibendum orci ac nibh facilisis, at malesuada orci congue.
            Nullam tempus sollicitudin cursus. Ut et adipiscing erat. Curabitur
            this is a text link libero tempus congue.
          </div>
          <div>
            Duis mattis laoreet neque, et ornare neque sollicitudin at. Proin
            sagittis dolor sed mi elementum pretium. Donec et justo ante.
            Vivamus egestas sodales est, eu rhoncus urna semper eu. Cum sociis
            natoque penatibus et magnis dis parturient montes, nascetur
            ridiculus mus. Integer tristique elit lobortis purus bibendum, quis
            dictum metus mattis. Phasellus posuere felis sed eros porttitor
            mattis. Curabitur massa magna, tempor in blandit id, porta in
            ligula. Aliquam laoreet nisl massa, at interdum mauris sollicitudin
            et
          </div>
        </v-card-text>
        <v-card>
          <v-card-text class="pb-0">
            <p>
              Aliquam hendrerit sollicitudin purus, quis rutrum mi accumsan nec.
              Quisque bibendum orci ac nibh facilisis, at malesuada orci congue.
            </p>
            <p class="text-h6 text--primary">Luis Pickford</p>
          </v-card-text>
        </v-card>
        <v-card-title>What you'll learn</v-card-title>
        <v-list class="what_you">
          <v-list-item>Become a UI/UX designer.</v-list-item>
          <v-list-item>Build a UI project from beginning to end.</v-list-item>
          <v-list-item
            >You will be able to start earning money Figma skills.</v-list-item
          >
          <v-list-item>Work with colors & fonts.</v-list-item>
          <v-list-item>You will create your own UI Kit.</v-list-item>
          <v-list-item>Build a UI project from beginning to end.</v-list-item>
          <v-list-item
            >You will be able to start earning money Figma skills.</v-list-item
          >
          <v-list-item>Work with colors & fonts.</v-list-item>
          <v-list-item>You will create your own UI Kit.</v-list-item></v-list
        >
        <v-card-title>Requirements</v-card-title>
        <ul class="requirement">
          <li>
            We do not require any previous experience or pre-defined skills to
            take this course. A great orientation would be enough to master
            UI/UX design.
          </li>
          <li>A computer with a good internet connection.</li>
          <li>Adobe Photoshop (OPTIONAL)</li>
        </ul>

        <div class="d-flex py-3 justify-space-between">
          <v-list-item density="compact">
            <v-list-item-title>Previous Post</v-list-item-title>
            <v-list-item-subtitle
              >Given Set was without from god divide rule
              Hath</v-list-item-subtitle
            >
          </v-list-item>
          <v-list-item density="compact">
            <v-list-item-title>Next Post</v-list-item-title>
            <v-list-item-subtitle
              >Tree earth fowl given moveth deep lesser
              After</v-list-item-subtitle
            >
          </v-list-item>
        </div>
        <v-divider class="mx-4 mb-1"></v-divider>

        <v-list lines="one">
          <v-list-item
            title="Oscar Cafeo"
            prepend-avatar="https://randomuser.me/api/portraits/women/8.jpg"
          >
            <v-list-item-subtitle>Beautiful courses After</v-list-item-subtitle>
            <v-list-item-subtitle
              >Far much that one rank beheld bluebird after outside ignobly
              allegedly more when oh arrogantly vehement tantaneously eel
              valiantly petted this along across highhandedly
              much.</v-list-item-subtitle
            >
          </v-list-item>
          <v-list-item
            title="Alex Morgan"
            prepend-avatar="https://randomuser.me/api/portraits/women/8.jpg"
          >
            <v-list-item-subtitle> Beautiful courses</v-list-item-subtitle>
            <v-list-item-subtitle
              >Far much that one rank beheld bluebird after outside ignobly
              allegedly more when oh arrogantly vehement tantaneously eel
              valiantly petted this along across highhandedly
              much.</v-list-item-subtitle
            >
          </v-list-item>
        </v-list>
        <v-card class="mx-auto">
          <v-form>
            <v-text-field
              v-model="YourName"
              :rules="YourName"
              label="Your Name"
            ></v-text-field>

            <v-text-field
              v-model="YourEmail"
              :rules="YourEmail"
              label="Your Email"
            ></v-text-field>
            <v-text-field
              v-model="Subject"
              :rules="Subject"
              label="Subject"
            ></v-text-field>

            <v-textarea
              label="massage"
              model-value="Wright you massage here."
              name="input-7-1"
              variant="filled"
              auto-grow
            ></v-textarea>
            <v-btn class="mt-2 form_fild_btn" type="submit" block>Submit</v-btn>
          </v-form>
        </v-card>
      </v-container>
    </v-card>
  </div>
</template>

<script>
export default {
  data: () => ({
    recentNews: [
      {
        id: "1",
        img: "assest/img/RecentNewsArticles/1.webp",
        title: "Attract Sales And Profits",
        date: "August 31, 2021 ",
        icon: "mdi-circle-small",
        comment: "comment",
        text: "A job ravenously while Far much that one rank beheld after outside",
      },
    ],
  }),
};
</script>
<style>
.single_blog_page .v-card .v-card-item__content {
  display: flex;
  flex-direction: column;
  align-items: center;
}
.single_blog_page .v-card .v-slide-group span.v-chip span.v-chip__underlay {
  background: transparent;
}
.single_blog_page .v-card .v-slide-group span.v-chip .v-chip__content {
  gap: 8px;
}
.single_blog_page .v-card .v-card-item {
  margin: 25px;
}
.single_blog_page .v-card .v-card {
  padding: 4%;
  width: 70%;
  margin: 20px auto;
}
.single_blog_page .v-card ul.requirement {
  list-style: disc;
}
.single_blog_page .v-card .v-list {
  display: flex;
  flex-wrap: wrap;
}
.single_blog_page .v-card .v-list .v-list-item {
  width: 50%;
}
</style>