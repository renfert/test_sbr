<template>
  <div class="content-page">
    <div>
      <students-list></students-list>
    </div>
  </div>
</template>

<script>
import Vue from 'vue';
import VueHead from 'vue-head';
import StudentsList from '@/components/students/StudentsList.vue';

export const eventBus = new Vue();

Vue.use(VueHead);

export default {
  components: {
    StudentsList
  },
  created() {
    this.$blockStudentAccess();
  },
  head: {
    title: {
      inner: 'Students'
    },
    meta: [
      { name: 'charset', content: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1.0' },
      { name: 'author', content: 'Sabiorealm' }
    ]
  }
};
</script>
