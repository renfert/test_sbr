<template>
  <div class="row">
    <!--------------
                Widgets
      --------------->
    <div class="col-12 col-md-12 mb-5">
      <h4 class="sbr-text-grey">
        <b>{{ lang['courses'] }}</b>
      </h4>
      <div class="row">
        <div class="col-md-4 col-12 mb-3">
          <!-- Courses finished -->
          <router-link to="/courses">
            <div class="card-widget">
              <div class="title-widget text-center">
                <img
                  src="@/assets/img/general/ux/widgets/student/courses_finished.png"
                  alt
                />
                <h3 class="sbr-text-grey text-widget">
                  {{ lang['finalized'] }}
                  <b>{{ finalizedCourses }}</b>
                </h3>
              </div>
            </div>
          </router-link>
        </div>
        <div class="col-md-4 col-12 mb-3">
          <!-- Courses in progress -->
          <router-link to="/courses">
            <div class="card-widget">
              <div class="title-widget text-center">
                <img
                  src="@/assets/img/general/ux/widgets/student/courses_inprogress.png"
                  alt
                />
                <h3 class="sbr-text-grey text-widget">
                  {{ lang['in-progress'] }}
                  <b>{{ inprogressCourses }}</b>
                </h3>
              </div>
            </div>
          </router-link>
        </div>

        <div class="col-md-4 col-12 mb-3">
          <!-- Courses not started -->
          <router-link to="/courses">
            <div class="card-widget">
              <div class="title-widget text-center">
                <img
                  src="@/assets/img/general/ux/widgets/student/courses_notstarted.png"
                  alt
                />
                <h3 class="sbr-text-grey text-widget">
                  {{ lang['not-started'] }}
                  <b>{{ naCourses }}</b>
                </h3>
              </div>
            </div>
          </router-link>
        </div>
      </div>

      <!--------------
                Last activities
        --------------->
      <user-activities :user-id="this.user.id"></user-activities>
      <!--------------
                Last activities
        --------------->
    </div>
    <!--------------
                End Widgets
      --------------->
  </div>
</template>

<script>
import Vue from 'vue';
import UserActivities from '@/components/activity/UserActivities.vue';
import VueGoogleCharts from 'vue-google-charts';

import { mapState } from 'vuex';

Vue.use(VueGoogleCharts);

export default {
  components: {
    UserActivities
  },
  data: () => {
    return {
      finalizedCourses: '',
      inprogressCourses: '',
      naCourses: ''
    };
  },
  mounted() {
    this.getCourses();
  },
  computed: {
    ...mapState(['lang', 'user'])
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
          this.finalizedCourses = response.data[1][1];
          this.inprogressCourses = response.data[2][1];
          this.naCourses = response.data[3][1];
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
   Fonts
============= */
.text-widget {
  font-size: 1em;
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

.title-widget img {
  width: 60px;
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
