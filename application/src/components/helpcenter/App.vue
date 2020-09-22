<template>
  <div class="content-page">
    <construction></construction>
  </div>
</template>

<script>
import Vue from 'vue';
import VueHead from 'vue-head';
import Construction from '@/components/helpcenter/Construction.vue';
import { mapState } from 'vuex';

Vue.use(VueHead);
export default {
  components: {
    Construction
  },
  computed: {
    ...mapState(['user'])
  },
  head: {
    title: {
      inner: 'Help center'
    },
    meta: [
      { name: 'charset', content: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1.0' },
      { name: 'author', content: 'Sabiorealm' }
    ]
  }
};
</script>

<style scoped></style>
