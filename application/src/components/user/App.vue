<template >
  <!-- Content page -->
  <div class="content-page">
    <div class="text-center">
      <!-- Group tabs -->
      <div id="tabs">
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
</template>

<script>
import ElementUI from "element-ui";
import Courses from "@/components/user/Courses";
import Programs from "@/components/user/Programs";
import Profile from "@/components/user/Profile";
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import VueHead from "vue-head";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import verify from "@/mixins/verify";

import { mapState } from "vuex";

export const eventBus = new Vue();

Vue.use(ElementUI);
Vue.use(VueAxios, axios);
Vue.use(VueHead);

export default {
  mixins: [domains, alerts, verify],
  data: () => {
    return {
      userId: "",
      name: "",
      avatar: ""
    };
  },
  created() {
    this.userId = this.$route.params.id;
    this.verifyAdministratorPrivileges();
    this.getUser();
  },
  computed: {
    ...mapState(["lang"])
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
    Courses,
    Programs,
    Profile
  }
};
</script>

<style>
</style>
