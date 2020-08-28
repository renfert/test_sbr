import Vue from "vue";
import VueGtag from "vue-gtag";
import VueGtm from "vue-gtm";

import { mapState } from "vuex";

const integrations = {
  data: () => {
    return {
      currentRoute: ""
    };
  },
  computed: {
    ...mapState(["userRole"])
  },
  methods: {
    loadIntegrations() {
      let urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        "integrations",
        "getIntegrations"
      );
      this.$request.get(urlToBeUsedInTheRequest).then(response => {
        /* Google analytics */
        let gaId = response.data["ga_id"];
        Vue.use(VueGtag, {
          config: {
            id: gaId
          }
        });

        /* Google tag manager */
        let gtmId = response.data["gtm_id"];
        Vue.use(VueGtm, {
          id: gtmId
        });

        /* Hotjar */
        (function(h, o, t, j, a, r) {
          h.hj =
            h.hj ||
            function() {
              (h.hj.q = h.hj.q || []).push(arguments);
            };
          h._hjSettings = { hjid: 1871028, hjsv: 6 };
          a = o.getElementsByTagName("head")[0];
          r = o.createElement("script");
          r.async = 1;
          r.src = t + h._hjSettings.hjid + j + h._hjSettings.hjsv;
          a.appendChild(r);
        })(window, document, "https://static.hotjar.com/c/hotjar-", ".js?sv=");

        /* Tawk to */
        if (
          this.currentRoute != "/" &&
          this.currentRoute != "/site" &&
          this.currentRoute != "/products" &&
          this.currentRoute != "/product" &&
          this.userRole == 1
        ) {
          var Tawk_API = Tawk_API || {};
          (function() {
            var s1 = document.createElement("script"),
              s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = "https://embed.tawk.to/5f0cb00d67771f3813c0f72a/default";
            s1.charset = "UTF-8";
            s1.setAttribute("crossorigin", "*");
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
