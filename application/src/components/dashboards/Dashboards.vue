<template>
  <div class="col-12">
    <admin-dashboards v-if="roleId == 1"></admin-dashboards>
    <instructor-dashboards v-if="roleId == 2"></instructor-dashboards>
    <student-dashboards v-if="roleId == 3"></student-dashboards>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import AdminDashboards from "@/components/dashboards/roles/Admin";
import InstructorDashboards from "@/components/dashboards/roles/Instructor";
import StudentDashboards from "@/components/dashboards/roles/Student";

Vue.use(VueAxios, axios);

export default {
  components: {
    AdminDashboards,
    InstructorDashboards,
    StudentDashboards
  },
  mixins: [domains, alerts],
  data: () => {
    return {
      roleId: ""
    };
  },
  mounted() {
    this.getProfile();
  },
  methods: {
    getProfile: function() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "user",
        "getUserProfile"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        response => {
          this.roleId = response.data["myrole_id"];
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.chart {
  width: 100%;
  height: 300px;
}
</style>
