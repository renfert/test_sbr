<template>
  <div id="wrapper">
    <!-- Content page -->
    <div class="content-page">
      <div class="content">
        <div class="container-fluid">
          <div class="row mt-5">
            <certificates-list></certificates-list>
          </div>
        </div>
      </div>
    </div>
    <!-- End of content page -->
  </div>
  <!-- End of wrapper -->
</template>

<script>
import CertificatesList from "@/components/certificates/CertificatesList.vue";
import Vue from "vue";
import VueHead from "vue-head";

Vue.use(VueHead);
export default {
  components: {
    CertificatesList
  },
  head: {
    title: {
      inner: "Certificates"
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
