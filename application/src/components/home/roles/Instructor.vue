<template>
  <div class="row">
    <!--------------
                Widgets
      --------------->
    <div class="col-12 col-md-12 mb-5">
      <h4 class="sbr-text-grey">
        <b>{{ lang['basic-information'] }}</b>
      </h4>
      <div class="row">
        <div class="col-md-6 col-12 mb-3">
          <!-- Courses -->
          <a href="courses">
            <div class="card-widget">
              <div class="title-widget text-center">
                <img
                  src="@/assets/img/general/ux/widgets/admin/courses.png"
                  alt
                />
                <h3 class="sbr-text-grey text-widget">
                  {{ lang['courses'] }}:
                  <b>{{ numberTotalOfCourses }}</b>
                </h3>
              </div>
            </div>
          </a>
        </div>
        <div class="col-md-6 col-12 mb-3">
          <!-- Users -->
          <a href="users">
            <div class="card-widget">
              <div class="title-widget text-center">
                <img
                  src="@/assets/img/general/ux/widgets/admin/enrolled.png"
                  alt
                />
                <h3 class="sbr-text-grey text-widget">
                  {{ lang['students'] }}:
                  <b>{{ numberTotalOfStudents }}</b>
                </h3>
              </div>
            </div>
          </a>
        </div>
      </div>

      <!--------------
                Last activities
        --------------->
      <Activities></Activities>
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
import Activities from '@/components/activity/Activities.vue';
import VueGoogleCharts from 'vue-google-charts';

import { mapState } from 'vuex';

Vue.use(VueGoogleCharts);

export default {
  components: {
    Activities
  },
  data: () => {
    return {
      numberTotalOfStudents: '',
      numberTotalOfCourses: ''
    };
  },
  mounted() {
    this.getTotalNumberOfStudents();
    this.getTotalNumberOfCourses();
    this.getCourses();
  },
  computed: {
    ...mapState(['lang'])
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
    },
    getTotalNumberOfStudents() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'widgets',
        'getTotalNumberOfStudents'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.numberTotalOfStudents = response.data;
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

.title-widget img {
  width: 60px;
}
</style>
