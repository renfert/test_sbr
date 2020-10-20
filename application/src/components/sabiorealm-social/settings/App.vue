<template>
  <div class="content-page">
    <h2 class="center m-b-30">Social settings</h2>

    <el-tabs type="border-card">
      <el-tab-pane>
        <span slot="label">
          <i class="mdi mdi-web"></i>
          {{ lang['public'] }}
        </span>
        <public></public>
      </el-tab-pane>
      <el-tab-pane>
        <span slot="label">
          <i class="mdi mdi-book-outline"></i>
          {{ lang['courses'] }}
        </span>
        <courses></courses>
      </el-tab-pane>
      <el-tab-pane>
        <span slot="label">
          <i class="mdi mdi-account-group"></i>
          {{ lang['groups'] }}
        </span>
        <groups></groups>
      </el-tab-pane>
    </el-tabs>
  </div>
</template>

<script>
import Vue from 'vue';
import Courses from '@/components/sabiorealm-social/settings/Courses';
import Groups from '@/components/sabiorealm-social/settings/Groups';
import Public from '@/components/sabiorealm-social/settings/Public';

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
    Public
  }
};
</script>
