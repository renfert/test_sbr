<template >
  <div class="content-page">
    <settings-edit></settings-edit>
  </div>
  <!-- End of wrapper -->
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import VueHead from "vue-head";
import domains from "@/mixins/domains";
import SettingsEdit from "@/components/settings/SettingsEdit.vue";
import alerts from "@/mixins/alerts";
import verify from "@/mixins/verify";

Vue.use(VueAxios, axios);
Vue.use(VueHead);

export default {
  mixins: [domains, alerts, verify],
  created() {
    this.verifyAdministratorPrivileges();
  },
  head: {
    title: {
      inner: "Settings"
    },
    meta: [
      { name: "charset", content: "utf-8" },
      { name: "viewport", content: "width=device-width, initial-scale=1.0" },
      { name: "author", content: "Sabiorealm" }
    ]
  },
  components: {
    SettingsEdit
  }
};
</script>

<style>
</style>
