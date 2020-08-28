<template>
  <div class="main" v-loading="loading">
    <lang></lang>

    <div class="row">
      <!-------------- 
                Widgets 
      --------------->
      <div class="col-12 col-md-12 mb-5">
        <h4 class="sbr-text-grey">
          <b>{{lang['courses']}}</b>
        </h4>
        <div class="row">
          <div class="col-md-4 col-12 mb-3">
            <!-- Courses finished -->
            <a href="courses">
              <div class="card-widget">
                <div class="title-widget text-center">
                  <img src="@/assets/img/general/ux/widgets/student/courses_finished.png" alt />
                  <h3 class="sbr-text-grey text-widget">
                    {{lang['finalized']}}
                    <b>{{finalizedCourses}}</b>
                  </h3>
                </div>
              </div>
            </a>
          </div>
          <div class="col-md-4 col-12 mb-3">
            <!-- Courses in progress -->
            <a href="users">
              <div class="card-widget">
                <div class="title-widget text-center">
                  <img src="@/assets/img/general/ux/widgets/student/courses_inprogress.png" alt />
                  <h3 class="sbr-text-grey text-widget">
                    {{lang['in-progress']}}
                    <b>{{inprogressCourses}}</b>
                  </h3>
                </div>
              </div>
            </a>
          </div>

          <div class="col-md-4 col-12 mb-3">
            <!-- Courses not started -->
            <a href="users">
              <div class="card-widget">
                <div class="title-widget text-center">
                  <img src="@/assets/img/general/ux/widgets/student/courses_notstarted.png" alt />
                  <h3 class="sbr-text-grey text-widget">
                    {{lang['not-started']}}
                    <b>{{naCourses}}</b>
                  </h3>
                </div>
              </div>
            </a>
          </div>
        </div>

        <!-------------- 
                Last activities
        --------------->
        <user-activities v-if="userId != 0" :user-id="userId"></user-activities>
        <!-------------- 
                Last activities
        --------------->
      </div>
      <!-------------- 
                End Widgets 
      --------------->
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import VueTheMask from "vue-the-mask";
import ElementUI from "element-ui";
import Lang from "@/components/helper/HelperLang.vue";
import UserActivities from "@/components/activity/UserActivities.vue";
import "element-ui/lib/theme-chalk/index.css";
import lang from "element-ui/lib/locale/lang/en";
import locale from "element-ui/lib/locale";
import { eventLang } from "@/components/helper/HelperLang";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import VueGoogleCharts from "vue-google-charts";

Vue.use(VueGoogleCharts);

locale.use(lang);
Vue.use(VueTheMask);
Vue.use(VueTheMask);
Vue.use(VueAxios, axios);
Vue.use(ElementUI);

export default {
  components: {
    Lang,
    UserActivities
  },
  mixins: [domains, alerts],
  data: function() {
    return {
      lang: {},
      loading: false,
      userId: 0,
      finalizedCourses: "",
      inprogressCourses: "",
      naCourses: ""
    };
  },
  mounted() {
    eventLang.$on(
      "lang",
      function(response) {
        this.lang = response;
      }.bind(this)
    );

    this.getUserProfile();
  },
  methods: {
    getCourses: function(studentId) {
      var formData = new FormData();
      formData.set("studentId", studentId);
      var urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        "chart",
        "getStudentCourses"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          this.finalizedCourses = response.data[1][1];
          this.inprogressCourses = response.data[2][1];
          this.naCourses = response.data[3][1];
        },
        /* Error callback */
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    getUserProfile: function() {
      var urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
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
