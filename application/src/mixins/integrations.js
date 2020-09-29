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

        /* Tawk to */
        if (
          this.currentRoute !== '/' &&
          this.currentRoute !== 'marketplace' &&
          this.currentRoute !== '/site' &&
          this.currentRoute !== '/products' &&
          this.currentRoute !== '/product' &&
          parseInt(this.user.role) === 1
        ) {
          /* eslint-disable */
          const Tawk_API = Tawk_API || {};
          (() => {
            var s1 = document.createElement('script'),
              s0 = document.getElementsByTagName('script')[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/5f0cb00d67771f3813c0f72a/default';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
          })();
        }
      });
    }
  },
  mounted() {
    this.currentRoute = this.$router.currentRoute.path;
  }
};

export default integrations;
