<template >
  <!-- Content page -->
  <div class="content-page">
    <h2 class="text-center mb-5">{{name}}</h2>

    <!-- Group tabs -->
    <el-tabs type="border-card">
      <el-tab-pane>
        <span slot="label">
          <i class="mdi mdi-book-outline"></i>
          {{lang["courses"]}}
        </span>
        <courses :group-id="groupId"></courses>
      </el-tab-pane>

      <el-tab-pane>
        <span slot="label">
          <i class="mdi mdi-account-multiple-outline"></i>
          {{lang["students"]}}
        </span>
        <students :group-id="groupId"></students>
      </el-tab-pane>

      <el-tab-pane>
        <span slot="label">
          <i class="mdi mdi-account-star-outline"></i>
          {{lang["instructors"]}}
        </span>
        <instructors :group-id="groupId"></instructors>
      </el-tab-pane>

      <el-tab-pane>
        <span slot="label">
          <i class="mdi mdi-account-star-outline"></i>
          {{lang["programs"]}}
        </span>
        <programs :group-id="groupId"></programs>
      </el-tab-pane>
    </el-tabs>
  </div>
</template>

<script>
import ElementUI from "element-ui";
import Courses from "@/components/group/Courses";
import Students from "@/components/group/Students";
import Instructors from "@/components/group/Instructors";
import Programs from "@/components/group/Programs";
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
      groupId: "",
      name: ""
    };
  },
  created() {
    this.verifyAdministratorPrivileges();
    this.groupId = this.$route.params.id;
    this.getGroup();
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    getGroup: function() {
      var formData = new FormData();
      formData.set("groupId", this.groupId);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("group", "get");
      axios.post(urlToBeUsedInTheRequest, formData).then(
        function(response) {
          this.name = response.data["name"];
        }.bind(this)
      );
    }
  },
  head: {
    title: {
      inner: "Manage group"
    },
    meta: [
      { name: "charset", content: "utf-8" },
      { name: "viewport", content: "width=device-width, initial-scale=1.0" },
      { name: "author", content: "Sabiorealm" }
    ]
  },
  components: {
    Courses,
    Students,
    Instructors,
    Programs
  }
};
</script>

