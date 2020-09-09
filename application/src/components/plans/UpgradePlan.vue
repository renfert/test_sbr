<template>
  <div
    id="video-overlay"
    class="video-overlay"
    :class="modal == true ? 'open' : 'hide'"
  >
    <a @click.prevent="modal = false" class="video-overlay-close">&times;</a>

    <div
      class="card-main"
      :class="comparativePlans == true ? 'scrollable' : ''"
    >
      <div class="container text-center container-desktop">
        <!-- Main card -->
        <div
          class="h-100"
          v-if="mainCard == true"
          style="transition: opacity 15s ease-out"
        >
          <div class="row justify-content-center h-100">
            <div class="col-md-6 col-12 box-plans">
              <div class="container mt-5">
                <!-- Feature image -->
                <img
                  v-if="ui == 'feature'"
                  class="mt-3"
                  src="https://sbrfiles.s3.amazonaws.com/images/trialexpiration.png"
                />

                <!-- Storage image -->
                <img
                  v-if="ui == 'storage'"
                  class="mt-3"
                  src="https://sbrfiles.s3.amazonaws.com/images/trialexpiration.png"
                />

                <!-- Trial topbar image -->
                <img
                  v-if="ui == 'trial-topbar'"
                  class="mt-3"
                  src="https://sbrfiles.s3.amazonaws.com/images/trialexpiration.png"
                />
              </div>
            </div>

            <div class="col-md-6 col-12">
              <div class="container mt-5">
                <!-- Feature text -->
                <div v-if="ui == 'feature'">
                  <h1 class="mt-5">
                    {{ lang['functionality-not-available'] }}
                  </h1>
                  <hr />
                  <h3>{{ lang['functionality-not-available-text-pt1'] }}</h3>
                  <h3>{{ lang['functionality-not-available-text-pt2'] }}</h3>
                </div>

                <!-- Storage text -->
                <div v-if="ui == 'storage'">
                  <h1 class="mt-5">{{ lang['modal-storage-title'] }}</h1>
                  <hr />
                  <h3>{{ lang['modal-storage-subtitle'] }}</h3>
                </div>

                <!-- Trial topbar text -->
                <div v-if="ui == 'trial-topbar'">
                  <h1 class="mt-5">{{ lang['modal-trial-topbar-title'] }}</h1>
                  <hr />
                  <h3>{{ lang['modal-trial-topbar-subtitle'] }}</h3>
                </div>

                <br />
                <button
                  :disabled="loading"
                  v-loading="loading"
                  @click="upgradePlan()"
                  class="sbr-btn sbr-primary"
                >
                  {{ lang['upgrade-plan-button'] }}
                  <i class="el-icon-sell"></i>
                </button>
                <br />
                <button
                  @click="
                    comparativePlans = true;
                    mainCard = false;
                    checkoutCard = false;
                  "
                  class="sbr-btn sbr-purple mt-4"
                >
                  {{ lang['view-plan-comparison'] }}
                  <i class="el-icon-guide"></i>
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Comparative plan card -->
        <div v-if="comparativePlans == true" class="comparative-plans">
          <h3 class="mb-5 text-sabiorealm">
            <a
              @click="
                comparativePlans = false;
                mainCard = true;
                checkoutCard = false;
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
        <div v-if="checkoutCard == true" class="comparative-plans">
          <div class="mb-5 pl-5 pr-5">
            <h3>
              <a
                @click="
                  comparativePlans = false;
                  mainCard = true;
                  checkoutCard = false;
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

      <!-- Mobile -->
      <div class="container-mobile text-center justify-content-center">
        <div v-if="mainCard == true">
          <h1 class="mt-5">{{ lang['functionality-not-available'] }}</h1>
          <img
            v-if="ui == 'feature'"
            style="
              position: relative;
              width: 50%;
              max-width: 50%;
              margin-left: 50%;
              left: -25%;
            "
            class="mt-3"
            src="https://sbrfiles.s3.amazonaws.com/images/trialexpiration.png"
            alt
          />
          <img
            v-if="ui == 'storage'"
            style="
              position: relative;
              width: 50%;
              max-width: 50%;
              margin-left: 50%;
              left: -25%;
            "
            class="mt-3"
            src="https://sbrfiles.s3.amazonaws.com/images/trialexpiration.png"
            alt
          />
          <img
            v-if="ui == 'trial-topbar'"
            style="
              position: relative;
              width: 50%;
              max-width: 50%;
              margin-left: 50%;
              left: -25%;
            "
            class="mt-3"
            src="https://sbrfiles.s3.amazonaws.com/images/trialexpiration.png"
          />

          <h3>{{ lang['functionality-not-available-text-pt1'] }}</h3>
          <h3>{{ lang['functionality-not-available-text-pt2'] }}</h3>
          <button
            :disabled="loading"
            v-loading="loading"
            @click="upgradePlan()"
            class="sbr-btn sbr-primary w-100 btn-mobile"
          >
            {{ lang['upgrade-plan-button'] }}
            <i class="el-icon-sell"></i>
          </button>
          <button
            @click="
              comparativePlans = true;
              mainCard = false;
              checkoutCard = false;
            "
            class="sbr-btn sbr-purple w-100 btn-mobile"
          >
            {{ lang['view-plan-comparison'] }}
            <i class="el-icon-guide"></i>
          </button>
        </div>
        <div v-if="comparativePlans == true">
          <h3 class="mb-5 text-sabiorealm">
            <a
              @click="
                comparativePlans = false;
                mainCard = true;
                checkoutCard = false;
              "
              class="text-sabiorealm"
              href="javascript:void(0)"
            >
              <i class="el-icon-back"></i>
              {{ lang['back'] }}
            </a>
          </h3>
          <available-plans></available-plans>
        </div>
        <!-- Checkout card -->
        <div v-if="checkoutCard == true">
          <div class="mb-2 mt-2 pl-2 pr-2">
            <h3>
              <a
                @click="
                  comparativePlans = false;
                  mainCard = true;
                  checkoutCard = false;
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
              style="width: 50%"
              src="https://sbrfiles.s3.amazonaws.com/sbr/sbr.png"
            />
            <h2 style="font-size: 1.5em" class="mb-3 mt-4">
              {{ lang['thank-you-title-purchase'] }}
            </h2>
            <h3>
              {{ lang['thank-you-pt1-purchase'] }}
              <b class="sbr-text-primary">{{ email }}</b>
              {{ lang['thank-you-pt2-purchase'] }}
            </h3>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Vue from 'vue';
import AvailablePlans from '@/components/plans/AvailablePlans';
import { mapState } from 'vuex';
export const eventPlan = new Vue();

export default {
  data: () => {
    return {
      plan: '',
      email: '',
      name: '',
      type: '',
      step: '',
      domain: '',
      country: '',
      ui: '',
      modal: false,
      mainCard: true,
      comparativePlans: false,
      checkoutCard: false,
      loading: false
    };
  },
  components: {
    AvailablePlans
  },
  mounted() {
    this.keypress();
    this.getCompanyInformation();

    eventPlan.$on('open-modal', () => {
      this.modal = true;
    });

    eventPlan.$on('upgrade-plan', (type) => {
      this.ui = type;
      this.modal = true;
    });
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    getCompanyInformation() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'company',
        'getCompanyInformation'
      );
      this.$request.get(urlToBeUsedInTheRequest).then((response) => {
        this.plan = response.data.plan;
        this.country = response.data.country;
        this.email = response.data.email;
        this.name = response.data.contact;
        this.step = response.data.step_project;
        this.type = response.data.type_project;
        this.domain = response.data.subdomain;
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
        this.mainCard = false;
        this.comparativePlans = false;
        this.checkoutCard = true;
      });
    },
    keypress() {
      document.onkeydown = (evt) => {
        evt = evt || window.event;
        let isEscape = false;
        if ('key' in evt) {
          isEscape = evt.key === 'Escape' || evt.key === 'Esc';
        } else {
          isEscape = evt.keyCode === 27;
        }
        if (isEscape) {
          this.modal = false;
        }
      };
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss">
.video-overlay {
  z-index: -1;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background: rgba(0, 0, 0, 0.8);
  opacity: 0;
}

.video-overlay.open {
  position: fixed;
  z-index: 3000;
  opacity: 1;
}

.video-overlay-close {
  position: absolute;
  z-index: 1000;
  top: 15px;
  right: 20px;
  font-size: 36px;
  line-height: 1;
  font-weight: 400;
  color: #fff;
  text-decoration: none;
  cursor: pointer;
  transition: all 200ms;
}

.video-overlay-close:hover {
  color: #009cd8;
}

.video-overlay div:first-child {
  position: relative;
}

.comparative-plans {
  padding: 3% 0% 8% 0%;
  transition: all ease 100ms;
}

.card-main {
  position: absolute;
  width: 70%;
  height: 80%;
  border-radius: 0px !important;
  margin-bottom: 20px;
  margin-left: 50%;
  margin-top: 3%;
  left: -35% !important;
  background-color: #fff;
  -webkit-box-shadow: 0px 0px 3px 0px #aca9a9;
  box-shadow: 0px 0px 3px 0px #aca9a9;
  transition: all ease 500ms;
}

.box-plans {
  box-shadow: 5px 0 10px -7px #888;
  padding: 0px !important;
  border-top-left-radius: 15px;
}

.scrollable {
  overflow-y: auto;
}

.container-mobile h1 {
  color: rgb(160, 174, 192) !important;
  font-weight: 800;
  font-size: 0.975rem;
}

.container-mobile h3 {
  color: rgb(160, 174, 192) !important;
  font-weight: 800;
  font-size: 0.775rem;
  padding: 20px;
}

.container h1 {
  color: rgb(160, 174, 192) !important;
  font-weight: 800;
  font-size: 1.575rem;
}

.container img {
  width: 100%;
  max-width: 100%;
}

.container h3 {
  color: rgb(160, 174, 192) !important;
  font-weight: 800;
  font-size: 0.875rem;
}

.container-mobile {
  display: none;
}

@media only screen and (max-width: 600px) {
  .container-desktop {
    display: none;
  }
  .container-mobile {
    display: initial;
  }

  .btn-mobile {
    border-radius: 0px !important;
  }

  .card-main {
    position: absolute;
    width: 90%;
    height: 80%;
    border-radius: 15px !important;
    margin-bottom: 20px;
    margin-left: 50%;
    margin-top: 3%;
    left: -45% !important;
    background-color: #fff;
    -webkit-box-shadow: 0px 0px 3px 0px #aca9a9;
    box-shadow: 0px 0px 3px 0px #aca9a9;
  }

  .video-overlay-close {
    right: 40px;
  }
}
</style>
