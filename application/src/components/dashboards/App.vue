<template>
  <div class="content-page">
    <dashboards></dashboards>
  </div>
  <!-- End of content page -->
</template>

<script>
import Vue from "vue";
import VueHead from "vue-head";
import Dashboards from "@/components/dashboards/Dashboards";

Vue.use(VueHead);
export default {
  components: {
    Dashboards
  },
  head: {
    title: {
      inner: "Dashboard"
    },
    meta: [
      { name: "charset", content: "utf-8" },
      { name: "viewport", content: "width=device-width, initial-scale=1.0" },
      { name: "author", content: "Sabiorealm" }
    ]
  }
};
</script>

<style></style>
