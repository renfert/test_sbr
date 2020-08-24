<template>
  <div class="section">
    <div class="banner" :style="styleHeader">
      <h1 :style="styleBannerHeader" class="banner-text">{{ banner["header"] }}</h1>
      <p :style="styleBannerSubHeader">{{ banner["subheader"] }}</p>
      <a
        class="btn banner-btn"
        :style="styleButton"
        :href="buttonUrl"
        :target="buttonTarget"
      >{{ banner["title"] }}</a>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import ElementUI from "element-ui";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";

import { eventBus } from "@/components/site/App";
import { mapState } from "vuex";

Vue.use(VueAxios, axios);
Vue.use(ElementUI);

export default {
  mixins: [domains, alerts],
  props: ["section-id"],
  data: () => {
    return {
      banner: [],
      image: "",
      buttonColor: "",
      buttonColorHover: "",
      headerColor: "",
      subHeaderColor: "",
      buttonStyle: "",
      buttonUrl: "",
      buttonTarget: ""
    };
  },
  mounted() {
    this.getBanner();
    eventBus.$on(
      "new-banner-change",
      function() {
        this.getBanner();
      }.bind(this)
    );
  },
  methods: {
    getBanner: function() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "site-elements/banner",
        "getBanner"
      );
      var formData = new FormData();
      formData.set("sectionId", this.sectionId);
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          this.banner = response.data[0];
          this.image =
            this.getUrlToContents() +
            "builder/body/" +
            response.data[0]["image"] +
            "";
          this.buttonColor = response.data[0]["color"];
          this.buttonColorHover = response.data[0]["color_hover"];
          this.headerColor = response.data[0]["header_color"];
          this.subHeaderColor = response.data[0]["subheader_color"];
          this.buttonStyle = response.data[0]["style"];
          this.buttonUrl = response.data[0]["url"];
          this.buttonTarget = response.data[0]["target"];
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    }
  },
  computed: {
    ...mapState(["lang"]),
    styleButton: function() {
      return {
        "background-color": this.buttonColor,
        display: this.banner["title"] == null ? "none" : "initial",
        "--color-hover": this.buttonColorHover,
        "border-radius": this.buttonStyle == "plain" ? "0px" : "50px"
      };
    },
    styleHeader: function() {
      return {
        "background-image": "url(" + this.image + ")"
      };
    },
    styleBannerHeader: function() {
      return {
        color: this.headerColor
      };
    },
    styleBannerSubHeader: function() {
      return {
        color: this.subHeaderColor
      };
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.banner-text {
  font-size: 40px;
  font-weight: 700;
  margin: 0;
  padding: 0% 25% 0% 25%;
  text-transform: uppercase;
  letter-spacing: 3px;
  text-align: center;
  color: white;
}

.banner p {
  font-size: 18px;
  padding: 0 25%;
  text-align: center;
  color: #fff;
}

.banner {
  height: 100vh;
  width: 100%;
  -webkit-backgroud-size: cover;
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center !important;
  display: -webkit-flex;
  display: -moz-flex;
  display: -ms-flex;
  display: -o-flex;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-flow: column;
  flex-wrap: wrap;
  overflow: hidden;
}

.main {
  width: 100%;
  position: relative;
}

.sabio-logo {
  padding: 1%;
}

.nav-link {
  font-size: 1.2em;
  font-family: "Poppins", sans-serif;
}

.btn {
  display: inline-block;
  font-weight: 400;
  text-align: center;
  white-space: nowrap;
  vertical-align: middle;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  border: 1px solid transparent;
  padding: 12px 25px;
  font-size: 1rem;
  line-height: 1.25;
  transition: all 0.15s ease-in-out;
  border: 2px solid transparent;
  cursor: pointer;
}

.banner-btn {
  margin: 1.5rem auto 0;
  display: flex;
  height: 44px;
  font-weight: 600;
  color: #fff !important;
  align-items: center;
  justify-content: center;
  font-size: 0.8rem !important;
}
</style>
