<template >
  <div class="content-page">
    <group-create></group-create>
    <group-list></group-list>
  </div>
</template>

<script>
import GroupCreate from "@/components/groups/GroupCreate.vue";
import GroupList from "@/components/groups/GroupList.vue";
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import VueHead from "vue-head";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import verify from "@/mixins/verify";

export const eventBus = new Vue();

Vue.use(VueAxios, axios);
Vue.use(VueHead);
export default {
  mixins: [domains, alerts, verify],
  components: {
    GroupCreate,
    GroupList
  },
  created: function() {
    this.verifyAdministratorPrivileges();
  },
  head: {
    title: {
      inner: "Groups"
    },
    meta: [
      { name: "charset", content: "utf-8" },
      { name: "viewport", content: "width=device-width, initial-scale=1.0" },
      { name: "author", content: "Sabiorealm" }
    ]
  }
};
</script>
