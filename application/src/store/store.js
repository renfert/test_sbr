// store.js

import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    lang: {},
    userRole: "",
    userId: "",
    courseId: "",
    plan: ""
  },
  mutations: {
    setLang: (state, obj) => {
      state.lang = obj;
    },
    setUser: (state, obj) => {
      state.userId = obj.id;
      state.userRole = obj.role;
    },
    setPlan: (state, obj) => {
      state.plan = obj;
    }
  }
});
