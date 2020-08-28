<template >
  <div class="content-page">
    <user-create></user-create>
    <user-list></user-list>
  </div>
</template>

<script>
import Vue from "vue";
import UserCreate from "@/components/users/UserCreate.vue";
import UserList from "@/components/users/UserList.vue";
import VueHead from "vue-head";

export const eventBus = new Vue();

Vue.use(VueHead);

export default {
  components: {
    UserCreate,
    UserList
  },
  created() {
    this.$verifyAdministratorPrivileges();
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

