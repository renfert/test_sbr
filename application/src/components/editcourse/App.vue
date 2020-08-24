<template >
  <div class="content-page">
    <div class="form-wizard-wrapper">
      <wizard-nav></wizard-nav>
      <div class="form-wizard-content-wrapper">
        <first-step></first-step>
        <second-step></second-step>
        <third-step></third-step>
      </div>
    </div>
  </div>
</template>

<script>
import WizardNav from "@/components/newcourse/WizardNav";
import FirstStep from "@/components/editcourse/FirstStep";
import SecondStep from "@/components/editcourse/SecondStep";
import ThirdStep from "@/components/editcourse/ThirdStep";
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import VueHead from "vue-head";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import verify from "@/mixins/verify";

export const eventBus = new Vue();

Vue.use(VueAxios, axios);
Vue.use(VueHead);

export default {
  mixins: [domains, alerts, verify],
  created: function() {
    this.blockStudentAccess();
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
    WizardNav,
    FirstStep,
    SecondStep,
    ThirdStep
  }
};
</script>

<style scoped>
.form-wizard-wrapper {
  position: relative !important;
}
</style>
