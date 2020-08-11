<template >
  <div id="wrapper" class="forced enlarged">
    <lang></lang>
    <!-- Content page -->
    <div class="content-page">
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-3 col-12" v-if="fullScreen == false">
              <toolbar></toolbar>
            </div>
            <div :class="fullScreen == false ? 'col-xl-9 col-12' : 'col-xl-12'">
              <site-preview class="preview" :full-screen-button="true"></site-preview>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End of content page -->
  </div>
  <!-- End of wrapper -->
</template>

<script>
import Lang from "@/components/helper/HelperLang.vue";
import Toolbar from "@/components/site/toolbar/Toolbar.vue";
import SitePreview from "@/components/site/SitePreview.vue";
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import VueHead from "vue-head";
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
      fullScreen: false
    };
  },
  created() {
    eventBus.$on(
      "full-screen",
      function() {
        if (this.fullScreen == true) {
          this.fullScreen = false;
        } else {
          this.fullScreen = true;
        }
      }.bind(this)
    );
    this.verifySession();
    this.verifyAdministratorPrivileges();
    this.loadIntegrations();
    this.createFavicon();
  },
  head: {
    title: {
      inner: "Site"
    },
    meta: [
      { name: "charset", content: "utf-8" },
      { name: "viewport", content: "width=device-width, initial-scale=1.0" },
      { name: "author", content: "Sabiorealm" }
    ]
  },
  components: {
    Lang,
    Toolbar,
    SitePreview
  }
};
</script>

<style scoped>
#wrapper {
  overflow-y: hidden;
}

.el-menu--collapse {
  width: 71px !important;
}
.col-xl-8,
.col-xl-4,
.col-xl-12,
.col-xl-3 {
  padding: 0px !important;
}
.content-page .content {
  padding: 0px !important;
}

.container-fluid {
  padding-left: 0px !important;
  padding-right: 0px !important;
}

#wrapper.enlarged .content-page {
  margin-left: 0px;
}

.col-xl-9 {
  padding: 0px;
}

header {
  width: 75% !important;
}

@media only screen and (max-width: 600px) {
  .preview {
    display: none;
  }
}
</style>
