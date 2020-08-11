<template >
  <div>
    <div id="wrapper">
      <lang></lang>
      <div>
        <div class="row">
          <purchase-in-process v-if="purchaseStatus == 'pending'"></purchase-in-process>
          <purchase-success v-if="purchaseStatus == 'success'"></purchase-success>
        </div>
      </div>
    </div>
    <!-- End of wrapper -->
  </div>
</template>

<script>
import Vue from "vue";
import VueHead from "vue-head";
import axios from "axios";
import VueAxios from "vue-axios";
import Lang from "@/components/helper/HelperLang.vue";
import { eventLang } from "@/components/helper/HelperLang";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import PurchaseInProcess from "@/components/purchase/PurchaseInProcess";
import PurchaseSuccess from "@/components/purchase/PurchaseSuccess";
export const eventBus = new Vue();

Vue.use(VueAxios, axios);
Vue.use(VueHead);
export default {
  mixins: [domains, alerts],
  data: () => {
    return {
      lang: [],
      purchaseStatus: null
    };
  },
  components: {
    Lang,
    PurchaseInProcess,
    PurchaseSuccess
  },
  created() {
    this.purchaseStatus = this.$route.params.status;
  },
  mounted() {
    eventLang.$on(
      "lang",
      function(response) {
        this.lang = response;
      }.bind(this)
    );
  },
  head: {
    title: {
      inner: "Purchase"
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
</style>
