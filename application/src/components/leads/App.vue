<template >
  <div class="content-page">
    <lead-list></lead-list>
  </div>
</template>

<script>
import Vue from "vue";
import VueHead from "vue-head";
import axios from "axios";
import VueAxios from "vue-axios";
import LeadList from "@/components/leads/LeadList.vue";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import verify from "@/mixins/verify";

export const eventBus = new Vue();

Vue.use(VueAxios, axios);
Vue.use(VueHead);
export default {
  mixins: [domains, alerts, verify],
  components: {
    LeadList
  },
  created: function() {
    this.verifyAdministratorPrivileges();
  },
  head: {
    title: {
      inner: "Leads"
    },
    meta: [
      { name: "charset", content: "utf-8" },
      { name: "viewport", content: "width=device-width, initial-scale=1.0" },
      { name: "author", content: "Sabiorealm" }
    ]
  }
};
</script>
