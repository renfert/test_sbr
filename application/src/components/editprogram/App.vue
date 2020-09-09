<template>
  <div class="content-page">
    <edit-program></edit-program>
  </div>
</template>

<script>
import Vue from 'vue';
import VueHead from 'vue-head';
import EditProgram from '@/components/editprogram/EditProgram';

Vue.use(VueHead);

export default {
  components: {
    EditProgram
  },
  created() {
    this.$blockStudentAccess();
  },
  head: {
    title: {
      inner: 'Edit program'
    },
    meta: [
      { name: 'charset', content: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1.0' },
      { name: 'author', content: 'Sabiorealm' }
    ]
  }
};
</script>
