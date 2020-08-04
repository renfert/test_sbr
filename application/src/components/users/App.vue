<template >
  <div id="wrapper">
    <lang></lang>
    <!-- Content page -->
    <div class="content-page">
      <div class="content">
        <div class="container-fluid">
          <!-- Create a new user  -->
          <div class="row gap-5">
            <user-create></user-create>
          </div>
          <!-- List users  -->
          <div class="row">
            <user-list></user-list>
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
import UserCreate from "@/components/users/UserCreate.vue";
import UserList from "@/components/users/UserList.vue";
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

Vue.use(VueAxios, axios);
Vue.use(VueHead);
export default {
  mixins: [domains, alerts, integrations, headerTags, verify],
  components: {
    UserCreate,
    UserList,
    Lang
  },
  created() {
    this.verifySession();
    this.verifyAdministratorPrivileges();
    this.loadIntegrations();
    this.createFavicon();
  },
  head: {
    title: {
      inner: "Users"
    },
    meta: [
      { name: "charset", content: "utf-8" },
      { name: "viewport", content: "width=device-width, initial-scale=1.0" },
      { name: "author", content: "Sabiorealm" }
    ]
  }
};
</script>

<style>
</style>
