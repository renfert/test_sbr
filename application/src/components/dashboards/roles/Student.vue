<template>
  <div class="main">
    <div class="row mb-5">
      <!-- Courses -->
      <div class="col-12 col-md-12">
        <div class="card-widget">
          <GChart
            v-if="coursesData"
            type="PieChart"
            :data="coursesData"
            :options="coursesChartOptions"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import VueGoogleCharts from "vue-google-charts";

Vue.use(VueGoogleCharts);
Vue.use(VueAxios, axios);

export default {
  mixins: [domains, alerts],
  data: () => {
    return {
      userId: 0,
      coursesData: [],
      coursesChartOptions: {
        title: "Courses",
        colors: ["#00A9B4", "#29277F", "#6959CD"]
      }
    };
  },
  created() {
    this.getUserProfile();
  },
  methods: {
    getCourses: function(studentId) {
      var formData = new FormData();
      formData.set("studentId", studentId);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "chart",
        "getStudentCourses"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          this.coursesData = response.data;
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    getUserProfile: function() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "user",
        "getUserProfile"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        response => {
          this.userId = response.data["id"];
          this.getCourses(response.data["id"]);
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
