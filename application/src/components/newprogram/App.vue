<template>
  <div class="content-page">
    <create-program></create-program>
  </div>
</template>

<script>
import Vue from 'vue';
import VueHead from 'vue-head';
import CreateProgram from '@/components/newprogram/CreateProgram';

Vue.use(VueHead);

export default {
  components: {
    CreateProgram
  },
  created() {
    this.$blockStudentAccess();
  },
  head: {
    title: {
      inner: 'New program'
    },
    meta: [
      { name: 'charset', content: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1.0' },
      { name: 'author', content: 'Sabiorealm' }
    ]
  }
};
</script>
