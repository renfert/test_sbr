<template>
  <div id="wrapper">
    <!-- Content page -->
    <div class="content-page">
      <div class="content">
        <div class="container-fluid">
          <div class="row gap-5">
            <category-create></category-create>
          </div>

          <div class="row">
            <category-list></category-list>
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
import axios from "axios";
import VueAxios from "vue-axios";
import VueHead from "vue-head";
import verify from "@/mixins/verify";
import CategoryCreate from "@/components/categories/CategoryCreate.vue";
import CategoryList from "@/components/categories/CategoryList.vue";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
export const eventBus = new Vue();

Vue.use(VueAxios, axios);
Vue.use(VueHead);
export default {
  mixins: [verify, domains, alerts],
  components: {
    CategoryCreate,
    CategoryList
  },
  created() {
    this.blockStudentAccess();
  },
  head: {
    title: {
      inner: "Categories"
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
