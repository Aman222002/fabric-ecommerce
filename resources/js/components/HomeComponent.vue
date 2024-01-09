
   <template>
    <div>
      <div class="col-6 home-image">
        <img src="@/assets/fabric.jpg" alt="Fabric Logo" style="margin-top: 30px;">
      </div>
      <div class="a1">
        <h2 style="font-weight: bolder;"><span style="color: red;">Featured</span> Products</h2>
        <h6>Our talented master stylists will connect with you on a personal level.</h6>
      </div>
      <div class="card-container">
        <div class="card" style="width: 15rem; ">
          <img class="card-img-top" src="@/assets/1.jpg" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Woven Fabric</h5>
          </div>
        </div>
        <div class="card" style="width: 15rem;">
          <img class="card-img-top" src="@/assets/3.jpg" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Cosmo Stretch TC 67/33 MWR Fabric</h5>
          </div>
        </div>
        <div class="card" style="width: 15rem;">
          <img class="card-img-top" src="@/assets/4.jpg" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Exclusive Cotton Lawn Fabric</h5>
          </div>
        </div>
        <div class="card" style="width: 15rem;">
          <img class="card-img-top" src="@/assets/5.jpg" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Pique, Lacost</h5>
          </div>
        </div>
      </div>
      <div class="a1">
        <h2 style="font-weight: bolder;"><span style="color: red;">Best</span> Offers</h2>
        <h6>Our talented master stylists will connect with you on a personal level.</h6>
      </div>
      <div class="card-container">
        <div class="card" style="width: 12rem; ">
          <img class="card-img-top" src="@/assets/6.jpg" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title" style="color: red;">Cotten design Fabric</h5>
            <h5> at $299</h5>
          </div>
        </div>
        <div class="card" style="width: 12rem;">
          <img class="card-img-top" src="@/assets/7.jpg" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title" style="color: red;">Semi Combed Cotton Lycra Fabric</h5>
            <h5> at $499</h5>
          </div>
        </div>
        <div class="card" style="width: 12rem;">
          <img class="card-img-top" src="@/assets/8.jpg" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title" style="color: red;">New Cotton Printed Fabric</h5>
            <h5> up to 50% discount</h5>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {},
  };
  </script>
  
  <style>
  .home-image {
    width: 100vw;
    height: auto;
    overflow: hidden;
  }
  
  .home-image img {
    width: 100%;
    height: 450px;
    display: block;
  }
  
  .a1 {
    margin-top: 40px;
    text-align: center;
  }
  
  .card-container {
    margin-top: 20px;
    display: flex;
    justify-content: space-evenly; 
    margin-left: 20px;
  }
  </style> 
    
    
      