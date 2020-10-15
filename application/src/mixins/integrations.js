import Vue from 'vue';
import VueGtag from 'vue-gtag';
import VueGtm from 'vue-gtm';

import { mapState } from 'vuex';

const integrations = {
  data: () => {
    return {
      currentRoute: ''
    };
  },
  computed: {
    ...mapState(['user'])
  },
  watch: {
    '$store.state.user.role': {
      /* eslint-disable */
      handler: function (newValue) {
        this.loadIntegrations();
      }
    },
    $route() {
      this.currentRoute = this.$route.name;
    }
  },
  methods: {
    loadIntegrations() {
      const deviceHeight = window.screen.height;
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'integrations',
        'getIntegrations'
      );
      this.$request.get(urlToBeUsedInTheRequest).then((response) => {
        /* Google analytics */
        const gaId = response.data.ga_id;
        Vue.use(VueGtag, {
          config: {
            id: gaId
          }
        });

        /* Google tag manager */
        const gtmId = response.data.gtm_id;
        Vue.use(VueGtm, {
          id: gtmId
        });
      });
    }
  },
  mounted() {
    this.currentRoute = this.$router.currentRoute.path;
  }
};

export default integrations;
