<template>
  <div>
    <nav-bar></nav-bar>
    <products-list></products-list>
    <the-footer class="top-10"></the-footer>
  </div>
</template>

<script>
import Vue from 'vue';
import VueHead from 'vue-head';
import NavBar from '@/components/template/TheNavBar';
import ProductsList from '@/components/products/ProductsList';
import TheFooter from '@/components/template/TheFooter';

import { mapState } from 'vuex';

export const eventBus = new Vue();

Vue.use(VueHead);

export default {
  data: () => {
    return {
      img: '',
      videoOverlay: false
    };
  },
  components: {
    NavBar,
    ProductsList,
    TheFooter
  },
  computed: {
    ...mapState(['lang'])
  },
  head: {
    title: {
      inner: 'Products'
    },
    meta: [
      { name: 'charset', content: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1.0' },
      { name: 'author', content: 'Sabiorealm' }
    ]
  }
};
</script>

<style scoped>
.main ol {
  padding-left: 70px;
}

.main h1.course-title {
  padding: 30px 0px 10px 70px;
}

.course-card {
  margin: 0px 80px 30px 70px;
}

.course-cta {
  border-radius: 5px;
  background-color: #c5cae9 !important;
  margin: 0px 80px 20px 70px;
  padding: 10px 10px 10px 10px;
  text-align: center;
}

.course-cta h3 {
  font-family: 'Poppins', sans-serif;
  font-size: 30px;
  padding: 5px;
}

.top-10 {
  margin-top: 10%;
}

body,
html {
  background-color: white !important;
}
</style>
