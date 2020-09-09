<template>
  <div class="content-page">
    <available-plans></available-plans>
  </div>
</template>

<script>
import Vue from 'vue';
import VueHead from 'vue-head';
import AvailablePlans from '@/components/plans/AvailablePlans';

Vue.use(VueHead);

export default {
  components: {
    AvailablePlans
  },
  created() {
    this.$verifyAdministratorPrivileges();
  },
  head: {
    title: {
      inner: 'Plans'
    },
    meta: [
      { name: 'charset', content: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1.0' },
      { name: 'author', content: 'Sabiorealm' }
    ]
  }
};
</script>
