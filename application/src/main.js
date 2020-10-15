import Vue from 'vue';
import axios from 'axios';
import ElementUI from 'element-ui';
import App from './App.vue';
import store from './store/store';
import Domains from './mixins/domains';
import Alerts from './mixins/alerts';
import Verify from './mixins/verify';
import router from '@/router';
import 'element-ui/lib/theme-chalk/index.css';
import '@/assets/css/bootstrap.min.css';
import '@/assets/css/icons.css';
import '@/assets/css/style.scss';
import '@/assets/fontawesome/css/all.css';
import 'mdbvue/lib/css/mdb.min.css';
import '@/assets/css/vueWysiwyg.css';

Vue.prototype.$request = axios;
Vue.mixin(Domains);
Vue.mixin(Alerts);
Vue.mixin(Verify);
Vue.use(ElementUI);
new Vue({
  render: (h) => h(App),
  router,
  store
}).$mount('#sbr');
