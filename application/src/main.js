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

Vue.directive('click-outside', {
  bind: function (el, binding, vnode) {
    el.clickOutsideEvent = function (event) {
      // here I check that click was outside the el and his children
      if (!(el === event.target || el.contains(event.target) || document.getElementById('fab').contains(event.target))) {
        // and if it did, call method provided in attribute value
        vnode.context[binding.expression](event);
      }
    };
    document.body.addEventListener('click', el.clickOutsideEvent)
  },
  unbind: function (el) {
    document.body.removeEventListener('click', el.clickOutsideEvent)
  },
});

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
