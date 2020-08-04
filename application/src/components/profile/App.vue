<template >
  <div id="wrapper">
    <lang></lang>
    <!-- Content page -->
    <div class="content-page">
      <div class="content">
        <div class="container-fluid">
          <div class="row gap5">
            <div class="col-3"></div>
            <profile-edit></profile-edit>
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
import axios from "axios";
import VueAxios from "vue-axios";
import Lang from "@/components/helper/HelperLang.vue";
import ProfileEdit from "@/components/profile/ProfileEdit";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import headerTags from "@/mixins/headerTags";
import integrations from "@/mixins/integrations";
import verify from "@/mixins/verify";
export const eventBus = new Vue();

Vue.use(VueAxios, axios);
Vue.use(VueHead);
export default {
  mixins: [domains, alerts, integrations, headerTags, verify],
  data: () => {
    return {
      img: "",
      lang: {}
    };
  },
  components: {
    Lang,
    ProfileEdit
  },
  created() {
    this.verifySession();
    this.loadIntegrations();
    this.createFavicon();
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

<style>
.image-no-results {
  width: 100%;
}
.box-construction {
  background-color: #fcfcfc !important;
}
.text-no-results {
  margin-top: 25%;
}
</style>
