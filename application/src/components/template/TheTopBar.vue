<template>
  <div class="topbar">
    <lang></lang>
    <!-- Logo -->
    <div class="topbar-left">
      <a :href="getDomainNameToNavigation()" class="logo">
        <span>
          <img :src="getUrlToContents() + 'settings/'+logo+''" />
        </span>
        <i class="mdi mdi-layers"></i>
      </a>
    </div>

    <!-- Button mobile view to collapse sidebar menu -->
    <div class="navbar navbar-default" role="navigation">
      <div class="container-fluid">
        <ul class="nav navbar-nav list-inline navbar-left">
          <li class="list-inline-item">
            <button @click="changeLeftBarClass()" class="button-menu-mobile open-left">
              <i class="mdi mdi-menu"></i>
            </button>
          </li>
          <li class="list-inline-item"></li>
        </ul>
      </div>
      <!-- end container -->
    </div>
    <!-- end navbar -->

    <div
      class="top-trial"
      v-if="trialBar != false && role == 1 && daysToExpiration >= 0 && plan == 'trial'"
    >
      <span>
        {{lang["trial-expiration-date-info-pt1"]}}
        <b>{{daysToExpiration}}</b>
        {{lang["trial-expiration-date-info-pt2"]}} | {{lang["upgrade-plan-info-pt1"]}}
        <a
          @click="upgradePlan()"
          href="javascript:void(0)"
        >
          <b>{{lang["plan"]}}</b>
        </a>
        {{lang["upgrade-plan-info-pt2"]}}
      </span>
    </div>
  </div>
  <!-- end topbar -->
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import { eventLang } from "@/components/helper/HelperLang";
import Lang from "@/components/helper/HelperLang";
import { eventPlan } from "@/components/plans/UpgradePlan";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";

Vue.use(VueAxios, axios);
export default {
  components: {
    Lang
  },
  props: ["trial-bar"],
  mixins: [domains, alerts],
  data: () => {
    return {
      role: 1,
      logo: "",
      lang: {},
      daysToExpiration: 0,
      currentDate: "",
      plan: ""
    };
  },
  created() {
    this.getCompanyPlan();
    this.getUserProfile();
    this.getCurrentDate();
    this.getCompanyLogo();
  },
  mounted() {
    eventLang.$on(
      "lang",
      function(response) {
        this.lang = response;
      }.bind(this)
    );
  },
  methods: {
    upgradePlan: function() {
      eventPlan.$emit("upgrade-plan", "trial-topbar");
    },
    getCompanyLogo: function() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "settings",
        "getSettingsInformation"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        function(response) {
          this.logo = response.data["logo"];
        }.bind(this)
      );
    },
    getCompanyPlan: function() {
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
          this.role = response.data["myrole_id"];
        }.bind(this)
      );
    },
    getRemainingTrialDays: function() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "company",
        "getCompanyInformation"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        function(response) {
          this.calculateDifferenceBetweenDates(response.data["expiration"]);
        }.bind(this)
      );
    },
    getCurrentDate: function() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "verify",
        "getCurrentDate"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        function(response) {
          this.currentDate = response.data;
          this.getRemainingTrialDays();
        }.bind(this)
      );
    },
    calculateDifferenceBetweenDates: function(expirationDate) {
      const _MS_PER_DAY = 1000 * 60 * 60 * 24;

      // a and b are javascript Date objects
      function dateDiffInDays(a, b) {
        // Discard the time and time-zone information.
        const utc1 = Date.UTC(a.getFullYear(), a.getMonth(), a.getDate());
        const utc2 = Date.UTC(b.getFullYear(), b.getMonth(), b.getDate());

        return Math.floor((utc2 - utc1) / _MS_PER_DAY);
      }

      const a = new Date(this.currentDate),
        b = new Date(expirationDate),
        difference = dateDiffInDays(a, b);

      this.daysToExpiration = difference;
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
@media only screen and (min-width: 1024px) {
  .navbar {
    display: none;
  }
}

.navbar-custom {
  max-width: 500px;
}

ul.list-unstyled {
  width: 70px;
}

li.dropdown.notification-list {
  margin-right: 5%;
}
.view-title {
  text-align: center;
  text-transform: uppercase;
  background-color: #3bb6b6;
  color: white !important;
}
.dropdown-menu {
  padding: 0px 0 !important;
  font-size: 14px;
  -webkit-box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05);
  box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05);
}

.top-trial {
  height: 80%;
  width: 100%;
  background-color: #009cd8 !important;
  position: absolute !important;
  overflow: hidden;
  text-align: center;
}

.top-trial span {
  position: relative;
  text-align: center;
  color: white;
  font-size: 1.2em;
  margin-top: 0.7% !important;
  font-weight: 400;
  margin-left: 230px;
  line-height: 2.5;
}

.top-trial span a {
  color: white;
  text-decoration: underline;
}

@media only screen and (max-width: 600px) {
  .top-trial span {
    font-size: 1.2em;
    margin-left: 0;
    line-height: 0px;
  }
  .top-trial {
    padding-bottom: 40px !important;
  }
}
</style>
