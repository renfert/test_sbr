<template>
  <!-- Content page -->
  <div class="content-page">
    <div class="center">
      <!-- Group tabs -->
      <div id="tabs">
        <el-tabs type="border-card">
          <el-tab-pane>
            <span slot="label">
              <i class="el-icon-user"></i>
              {{ lang['profile'] }}
            </span>
            <profile :user-id="userId"></profile>
          </el-tab-pane>

          <el-tab-pane>
            <span slot="label">
              <i class="mdi mdi-book-outline"></i>
              {{ lang['courses'] }}
            </span>
            <courses :user-id="userId" :user-role="roleId"></courses>
          </el-tab-pane>

          <el-tab-pane>
            <span slot="label">
              <i class="el-icon-s-unfold"></i>
              {{ lang['programs'] }}
            </span>
            <programs :user-id="userId"></programs>
          </el-tab-pane>
        </el-tabs>
      </div>
    </div>
  </div>
</template>

<script>
import Vue from 'vue';
import Courses from '@/components/user/Courses';
import Programs from '@/components/user/Programs';
import Profile from '@/components/user/Profile';
import VueHead from 'vue-head';

import { mapState } from 'vuex';

export const eventBus = new Vue();

Vue.use(VueHead);

export default {
  data: () => {
    return {
      userId: '',
      name: '',
      avatar: '',
      roleId: ''
    };
  },
  created() {
    this.userId = this.$route.params.id;
    this.$verifyAdministratorPrivileges();
    this.getUser();
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    getUser() {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest('user', 'get');
      formData.set('userId', this.userId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then((response) => {
        this.name = response.data.name;
        this.avatar = response.data.avatar;
        this.roleId = response.data.myrole_id;
      });
    }
  },
  head: {
    title: {
      inner: 'Manage user'
    },
    meta: [
      { name: 'charset', content: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1.0' },
      { name: 'author', content: 'Sabiorealm' }
    ]
  },
  components: {
    Courses,
    Programs,
    Profile
  }
};
</script>
