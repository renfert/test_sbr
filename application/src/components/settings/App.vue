<template>
  <div class="content-page">
    <settings-edit></settings-edit>
  </div>
</template>

<script>
import Vue from 'vue';
import VueHead from 'vue-head';
import SettingsEdit from '@/components/settings/SettingsEdit.vue';

Vue.use(VueHead);

export default {
  created() {
    this.$verifyAdministratorPrivileges();
  },
  head: {
    title: {
      inner: 'Settings'
    },
    meta: [
      { name: 'charset', content: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1.0' },
      { name: 'author', content: 'Sabiorealm' }
    ]
  },
  components: {
    SettingsEdit
  }
};
</script>
