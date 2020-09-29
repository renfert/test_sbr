<template>
  <div class="content-page">
    <group-create v-if="user.role == 1"></group-create>
    <group-list></group-list>
  </div>
</template>

<script>
import Vue from 'vue';
import GroupCreate from '@/components/groups/GroupCreate.vue';
import GroupList from '@/components/groups/GroupList.vue';
import VueHead from 'vue-head';
import { mapState } from 'vuex';

export const eventBus = new Vue();

Vue.use(VueHead);

export default {
  components: {
    GroupCreate,
    GroupList
  },
  computed: {
    ...mapState(['user'])
  },
  created() {
    this.$blockStudentAccess();
  },
  head: {
    title: {
      inner: 'Groups'
    },
    meta: [
      { name: 'charset', content: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1.0' },
      { name: 'author', content: 'Sabiorealm' }
    ]
  }
};
</script>
