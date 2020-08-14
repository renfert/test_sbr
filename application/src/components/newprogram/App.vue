<template >
  <div class="content-page">
    <create-program></create-program>
  </div>
</template>

<script>
import Vue from "vue";
import VueHead from "vue-head";
import axios from "axios";
import VueAxios from "vue-axios";
import CreateProgram from "@/components/newprogram/CreateProgram";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import verify from "@/mixins/verify";

Vue.use(VueAxios, axios);
Vue.use(VueHead);
export default {
  mixins: [domains, alerts, verify],
  components: {
    CreateProgram
  },
  created: function() {
    this.blockStudentAccess();
  },
  head: {
    title: {
      inner: "New program"
    },
    meta: [
      { name: "charset", content: "utf-8" },
      { name: "viewport", content: "width=device-width, initial-scale=1.0" },
      { name: "author", content: "Sabiorealm" }
    ]
  }
};
</script>

