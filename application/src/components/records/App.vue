<template>
  <div class="content-page">
    <record-list></record-list>
  </div>
</template>

<script>
import RecordList from '@/components/records/RecordList';
import Vue from 'vue';
import VueHead from 'vue-head';

export const eventBus = new Vue();

Vue.use(VueHead);

export default {
  components: {
    RecordList
  },
  head: {
    title: {
      inner: 'Records'
    },
    meta: [
      { name: 'charset', content: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1.0' },
      { name: 'author', content: 'Sabiorealm' }
    ]
  }
};
</script>
