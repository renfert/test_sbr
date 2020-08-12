<template >
  <div id="wrapper">
    <div class="content-page">
      <edit-program></edit-program>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import VueHead from "vue-head";
import axios from "axios";
import VueAxios from "vue-axios";
import EditProgram from "@/components/editprogram/EditProgram";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import verify from "@/mixins/verify";

Vue.use(VueAxios, axios);
Vue.use(VueHead);

export default {
  mixins: [domains, alerts, verify],
  data: () => {
    return {
      lang: {}
    };
  },
  components: {
    EditProgram
  },
  created: function() {
    this.blockStudentAccess();
  },
  head: {
    title: {
      inner: "Edit program"
    },
    meta: [
      { name: "charset", content: "utf-8" },
      { name: "viewport", content: "width=device-width, initial-scale=1.0" },
      { name: "author", content: "Sabiorealm" }
    ]
  }
};
</script>

<style scoped>
</style>
