<template>
  <div>
    <el-dialog :visible.sync="modalLogin" :title="lang['go-to-platform']" center top="5vh">
      <form
        @submit.prevent="doLogin()"
        id="form-login"
        v-loading="loading"
        class="form-login text-center border border-light p-5"
      >
        <el-alert
          @close="wrongPasswordOrUser = false"
          :title="lang['wrong-password']"
          type="error"
          v-if="wrongPasswordOrUser == true"
          show-icon
        ></el-alert>
        <br />
        <!-- Email -->
        <input
          type="email"
          name="email"
          id="defaultLoginFormEmail"
          class="form-control mb-4"
          placeholder="E-mail"
        />
        <!-- Password -->
        <input
          type="password"
          id="defaultLoginFormPassword"
          name="password"
          class="form-control mb-4"
          :placeholder="lang['password']"
        />

        <div class="d-flex justify-content-around">
          <div>
            <!-- Forgot password -->
            <a
              href="javascript:void(0)"
              :style="primaryColor"
              @click="modalRecover = true"
            >{{lang['recover-password']}}</a>
          </div>
        </div>

        <!-- Sign in button -->
        <button
          :style="primaryColorBg"
          class="btn account-btn"
          type="submit"
        >{{lang['go-to-platform']}}</button>
      </form>
    </el-dialog>

    <el-dialog
      :visible.sync="modalRecover"
      :title="lang['recover-password']"
      center
      width="40%"
      top="5vh"
    >
      <form
        v-loading="loadingRecover"
        id="form-recover"
        @submit.prevent="recoverPassword()"
        action="recover"
      >
        <el-input v-model="email" required placeholder="Email" name="email"></el-input>
        <button :style="primaryColorBg" class="btn account-btn">Recover</button>
        <el-alert
          v-if="failedRecover == true"
          :title="lang['this-email-doesnt-exist']"
          type="error"
        ></el-alert>

        <el-alert
          v-if="successRecover == true"
          :title="lang['please-review-your-email']"
          type="success"
        ></el-alert>
      </form>
    </el-dialog>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import ElementUI from "element-ui";
import "element-ui/lib/theme-chalk/index.css";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";

export const eventLogin = new Vue();

import { mapState } from "vuex";

Vue.use(ElementUI);
Vue.use(VueAxios, axios);

export default {
  mixins: [domains, alerts],
  data: function() {
    return {
      modalLogin: false,
      modalRecover: false,
      loading: false,
      loadingRecover: false,
      wrongPasswordOrUser: false,
      recoverEmail: "",
      failedRecover: false,
      successRecover: false,
      email: "",
      color: ""
    };
  },
  mounted() {
    this.getColor();
    eventLogin.$on(
      "open-login-modal",
      function() {
        this.modalLogin = true;
      }.bind(this)
    );
  },
  methods: {
    doLogin: function() {
      this.loading = true;
      var form = document.getElementById("form-login");
      var formData = new FormData(form);
      var urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        "Login",
        "doLogin"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          if (response.data == true) {
            window.location.href =
              this.$getDomainNameToNavigation() + "courses";
          } else {
            this.wrongPasswordOrUser = true;
          }
          this.loading = false;
        },
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    getColor: function() {
      var urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        "settings",
        "getSettingsInformation"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        function(response) {
          this.color = response.data["color"];
        }.bind(this)
      );
    },
    recoverPassword: function() {
      this.successRecover = false;
      this.failedRecover = false;
      this.loadingRecover = true;
      var form = document.getElementById("form-recover");
      var formData = new FormData(form);
      var urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        "Login",
        "recoverPassword"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          if (response.data == true) {
            this.successRecover = true;
          } else {
            this.failedRecover = true;
          }
          this.loadingRecover = false;
        },
        function() {
          this.errorMessage();
        }.bind(this)
      );
    }
  },
  computed: {
    primaryColorBg: function() {
      return {
        "background-color": this.color
      };
    },
    primaryColor: function() {
      return {
        color: this.color
      };
    },
    ...mapState(["lang"])
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.btn {
  display: inline-block;
  font-weight: 400;
  text-align: center;
  white-space: nowrap;
  vertical-align: middle;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  border: 1px solid transparent;
  padding: 12px 25px;
  font-size: 1rem;
  line-height: 1.25;
  transition: all 0.15s ease-in-out;
  border: 2px solid transparent;
  cursor: pointer;
}

.account-btn {
  width: 60%;
  margin: 1.5rem auto 0;
  display: flex;
  height: 44px;
  font-weight: 600;
  border-radius: 50px;
  color: #fff !important;
  align-items: center;
  justify-content: center;
  font-size: 0.8rem !important;
}

.custom-control-label {
  padding-top: 4px !important;
}
</style>
