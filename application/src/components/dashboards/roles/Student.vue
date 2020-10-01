<template>
  <div class="main">
    <div class="row">
      <!-- Courses -->
      <div class="col-12 col-md-12">
        <div class="card-box">
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
    ...mapState(['user', 'lang'])
  },
  created() {
    this.coursesChartOptions.title = this.lang.courses;
    this.getCourses();
  },
  methods: {
    getCourses() {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'chart',
        'getStudentCourses'
      );
      formData.set('studentId', this.user.id);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
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
