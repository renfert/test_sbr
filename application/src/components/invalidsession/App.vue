<template>
  <!-- partial:index.partial.html -->
  <section class="page_404">
    <div class="container">
      <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
          <div class="col-sm-12 col-sm-offset-1 text-center">
            <div class="four_zero_four_bg">
              <h1 class="text-center">Invalid session</h1>
            </div>
            <div class="contant_box_404">
              <h3 class="h2">You do not have a valid session</h3>
              <p>Your session has expired or is invalid</p>

              <a class="link_404" @click.prevent="$router.replace('/')"
                >Go home</a
              >
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- partial -->
</template>

<style>
/*======================
    404 page
=======================*/

.page_404 {
  padding: 40px 0;
  background: #fff;
  font-family: 'Arvo', serif;
}

.page_404 img {
  width: 100%;
}

.four_zero_four_bg {
  background-image: url(https://cdn.dribbble.com/users/285475/screenshots/2083086/dribbble_1.gif);
  height: 400px;
  background-position: center;
}

.four_zero_four_bg h1 {
  font-size: 50px;
}

.four_zero_four_bg h3 {
  font-size: 80px;
}

.link_404 {
  color: #fff !important;
  padding: 10px 20px;
  background: #39ac31;
  margin: 20px 0;
  display: inline-block;
}

.contant_box_404 {
  margin-top: -50px;
}
</style>
