<template>
  <div>
    <div v-if="userStep != null && courseStep != null && settingsStep != null">
      <!--------------
      Widgets
      --------------->
      <el-row>
        <el-col :span="12">
          <b>{{ lang['basic-information'] }}</b>
        </el-col>
      </el-row>

      <el-row class="m-t-30" :gutter="20">
        <el-col :sm="8" :xs="24">
          <!-- Courses -->
          <a href="courses">
            <div class="card-widget">
              <div class="title-widget">
                <img
                  src="@/assets/img/general/ux/widgets/admin/courses.png"
                  alt
                />
                <h4>
                  {{ lang['courses'] }}:
                  <b class="sbr-text-primary">{{ numberTotalOfCourses }}</b>
                </h4>
              </div>
            </div>
          </a>
        </el-col>

        <el-col :sm="8" :xs="24">
          <!-- Users -->
          <a href="users">
            <div class="card-widget">
              <div class="title-widget">
                <img
                  src="@/assets/img/general/ux/widgets/admin/enrolled.png"
                  alt
                />
                <h4>
                  {{ lang['users'] }}:
                  <b class="sbr-text-primary">{{ numberTotalOfUsers }}</b>
                </h4>
              </div>
            </div>
          </a>
        </el-col>

        <el-col :sm="8" :xs="24">
          <!-- Storage -->
          <a href="javascript:void(0)">
            <div class="card-widget">
              <div class="title-widget">
                <img
                  src="@/assets/img/general/ux/widgets/admin/storage.png"
                  alt
                />
                <el-tooltip
                  class="item"
                  effect="dark"
                  :content="
                    totalStorageUsed + ' GB / ' + totalStorageAvaiable + ' GB'
                  "
                  placement="bottom"
                >
                  <h4>
                    {{ lang['storage'] }}
                    <b class="sbr-text-primary">{{ storagePercent }} %</b>
                  </h4>
                </el-tooltip>
              </div>
            </div>
          </a>
        </el-col>
      </el-row>

      <!--------------
      End Widgets
      --------------->

      <!--------------
      Shortcuts
      --------------->
      <el-row class="m-t-30" :gutter="20">
        <!-- View my marketplace -->
        <el-col :sm="8" :xs="24">
          <a target="_blank" href="/products">
            <div class="card-widget">
              <div class="title-widget">
                <img
                  src="@/assets/img/general/ux/shortcuts/coursespage.png"
                  alt
                />
                <h4>{{ lang['view-my-marketplace'] }}</h4>
              </div>
            </div>
          </a>
        </el-col>
        <!-- View my home page -->
        <el-col :sm="8" :xs="24">
          <a target="_blank" href="/">
            <div class="card-widget">
              <div class="title-widget">
                <img
                  src="@/assets/img/general/ux/shortcuts/marketplace.png"
                  alt
                />
                <h4>{{ lang['view-my-entry-page'] }}</h4>
              </div>
            </div>
          </a>
        </el-col>
        <!-- New course -->
        <el-col :sm="8" :xs="24">
          <a href="newcourse">
            <div class="card-widget">
              <div class="title-widget">
                <img
                  src="@/assets/img/general/ux/shortcuts/new_course.png"
                  alt
                />
                <h4>{{ lang['new-course-button'] }}</h4>
              </div>
            </div>
          </a>
        </el-col>
      </el-row>

      <el-row class="m-t-30" :gutter="20">
        <!-- New user -->
        <el-col :sm="8" :xs="24">
          <a href="users">
            <div class="card-widget">
              <div class="title-widget">
                <img src="@/assets/img/general/ux/shortcuts/add_user.png" alt />
                <h4>{{ lang['create-user'] }}</h4>
              </div>
            </div>
          </a>
        </el-col>
        <!-- Customize -->
        <el-col :sm="8" :xs="24">
          <a href="site">
            <div class="card-widget">
              <div class="title-widget">
                <img
                  src="@/assets/img/general/ux/shortcuts/customize.png"
                  alt
                />
                <h4>{{ lang['customize-your-page'] }}</h4>
              </div>
            </div>
          </a>
        </el-col>
        <!-- Settings -->
        <el-col :sm="8" :xs="24">
          <a href="settings">
            <div class="card-widget">
              <div class="title-widget">
                <img src="@/assets/img/general/ux/shortcuts/settings.png" alt />
                <h4>{{ lang['settings-nav'] }}</h4>
              </div>
            </div>
          </a>
        </el-col>
      </el-row>

      <!--------------
                End shortcuts
      --------------->

      <!--------------
      Activities
      ---------------->

      <Activities class="m-t-30"></Activities>

      <!---------------
        End activities
      ----------------->
    </div>

    <first-steps v-else></first-steps>
  </div>
</template>

<script>
import Vue from 'vue';
import Activities from '@/components/activity/Activities.vue';
import VueGoogleCharts from 'vue-google-charts';
import FirstSteps from '@/components/home/tour/FirstSteps';
import { mapState } from 'vuex';

Vue.use(VueGoogleCharts);

export default {
  components: {
    Activities,
    FirstSteps
  },
  data: () => {
    return {
      usersData: [],
      usersChartOptions: {
        title: 'New users',
        colors: ['#00A9B4', '#29277F']
      },
      coursesChartOptions: {
        title: 'Courses',
        colors: ['#00A9B4', '#29277F', '#6959CD']
      },
      numberTotalOfUsers: '',
      numberTotalOfCourses: '',
      storagePercent: '',
      totalStorageAvaiable: '',
      totalStorageUsed: '',

      userStep: null,
      courseStep: null,
      customizeStep: null,
      settingsStep: null
    };
  },
  created() {
    this.getCompanyInformation();
    this.getStepsStatus();
  },
  mounted() {
    this.getTotalNumberOfUsers();
    this.getTotalNumberOfCourses();
    this.getRegisteredUsersPerMonth();
  },
  computed: {
    ...mapState(['lang'])
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
    getStepsStatus() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'verify',
        'stepsStatus'
      );
      this.$request.get(urlToBeUsedInTheRequest).then((response) => {
        this.userStep = response.data[0].status;
        this.courseStep = response.data[1].status;
        this.customizeStep = response.data[2].status;
        this.settingsStep = response.data[3].status;
      });
    },
    getTotalNumberOfUsers() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'widgets',
        'getTotalNumberOfUsers'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.numberTotalOfUsers = response.data;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getTotalNumberOfCourses() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'widgets',
        'getTotalNumberOfCourses'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.numberTotalOfCourses = response.data;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getStorage(storageAvaiable) {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'widgets',
        'getStorage'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.totalStorageUsed = response.data;
          this.storagePercent = (
            (100 * parseInt(response.data)) /
            parseInt(storageAvaiable)
          ).toFixed(2);
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getCompanyInformation() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'company',
        'getCompanyInformation'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.plan = response.data.plan;

          if (response.data.plan === 'free') {
            this.totalStorageAvaiable = 5;
          }

          if (response.data.plan === 'basic') {
            this.totalStorageAvaiable = 32;
          }

          if (response.data.plan === 'pro') {
            this.totalStorageAvaiable = 64;
          }

          if (response.data.plan === 'bussiness') {
            this.totalStorageAvaiable = 512;
          }

          this.getStorage(this.totalStorageAvaiable);
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
/* =============
   Scrollbar
============= */

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

/* =============
   Layout
============= */

.user-avatar {
  width: 70px;
}

.card-widget {
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
  transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
  background-color: white;
  border-radius: 10px;
  padding: 30px;
  text-align: center;
}

.card-widget:hover {
  box-shadow: 0 0px 7px rgba(70, 67, 67, 0.25), 0 5px 5px rgba(70, 67, 67, 0.25);
}

.title-widget img {
  width: 40px;
}
</style>
