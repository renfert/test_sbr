<template>
  <div class="block">
    <lang></lang>

    <!-------------- 
            Introduction
    --------------->
    <div class="row text-center">
      <div class="col-12">
        <img class="waiter" src="@/assets/img/general/ux/gifs/waiter-rev1.gif" alt />
        <h2 class="sbr-text-grey text-center">
          {{lang['welcome-to-sabiorealm']}}
          <b>{{userName}}</b>
        </h2>
        <h3>{{lang['welcome-message-pt1']}}</h3>
        <h4 class="sbr-text-grey">{{lang['welcome-message-pt2']}}</h4>
      </div>
    </div>
    <!-------------- 
            End  Introduction
    --------------->

    <!-------------- 
            Steps
    --------------->
    <div class="block text-center mb-5 mt-5">
      <div class="row text-center">
        <div class="col-md-4 col-12 mb-5">
          <img
            class="img-step"
            v-if="userStep != null"
            src="@/assets/img/general/ux/tour/check.png"
          />
          <img class="img-step" v-else src="@/assets/img/general/ux/tour/1.png" />
          <div>
            <h4>
              <router-link to="/users" class="mb-3 sbr-text-primary">{{lang['create-user']}}</router-link>
            </h4>
          </div>
        </div>
        <div class="col-md-4 col-12 mb-5">
          <img
            class="img-step"
            v-if="courseStep != null"
            src="@/assets/img/general/ux/tour/check.png"
          />
          <img class="img-step" v-else src="@/assets/img/general/ux/tour/2.png" />
          <div>
            <h4>
              <router-link
                to="/newcourse"
                class="mb-3 sbr-text-primary"
              >{{lang['new-course-button']}}</router-link>
            </h4>
          </div>
        </div>

        <div class="col-md-4 col-12 mb-5">
          <img
            class="img-step"
            v-if="settingsStep != null"
            src="@/assets/img/general/ux/tour/check.png"
          />
          <img class="img-step" v-else src="@/assets/img/general/ux/tour/3.png" />
          <div>
            <h4>
              <router-link to="/settings" class="mb-3 sbr-text-primary">{{lang['change-settings']}}</router-link>
            </h4>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import VueTheMask from "vue-the-mask";
import ElementUI from "element-ui";
import Lang from "@/components/helper/HelperLang.vue";
import "element-ui/lib/theme-chalk/index.css";
import lang from "element-ui/lib/locale/lang/en";
import locale from "element-ui/lib/locale";
import { eventLang } from "@/components/helper/HelperLang";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";

locale.use(lang);
Vue.use(VueTheMask);
Vue.use(VueTheMask);
Vue.use(VueAxios, axios);
Vue.use(ElementUI);

export default {
  components: {
    Lang
  },
  mixins: [domains, alerts],
  data: () => {
    return {
      lang: {},
      userName: "",
      userStep: null,
      courseStep: null,
      customizeStep: null,
      settingsStep: null
    };
  },
  mounted() {
    eventLang.$on(
      "lang",
      function(response) {
        this.lang = response;
      }.bind(this)
    );

    this.getUserProfile();
    this.getStepsStatus();
  },
  methods: {
    getUserProfile() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "user",
        "getUserProfile"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        function(response) {
          this.userName = response.data["name"];
        }.bind(this)
      );
    },
    getStepsStatus: function() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "verify",
        "stepsStatus"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        function(response) {
          this.userStep = response.data[0]["status"];
          this.courseStep = response.data[1]["status"];
          this.customizeStep = response.data[2]["status"];
          this.settingsStep = response.data[3]["status"];
        }.bind(this)
      );
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.waiter {
  width: 18%;
}

@media only screen and (max-width: 600px) {
  .waiter {
    width: 60%;
    margin-top: 0%;
  }
}

.img-step {
  width: 25%;
}
</style>
