<template>
  <div>
    <el-row :gutter="20">
      <!-- Students -->
      <el-col :sm="12" :xs="24" class="m-b-30">
        <div class="card-widget">
          <GChart
            v-if="usersData != null"
            type="ColumnChart"
            :data="usersData"
            :options="usersChartOptions"
          />
          <el-row class="center" v-else>
            <el-col>
              <img
                class="not-found-image"
                src="@/assets/img/general/ux/data_not_found.svg"
              />
              <h4 class="sbr-text-grey">{{ lang['no-data'] }}</h4>
            </el-col>
          </el-row>
        </div>
      </el-col>

      <!-- Courses -->
      <el-col :sm="12" :xs="24" class="m-b-30">
        <div class="card-widget">
          <GChart
            v-if="coursesData != null"
            type="PieChart"
            :data="coursesData"
            :options="coursesChartOptions"
          />
          <el-row class="center" v-else>
            <el-col>
              <img
                class="not-found-image"
                src="@/assets/img/general/ux/data_not_found.svg"
              />
              <h4 class="sbr-text-grey">{{ lang['no-data'] }}</h4>
            </el-col>
          </el-row>
        </div>
      </el-col>
    </el-row>
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
      usersData: [],
      coursesData: [],
      usersChartOptions: {
        title: 'New users',
        colors: ['#00A9B4', '#29277F']
      },
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
    this.usersChartOptions.title = this.lang['new-users'];
    this.coursesChartOptions.title = this.lang.courses;
    this.getRegisteredUsersPerMonth();
    this.getCourses();
  },
  methods: {
    getRegisteredUsersPerMonth() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'chart',
        'getRegisteredUsersPerMonth'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.usersData = response.data;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
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
.card-widget {
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
  transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
  background-color: white;
  border-radius: 10px;
  padding: 30px;
  max-width: 100%;
  height: 250px;
}

.card-widget:hover {
  box-shadow: 0 0px 7px rgba(70, 67, 67, 0.25), 0 5px 5px rgba(70, 67, 67, 0.25);
}
</style>
