import Vue from "vue";
import App from "./App.vue";
import router from "@/router";
import store from "./store/store.js";
import axios from "axios";
import Helpers from "./mixins/helpers";
import Domains from "./mixins/domains";
import Alerts from "./mixins/domains";
import Verify from "./mixins/verify";
import "@/assets/css/bootstrap.min.css";
import "@/assets/css/icons.css";
import "@/assets/css/style.scss";
import "@/assets/fontawesome/css/all.css";
import "mdbvue/lib/css/mdb.min.css";
import "@/assets/css/vueWysiwyg.css";

Vue.prototype.$request = axios;
Vue.mixin(Helpers);
Vue.mixin(Domains);
Vue.mixin(Alerts);
Vue.mixin(Verify);

new Vue({
  render: h => h(App),
  router,
  store
}).$mount("#sbr");
