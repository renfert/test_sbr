<template>
  <div class="main">
    <lang></lang>
    <div class="row">
      <!-- Students -->
      <div class="col-12 col-md-6 mb-5">
        <div class="card-widget chart">
          <GChart
            v-if="usersData != null"
            type="ColumnChart"
            :data="usersData"
            :options="usersChartOptions"
          />
          <div class="row mb-5" v-else>
            <div class="col-12 text-center">
              <img
                style="width:40%;"
                src="@/assets/img/general/ux/not_found.png"
                alt="No activities"
              />
              <h4 class="no-results-text">{{ lang["no-data"] }}</h4>
            </div>
          </div>
        </div>
      </div>

      <!-- Courses -->
      <div class="col-12 col-md-6 mb-5">
        <div class="card-widget chart">
          <GChart
            v-if="coursesData != null"
            type="PieChart"
            :data="coursesData"
            :options="coursesChartOptions"
          />
          <div class="row mb-5" v-else>
            <div class="col-12 text-center">
              <img
                style="width:40%;"
                src="@/assets/img/general/ux/not_found.png"
                alt="No activities"
              />
              <h4 class="no-results-text">{{ lang["no-data"] }}</h4>
            </div>
          </div>
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

import { mapState } from "vuex";

Vue.use(VueGoogleCharts);
Vue.use(VueAxios, axios);

export default {
  mixins: [domains, alerts],
  data: () => {
    return {
      usersData: [],
      coursesData: [],
      usersChartOptions: {
        title: "New users",
        colors: ["#00A9B4", "#29277F"]
      },
      coursesChartOptions: {
        title: "Courses",
        colors: ["#00A9B4", "#29277F", "#6959CD"]
      }
    };
  },
  computed: {
    ...mapState(["lang"])
  },
  mounted() {
    this.getRegisteredUsersPerMonth();
    this.getCourses();
  },
  methods: {
    getRegisteredUsersPerMonth: function() {
      var urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        "chart",
        "getRegisteredUsersPerMonth"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        response => {
          this.usersData = response.data;
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    getCourses: function() {
      var urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        "chart",
        "getCourses"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        response => {
          this.coursesData = response.data;
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
  max-height: 100%;
}

@media only screen and (max-width: 600px) {
  .chart {
    height: 100%;
  }
}

.user-avatar {
  width: 70px;
}

.card-widget {
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
  transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
  background-color: white;
  border-radius: 10px;
  padding: 30px;
}

.card-widget:hover {
  box-shadow: 0 0px 7px rgba(70, 67, 67, 0.25), 0 5px 5px rgba(70, 67, 67, 0.25);
}

::-webkit-scrollbar-track {
  -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
  background-color: #f5f5f5;
}

::-webkit-scrollbar {
  width: 2px;
  background-color: #f5f5f5;
}

::-webkit-scrollbar-thumb {
  background-color: #0ae;

  background-image: -webkit-gradient(
    linear,
    0 0,
    0 100%,
    color-stop(0.5, rgba(255, 255, 255, 0.2)),
    color-stop(0.5, transparent),
    to(transparent)
  );
}
</style>
