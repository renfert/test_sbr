<template>
  <div class="content-page">
    <div class="content">
      <div class="container-fluid">
        <view-program></view-program>
      </div>
    </div>
  </div>
</template>

<script>
import Vue from 'vue';
import VueHead from 'vue-head';
import ViewProgram from '@/components/viewprogram/Viewprogram';

import { mapState } from 'vuex';

export const eventBus = new Vue();

Vue.use(VueHead);

export default {
  components: {
    ViewProgram
  },
  data: () => {
    return {};
  },
  computed: {
    ...mapState(['lang'])
  },
  head: {
    title: {
      inner: 'View program'
    },
    meta: [
      { name: 'charset', content: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1.0' },
      { name: 'author', content: 'Sabiorealm' }
    ]
  }
};
</script>
