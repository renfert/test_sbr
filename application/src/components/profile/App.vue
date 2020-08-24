<template >
  <div class="content-page">
    <profile-edit></profile-edit>
  </div>
</template>

<script>
import Vue from "vue";
import VueHead from "vue-head";
import axios from "axios";
import VueAxios from "vue-axios";
import ProfileEdit from "@/components/profile/ProfileEdit";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
export const eventBus = new Vue();

Vue.use(VueAxios, axios);
Vue.use(VueHead);
export default {
  mixins: [domains, alerts],
  components: {
    ProfileEdit
  },
  head: {
    title: {
      inner: "Profile"
    },
    meta: [
      { name: "charset", content: "utf-8" },
      { name: "viewport", content: "width=device-width, initial-scale=1.0" },
      { name: "author", content: "Sabiorealm" }
    ]
  }
};
</script>

