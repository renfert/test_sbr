<template>
  <div class="content-page">
    <div v-if="user.role != 3">
      <course-create></course-create>
    </div>

    <div class="mb-5">
      <course-list></course-list>
    </div>
  </div>
</template>

<script>
import CourseCreate from '@/components/courses/CourseCreate.vue';
import CourseList from '@/components/courses/CourseList.vue';
import Vue from 'vue';
import VueHead from 'vue-head';

import { mapState } from 'vuex';

export const eventBus = new Vue();

Vue.use(VueHead);

export default {
  data: () => {
    return {};
  },
  computed: {
    ...mapState(['user'])
  },
  head: {
    title: {
      inner: 'Courses'
    },
    meta: [
      { name: 'charset', content: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1.0' },
      { name: 'author', content: 'Sabiorealm' }
    ]
  },
  components: {
    CourseCreate,
    CourseList
  }
};
</script>
