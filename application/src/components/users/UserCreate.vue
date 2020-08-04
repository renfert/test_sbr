<template>
  <div class="col-12">
    <div class="card-box">
      <div class="text-center v-step-5" style="visibility:hidden;"></div>
      <div class="float-right">
        <!-- Massive import button -->
        <el-button
          class="sbr-btn sbr-primary"
          v-if="plan == 'bussiness'"
          @click.prevent="modal = true"
          type="primary"
          size="medium"
          >{{ lang["massive-import"] }}</el-button
        >

        <el-button
          @click.prevent="upgradePlanFeature()"
          v-else
          class="sbr-btn sbr-primary"
          type="primary"
          size="medium"
        >
          <i class="el-icon-lock"></i> {{ lang["massive-import"] }}</el-button
        >
      </div>
      <h4>{{ lang["create-user"] }}</h4>
      <br />
      <form id="form-user" @submit.prevent="createUser">
        <div class="row">
          <div class="col-xl-4 col-md-4">
            <!-- Username -->
            <div class="form-group v-step-0">
              <el-input
                required
                name="name"
                :placeholder="lang['name']"
                v-model="name"
              ></el-input>
            </div>
            <!-- Password -->
            <div class="form-group v-step-2">
              <el-input
                required
                type="password"
                name="password"
                :placeholder="lang['password']"
                v-model="password"
              ></el-input>
            </div>

            <div class="form-group">
              <el-button
                v-loading="loadingButton"
                class="sbr-btn sbr-primary v-step-4"
                native-type="submit"
              >
                {{ lang["save-button"] }}
              </el-button>
            </div>
          </div>

          <div class="col-xl-4 col-md-4">
            <!-- Email -->
            <div class="form-group v-step-1">
              <el-input
                required
                type="email"
                name="email"
                :placeholder="lang['email']"
                v-model="email"
              ></el-input>
            </div>
            <!-- Role -->
            <div class="form-group v-step-3">
              <template>
                <el-select
                  required
                  name="role"
                  v-model="role"
                  :placeholder="lang['select-role']"
                >
                  <el-option
                    style="pointer-events: auto !important;z-index: 9999 !important;"
                    value="2"
                    :label="lang['instructor']"
                  >
                    {{ lang["instructor"] }}
                  </el-option>
                  <el-option
                    style="pointer-events: auto !important;z-index: 9999 !important;"
                    value="3"
                    :label="lang['student']"
                  >
                    {{ lang["student"] }}
                  </el-option>
                </el-select>
              </template>
            </div>
          </div>
        </div>
      </form>

      <!-- Massive import -->
      <div>
        <el-dialog
          :visible.sync="modal"
          :title="lang['massive-import']"
          center
          width="40%"
          top="5vh"
        >
          <div class="row">
            <div class="col-xl-12 col-md-12 text-center">
              <a
                download
                href="https://cdn.eadtools.com/files/import_user.xlsx"
                class="sbr-btn sbr-purple"
                >{{ lang["download-template"] }}</a
              >
            </div>
          </div>
          <br />
          <div class="row">
            <div class="col-xl-12 col-md-12 center">
              <h3 v-if="loadingMassiveImport" class="sbr-text-grey">
                {{ lang["please-wait"] }}
              </h3>
              <form
                v-loading="loadingMassiveImport"
                id="form-massive"
                @submit.prevent="massivelyCreateUsers"
              >
                <upload input-name="file" acceptable=".xlsx" box-height="200">
                </upload>
                <br />
                <el-button
                  v-loading="loadingButton"
                  class="sbr-btn sbr-primary"
                  native-type="submit"
                  type="primary"
                >
                  {{ lang["save-button"] }}
                </el-button>
              </form>
            </div>
          </div>
        </el-dialog>
      </div>
      <!-- End massive import -->
    </div>

    <!-------- 
            Tour
        ---------->
    <v-tour
      name="user-tour"
      :options="tourOptions"
      :callbacks="tourCallbacks"
      :steps="steps"
    ></v-tour>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import { eventBus } from "@/components/users/App";
import { eventLang } from "@/components/helper/HelperLang";
import { eventPlan } from "@/components/plans/UpgradePlan";
import { eventUpload } from "@/components/helper/HelperUpload";
import ElementUI from "element-ui";
import VueTheMask from "vue-the-mask";
import Upload from "@/components/helper/HelperUpload";
import "element-ui/lib/theme-chalk/index.css";
import lang from "element-ui/lib/locale/lang/en";
import locale from "element-ui/lib/locale";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";

import VueTour from "vue-tour";
require("vue-tour/dist/vue-tour.css");
Vue.use(VueTour);

locale.use(lang);
Vue.use(ElementUI);
Vue.use(VueTheMask);
Vue.use(VueAxios, axios);
export default {
  mixins: [domains, alerts],
  data: function() {
    return {
      modal: false,
      url: "",
      target: "",
      title: "",
      name: "",
      email: "",
      role: "",
      password: "",
      lang: {},
      plan: "",
      tourCallbacks: {
        onFinish: this.finishTour
      },
      tourOptions: {
        useKeyboardNavigation: true,
        labels: {
          buttonSkip: "",
          buttonPrevious: "",
          buttonNext: "",
          buttonStop: ""
        }
      },
      steps: [
        {
          target: ".v-step-0",
          header: {
            title: ""
          },
          params: {
            placement: "bottom",
            highlight: true
          },
          content: ""
        },
        {
          target: ".v-step-1",
          header: {
            title: ""
          },
          params: {
            placement: "right",
            highlight: true
          },
          content: ""
        },
        {
          target: ".v-step-2",
          header: {
            title: ""
          },
          params: {
            placement: "right",
            highlight: true
          },
          content: ""
        },
        {
          target: ".v-step-3",
          header: {
            title: ""
          },
          params: {
            placement: "right",
            highlight: true
          },
          content: ""
        },
        {
          target: ".v-step-4",
          header: {
            title: ""
          },
          params: {
            placement: "right",
            highlight: true
          },
          content: ""
        },
        {
          target: ".v-step-5",
          header: {
            title: ""
          },
          params: {
            placement: "bottom",
            highlight: true
          },
          content: ""
        }
      ],
      loadingButton: false,
      loadingMassiveImport: false
    };
  },
  components: {
    Upload
  },
  mounted() {
    eventLang.$on(
      "lang",
      function(response) {
        this.lang = response;

        /* Tour labels */
        this.tourOptions.labels.buttonSkip = this.lang["skip-tour"];
        this.tourOptions.labels.buttonPrevious = this.lang[
          "previous-step-button"
        ];
        this.tourOptions.labels.buttonNext = this.lang["next-step-button"];
        this.tourOptions.labels.buttonStop = this.lang["finish"];

        /* Tour step 0 - Username */
        this.steps[0].header.title = this.lang["name"];
        this.steps[0].content = this.lang["tour-user-name-message"];

        /* Tour step 1 - Email */
        this.steps[1].header.title = this.lang["email"];
        this.steps[1].content = this.lang["tour-user-email-message"];

        /* Tour step 2 - Password */
        this.steps[2].header.title = this.lang["password"];
        this.steps[2].content = this.lang["tour-user-password-message"];

        /* Tour step 3 - Role */
        this.steps[3].header.title = this.lang["select-role"];
        this.steps[3].content = this.lang["tour-user-role-message"];

        /* Tour step 4 - Save */
        this.steps[4].header.title = this.lang["save-button"];
        this.steps[4].content = this.lang["tour-user-save-message"];

        /* Tour step 5 - finish */
        this.steps[5].header.title = this.lang["tour-done"];
        this.steps[5].content = this.lang["tour-user-done-message"];
      }.bind(this)
    );

    setTimeout(() => {
      if (this.$route.query.tour == "true") {
        this.$tours["user-tour"].start();
      }
    }, 2000);
  },
  created: function() {
    this.getCompanyInformation();
  },
  methods: {
    finishTour() {
      window.location.href = "/home";
    },
    upgradePlanFeature: function() {
      eventPlan.$emit("upgrade-plan", "feature");
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
    createUser: function() {
      this.loadingButton = true;
      var form = document.getElementById("form-user");
      var formData = new FormData(form);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("user", "create");
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          /* Success callback */
          if (response.data == "upgrade-plan") {
            eventPlan.$emit("upgrade-plan", "users");
          } else {
            if (response.data == false) {
              this.userAlreadyExistsMessage();
            } else {
              this.successMessage();
              this.actionsToBePerformedAfterRegistration();
            }
          }
          this.loadingButton = false;
        },
        /* Error callback */

        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    massivelyCreateUsers: function() {
      this.loadingMassiveImport = true;
      var form = document.getElementById("form-massive");
      var formData = new FormData(form);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "user",
        "massivelyCreateUsers"
      );
      axios
        .post(urlToBeUsedInTheRequest, formData, {
          headers: { "Content-Type": "multipart/form-data" }
        })
        .then(
          () => {
            this.successMessage();
            this.loadingMassiveImport = false;
            eventBus.$emit("new-user");
            eventUpload.$emit("clear");
            this.modal = false;
          },
          /* Error callback */
          function() {
            this.errorMessage();
          }.bind(this)
        );
    },
    userAlreadyExistsMessage() {
      this.$notify({
        title: this.lang["error"],
        message: this.lang["user-already-exists"],
        type: "warning",
        duration: 3500
      });
    },
    actionsToBePerformedAfterRegistration() {
      eventBus.$emit("new-user");
      this.name = "";
      this.email = "";
      this.password = "";
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.col-md-4 {
  padding-right: 15px !important;
  padding-left: 15px !important;
}
</style>
