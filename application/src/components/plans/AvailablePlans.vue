<template>
  <div>
    <h3 class="mb-5">
      {{lang['current-plan']}}
      <b class="sbr-text-primary">{{plan}}</b>
    </h3>

    <div class="row text-center">
      <!-- Basic plan -->
      <div class="col-md-6 col-12">
        <article class="pricing-column">
          <div class="inner-box card-box" :class="plan == 'basic' ? 'sbr-shadow-primary': '' ">
            <div class="plan-header text-center">
              <h3 class="text-eadtools">
                BASIC
                <i class="far fa-paper-plane"></i>
              </h3>
              <hr />
              <!-- R$ -->
              <div v-if="country == 'Brazil'">
                <h2 class="plan-price" v-if="periodBasic == true">R$ 179</h2>
                <h2 class="plan-price" v-else>R$ 960</h2>
                <b>
                  <span class="sbr-text-primary" v-if="periodBasic == false">30% off</span>
                </b>
                <br />
                <el-switch
                  class="mt-2"
                  v-model="periodBasic"
                  :active-text="lang['monthly']"
                  :inactive-text="lang['semiannually']"
                ></el-switch>
              </div>
              <!-- USD -->
              <div v-else>
                <h2 class="plan-price" v-if="periodBasic == true">USD 55</h2>
                <h2 class="plan-price" v-else>USD 297</h2>
                <b>
                  <span class="sbr-text-primary" v-if="periodBasic == false">10% off</span>
                </b>
                <br />
                <el-switch
                  class="mt-2"
                  v-model="periodBasic"
                  :active-text="lang['monthly']"
                  :inactive-text="lang['semiannually']"
                ></el-switch>
              </div>
            </div>
            <ul class="plan-stats list-unstyled text-left">
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                <b class="sbr-text-primary">{{lang["feature-plan-courses"]}}</b>
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-basic-storage"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-basic-users"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-basic-instructors"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-content"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-mercadopago"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check text-primary"></i>
                {{lang["feature-plan-google-analytics"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check text-primary"></i>
                {{lang["feature-plan-tag-manager"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check text-primary"></i>
                {{lang["feature-plan-videoconference"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check text-primary"></i>
                {{lang["feature-plan-programs"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-times text-danger"></i>
                {{lang["feature-plan-facebook-pixel"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-times text-danger"></i>
                {{lang["feature-plan-certificate"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-times sbr-text-danger"></i>
                {{lang["feature-plan-exams"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-times text-danger"></i>
                {{lang["feature-plan-webinar"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-times text-danger"></i>
                {{lang["feature-plan-mass-import"]}}
              </li>
            </ul>
          </div>
        </article>
      </div>
      <!-- End basic plan -->

      <!-- Pro plan -->
      <div class="col-md-6 col-12">
        <article class="pricing-column">
          <div class="inner-box card-box" :class="plan == 'pro' ? 'sbr-shadow-primary': '' ">
            <div class="plan-header text-center">
              <h3 class="text-eadtools">
                PRO
                <i class="fas fa-plane-departure"></i>
              </h3>
              <hr />
              <!-- R$ -->
              <div v-if="country == 'Brazil'">
                <h2 class="plan-price" v-if="periodPro == true">R$ 469</h2>
                <h2 class="plan-price" v-else>R$ 2540</h2>
                <b>
                  <span class="sbr-text-primary" v-if="periodPro == false">30% off</span>
                </b>
                <br />
                <el-switch
                  class="mt-2"
                  v-model="periodPro"
                  :active-text="lang['monthly']"
                  :inactive-text="lang['semiannually']"
                ></el-switch>
              </div>
              <!-- USD -->
              <div v-else>
                <h2 class="plan-price" v-if="periodPro == true">USD 89</h2>
                <h2 class="plan-price" v-else>USD 480</h2>
                <b>
                  <span class="sbr-text-primary" v-if="periodPro == false">10% off</span>
                </b>
                <br />
                <el-switch
                  class="mt-2"
                  v-model="periodPro"
                  :active-text="lang['monthly']"
                  :inactive-text="lang['semiannually']"
                ></el-switch>
              </div>
            </div>
            <ul class="plan-stats list-unstyled text-left mt-2">
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                <b class="sbr-text-primary">{{lang["feature-plan-courses"]}}</b>
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-pro-storage"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-pro-users"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-pro-instructors"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-content"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-mercadopago"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-google-analytics"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-tag-manager"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-videoconference"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check text-primary"></i>
                {{lang["feature-plan-programs"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-facebook-pixel"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-certificate"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-exams"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-times sbr-text-danger"></i>
                {{lang["feature-plan-webinar"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-times sbr-text-danger"></i>
                {{lang["feature-plan-mass-import"]}}
              </li>
            </ul>
          </div>
        </article>
      </div>
      <!-- End pro plan -->

      <!-- Growt plan -->
      <div class="col-md-6 col-12">
        <article class="pricing-column">
          <div class="inner-box card-box" :class="plan == 'pro' ? 'sbr-shadow-primary': '' ">
            <div class="plan-header text-center">
              <h3 class="text-eadtools">
                GROWT
                <i class="fas fa-fighter-jet"></i>
              </h3>
              <hr />
              <!-- R$ -->
              <div v-if="country == 'Brazil'">
                <h2 class="plan-price" v-if="periodGrowt == true">R$ 769</h2>
                <h2 class="plan-price" v-else>R$ 4150</h2>
                <b>
                  <span class="sbr-text-primary" v-if="periodGrowt == false">30% off</span>
                </b>
                <br />
                <el-switch
                  class="mt-2"
                  v-model="periodGrowt"
                  :active-text="lang['monthly']"
                  :inactive-text="lang['semiannually']"
                ></el-switch>
              </div>
              <!-- USD -->
              <div v-else>
                <h2 class="plan-price" v-if="periodGrowt == true">USD 150</h2>
                <h2 class="plan-price" v-else>USD 810</h2>
                <b>
                  <span class="sbr-text-primary" v-if="periodGrowt == false">10% off</span>
                </b>
                <br />
                <el-switch
                  class="mt-2"
                  v-model="periodGrowt"
                  :active-text="lang['monthly']"
                  :inactive-text="lang['semiannually']"
                ></el-switch>
              </div>
            </div>
            <ul class="plan-stats list-unstyled text-left mt-2">
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                <b class="sbr-text-primary">{{lang["feature-plan-courses"]}}</b>
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-growt-storage"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-growt-users"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-growt-instructors"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-content"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-mercadopago"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-google-analytics"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-tag-manager"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-videoconference"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check text-primary"></i>
                {{lang["feature-plan-programs"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-facebook-pixel"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-certificate"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-exams"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-webinar"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-times sbr-text-danger"></i>
                {{lang["feature-plan-mass-import"]}}
              </li>
            </ul>
          </div>
        </article>
      </div>
      <!-- End pro plan -->

      <!-- Bussiness plan -->
      <div class="col-md-6 col-12">
        <article class="pricing-column">
          <div class="inner-box card-box" :class="plan == 'bussiness' ? 'sbr-shadow-primary': '' ">
            <div class="plan-header text-center">
              <h3 class="text-eadtools">
                BUSSINESS
                <i class="fas fa-rocket"></i>
              </h3>
              <hr />
              <!-- USD -->
              <div class="mb-5">
                <h2 class="plan-price" v-if="periodBussiness == true">{{lang['on-request']}}</h2>
              </div>
            </div>
            <ul class="plan-stats list-unstyled text-left mt-3">
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                <b class="sbr-text-primary">{{lang["feature-plan-courses"]}}</b>
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-bussiness-storage"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-bussiness-users"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-bussiness-instructors"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-content"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-mercadopago"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-google-analytics"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-tag-manager"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-videoconference"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check text-primary"></i>
                {{lang["feature-plan-programs"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-facebook-pixel"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-certificate"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-exams"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-webinar"]}}
              </li>
              <hr />
              <li>
                <i class="fas fa-check sbr-text-primary"></i>
                {{lang["feature-plan-mass-import"]}}
              </li>
            </ul>
          </div>
        </article>
      </div>
      <!-- End bussiness plan -->
    </div>
    <hr class="mb-5" />

    <div class="text-center mb-5">
      <div class="col-12">
        <h2 class="mb-4">
          <i class="fas fa-gem sbr-text-primary"></i>
        </h2>
        <h2 class="mb-3">{{lang['included-in-all-plans']}}</h2>
        <h3>
          <i class="fas fa-check sbr-text-primary"></i>
          {{lang['chat-support']}}
        </h3>
        <h3>
          <i class="fas fa-check sbr-text-primary"></i>
          {{lang['multi-languages']}}
          <img
            class="mr-1"
            style="width:15px;"
            src="@/assets/img/general/flags/es.png"
            alt
          />
          <img class="mr-1" style="width:15px" src="@/assets/img/general/flags/pt-br.png" alt />
          <img class="mr-1" style="width:15px" src="@/assets/img/general/flags/en.png" alt />
        </h3>
      </div>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";

import { mapState } from "vuex";

Vue.use(VueAxios, axios);
export default {
  mixins: [domains, alerts],
  data: () => {
    return {
      plan: "",
      country: "",
      periodBasic: true,
      periodGrowt: true,
      periodBussiness: true,
      periodPro: true
    };
  },
  mounted() {
    this.getCompanyInformation();
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    getCompanyInformation() {
      var urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        "company",
        "getCompanyInformation"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        function(response) {
          this.plan = response.data["plan"];
          this.country = response.data["country"];
        }.bind(this)
      );
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.plan-price {
  font-size: 2em;
  font-family: "Poppins", sans-serif;
}

.pricing-column .plan-stats li {
  font-size: 1.1em;
  font-family: "Poppins", sans-serif;
}

.plan-stats li {
  cursor: pointer;
}
</style>
