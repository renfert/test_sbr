<template>
  <div class="col-auto">
    <facebook-loader
      v-if="content == false"
      :speed="2"
      width="700"
      height="200"
      primaryColor="#f0f0f0"
      secondaryColor="#d9d9d9"
    ></facebook-loader>

    <div class="row mt-5 mb-5" v-else>
      <div class="col-12 col-md-4 list-courses" v-for="element in courseList" :key="element.id">
        <!-- Card -->
        <div class="card">
          <!-- Card image -->
          <img
            v-if="element.expirationDays < 0 || element.releaseDays > 0"
            v-lazy="$getUrlToContents() + 'course/'+element.photo+''"
            style="height:200px;cursor:not-allowed;"
            class="card-img-top"
          />
          <router-link v-else :to="'/viewcourse/'+element.id">
            <!-- Card image -->
            <img
              v-lazy="$getUrlToContents() + 'course/'+element.photo+''"
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

            <el-divider v-if="userRole != 3">
              <i class="el-icon-more-outline"></i>
            </el-divider>
            <el-row v-if="userRole != 3">
              <router-link :to="'/editcourse/'+element.id">
                <el-button
                  size="small"
                  class="sbr-primary mr-2"
                  type="primary"
                  icon="el-icon-edit"
                  circle
                ></el-button>
              </router-link>
              <template>
                <el-popconfirm
                  confirmButtonText="Ok"
                  cancelButtonText="No, Thanks"
                  placement="right"
                  :title="lang['question-delete-course'] + element.title  + '?'"
                  @onConfirm="deleteCourse(element.id)"
                >
                  <el-button
                    size="small"
                    slot="reference"
                    class="sbr-danger"
                    icon="el-icon-delete"
                    circle
                  ></el-button>
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
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import VueLazyload from "vue-lazyload";

import { FacebookLoader } from "vue-content-loader";
import { eventBus } from "@/components/courses/App";
import { mapState } from "vuex";

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
      content: false
    };
  },
  computed: {
    ...mapState(["lang", "userRole"])
  },
  created() {
    this.getCourses();
  },
  methods: {
    deleteCourse(id) {
      let formData = new FormData();
      let urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        "course",
        "delete"
      );
      formData.set("courseId", id);

      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.successMessage();
          this.getCourses();
          eventBus.$emit("course-deleted");
        },
        () => {
          this.errorMessage();
        }
      );
    },
    getCourses() {
      this.content = false;
      let urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        "course",
        "listing"
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        response => {
          this.courseList = response.data;
          this.$applyDelayInFunction(() => {
            this.content = true;
          }, 2000);
        },
        () => {
          this.errorMessage();
        }
      );
    }
  }
};
</script>

<style lang="scss" scoped>
.card a {
  color: #647b9c !important;
}
</style>
