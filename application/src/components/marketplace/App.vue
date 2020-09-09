<template>
  <div>
    <site-preview :full-screen-button="false"></site-preview>
    <login></login>
  </div>
</template>

<script>
import Vue from 'vue';
import SitePreview from '@/components/site/SitePreview';
import Login from '@/components/login/Login';
import VueHead from 'vue-head';

export const eventBus = new Vue();

Vue.use(VueHead);

export default {
  components: {
    SitePreview,
    Login
  },
  created() {
    eventBus.$on('full-screen', () => {
      if (this.fullScreen === true) {
        this.fullScreen = false;
      } else {
        this.fullScreen = true;
      }
    });
  },
  head: {
    title: {
      inner: 'Home'
    },
    meta: [
      { name: 'charset', content: 'utf-8' },
      {
        name: 'viewport',
        content: 'width=device-width, initial-scale=1.0'
      },
      { name: 'author', content: 'Sabiorealm' }
    ]
  }
};
</script>

<style>
.col-xl-8,
.col-xl-4,
.col-xl-12,
.col-xl-3 {
  padding: 0px !important;
}
.content-page .content {
  padding: 0px !important;
}
</style>
