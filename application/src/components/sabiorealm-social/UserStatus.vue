<template>
  <div style="">
    <el-card style="">
      <el-row>
        <b> {{ lang['admin-view-topbar'] }}</b>
      </el-row>

      <el-row v-for="user in users" :key="user.id">
        <div v-if="user.myrole_id == 1">
          <el-col :md="2" :sm="2" :xs="2">
            <div
              style="
                background: #00cc00;
                border-radius: 75%;
                width: 10px;
                height: 10px;
                margin-top: 0.5vh;
              "
            ></div>
          </el-col>
          <div :md="12" :sm="12" :xs="12">
            {{ user.name }}
          </div>
        </div>
      </el-row>
      <div slot="header" class="clearfix">
        <i class="el-icon-user-solid"></i>{{ lang['users-status'] }}
      </div>

      <el-row>
        <b>{{ lang['instructor-view-topbar'] }}</b>
      </el-row>
      <el-row v-for="user in users" :key="user.id">
        <div v-if="user.myrole_id == 2">
          <el-col :md="2" :sm="2" :xs="2">
            <div
              style="
                background: #00cc00;
                border-radius: 75%;
                width: 10px;
                height: 10px;
                margin-top: 0.5vh;
              "
            ></div>
          </el-col>
          <div :md="12" :sm="12" :xs="12">
            {{ user.name }}
          </div>
        </div>
      </el-row>
      <el-row>
        <b>{{ lang['student-view-topbar'] }}</b>
      </el-row>
      <el-row v-for="user in users" :key="user.id">
        <div v-if="user.myrole_id == 3">
          <el-col :md="2" :sm="2" :xs="2">
            <div
              style="
                background: #00cc00;
                border-radius: 75%;
                width: 10px;
                height: 10px;
                margin-top: 0.5vh;
              "
            ></div>
          </el-col>
          <div :md="12" :sm="12" :xs="12">
            {{ user.name }}
          </div>
        </div>
      </el-row>
    </el-card>
  </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
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
  data() {
    return {
      users: []
    };
  },
  methods: {
    getOnlineUsers() {
      this.$request
        .post(this.$getUrlToMakeRequest('SocialNetwork', 'getOnlineUsers'))
        .then((response) => {
          this.users = response.data;
        });
    }
  },
  computed: {
    ...mapState(['lang', 'user'])
  },
  mounted() {
    this.getOnlineUsers();
  }
};
</script>

<style scoped></style>
