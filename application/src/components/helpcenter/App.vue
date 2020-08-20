<template >
  <div class="content-page">
    <construction></construction>
  </div>
</template>

<script>
import Vue from "vue";
import VueHead from "vue-head";
import axios from "axios";
import VueAxios from "vue-axios";
import Construction from "@/components/helpcenter/Construction.vue";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";

Vue.use(VueAxios, axios);
Vue.use(VueHead);
export default {
  mixins: [domains, alerts],
  components: {
    Construction
  },
  head: {
    title: {
      inner: "Help center"
    },
    meta: [
      { name: "charset", content: "utf-8" },
      { name: "viewport", content: "width=device-width, initial-scale=1.0" },
      { name: "author", content: "Sabiorealm" }
    ]
  }
};
</script>


