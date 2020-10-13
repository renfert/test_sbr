<template>
  <div class="content-page">
    <reports v-if="user.role != 3"></reports>
    <dashboards></dashboards>
  </div>
</template>

<script>
import Vue from 'vue';
import VueHead from 'vue-head';
import Reports from '@/components/reports/App';
import Dashboards from '@/components/dashboards/Dashboards';
import { mapState } from 'vuex';

Vue.use(VueHead);

export default {
  components: {
    Dashboards,
    Reports
  },
  computed: {
    ...mapState(['user'])
  },
  head: {
    title: {
      inner: 'Dashboard'
    },
    meta: [
      { name: 'charset', content: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1.0' },
      { name: 'author', content: 'Sabiorealm' }
    ]
  }
};
</script>
