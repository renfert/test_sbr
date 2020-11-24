import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    lang: {},
    user: {
      id: '',
      name: '',
      email: '',
      avatar: '',
      role: ''
    },
    company: {
      name: '',
      plan: '',
      country: '',
      expiration: '',
      subdomain: '',
      trial: ''
    }
  },
  mutations: {
    setLang: (state, obj) => {
      state.lang = obj;
    },
    setUser: (state, obj) => {
      state.user.id = obj.id;
      state.user.role = parseInt(obj.role);
      state.user.name = obj.name;
      state.user.email = obj.email;
      state.user.avatar = obj.avatar;
    },
    setCompany: (state, obj) => {
      /* eslint-disable */
      state.company.name = obj.name;
      state.company.plan = obj.plan;
      state.company.country = obj.country;
      state.company.expiration = obj.expiration;
      state.company.subdomain = obj.subdomain;
    }
  }
});
