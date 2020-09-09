<template>
  <div class="topbar">
    <header>
      <router-link to="/"></router-link>
      <!-- Icon menu for mobile -->
      <ul class="ul-mobile">
        <li>
          <a @click.prevent="toogleSidebar" href="javascript:void(0)">
            <i class="ti-menu"></i>
          </a>
        </li>
      </ul>
    </header>

    <div
      class="top-trial"
      v-if="
        trialBar != false &&
        user.role == 1 &&
        daysToExpiration >= 0 &&
        company.plan == 'trial'
      "
    >
      <span>
        {{ lang['trial-expiration-date-info-pt1'] }}
        <b>{{ daysToExpiration }}</b>
        {{ lang['trial-expiration-date-info-pt2'] }} |
        {{ lang['upgrade-plan-info-pt1'] }}
        <a @click="upgradePlan()" href="javascript:void(0)">
          <b>{{ lang['plan'] }}</b>
        </a>
        {{ lang['upgrade-plan-info-pt2'] }}
      </span>
    </div>
  </div>
  <!-- end topbar -->
</template>

<script>
import Vue from 'vue';
import { eventPlan } from '@/components/plans/UpgradePlan';
import { mapState } from 'vuex';
export const eventTemplate = new Vue();

export default {
  props: ['trial-bar'],
  data: () => {
    return {
      role: 1,
      logo: '',
      daysToExpiration: 0,
      currentDate: ''
    };
  },
  computed: {
    ...mapState(['lang', 'company', 'user'])
  },
  created() {
    this.getCurrentDate();
    this.getCompanyLogo();
  },
  methods: {
    toogleSidebar() {
      eventTemplate.$emit('change-leftbar-class');
    },
    upgradePlan() {
      eventPlan.$emit('upgrade-plan', 'trial-topbar');
    },
    getCompanyLogo() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'settings',
        'getSettingsInformation'
      );
      this.$request.get(urlToBeUsedInTheRequest).then((response) => {
        this.logo = response.data.logo;
      });
    },
    getRemainingTrialDays() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'company',
        'getCompanyInformation'
      );
      this.$request.get(urlToBeUsedInTheRequest).then((response) => {
        this.calculateDifferenceBetweenDates(response.data.expiration);
      });
    },
    getCurrentDate() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'verify',
        'getCurrentDate'
      );
      this.$request.get(urlToBeUsedInTheRequest).then((response) => {
        this.currentDate = response.data;
        this.getRemainingTrialDays();
      });
    },
    calculateDifferenceBetweenDates(expirationDate) {
      const _MS_PER_DAY = 1000 * 60 * 60 * 24;

      // a and b are javascript Date objects
      function dateDiffInDays(a, b) {
        // Discard the time and time-zone information.
        const utc1 = Date.UTC(a.getFullYear(), a.getMonth(), a.getDate());
        const utc2 = Date.UTC(b.getFullYear(), b.getMonth(), b.getDate());

        return Math.floor((utc2 - utc1) / _MS_PER_DAY);
      }

      const a = new Date(this.currentDate);
      const b = new Date(expirationDate);
      const difference = dateDiffInDays(a, b);

      this.daysToExpiration = difference;
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
/* =============
Header
============= */
header {
  background-color: #2a2d35;
  position: relative;
  top: 0;
  width: 100%;
  height: 70px;
  display: none;
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
  font-family: 'Poppins', sans-serif;
}

.logo-nav {
  width: 80px !important;
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
  header {
    display: flex;
  }
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
