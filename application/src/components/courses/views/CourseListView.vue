<template>
  <div>
    <facebook-loader
      v-if="content == false"
      :speed="2"
      width="700"
      height="200"
      primaryColor="#f0f0f0"
      secondaryColor="#d9d9d9"
    ></facebook-loader>
    <el-row :gutter="24" v-else>
      <el-col :sm="8" v-for="element in courseList" :key="element.id">
        <!-------------
          Course card
        --------------->
        <el-card :body-style="{ padding: '0px' }" shadow="hover">
          <img
            class="card-img-top"
            v-if="element.expirationDays < 0 || element.releaseDays > 0"
            v-lazy="$getUrlToContents() + 'course/' + element.photo + ''"
          />
          <router-link v-else :to="'/viewcourse/' + element.id">
            <!-- Card image -->
            <img
              v-lazy="$getUrlToContents() + 'course/' + element.photo + ''"
              class="card-img-top"
            />
          </router-link>
          <div class="card-body">
            <!-- Title -->
            <h4
              style="cursor: not-allowed"
              v-if="element.expirationDays < 0 || element.releaseDays > 0"
              class="card-title"
            >
              {{ element.title }}
            </h4>

            <!-- Title -->
            <h4 v-else class="card-title">
              <router-link :to="'/viewcourse/' + element.id">{{
                element.title
              }}</router-link>
            </h4>
            <!-- Course progress -->
            <el-progress
              v-if="
                parseInt((100 * element.finishedLessons) / element.lessons) >= 0
              "
              :percentage="
                parseInt((100 * element.finishedLessons) / element.lessons)
              "
            ></el-progress>

            <el-progress v-else :percentage="parseInt(0)"></el-progress>

            <!-----------------
              Course expired tag
            ------------------->
            <el-tag class="mt-2" v-if="element.expirationDays < 0" type="danger"
              >{{ lang['course-expired'] }}
              {{ element.expiration_date }}</el-tag
            >

            <!-----------------
              Course not released tag
            ------------------->
            <el-tag class="mt-2" v-if="element.releaseDays > 0" type="primary"
              >{{ lang['course-avaiable-in'] }}
              {{ element.release_date }}</el-tag
            >

            <!-----------------
              Course validity tag
            ------------------->
            <el-tag type="primary" v-if="element.validity != null" class="mt-2">
              {{ lang['course-validity'] }}
              <b class="fw-700">{{ element.validityDays }}</b>
              {{ lang['days'] }}
            </el-tag>

            <el-divider v-if="user.role != 3">
              <i class="el-icon-more-outline"></i>
            </el-divider>
            <el-row v-if="user.role != 3">
              <el-tooltip
                v-if="element.editPrivilege == 'on' || user.role == 1"
                class="item"
                effect="dark"
                :content="lang['edit-course']"
                placement="top"
              >
                <router-link :to="'/editcourse/' + element.id">
                  <i
                    class="el-icon-edit-outline table-icon table-icon-primary m-r-20"
                  ></i>
                </router-link>
              </el-tooltip>
              <template>
                <el-tooltip
                  v-if="element.deletePrivilege == 'on' || user.role == 1"
                  class="item"
                  effect="dark"
                  :content="lang['delete-course']"
                  placement="top"
                >
                  <el-popconfirm
                    confirmButtonText="Ok"
                    cancelButtonText="No, Thanks"
                    placement="right"
                    :title="
                      lang['question-delete-course'] + element.title + '?'
                    "
                    @onConfirm="deleteCourse(element.id)"
                  >
                    <i
                      slot="reference"
                      class="el-icon-delete table-icon table-icon-danger"
                    ></i>
                  </el-popconfirm>
                </el-tooltip>
              </template>
            </el-row>
          </div>
        </el-card>

        <!-------------
          End course card
        --------------->
      </el-col>
    </el-row>
  </div>
</template>

<script>
import Vue from 'vue';
import VueLazyload from 'vue-lazyload';

import { FacebookLoader } from 'vue-content-loader';
import { eventBus } from '@/components/courses/App';
import { mapState } from 'vuex';

Vue.use(VueLazyload, {
  preLoad: 1.3,
  error: 'https://sbrfiles.s3.amazonaws.com/images/image-not-available.png',
  loading: 'https://sbrfiles.s3.amazonaws.com/gifs/loading7.gif',
  attempt: 1
});

export default {
  components: {
    FacebookLoader
  },
  data: () => {
    return {
      courseList: [],
      content: false
    };
  },
  computed: {
    ...mapState(['lang', 'user'])
  },
  created() {
    this.getCourses();
  },
  methods: {
    deleteCourse(id) {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'course',
        'delete'
      );
      formData.set('courseId', id);

      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.$successMessage();
          this.getCourses();
          eventBus.$emit('course-deleted');
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getCourses() {
      this.content = false;
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'course',
        'listing'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.courseList = response.data;
          setTimeout(() => {
            this.content = true;
          }, 2000);
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
.card-img-top {
  width: 100%;
  height: 200px !important;
  max-width: 100% !important;
}

.card-title {
  height: 60px;
}

.card-title a {
  font-family: 'Poppins', sans-serif;
  word-break: break-word !important;
  color: #647b9c;
  text-decoration: none;
  font-size: 15px;
}

.card-body {
  padding: 30px;
}

.el-col {
  margin-bottom: 2rem;
  &:last-child {
    margin-bottom: 0;
  }
}

.el-card {
  border-radius: 20px;
}
</style>
