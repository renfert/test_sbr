<template>
  <div id="wrapper">
    <lang></lang>
    <topbar></topbar>
    <el-container style="height: 100vh; border: 1px solid #eee">
      <navigation></navigation>
      <load-content></load-content>
    </el-container>
  </div>
  <!-- End of wrapper -->
</template>

<script>
import Lang from "@/components/helper/HelperLang.vue";
import Topbar from "@/components/viewcourse/Topbar";
import LoadContent from "@/components/viewcourse/LoadContent";
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import VueHead from "vue-head";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import ElementUI from "element-ui";
import Navigation from "@/components/viewcourse/Navigation";
import "element-ui/lib/theme-chalk/index.css";
import lang from "element-ui/lib/locale/lang/en";
import locale from "element-ui/lib/locale";
import headerTags from "@/mixins/headerTags";
import integrations from "@/mixins/integrations";
import verify from "@/mixins/verify";
export const eventBus = new Vue();

locale.use(lang);
Vue.use(ElementUI);
Vue.use(VueAxios, axios);
Vue.use(VueHead);
export default {
  mixins: [domains, alerts, integrations, headerTags, verify],
  components: {
    Lang,
    Navigation,
    Topbar,
    LoadContent
  },
  data: function() {
    return {
      mobile: "retracted"
    };
  },
  created() {
    eventBus.$on(
      "change-leftbar-class",
      function() {
        this.mobile == "retracted"
          ? (this.mobile = "opened")
          : (this.mobile = "retracted");
      }.bind(this)
    );
  },
  head: {
    title: {
      inner: "View course"
    },
    meta: [
      { name: "charset", content: "utf-8" },
      { name: "viewport", content: "width=device-width, initial-scale=1.0" },
      { name: "author", content: "Sabiorealm" }
    ]
  },
  mounted() {
    const compability = document.createElement("script");
    compability.setAttribute(
      "src",
      "https://cdn.eadtools.com/library/plugins/ViewerJS/compatibility.js"
    );
    compability.async = true;
    document.head.appendChild(compability);

    const pdf = document.createElement("script");
    pdf.setAttribute(
      "src",
      "https://cdn.eadtools.com/library/plugins/ViewerJS/pdf.js"
    );
    pdf.async = true;
    document.head.appendChild(pdf);

    const pdfWorker = document.createElement("script");
    pdfWorker.setAttribute(
      "src",
      "https://cdn.eadtools.com/library/plugins/ViewerJS/pdf.worker.js"
    );
    pdfWorker.async = true;
    document.head.appendChild(pdfWorker);

    const pdfJsVersion = document.createElement("script");
    pdfJsVersion.setAttribute(
      "src",
      "https://cdn.eadtools.com/library/plugins/ViewerJS/pdfjsversion.js"
    );
    pdfJsVersion.async = true;
    document.head.appendChild(pdfJsVersion);

    const textLayerBuilder = document.createElement("script");
    textLayerBuilder.setAttribute(
      "src",
      "https://cdn.eadtools.com/library/plugins/ViewerJS/text_layer_builder.js"
    );
    textLayerBuilder.async = true;
    document.head.appendChild(textLayerBuilder);

    const uiUtils = document.createElement("script");
    uiUtils.setAttribute(
      "src",
      "https://cdn.eadtools.com/library/plugins/ViewerJS/ui_utils.js"
    );
    uiUtils.async = true;
    document.head.appendChild(uiUtils);

    const webodf = document.createElement("script");
    webodf.setAttribute(
      "src",
      "https://cdn.eadtools.com/library/plugins/ViewerJS/webodf.js"
    );
    webodf.async = true;
    document.head.appendChild(webodf);
  }
};
</script>

<style>
.el-container {
  border: none !important;
}

/* Let's get this party started */
::-webkit-scrollbar {
  display: none;
}
</style>
