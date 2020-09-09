<template>
  <div class="content-page">
    <lead-list></lead-list>
  </div>
</template>

<script>
import Vue from 'vue';
import VueHead from 'vue-head';
import LeadList from '@/components/leads/LeadList.vue';

export const eventBus = new Vue();

Vue.use(VueHead);

export default {
  components: {
    LeadList
  },
  created() {
    this.$verifyAdministratorPrivileges();
  },
  head: {
    title: {
      inner: 'Leads'
    },
    meta: [
      { name: 'charset', content: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1.0' },
      { name: 'author', content: 'Sabiorealm' }
    ]
  }
};
</script>
