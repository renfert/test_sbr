<template>
  <div>
    <login></login>

    <!-- Navbar -->
    <div v-if="showMobile" class="sidebar-mobile">
      <span @click.prevent="toogleSidebar" class="sidebar-mobile-close-button">✕</span>
      <ul>
        <!-- Products -->
        <li>
          <router-link to="/products" replace>
            <span>{{ lang["courses"] }}</span>
          </router-link>
        </li>

        <li v-for="element in links" :key="element.id">
          <a :href="element.url" :target="element.target">
            {{
            element.title
            }}
          </a>
        </li>

        <!-- Login button -->
        <li class="pt-5" v-if="activeSession == false">
          <a href="javascript:void(0)" @click.prevent="openLoginModal()">Login</a>
        </li>

        <li class="pt-5" v-else>
          <router-link to="/home">
            <span class="link-button" :style="linkButtonMobile">{{ lang["go-to-platform"] }}</span>
          </router-link>
        </li>
      </ul>
    </div>

    <header :style="styleHeader">
      <router-link to="/">
        <img class="logo-nav" :src="logo" :width="logoSize" />
      </router-link>

      <!-- Icon menu for mobile -->
      <ul class="ul-mobile">
        <li>
          <a @click.prevent="toogleSidebar" href="javascript:void(0)">
            <i class="ti-menu"></i>
          </a>
        </li>
      </ul>

      <ul class="ul-landscape">
        <!-- Products -->
        <li>
          <router-link to="/products">
            <span>{{ lang["courses"] }}</span>
          </router-link>
        </li>

        <!-- Links -->
        <li v-for="element in links" :key="element.id">
          <a :href="element.url" :target="element.target">
            {{
            element.title
            }}
          </a>
        </li>

        <!-- Login button -->
        <li v-if="activeSession == false">
          <a href="javascript:void(0)" @click.prevent="openLoginModal()">Login</a>
        </li>

        <li v-else>
          <router-link to="/home">
            <span class="link-button">{{ lang["go-to-platform"] }}</span>
          </router-link>
        </li>
      </ul>
    </header>
    <!-- End Navbar -->
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import Login from "@/components/login/Login";

import { eventBus } from "@/components/site/App";
import { eventLogin } from "@/components/login/Login";
import { mapState } from "vuex";

Vue.use(VueAxios, axios);

export default {
  mixins: [domains, alerts],
  props: ["full-screen-button"],
  components: {
    Login
  },
  data: () => {
    return {
      logo: "",
      logoSize: "",
      sections: null,
      loadingHeader: false,
      loadingSection: false,
      loadingFooter: false,
      footerColor: "",
      copyright: "",
      links: [],
      socialMedias: [],
      headerColor: "",
      activeSession: false,
      showMobile: false,
      primaryColor: "",
      navMobile: "display:initial !important"
    };
  },
  mounted() {
    eventLogin.$on(
      "new-login",
      function() {
        this.getSession();
      }.bind(this)
    );

    this.getSession();
    this.getPrimaryColor();
    this.listHeader();
    this.navBarSticky();
  },
  computed: {
    styleHeader: function() {
      return {
        "background-color":
          this.headerColor == "transparent"
            ? this.primaryColor
            : this.headerColor,
        width: "100%"
      };
    },
    styleBorder: function() {
      return {
        border:
          this.headerColor == "transparent"
            ? "1px solid #969bb5"
            : "1px solid white",
        padding: "5px 15px 5px 15px"
      };
    },
    linkButtonMobile: function() {
      return {
        color: "#fff",
        border: "1px solid " + this.primaryColor + "",
        "background-color": this.primaryColor
      };
    },
    ...mapState(["lang"])
  },
  methods: {
    toogleSidebar: function() {
      this.showMobile == true
        ? (this.showMobile = false)
        : (this.showMobile = true);
    },
    enterPlatform: function() {
      window.location.href = "home";
    },
    openLoginModal: function() {
      eventLogin.$emit("open-login-modal");
    },
    navBarSticky: function() {
      window.addEventListener("scroll", function() {
        var header = document.querySelector("header");
        header.classList.toggle("sticky", window.scrollY > 0);
      });
    },
    listHeader: function() {
      this.loadingHeader = true;
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "builder",
        "listHeader"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        response => {
          this.logo =
            this.getUrlToContents() +
            "builder/header/" +
            response.data[0].logo +
            "";
          this.logoSize = response.data[0].logo_size + "%";
          this.headerColor = response.data[0].color;
          this.loadingHeader = false;
          this.updateLinkListArray();
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    changeMobileButtonClass: function() {
      if (this.navMobile == "display:none !important;") {
        this.navMobile = "display:initial !important;";
      } else {
        this.navMobile = "display:none !important;";
      }
    },
    listFooter: function() {
      this.loadingFooter = true;
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "builder",
        "listFooter"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        response => {
          this.footerColor = response.data[0].color;
          this.copyright = response.data[0].copyright;
          this.loadingFooter = false;
          this.updateSocialMediaListArray();
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    fullScreen: function() {
      eventBus.$emit("full-screen");
    },
    updateSectionListArray: function() {
      this.loadingSection = true;
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "section",
        "listing"
      );
      axios.post(urlToBeUsedInTheRequest).then(
        response => {
          this.sections = response.data;
          this.loadingSection = false;
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    updateLinkListArray: function() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("link", "listing");
      axios.post(urlToBeUsedInTheRequest).then(
        response => {
          this.links = response.data;
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    updateSocialMediaListArray: function() {
      this.loading = true;
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "social",
        "listing"
      );
      axios.post(urlToBeUsedInTheRequest).then(
        response => {
          this.socialMedias = response.data;
          this.loading = false;
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    getPrimaryColor: function() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "settings",
        "getSettingsInformation"
      );
      axios.post(urlToBeUsedInTheRequest).then(
        response => {
          this.primaryColor = response.data["color"];
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    getSession: function() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "Mysessions",
        "activeSession"
      );
      axios.post(urlToBeUsedInTheRequest).then(
        response => {
          this.activeSession = response.data;
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
/* =============
    Navbar style

    - Header
    - Sticky
    - Mobile
    - Button

============= */

/* =============
Header
============= */
header {
  position: relative;
  top: 0;
  width: 100%;
  height: 90px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  transform: 0.4s;
  padding: 0px 15%;
  z-index: 2000;
  transition: 0.2s;
}

header a {
  flex: 0 0 20%;
}

header ul {
  position: relative;
  display: flex;
  justify-content: flex-end;
  align-items: center;
  margin: 0px !important;
}

header ul li {
  position: relative;
  list-style: none;
}

header ul li a {
  position: relative;
  margin: 0 15px;
  font-weight: 500;
  transition: 0.5s;
  color: white;
  font-size: 1.3em;
  font-family: "Poppins", sans-serif;
}

/* =============
   sticky
============= */
header.sticky {
  position: fixed;
  height: 75px;
  padding: 0px 15%;
  background-color: white;
  animation: smoothScroll 1.2s forwards;
}

@keyframes smoothScroll {
  0% {
    transform: translateY(-40px);
  }
  100% {
    transform: translateY(0px);
  }
}

/* =============
   Mobile
============= */

.ul-mobile {
  display: none;
}

.sidebar-mobile {
  position: fixed;
  overflow-y: auto;
  left: 0;
  background-color: #1c2138;
  width: 90%;
  height: 100vh;
  z-index: 3000 !important;
  animation: hideLeftBar 1s;
}

@keyframes hideLeftBar {
  0% {
    transform: translateX(-100px);
  }
  100% {
    transform: translateX(0px);
  }
}

.sidebar-mobile-close-button {
  width: 30px;
  height: 40px;
  margin: 10px 7px;
  display: none;
  float: right;
  color: #70798b;
  font-size: 26px;
  cursor: pointer;
  display: block;
}

.sidebar-mobile ul {
  width: 100%;
  float: left;
  padding: 0 !important;
  margin-top: 10%;
}

.sidebar-mobile ul li {
  list-style: none;
  border-top: solid 1px #2d3454;
  padding: 10px 30px;
}

.sidebar-mobile ul li a {
  position: relative;
  font-weight: 500;
  transition: 0.5s;
  color: white;
  font-size: 1.2em;
  font-family: "Poppins", sans-serif;
}

@media only screen and (max-width: 1024px) {
  .logo-nav {
    width: 80px !important;
  }
  .ul-landscape {
    display: none;
  }
  .ul-mobile {
    display: initial;
  }
  header {
    height: 90px;
  }
  header ul li a {
    font-size: 2em;
  }
}

/* =============
   Button
============= */
.link-button {
  border: 1.2px solid white;
  border-radius: 5px;
  padding: 8px 18px 8px 18px;
}
</style>
