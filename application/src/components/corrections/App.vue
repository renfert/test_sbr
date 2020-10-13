<template>
  <div class="content-page">
    <corrections-list></corrections-list>
  </div>
</template>

<script>
import CorrectionsList from '@/components/corrections/CorrectionsList.vue';
import Vue from 'vue';
import VueHead from 'vue-head';

export const eventBus = new Vue();

Vue.use(VueHead);

export default {
  components: {
    CorrectionsList
  },
  created() {
    this.$blockStudentAccess();
  },
  head: {
    title: {
      inner: 'Corrections'
    },
    meta: [
      { name: 'charset', content: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1.0' },
      { name: 'author', content: 'Sabiorealm' }
    ]
  }
};
</script>
