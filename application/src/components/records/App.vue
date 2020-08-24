<template >
  <div class="content-page">
    <record-list></record-list>
  </div>
  <!-- End of wrapper -->
</template>

<script>
import RecordList from "@/components/records/RecordList";
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
    RecordList
  },
  created() {
    this.verifySession();
  },
  head: {
    title: {
      inner: "Records"
    },
    meta: [
      { name: "charset", content: "utf-8" },
      { name: "viewport", content: "width=device-width, initial-scale=1.0" },
      { name: "author", content: "Sabiorealm" }
    ]
  }
};
</script>

<style>
</style>
