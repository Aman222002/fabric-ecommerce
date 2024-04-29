<template>
  <div class="page_404">
    <v-img
      class="page_404_img"
      src="http://127.0.0.1:8000/assest/img/page_404.jpg"
      cover
    ></v-img>
    <div class="page_404_error">
      <h1>404!</h1>
      <p>The page you are looking for could not be found.</p>
      <a href="/">BACK TO HOME</a>
    </div>
  </div>
</template>

<script>
export default {
  data: () => ({
    recentNews: [
      {
        img: "assest/img/page_404.jpg",
      },
    ],
  }),
};
</script>
<style>
.page_404,
.page_404_img {
  position: relative;
}
.page_404_error {
  position: absolute;
  top: 50%;
  left: 0;
  right: 0;
  margin: 0 auto;
  text-align: center;
  display: flex;
  flex-direction: column;
  width: 50%;
  margin-top: -150px;
}
.page_404_error h1 {
  font-weight: 900;
  font-size: 125px;
}
.page_404_error p {
  font-size: 20px;
  color: #696969;
  font-weight: 400;
  margin: 0;
}
.page_404_error a {
  color: #fff;
  background-color: #1967d2;
  font-size: 15px;
  border-radius: 8px;
  font-weight: 400;
  padding: 15px 35px 15px;
  width: 195px;
  margin: 0 auto;
  margin-top: 25px;
}
</style>