<template>
  <div class="content-page">
    <h2 class="text-center mb-5">{{ group.name }}</h2>

    <el-tabs type="border-card">
      <el-tab-pane>
        <span slot="label">
          <i class="mdi mdi-book-outline"></i>
          {{ lang['courses'] }}
        </span>
        <courses :group-id="group.id"></courses>
      </el-tab-pane>

      <el-tab-pane>
        <span slot="label">
          <i class="mdi mdi-account-multiple-outline"></i>
          {{ lang['students'] }}
        </span>
        <students :group-id="groupId"></students>
      </el-tab-pane>

      <el-tab-pane>
        <span slot="label">
          <i class="mdi mdi-account-star-outline"></i>
          {{ lang['instructors'] }}
        </span>
        <instructors :group-id="groupId"></instructors>
      </el-tab-pane>

      <el-tab-pane>
        <span slot="label">
          <i class="mdi mdi-account-star-outline"></i>
          {{ lang['programs'] }}
        </span>
        <programs :group-id="groupId"></programs>
      </el-tab-pane>
    </el-tabs>
  </div>
</template>

<script>
import Vue from 'vue';
import Courses from '@/components/group/Courses';
import Students from '@/components/group/Students';
import Instructors from '@/components/group/Instructors';
import Programs from '@/components/group/Programs';
import VueHead from 'vue-head';
import { mapState } from 'vuex';

Vue.use(VueHead);

export const eventBus = new Vue();

export default {
  data: () => {
    return {
      group: {
        id: '',
        name: ''
      }
    };
  },
  created() {
    this.group.id = this.$route.params.id;
    this.$verifyAdministratorPrivileges();
    this.getGroup();
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    getGroup() {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest('group', 'get');
      formData.set('groupId', this.groupId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then((response) => {
        this.group.name = response.data.name;
      });
    }
  },
  head: {
    title: {
      inner: 'Manage group'
    },
    meta: [
      { name: 'charset', content: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1.0' },
      { name: 'author', content: 'Sabiorealm' }
    ]
  },
  components: {
    Courses,
    Students,
    Instructors,
    Programs
  }
};
</script>
