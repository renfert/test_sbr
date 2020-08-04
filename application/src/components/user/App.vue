<template >
  <div id="wrapper">
    <lang></lang>

    <!-- Content page -->
    <div class="content-page">
      <div class="content">
        <div class="container-fluid">
          <div class="row mt-5 text-center">
            <!-- Group tabs -->
            <div class="col-12">
              <el-tabs type="border-card">
                <el-tab-pane>
                  <span slot="label">
                    <i class="el-icon-user"></i>
                    {{lang["profile"]}}
                  </span>
                  <profile :user-id="userId"></profile>
                </el-tab-pane>

                <el-tab-pane>
                  <span slot="label">
                    <i class="mdi mdi-book-outline"></i>
                    {{lang["courses"]}}
                  </span>
                  <courses :user-id="userId"></courses>
                </el-tab-pane>

                <el-tab-pane>
                  <span slot="label">
                    <i class="el-icon-s-unfold"></i>
                    {{lang["programs"]}}
                  </span>
                  <programs :user-id="userId"></programs>
                </el-tab-pane>
              </el-tabs>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End of content page -->
  </div>
  <!-- End of wrapper -->
</template>

<script>
import Lang from "@/components/helper/HelperLang.vue";
import ElementUI from "element-ui";
import { eventLang } from "@/components/helper/HelperLang";
import "element-ui/lib/theme-chalk/index.css";
import lang from "element-ui/lib/locale/lang/en";
import locale from "element-ui/lib/locale";
import Courses from "@/components/user/Courses";
import Programs from "@/components/user/Programs";
import Profile from "@/components/user/Profile";
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import VueHead from "vue-head";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import headerTags from "@/mixins/headerTags";
import integrations from "@/mixins/integrations";
import verify from "@/mixins/verify";
export const eventBus = new Vue();

locale.use(lang);
Vue.use(ElementUI);
Vue.use(VueAxios, axios);
Vue.use(VueHead);
export default {
  mixins: [domains, alerts, integrations, headerTags, verify],
  data: () => {
    return {
      lang: [],
      userId: "",
      name: "",
      avatar: ""
    };
  },
  created() {
    this.verifySession();
    this.verifyAdministratorPrivileges();
    this.loadIntegrations();
    this.createFavicon();
    this.userId = sessionStorage.getItem("sbr_user_id");
    this.getUser();
  },
  methods: {
    getUser: function() {
      var formData = new FormData();
      formData.set("userId", this.userId);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("user", "get");
      axios.post(urlToBeUsedInTheRequest, formData).then(
        function(response) {
          this.name = response.data["name"];
          this.avatar = response.data["avatar"];
        }.bind(this)
      );
    }
  },
  head: {
    title: {
      inner: "Manage user"
    },
    meta: [
      { name: "charset", content: "utf-8" },
      { name: "viewport", content: "width=device-width, initial-scale=1.0" },
      { name: "author", content: "Sabiorealm" }
    ]
  },
  components: {
    Lang,
    Courses,
    Programs,
    Profile
  },
  mounted() {
    eventLang.$on(
      "lang",
      function(response) {
        this.lang = response;
      }.bind(this)
    );
  }
};
</script>

<style>
</style>
