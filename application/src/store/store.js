// store.js

import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    lang: {},
    courseId: ""
  },
  mutations: {
    setLang: (state, obj) => {
      state.lang = obj;
    }
  }
});
