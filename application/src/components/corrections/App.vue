<template >
  <div class="content-page">
    <corrections-list></corrections-list>
  </div>
</template>

<script>
import CorrectionsList from "@/components/corrections/CorrectionsList.vue";
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
    CorrectionsList
  },
  created() {
    this.verifyInstructorPrivileges();
  },
  head: {
    title: {
      inner: "Corrections"
    },
    meta: [
      { name: "charset", content: "utf-8" },
      { name: "viewport", content: "width=device-width, initial-scale=1.0" },
      { name: "author", content: "Sabiorealm" }
    ]
  }
};
</script>

