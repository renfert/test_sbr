<template>
  <div id="wrapper">
    <!-- Content page -->
    <div class="content-page">
      <div class="content">
        <div class="container-fluid">
          <div class="row gap5">
            <dashboards></dashboards>
          </div>
        </div>
      </div>
    </div>
    <!-- End of content page -->
  </div>
  <!-- End of wrapper -->
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
