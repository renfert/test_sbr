<template >
  <div id="wrapper">
    <lang></lang>

    <!-- Content page -->
    <div class="content-page">
      <div class="content">
        <div class="container-fluid">
          <div class="form-wizard-wrapper">
            <wizard-nav></wizard-nav>
            <div class="form-wizard-content-wrapper">
              <first-step></first-step>
              <second-step></second-step>
              <third-step></third-step>
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
import WizardNav from "@/components/newcourse/WizardNav";
import FirstStep from "@/components/editcourse/FirstStep";
import SecondStep from "@/components/newcourse/SecondStep";
import ThirdStep from "@/components/editcourse/ThirdStep";
import Lang from "@/components/helper/HelperLang";
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
  mixins: [domains, alerts, headerTags, integrations, verify],
  data: () => {
    return {};
  },
  created: function() {
    this.blockStudentAccess();
    this.loadIntegrations();
    this.createFavicon();
    this.verifySession();
  },
  head: {
    title: {
      inner: "Edit course"
    },
    meta: [
      { name: "charset", content: "utf-8" },
      { name: "viewport", content: "width=device-width, initial-scale=1.0" },
      { name: "author", content: "Sabiorealm" }
    ]
  },
  components: {
    Lang,
    WizardNav,
    FirstStep,
    SecondStep,
    ThirdStep
  }
};
</script>

<style>
.container-fluid {
  padding-left: 0px !important;
  padding-right: 0px !important;
}

.form-wizard-wrapper {
  position: relative !important;
}
</style>
