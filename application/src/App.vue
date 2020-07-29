<template>
  <div>
    <!-------- 
     Language
    ---------->
    <lang></lang>
    <!-------- 
     Template base
    ---------->

    <div
      v-if="
          currentRoute != null &&
          currentRoute != 'marketplace' &&
          currentRoute != 'products' &&
          currentRoute != 'product'
      "
    >
      <top-bar></top-bar>
      <admin-left-bar v-if="userRoleId == 1"></admin-left-bar>
      <instructor-left-bar v-if="userRoleId == 2"></instructor-left-bar>
      <student-left-bar v-if="userRoleId == 3"></student-left-bar>
    </div>

    <transition name="fade" mode="out-in">
      <router-view></router-view>
    </transition>
    <upgrade-plan></upgrade-plan>
    <the-trial-expired></the-trial-expired>
    <div v-if="overlay" class="overlay open"></div>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import UpgradePlan from "@/components/plans/UpgradePlan";
import TheTrialExpired from "@/components/template/TheTrialExpired";
import AdminLeftBar from "@/components/template/TheLeftBar/Admin";
import InstructorLeftBar from "@/components/template/TheLeftBar/Instructor";
import StudentLeftBar from "@/components/template/TheLeftBar/Student";
import TopBar from "@/components/template/TheTopBar.vue";
import Lang from "@/components/helper/HelperLang.vue";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import headerTags from "@/mixins/headerTags";
import integrations from "@/mixins/integrations";
import verify from "@/mixins/verify";
import { mapMutations } from "vuex";

Vue.use(VueAxios, axios);

export default {
  mixins: [domains, alerts, headerTags, integrations, verify],
  data: () => {
    return {
      overlay: false,
      userRoleId: null,
      currentRoute: null
    };
  },
  components: {
    UpgradePlan,
    TheTrialExpired,
    AdminLeftBar,
    InstructorLeftBar,
    StudentLeftBar,
    TopBar,
    Lang
  },
  watch: {
    $route() {
      this.currentRoute = this.$route.name;
    }
  },
  created() {
    this.getLanguage();
    this.loadIntegrations();
    this.createFavicon();
    this.verifySession();
  },
  mounted() {
    this.addClassNameListener();
    this.getUserProfile();
  },
  methods: {
    ...mapMutations(["setLang"]),
    getLanguage: function() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "settings",
        "getSettingsInformation"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        function(response) {
          let lang = require("../language/" +
            response.data["lang"] +
            "/lang.json");
          this.setLang(lang);
        }.bind(this)
      );
    },
    getUserProfile: function() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "user",
        "getUserProfile"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        function(response) {
          this.userRoleId = response.data["myrole_id"];
        }.bind(this)
      );
    },
    addClassNameListener: function() {
      var el = document.querySelector("body");
      var lastClassName = el.className;
      window.setInterval(
        function() {
          var className = el.className;
          if (className !== lastClassName) {
            if (el.className == "v-tour--active") {
              this.overlay = true;
            } else {
              this.overlay = false;
            }
            lastClassName = className;
          }
        }.bind(this),
        10
      );
    }
  }
};
</script>

<style>
.overlay {
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background: rgba(0, 0, 0, 0.8);
}
.overlay.open {
  position: fixed;
  z-index: 100;
  opacity: 0.6;
}

.fade-enter {
  opacity: 0;
}

.fade-enter-active {
  transition: all 0.4s ease;
}

.fade-leave-active {
  transition: opacity 0.4s ease;
  opacity: 0;
}
</style>
