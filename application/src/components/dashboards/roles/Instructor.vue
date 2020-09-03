<template>
  <div class="main">
    <div class="row">
      <!-- Courses -->
      <div class="col-12 col-md-12 mb-5">
        <div class="card-widget">
          <GChart
            v-if="coursesData != null"
            type="PieChart"
            :data="coursesData"
            :options="coursesChartOptions"
          />
          <div class="row mb-5" v-else>
            <div class="col-12 text-center">
              <img
                style="width: 20%"
                src="@/assets/img/general/ux/not_found.png"
              />
              <h4 class="no-results-text">
                {{ lang['no-data'] }}
              </h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Vue from 'vue';
import VueGoogleCharts from 'vue-google-charts';

import { mapState } from 'vuex';

Vue.use(VueGoogleCharts);

export default {
  data: () => {
    return {
      coursesData: [],
      coursesChartOptions: {
        title: 'Courses',
        colors: ['#00A9B4', '#29277F', '#6959CD']
      }
    };
  },
  computed: {
    ...mapState(['lang'])
  },
  mounted() {
    this.getCourses();
  },
  methods: {
    getCourses() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'chart',
        'getCourses'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.coursesData = response.data;
        },
        () => {
          this.$errorMessage();
        }
      );
    }
  }
};
</script>

<style lang="scss" scoped>
.chart {
  width: 100%;
  height: 300px;
}
</style>
