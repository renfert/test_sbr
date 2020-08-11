<template>
  <div>
    <!-------- 
    Language
    ---------->
    <lang></lang>
    <!-------- 
    Template base
    ---------->
    <top-bar
      v-if="currentRoute != null &&
      currentRoute != 'marketplace' && 
      currentRoute != 'products' && 
      currentRoute != 'product' && 
      currentRoute != 'viewcourse' &&
      currentRoute != 'invalidsession' &&
      currentRoute != 'purchase' &&
      currentRoute != 'site' &&
      currentRoute != '404' 
      "
    ></top-bar>
    <div
      v-if="
          currentRoute != null &&
          currentRoute != 'marketplace' &&
          currentRoute != 'products' &&
          currentRoute != 'product' && 
          currentRoute != 'viewcourse' &&
          currentRoute != 'invalidsession' &&
          currentRoute != 'purchase' &&
          currentRoute != 'site' &&
          currentRoute != '404'
      "
    >
      <admin-left-bar
        :user-name="userName"
        :user-avatar="userAvatar"
        :user-id="userId"
        :plan="plan"
        :logo="logo"
        v-if="userRoleId == 1"
      ></admin-left-bar>
      <instructor-left-bar
        :user-name="userName"
        :user-avatar="userAvatar"
        :user-id="userId"
        :logo="logo"
        :plan="plan"
        v-if="userRoleId == 2"
      ></instructor-left-bar>
      <student-left-bar
        :user-name="userName"
        :user-avatar="userAvatar"
        :user-id="userId"
        :plan="plan"
        :logo="logo"
        v-if="userRoleId == 3"
      ></student-left-bar>
    </div>

    <transition name="fade" mode="out-in">
      <router-view></router-view>
    </transition>
    <upgrade-plan></upgrade-plan>
    <the-trial-expired></the-trial-expired>
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
import TopBar from "@/components/template/TheTopBar";
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
      userRoleId: null,
      currentRoute: null,
      logo: "",
      userName: "",
      userAvatar: "",
      userId: "",
      plan: ""
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
      this.getCompanyInformation();
      this.getUserProfile();
      if (
        this.$route.name != "marketplace" &&
        this.$route.name != "invalidsession" &&
        this.$route.name != "products" &&
        this.$route.name != "product" &&
        this.$route.name != "404"
      ) {
        this.verifySession();
      }
    }
  },
  created() {
    this.getLanguage();
    this.loadIntegrations();
    this.createFavicon();
  },
  mounted() {
    this.getCompanyInformation();
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
          this.logo = response.data["logo"];
          let lang = require("../language/" +
            response.data["lang"] +
            "/lang.json");
          this.setLang(lang);
        }.bind(this)
      );
    },
    getCompanyInformation() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "company",
        "getCompanyInformation"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        function(response) {
          this.plan = response.data["plan"];
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
          this.userName = response.data["name"];
          this.userAvatar = response.data["avatar"];
          this.userId = response.data["id"];
          this.userRoleId = response.data["myrole_id"];
        }.bind(this)
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
