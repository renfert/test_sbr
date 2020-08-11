<template>
  <div class="col-auto">
    <facebook-loader
      v-if="loadingContent == true"
      :speed="2"
      width="700"
      height="200"
      primaryColor="#f0f0f0"
      secondaryColor="#d9d9d9"
    ></facebook-loader>

    <div class="row mt-5" v-else>
      <div class="col-12 col-md-4 list-courses" v-for="element in courseList" :key="element.id">
        <!-- Card -->
        <div class="card">
          <!-- Card image -->
          <img
            v-if="element.expirationDays < 0 || element.releaseDays > 0"
            v-lazy="getUrlToContents() + 'course/'+element.photo+''"
            style="height:200px;cursor:not-allowed;"
            class="card-img-top"
          />
          <router-link v-else :to="'/viewcourse/'+element.id">
            <!-- Card image -->
            <img
              v-lazy="getUrlToContents() + 'course/'+element.photo+''"
              style="height:200px;"
              class="card-img-top"
            />
          </router-link>

          <!-- Card content -->
          <div class="card-body">
            <!-- Title -->
            <h4
              style="cursor:not-allowed"
              v-if="element.expirationDays < 0 || element.releaseDays > 0"
              class="card-title"
            >{{element.title}}</h4>

            <!-- Title -->
            <h4 v-else class="card-title">
              <router-link :to="'/viewcourse/'+element.id">{{element.title}}</router-link>
            </h4>
            <el-progress
              v-if="parseInt(((100 * element.finishedLessons) /  element.lessons )) >=0 "
              :percentage="parseInt(((100 * element.finishedLessons) /  element.lessons ))"
            ></el-progress>

            <el-progress v-else :percentage="parseInt(0)"></el-progress>

            <!----------------- 
              Course expired 
            ------------------->
            <el-tag
              class="mt-2"
              v-if="element.expirationDays < 0"
              type="danger"
            >{{lang["course-expired"]}} {{element.expiration_date}}</el-tag>

            <!----------------- 
              Course not released 
            ------------------->
            <el-tag
              class="mt-2"
              v-if="element.releaseDays > 0"
              type="primary"
            >{{lang["course-avaiable-in"]}} {{element.release_date}}</el-tag>

            <!----------------- 
              Course validity 
            ------------------->
            <el-tag type="primary" v-if="element.validity != null" class="mt-2">
              {{lang["course-validity"]}}
              <b class="fw-700">{{element.validityDays}}</b>
              {{lang["days"]}}
            </el-tag>

            <el-divider v-if="roleId != 3">
              <i class="el-icon-more-outline"></i>
            </el-divider>
            <el-row v-if="roleId != 3">
              <router-link :to="'/editcourse/'+element.id">
                <el-button class="sbr-primary" type="primary" icon="el-icon-edit" circle></el-button>
              </router-link>
              <template>
                <el-popconfirm
                  confirmButtonText="Ok"
                  cancelButtonText="No, Thanks"
                  placement="right"
                  :title="lang['question-delete-course'] + element.title  + '?'"
                  @onConfirm="deleteCourse(element.id)"
                >
                  <el-button slot="reference" class="sbr-danger" icon="el-icon-delete" circle></el-button>
                </el-popconfirm>
              </template>
            </el-row>
          </div>
        </div>
        <!-- Card -->
      </div>
    </div>
  </div>
  <!-- End col-12 -->
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import ElementUI from "element-ui";
import "element-ui/lib/theme-chalk/index.css";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import VueLazyload from "vue-lazyload";

import { FacebookLoader } from "vue-content-loader";
import { eventBus } from "@/components/courses/App";
import { mapState } from "vuex";

Vue.use(ElementUI);
Vue.use(VueAxios, axios);
Vue.use(VueLazyload, {
  preLoad: 1.3,
  error: "https://sbrfiles.s3.amazonaws.com/images/image-not-available.png",
  loading: "https://sbrfiles.s3.amazonaws.com/gifs/loading7.gif",
  attempt: 1
});

export default {
  components: {
    FacebookLoader
  },
  mixins: [domains, alerts],
  data: function() {
    return {
      courseList: [],
      loadingContent: false,
      roleId: "",
      enrollDate: "",
      currentDate: ""
    };
  },
  computed: {
    ...mapState(["lang"])
  },
  created() {
    this.getCurrentDate();
    this.getCourses();
    this.getUserProfile();
  },
  methods: {
    editCourse: function(id) {
      sessionStorage.setItem("sbr_course_id", "" + id + "");
      window.location.href = "editcourse";
    },
    getCurrentDate: function() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "verify",
        "getCurrentDate"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        function(response) {
          this.currentDate = response.data;
        }.bind(this)
      );
    },
    deleteCourse: function(id) {
      var formData = new FormData();
      formData.set("courseId", id);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "course",
        "delete"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.successMessage();
          this.getCourses();
          eventBus.$emit("course-deleted");
        },

        function() {
          this.errorMessage();
        }
      );
    },
    getCourses() {
      this.loadingContent = true;
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "course",
        "listing"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        response => {
          this.courseList = response.data;
          setTimeout(
            function() {
              this.loadingContent = false;
            }.bind(this),
            1000
          );
        },
        // Failure callback
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    getUserProfile() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "user",
        "getUserProfile"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        function(response) {
          this.roleId = response.data["myrole_id"];
        }.bind(this)
      );
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.list-courses {
  margin-bottom: 50px !important;
}

.card a {
  color: #647b9c !important;
}
</style>
