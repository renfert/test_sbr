<template>
  <div class="content-page">
    <admin v-if="roleId == 1"></admin>
    <instructor v-if="roleId == 2"></instructor>
    <student v-if="roleId == 3"></student>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import Admin from "@/components/home/roles/Admin";
import Instructor from "@/components/home/roles/Instructor";
import Student from "@/components/home/roles/Student";

Vue.use(VueAxios, axios);

export default {
  components: {
    Admin,
    Instructor,
    Student
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
