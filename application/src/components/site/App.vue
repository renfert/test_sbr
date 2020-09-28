<template>
  <el-row>
    <el-col :sm="4" :xs="24" v-if="fullScreen == false">
      <toolbar></toolbar>
    </el-col>
    <el-col style="margin-left: 13%" :sm="24" :xs="24">
      <preview class="preview" :full-screen-button="true"></preview>
    </el-col>
  </el-row>
</template>

<script>
import Toolbar from '@/components/site/toolbar/Toolbar.vue';
import Vue from 'vue';
import VueHead from 'vue-head';

export const eventBus = new Vue();

Vue.use(VueHead);

export default {
  data: () => {
    return {
      fullScreen: false
    };
  },
  created() {
    eventBus.$on('full-screen', () => {
      if (this.fullScreen === true) {
        this.fullScreen = false;
      } else {
        this.fullScreen = true;
      }
    });
    this.$verifyAdministratorPrivileges();
  },
  head: {
    title: {
      inner: 'Site'
    },
    meta: [
      { name: 'charset', content: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1.0' },
      { name: 'author', content: 'Sabiorealm' }
    ]
  },
  components: {
    Toolbar,
    Preview: () => import('@/components/site/SitePreview.vue')
  }
};
</script>

<style scoped>
#wrapper {
  overflow-y: hidden;
}

.el-menu--collapse {
  width: 71px !important;
}
.col-xl-8,
.col-xl-4,
.col-xl-12,
.col-xl-3 {
  padding: 0px !important;
}
.content-page .content {
  padding: 0px !important;
}

.container-fluid {
  padding-left: 0px !important;
  padding-right: 0px !important;
}

#wrapper.enlarged .content-page {
  margin-left: 0px;
}

.col-xl-9 {
  padding: 0px;
}

header {
  width: 75% !important;
}

@media only screen and (max-width: 600px) {
  .preview {
    display: none;
  }
}
</style>
