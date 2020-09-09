<template>
  <div class="content-page">
    <profile-edit></profile-edit>
  </div>
</template>

<script>
import Vue from 'vue';
import VueHead from 'vue-head';
import ProfileEdit from '@/components/profile/ProfileEdit';

export const eventBus = new Vue();

Vue.use(VueHead);

export default {
  components: {
    ProfileEdit
  },
  head: {
    title: {
      inner: 'Profile'
    },
    meta: [
      { name: 'charset', content: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1.0' },
      { name: 'author', content: 'Sabiorealm' }
    ]
  }
};
</script>
