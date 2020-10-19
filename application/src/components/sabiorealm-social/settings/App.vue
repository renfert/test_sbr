<template>
  <div class="content-page">
    <h2 class="center m-b-30">Social settings</h2>

    <el-tabs type="border-card">
      <el-tab-pane>
        <span slot="label">
          <i class="mdi mdi-book-outline"></i>
          {{ lang['courses'] }}
        </span>
        <courses></courses>
      </el-tab-pane>

      <el-tab-pane v-if="user.role == 1">
        <span slot="label">
          <i class="mdi mdi-account-multiple-outline"></i>
          {{ lang['groups'] }}
        </span>
        <groups></groups>
      </el-tab-pane>

      <el-tab-pane v-if="user.role == 1">
        <span slot="label">
          <i class="mdi mdi-account-star-outline"></i>
          {{ lang['programs'] }}
        </span>
        <programs></programs>
      </el-tab-pane>
    </el-tabs>
  </div>
</template>

<script>
import Vue from 'vue';
import Courses from '@/components/sabiorealm-social/settings/Courses';
import Groups from '@/components/sabiorealm-social/settings/Groups';
import Programs from '@/components/sabiorealm-social/settings/Programs';
import VueHead from 'vue-head';
import { mapState } from 'vuex';

Vue.use(VueHead);

export const eventBus = new Vue();

export default {
  data: () => {
    return {};
  },
  created() {
    this.$blockStudentAccess();
  },
  computed: {
    ...mapState(['lang', 'user'])
  },
  head: {
    title: {
      inner: 'Manage social'
    },
    meta: [
      { name: 'charset', content: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1.0' },
      { name: 'author', content: 'Sabiorealm' }
    ]
  },
  components: {
    Courses,
    Groups,
    Programs
  }
};
</script>
