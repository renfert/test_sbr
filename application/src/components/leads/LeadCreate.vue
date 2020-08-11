<template>
  <div>
    <el-dialog :visible.sync="modal" :title="lang['create-account']" center top="5vh">
      <el-alert :title="lang['create-account-to-continue']" type="info"></el-alert>
      <form
        id="form-lead"
        @submit.prevent="createLead()"
        v-loading="loading"
        class="form-login text-center border border-light p-5"
      >
        <input
          required
          type="text"
          name="name"
          id="defaultLoginFormEmail"
          class="form-control mb-4"
          :placeholder="lang['name']"
        />

        <input
          required
          type="email"
          name="email"
          id="defaultLoginFormEmail"
          class="form-control mb-4"
          placeholder="E-mail"
        />

        <input
          v-model="password"
          required
          type="password"
          id="defaultLoginFormPassword"
          name="password"
          class="form-control mb-4"
          :placeholder="lang['password']"
        />

        <input
          v-model="confirmPassword"
          required
          type="password"
          id="defaultLoginFormPassword"
          class="form-control mb-4"
          :placeholder="lang['confirm-password']"
        />

        <input class="hide" type="number" name="courseId" :value="courseId" />

        <button :style="primaryColorBg" class="btn btn-theme account-btn" type="submit">
          {{lang['create-account']}}
          <i class="ti-angle-right"></i>
        </button>
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

import { mapState } from "vuex";

export const eventLead = new Vue();

Vue.use(ElementUI);
Vue.use(VueAxios, axios);

export default {
  mixins: [domains, alerts],
  props: ["course-id"],
  data: function() {
    return {
      modal: false,
      loading: false,
      password: "",
      confirmPassword: "",
      color: ""
    };
  },
  created() {
    this.getColor();
  },
  mounted() {
    eventLead.$on(
      "open-lead-modal",
      function() {
        this.modal = true;
      }.bind(this)
    );
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
  },
  methods: {
    getColor: function() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "settings",
        "getSettingsInformation"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        function(response) {
          this.color = response.data["color"];
        }.bind(this)
      );
    },
    createLead: function() {
      if (this.password == this.confirmPassword) {
        this.loading = true;
        var form = document.getElementById("form-lead");
        var formData = new FormData(form);
        var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
          "lead",
          "create"
        );
        axios.post(urlToBeUsedInTheRequest, formData).then(
          response => {
            if (response.data == false) {
              this.userAlreadyExists();
              this.loading = false;
            } else {
              this.$router.push("/courses");
            }
          },
          function() {
            this.errorMessage();
          }.bind(this)
        );
      } else {
        this.diferentPasswords();
      }
    }
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
  line-height: 1;
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

.btn-theme {
  color: #fff;
  transition: all ease 0.4s;
}
</style>
