<template>
  <div
    v-if="
      daysToExpiration < 0 &&
      trial == 0 &&
      currentRouteName != 'marketplace' &&
      currentRouteName != 'products' &&
      currentRouteName != 'product'
    "
    class="blocked"
    :style="
      trialContent == true
        ? 'background-image: url(https://sbrfiles.s3.amazonaws.com/images/trialexpiration.png)'
        : ''
    "
  >
    <!-- Trial expired card -->
    <div class="text-center container-trial" v-if="trialContent == true">
      <div v-if="user.role == 1">
        <h2>{{ lang['trial-expired'] }}</h2>
        <h3>{{ lang['trial-expired-message'] }}</h3>
        <div class="buttons text-center">
          <el-button
            :disabled="loading"
            v-loading="loading"
            @click="upgradePlan()"
            class="sbr-primary"
            icon="el-icon-sell"
            type="primary"
          >
            {{ lang['upgrade-plan-button'] }}</el-button
          >

          <el-button
            @click="
              trialContent = false;
              comparisonPlansContent = true;
              checkoutContent = false;
            "
            class="sbr-purple"
            icon="el-icon-guide"
            type="primary"
          >
            {{ lang['view-plan-comparison'] }}</el-button
          >
        </div>
      </div>

      <div class="text-center container-trial" v-else>
        <h2>{{ lang['trial-expired-to-another-role'] }}</h2>
        <h3>{{ lang['trial-expired-message-to-another-role'] }}</h3>
      </div>
    </div>

    <!-- Comparison table -->
    <div class="mt-5 ml-5 mr-5 text-center" v-if="comparisonPlansContent">
      <h3>
        <a
          @click="
            comparisonPlansContent = false;
            trialContent = true;
            checkoutContent = false;
          "
          class="sbr-text-primary"
          href="javascript:void(0)"
        >
          <i class="el-icon-back"></i>
          {{ lang['back'] }}
        </a>
      </h3>
      <available-plans></available-plans>
    </div>

    <!-- Checkout card -->
    <div
      v-if="checkoutContent == true"
      class="comparative-plans text-center mr-5 ml-5"
    >
      <div class="mb-5 pl-5 pr-5">
        <h3>
          <a
            @click="
              comparisonPlansContent = false;
              trialContent = true;
              checkoutContent = false;
            "
            class="sbr-text-primary"
            href="javascript:void(0)"
          >
            <i class="el-icon-back"></i>
            {{ lang['back'] }}
          </a>
        </h3>
        <hr />
        <img
          class="mt-3"
          style="width: 15%"
          src="https://sbrfiles.s3.amazonaws.com/sbr/sbr.png"
        />
        <h2 class="mb-3 mt-4">{{ lang['thank-you-title-purchase'] }}</h2>
        <h3>
          {{ lang['thank-you-pt1-purchase'] }}
          <b class="sbr-text-primary">{{ email }}</b>
          {{ lang['thank-you-pt2-purchase'] }}
        </h3>
        <h2 class="mt-5">{{ lang['have-any-doubt'] }}</h2>
        <h3 style="text-decoration: underline">
          {{ lang['access'] }}
          <a class="sbr-text-primary" href="helpcenter">help center</a>
        </h3>
        <h3 style="text-decoration: underline">
          {{ lang['or-contact'] }}
          <a class="sbr-text-primary" href="mailto:financiero@sabioreal.com"
            >financiero@sabiorealm.com</a
          >
        </h3>
      </div>
    </div>
  </div>
</template>

<script>
import AvailablePlans from '@/components/plans/AvailablePlans';

import { mapState } from 'vuex';

export default {
  components: {
    AvailablePlans
  },
  data: () => {
    return {
      plan: '',
      email: '',
      trial: '',
      name: '',
      type: '',
      step: '',
      domain: '',
      country: '',
      trialExpirationDate: '',

      comparisonPlansContent: false,
      trialContent: true,
      checkoutContent: false,
      loading: false,
      daysToExpiration: 0,
      currentDate: ''
    };
  },
  created() {
    this.getCompanyInformation();
    this.getCurrentDate();
  },
  methods: {
    getCompanyInformation() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'company',
        'getCompanyInformation'
      );
      this.$request.get(urlToBeUsedInTheRequest).then((response) => {
        this.trial = response.data.trial;
        this.plan = response.data.plan;
        this.country = response.data.country;
        this.email = response.data.email;
        this.name = response.data.contact;
        this.step = response.data.step_project;
        this.type = response.data.type_project;
        this.domain = response.data.subdomain;
        this.trialExpirationDate = response.data.expiration;
      });
    },
    upgradePlan() {
      this.loading = true;
      const formData = new FormData();
      formData.set('domain', this.domain);
      formData.set('name', this.name);
      formData.set('customerEmail', this.email);
      formData.set('plan', this.plan);
      formData.set('step', this.step);
      formData.set('type', this.type);
      formData.set('country', this.country);

      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'emails',
        'sendPurchaseEmail'
      );
      this.$request.post(urlToBeUsedInTheRequest, formData).then(() => {
        this.loading = false;
        this.trialContent = false;
        this.comparisonPlansContent = false;
        this.checkoutContent = true;
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
    getRemainingTrialDays() {
      this.calculateDifferenceBetweenDates(this.trialExpirationDate);
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
  },
  computed: {
    ...mapState(['lang', 'user']),
    currentRouteName() {
      return this.$route.name;
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.blocked {
  overflow: auto;
  display: block;
  position: fixed;
  top: 0;
  left: 0;
  bottom: 0;
  z-index: 100;
  margin-left: 230px;
  width: calc(100vw - 230px);
  background-color: white;
  background-repeat: no-repeat;
  background-size: 30%;
  background-position: center 40%;
}
.buttons {
  margin-top: 25%;
}
.container-trial {
  margin-top: 5%;
}

@media only screen and (max-width: 600px) {
  .blocked {
    display: block;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 100;
    margin-left: 0px;
    width: 100vw !important;
    height: 100vh;
    max-width: 100% !important;
    background-color: white;
    background-repeat: no-repeat;
    background-size: 100%;
    background-position: center;
  }
  .buttons {
    margin-top: 100%;
    justify-content: center !important;
  }
  .container-trial {
    margin-top: 10%;
    padding: 5%;
  }
  .container-trial h2 {
    font-size: 2em;
  }
  .container-trial h3 {
    font-size: 1.2em;
  }
}
</style>
