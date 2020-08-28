<template>
  <div class="content-page">
    <div>
      <category-create></category-create>
    </div>

    <div>
      <category-list></category-list>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import VueHead from "vue-head";
import verify from "@/mixins/verify";
import CategoryCreate from "@/components/categories/CategoryCreate.vue";
import CategoryList from "@/components/categories/CategoryList.vue";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";

export const eventBus = new Vue();

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

